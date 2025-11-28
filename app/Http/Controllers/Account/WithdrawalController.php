<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Withdrawal;
use App\Models\PaymentMethod;
use App\Models\UserNotification;
use App\Models\Setting;

class WithdrawalController extends Controller
{
    /**
     * Afficher la page de demande de retrait
     */
    public function index()
    {
        $user = Auth::user();

        // Vérifier le solde disponible
        $availableBalance = $user->balance;

        // Paramètres de retrait
        $minWithdrawal = Setting::get('min_withdrawal_amount', 50);
        $maxWithdrawal = Setting::get('max_withdrawal_amount', 100000);
        $feePercentage = Setting::get('withdrawal_fee_percentage', 2);

        // Moyens de paiement disponibles pour les retraits
        $paymentMethods = PaymentMethod::active()
            ->whereIn('type', ['crypto', 'e-wallet', 'mobile-money', 'bank-transfer'])
            ->ordered()
            ->get()
            ->groupBy('type');

        // Historique des retraits
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->with('paymentMethod')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistiques
        $stats = [
            'total' => Withdrawal::where('user_id', $user->id)->count(),
            'pending' => Withdrawal::where('user_id', $user->id)->whereIn('status', ['pending', 'under_review'])->count(),
            'approved' => Withdrawal::where('user_id', $user->id)->where('status', 'approved')->count(),
            'completed' => Withdrawal::where('user_id', $user->id)->where('status', 'completed')->count(),
            'total_amount' => Withdrawal::where('user_id', $user->id)
                ->where('status', 'completed')
                ->sum('net_amount'),
        ];

        return view('account.withdrawals', compact(
            'user',
            'availableBalance',
            'minWithdrawal',
            'maxWithdrawal',
            'feePercentage',
            'paymentMethods',
            'withdrawals',
            'stats'
        ));
    }

    /**
     * Créer une demande de retrait
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $minWithdrawal = Setting::get('min_withdrawal_amount', 50);
        $maxWithdrawal = Setting::get('max_withdrawal_amount', 100000);
        $feePercentage = Setting::get('withdrawal_fee_percentage', 2);

        $request->validate([
            'amount' => "required|numeric|min:{$minWithdrawal}|max:{$maxWithdrawal}",
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_details' => 'required|array',
            'payment_details.*' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Vérifier que l'utilisateur a suffisamment de fonds
        if ($request->amount > $user->balance) {
            return back()
                ->withInput()
                ->with('error', 'Solde insuffisant pour effectuer ce retrait.');
        }

        // Calculer les frais et le montant net
        $fees = ($request->amount * $feePercentage) / 100;
        $netAmount = $request->amount - $fees;

        // Vérifier les retraits en attente
        $pendingWithdrawals = Withdrawal::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'under_review', 'approved', 'processing'])
            ->count();

        if ($pendingWithdrawals >= 3) {
            return back()
                ->withInput()
                ->with('error', 'Vous avez déjà 3 demandes de retrait en cours. Veuillez attendre leur traitement.');
        }

        DB::beginTransaction();

        try {
            // Créer la demande de retrait
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'payment_method_id' => $request->payment_method_id,
                'amount' => $request->amount,
                'fees' => $fees,
                'net_amount' => $netAmount,
                'status' => 'pending',
                'payment_details' => $request->payment_details,
                'user_notes' => $request->notes,
            ]);

            // Déduire le montant du solde de l'utilisateur (bloqué en attente)
            $user->decrement('balance', $request->amount);

            // Créer une notification
            UserNotification::create([
                'user_id' => $user->id,
                'title' => 'Demande de retrait reçue',
                'message' => "Votre demande de retrait de {$withdrawal->formatted_amount} a été reçue. Elle sera traitée sous " . Setting::get('withdrawal_processing_days', 3) . " jours.",
                'type' => 'withdrawal',
                'icon' => '💰',
                'action_url' => route('user.withdrawals.show', $withdrawal->id),
            ]);

            DB::commit();

            return redirect()
                ->route('user.withdrawals.show', $withdrawal->id)
                ->with('success', 'Votre demande de retrait a été enregistrée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de votre demande. Veuillez réessayer.');
        }
    }

    /**
     * Afficher les détails d'un retrait
     */
    public function show($id)
    {
        $withdrawal = Withdrawal::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['paymentMethod', 'approvedBy'])
            ->firstOrFail();

