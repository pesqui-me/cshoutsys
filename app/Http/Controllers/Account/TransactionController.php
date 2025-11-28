<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\UserInvestment;

class TransactionController extends Controller
{
    /**
     * Afficher l'historique des transactions
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Transaction::where('user_id', $user->id)
            ->with(['userInvestment.investmentCard', 'paymentMethod']);

        // Filtrer par type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filtrer par statut
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filtrer par période
        if ($request->has('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        // Recherche par référence
        if ($request->has('search') && !empty($request->search)) {
            $query->where('reference', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        // Statistiques
        $stats = $this->getTransactionStats($user->id);

        return view('account.history', compact('transactions', 'stats'));
    }

    /**
     * Afficher les détails d'une transaction
     */
    public function show($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['userInvestment.investmentCard', 'paymentMethod'])
            ->firstOrFail();

        return view('user.transactions.show', compact('transaction'));
    }

    /**
     * Télécharger le reçu d'une transaction (PDF)
     */
    public function downloadReceipt($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['user', 'userInvestment.investmentCard', 'paymentMethod'])
            ->firstOrFail();

        // Vérifier que la transaction est complétée
        if ($transaction->status !== 'completed') {
            return back()->with('error', 'Le reçu n\'est disponible que pour les transactions complétées.');
        }

        // Générer le PDF
        $pdf = \PDF::loadView('user.transactions.receipt', compact('transaction'));

        return $pdf->download("receipt-{$transaction->reference}.pdf");
    }

    /**
     * Exporter les transactions en CSV
     */
    public function export(Request $request)
    {
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)
            ->with(['userInvestment.investmentCard', 'paymentMethod'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "transactions-{$user->id}-" . now()->format('Y-m-d') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'Référence',
                'Date',
                'Type',
                'Montant',
                'Devise',
                'Statut',
                'Moyen de paiement',
                'Description',
            ]);

            // Données
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->reference,
                    $transaction->created_at->format('Y-m-d H:i:s'),
                    $transaction->type_label,
                    $transaction->amount,
                    $transaction->currency,
                    $transaction->status_label,
                    $transaction->paymentMethod?->name ?? 'N/A',
                    $transaction->description,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Obtenir les statistiques des transactions
     */
    private function getTransactionStats($userId)
    {
        $allTransactions = Transaction::where('user_id', $userId);

        return [
            'total' => $allTransactions->count(),
            'completed' => (clone $allTransactions)->where('status', 'completed')->count(),
            'pending' => (clone $allTransactions)->where('status', 'pending')->count(),
            'failed' => (clone $allTransactions)->where('status', 'failed')->count(),
            'total_amount' => (clone $allTransactions)->where('status', 'completed')->sum('amount'),
            'this_month' => (clone $allTransactions)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    /**
     * Obtenir les statistiques par type (AJAX)
     */
    public function getStatsByType()
    {
        $user = Auth::user();

        $types = [
            'investment_purchase',
            'profit_credit',
            'withdrawal',
            'refund',
            'bonus',
            'commission',
        ];

        $stats = [];

        foreach ($types as $type) {
            $count = Transaction::where('user_id', $user->id)
                ->where('type', $type)
                ->count();

            $amount = Transaction::where('user_id', $user->id)
                ->where('type', $type)
                ->where('status', 'completed')
                ->sum('amount');

            $stats[$type] = [
                'count' => $count,
                'amount' => $amount,
                'formatted_amount' => '$' . number_format($amount, 2),
            ];
        }

        return response()->json($stats);
    }
}