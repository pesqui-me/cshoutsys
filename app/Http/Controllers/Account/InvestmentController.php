<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\InvestmentCard;
use App\Models\UserInvestment;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\UserNotification;
use App\Models\Setting;

class InvestmentController extends Controller
{
    /**
     * Afficher la page d'achat de cartes
     */
    public function buyCard()
    {
        $cards = InvestmentCard::active()
            ->ordered()
            ->get();

        $paymentMethods = PaymentMethod::active()
            ->ordered()
            ->get()
            ->groupBy('type');

        return view('account.buy-card', compact('cards', 'paymentMethods'));
    }

    /**
     * Traiter l'achat d'une carte
     */
    public function processPurchase(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:investment_cards,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        $user = Auth::user();
        $card = InvestmentCard::findOrFail($request->card_id);
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);

        // Vérifier que la carte est active
        if (!$card->is_active) {
            return back()->with('error', 'Cette carte n\'est plus disponible.');
        }

        DB::beginTransaction();

        try {
            // Créer l'investissement
            $investment = UserInvestment::create([
                'user_id' => $user->id,
                'investment_card_id' => $card->id,
                'amount_paid' => $card->price,
                'expected_profit' => $card->expected_profit,
                'status' => 'pending_payment',
                'purchased_at' => now(),
            ]);

            // Créer la transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'user_investment_id' => $investment->id,
                'payment_method_id' => $paymentMethod->id,
                'type' => 'investment_purchase',
                'amount' => $card->price,
                'status' => 'pending',
                'description' => "Achat de {$card->name}",
                'metadata' => [
                    'card_name' => $card->name,
                    'card_price' => $card->price,
                    'expected_profit' => $card->expected_profit,
                    'roi' => $card->roi_percentage,
                ],
            ]);

            // Ajouter la preuve de paiement si fournie
            if ($request->hasFile('payment_proof')) {
                $transaction->addMedia($request->file('payment_proof'))
                    ->toMediaCollection('payment_proof');
            }

            // Créer une notification
            UserNotification::create([
                'user_id' => $user->id,
                'title' => 'Commande reçue',
                'message' => "Votre commande pour {$card->name} a été reçue. Elle sera traitée sous peu.",
                'type' => 'investment',
                'icon' => '💎',
                'action_url' => route('user.investments.show', $investment->id),
            ]);

            DB::commit();

            // Vérifier si on doit proposer l'upsell (carte 200$ → 350$)
            if ($card->price == 200 && Setting::get('enable_upsell', true)) {
                $upsellDelayMinutes = Setting::get('upsell_delay_minutes', 15);
                
                // Créer une notification pour l'upsell (sera affichée après le délai)
                UserNotification::create([
                    'user_id' => $user->id,
                    'title' => 'Offre Spéciale ! 🎁',
                    'message' => "Passez à la carte 350$ et gagnez encore plus ! Offre limitée.",
                    'type' => 'info',
                    'icon' => '⭐',
                    'action_url' => route('user.investments.buy-card'),
                    'created_at' => now()->addMinutes($upsellDelayMinutes),
                ]);
            }

            return redirect()
                ->route('user.investments.show', $investment->id)
                ->with('success', 'Votre commande a été enregistrée ! Elle sera validée dès réception du paiement.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors du traitement de votre commande. Veuillez réessayer.');
        }
    }

    /**
     * Afficher la liste des investissements
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = UserInvestment::where('user_id', $user->id)
            ->with(['investmentCard', 'transactions']);

        // Filtrer par statut
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $investments = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistiques
        $stats = [
            'total' => UserInvestment::where('user_id', $user->id)->count(),
            'active' => UserInvestment::where('user_id', $user->id)->where('status', 'active')->count(),
            'pending' => UserInvestment::where('user_id', $user->id)->whereIn('status', ['pending_payment', 'payment_processing'])->count(),
            'completed' => UserInvestment::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        return view('account.investments', compact('investments', 'stats'));
    }

    /**
     * Afficher les détails d'un investissement
     */
    public function show($id)
    {
        $investment = UserInvestment::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['investmentCard', 'transactions.paymentMethod'])
            ->firstOrFail();

        return view('account.show-investments', compact('investment'));
    }

    /**
     * Annuler un investissement (seulement si en attente de paiement)
     */
    public function cancel($id)
    {
        $investment = UserInvestment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier si l'investissement peut être annulé
        if (!in_array($investment->status, ['pending_payment', 'payment_processing'])) {
            return back()->with('error', 'Cet investissement ne peut plus être annulé.');
        }

        DB::beginTransaction();

        try {
            // Mettre à jour le statut
            $investment->update(['status' => 'cancelled']);

            // Annuler les transactions associées
            $investment->transactions()
                ->whereIn('status', ['pending', 'processing'])
                ->update(['status' => 'cancelled']);

            // Créer une notification
            UserNotification::create([
                'user_id' => $investment->user_id,
                'title' => 'Investissement annulé',
                'message' => "Votre investissement {$investment->reference} a été annulé avec succès.",
                'type' => 'info',
                'icon' => 'ℹ️',
            ]);

            DB::commit();

            return redirect()
                ->route('user.investments.index')
                ->with('success', 'Votre investissement a été annulé.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Une erreur est survenue lors de l\'annulation.');
        }
    }

    /**
     * Obtenir les détails d'une carte (AJAX)
     */
    public function getCardDetails($id)
    {
        $card = InvestmentCard::findOrFail($id);

        return response()->json([
            'id' => $card->id,
            'name' => $card->name,
            'price' => $card->price,
            'formatted_price' => $card->formatted_price,
            'expected_profit' => $card->expected_profit,
            'formatted_profit' => $card->formatted_profit,
            'roi_percentage' => $card->roi_percentage,
            'formatted_roi' => $card->formatted_roi,
            'processing_hours' => $card->processing_hours,
            'description' => $card->description,
            'features' => $card->features,
        ]);
    }
}