        return view('user.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Annuler une demande de retrait (seulement si en attente)
     */
    public function cancel($id)
    {
        $withdrawal = Withdrawal::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier si le retrait peut être annulé
        if (!in_array($withdrawal->status, ['pending', 'under_review'])) {
            return back()->with('error', 'Cette demande de retrait ne peut plus être annulée.');
        }

        DB::beginTransaction();

        try {
            // Rembourser le montant au solde de l'utilisateur
            $withdrawal->user->increment('balance', $withdrawal->amount);

            // Mettre à jour le statut
            $withdrawal->update(['status' => 'cancelled']);

            // Créer une notification
            UserNotification::create([
                'user_id' => $withdrawal->user_id,
                'title' => 'Retrait annulé',
                'message' => "Votre demande de retrait {$withdrawal->reference} a été annulée. Le montant a été recrédité sur votre compte.",
                'type' => 'info',
                'icon' => 'ℹ️',
            ]);

            DB::commit();

            return redirect()
                ->route('user.withdrawals.index')
                ->with('success', 'Votre demande de retrait a été annulée et le montant a été recrédité.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Une erreur est survenue lors de l\'annulation.');
        }
    }

    /**
     * Calculer les frais de retrait (AJAX)
     */
    public function calculateFees(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $feePercentage = Setting::get('withdrawal_fee_percentage', 2);
        $amount = $request->amount;
        $fees = ($amount * $feePercentage) / 100;
        $netAmount = $amount - $fees;

        return response()->json([
            'amount' => number_format($amount, 2),
            'fees' => number_format($fees, 2),
            'fee_percentage' => $feePercentage,
            'net_amount' => number_format($netAmount, 2),
            'formatted' => [
                'amount' => '$' . number_format($amount, 2),
                'fees' => '$' . number_format($fees, 2),
                'net_amount' => '$' . number_format($netAmount, 2),
            ],
        ]);
    }

    /**
     * Obtenir les informations d'un moyen de paiement (AJAX)
     */
    public function getPaymentMethodInfo($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        // Déterminer les champs requis selon le type
        $requiredFields = [];

        switch ($paymentMethod->type) {
            case 'crypto':
                $requiredFields = [
                    [
                        'name' => 'wallet_address',
                        'label' => 'Adresse de Wallet ' . $paymentMethod->name,
                        'type' => 'text',
                        'placeholder' => 'Votre adresse de wallet',
                        'help' => 'Assurez-vous que l\'adresse est correcte',
                    ],
                ];
                break;

            case 'e-wallet':
                $requiredFields = [
                    [
                        'name' => 'account_id',
                        'label' => 'Identifiant ' . $paymentMethod->name,
                        'type' => 'text',
                        'placeholder' => 'Votre identifiant de compte',
                    ],
                ];
                break;

            case 'mobile-money':
                $requiredFields = [
                    [
                        'name' => 'phone_number',
                        'label' => 'Numéro de Téléphone',
                        'type' => 'tel',
                        'placeholder' => '+229XXXXXXXX',
                        'help' => 'Incluez l\'indicatif du pays',
                    ],
                    [
                        'name' => 'account_name',
                        'label' => 'Nom du Titulaire',
                        'type' => 'text',
                        'placeholder' => 'Nom complet',
                    ],
                ];
                break;

            case 'bank-transfer':
                $requiredFields = [
                    [
                        'name' => 'account_number',
                        'label' => 'Numéro de Compte',
                        'type' => 'text',
                        'placeholder' => 'Votre numéro de compte',
                    ],
                    [
                        'name' => 'account_name',
                        'label' => 'Nom du Titulaire',
                        'type' => 'text',
                        'placeholder' => 'Nom complet',
                    ],
                    [
                        'name' => 'bank_name',
                        'label' => 'Nom de la Banque',
                        'type' => 'text',
                        'placeholder' => 'Nom de votre banque',
                    ],
                ];
                break;
        }

        return response()->json([
            'id' => $paymentMethod->id,
            'name' => $paymentMethod->name,
            'type' => $paymentMethod->type,
            'description' => $paymentMethod->description,
            'required_fields' => $requiredFields,
        ]);
    }
}