<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInvestment;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Afficher le dashboard admin
     */
    public function index(Request $request)
    {
        // Période sélectionnée (par défaut: ce mois)
        $period = $request->input('period', 'month');
        
        $startDate = match($period) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth(),
        };

        // Statistiques principales
        $stats = [
            'total_users' => User::role('user')->count(),
            'new_users' => User::role('user')->where('created_at', '>=', $startDate)->count(),
            'active_users' => User::role('user')->where('is_active', true)->count(),
            
            'total_investments' => UserInvestment::count(),
            'active_investments' => UserInvestment::where('status', 'active')->count(),
            'pending_investments' => UserInvestment::whereIn('status', ['pending_payment', 'payment_processing'])->count(),
            'completed_investments' => UserInvestment::where('status', 'completed')->count(),
            
            'total_invested' => UserInvestment::whereNotIn('status', ['cancelled', 'refunded'])->sum('amount_paid'),
            'total_profit_paid' => UserInvestment::where('status', 'completed')->sum('actual_profit'),
            'pending_profit' => UserInvestment::where('status', 'active')->sum('expected_profit'),
            
            'pending_withdrawals' => Withdrawal::whereIn('status', ['pending', 'under_review'])->count(),
            'approved_withdrawals' => Withdrawal::where('status', 'approved')->count(),
            'total_withdrawn' => Withdrawal::where('status', 'completed')->sum('net_amount'),
            
            'pending_tickets' => SupportTicket::whereIn('status', ['new', 'open'])->count(),
            'in_progress_tickets' => SupportTicket::where('status', 'in_progress')->count(),
        ];

        // Graphique des revenus (7 derniers jours)
        $revenueChart = $this->getRevenueChartData();

        // Graphique des investissements par carte
        $investmentsByCard = $this->getInvestmentsByCard();

        // Dernières transactions
        $recentTransactions = Transaction::with(['user', 'userInvestment.investmentCard'])
            ->latest()
            ->limit(10)
            ->get();

        // Demandes de retrait en attente
        $pendingWithdrawals = Withdrawal::with('user')
            ->whereIn('status', ['pending', 'under_review'])
            ->latest()
            ->limit(5)
            ->get();

        // Nouveaux tickets
        $newTickets = SupportTicket::with('user')
            ->where('status', 'new')
            ->latest()
            ->limit(5)
            ->get();

        // Utilisateurs récents
        $recentUsers = User::role('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'revenueChart',
            'investmentsByCard',
            'recentTransactions',
            'pendingWithdrawals',
            'newTickets',
            'recentUsers',
            'period'
        ));
    }

    /**
     * Obtenir les données du graphique de revenus
     */
    private function getRevenueChartData()
    {
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            $invested = UserInvestment::whereDate('created_at', $date)
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->sum('amount_paid');
            
            $withdrawn = Withdrawal::whereDate('completed_at', $date)
                ->where('status', 'completed')
                ->sum('net_amount');
            
            $data[] = [
                'date' => $date->format('d/m'),
                'invested' => $invested,
                'withdrawn' => $withdrawn,
                'net' => $invested - $withdrawn,
            ];
        }
        
        return $data;
    }

    /**
     * Obtenir la répartition des investissements par carte
     */
    private function getInvestmentsByCard()
    {
        return DB::table('user_investments')
            ->join('investment_cards', 'user_investments.investment_card_id', '=', 'investment_cards.id')
            ->select('investment_cards.name', DB::raw('COUNT(*) as count'), DB::raw('SUM(user_investments.amount_paid) as total'))
            ->whereNotIn('user_investments.status', ['cancelled', 'refunded'])
            ->groupBy('investment_cards.id', 'investment_cards.name')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Obtenir les statistiques en temps réel (AJAX)
     */
    public function getRealtimeStats()
    {
        return response()->json([
            'active_users' => User::role('user')->where('is_active', true)->count(),
            'active_investments' => UserInvestment::where('status', 'active')->count(),
            'pending_withdrawals' => Withdrawal::whereIn('status', ['pending', 'under_review'])->count(),
            'pending_tickets' => SupportTicket::whereIn('status', ['new', 'open'])->count(),
            'total_balance' => User::role('user')->sum('balance'),
        ]);
    }

    /**
     * Exporter les statistiques en PDF
     */
    public function exportStats(Request $request)
    {
        $period = $request->input('period', 'month');
        
        // Récupérer toutes les statistiques
        $stats = $this->getDetailedStats($period);
        
        $pdf = \PDF::loadView('admin.reports.stats', compact('stats', 'period'));
        
        return $pdf->download('statistics-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Obtenir des statistiques détaillées
     */
    private function getDetailedStats($period)
    {
        $startDate = match($period) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth(),
        };

        return [
            'users' => [
                'total' => User::role('user')->count(),
                'new' => User::role('user')->where('created_at', '>=', $startDate)->count(),
                'active' => User::role('user')->where('is_active', true)->count(),
                'inactive' => User::role('user')->where('is_active', false)->count(),
            ],
            'investments' => [
                'total' => UserInvestment::count(),
                'active' => UserInvestment::where('status', 'active')->count(),
                'pending' => UserInvestment::whereIn('status', ['pending_payment', 'payment_processing'])->count(),
                'completed' => UserInvestment::where('status', 'completed')->count(),
                'cancelled' => UserInvestment::where('status', 'cancelled')->count(),
            ],
            'financial' => [
                'total_invested' => UserInvestment::whereNotIn('status', ['cancelled', 'refunded'])->sum('amount_paid'),
                'total_profit_paid' => UserInvestment::where('status', 'completed')->sum('actual_profit'),
                'pending_profit' => UserInvestment::where('status', 'active')->sum('expected_profit'),
                'total_withdrawn' => Withdrawal::where('status', 'completed')->sum('net_amount'),
                'platform_balance' => User::role('user')->sum('balance'),
            ],
            'withdrawals' => [
                'total' => Withdrawal::count(),
                'pending' => Withdrawal::whereIn('status', ['pending', 'under_review'])->count(),
                'approved' => Withdrawal::where('status', 'approved')->count(),
                'completed' => Withdrawal::where('status', 'completed')->count(),
                'rejected' => Withdrawal::where('status', 'rejected')->count(),
            ],
            'support' => [
                'total_tickets' => SupportTicket::count(),
                'new' => SupportTicket::where('status', 'new')->count(),
                'open' => SupportTicket::where('status', 'open')->count(),
                'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
                'resolved' => SupportTicket::where('status', 'resolved')->count(),
            ],
        ];
    }
}