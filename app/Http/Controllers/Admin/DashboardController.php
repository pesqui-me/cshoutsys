<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Investment;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\InvestmentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Calculate statistics
        $stats = $this->getStats();
        
        // Get chart data
        $chart_data = $this->getChartData();
        
        // Get recent activities
        $recent_activities = $this->getRecentActivities();
        
        // Get top investors
        $top_investors = $this->getTopInvestors();
        
        // Pass stats to sidebar via view composer or shared data
        view()->share('stats', [
            'pending_users' => 0, // À implémenter si besoin
            'active_investments' => $stats['active_investments'],
            'pending_withdrawals' => $stats['pending_withdrawals'],
            'open_tickets' => 0, // À implémenter avec support_tickets
        ]);
        
        return view('admin.dashboard.index', compact(
            'stats',
            'chart_data',
            'recent_activities',
            'top_investors'
        ));
    }
    
    /**
     * Get dashboard statistics
     */
    private function getStats(): array
    {
        return [
            // Users stats
            'total_users' => User::count(),
            'new_users_30d' => User::where('created_at', '>=', now()->subDays(30))->count(),
            
            // Investments stats
            'active_investments' => Investment::where('status', 'active')->count(),
            'total_invested' => Investment::sum('amount'),
            
            // Withdrawals stats
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'pending_withdrawals_amount' => Withdrawal::where('status', 'pending')->sum('amount'),
            
            // Revenue stats
            'total_revenue' => Transaction::where('type', 'profit')
                ->sum('amount'),
            'revenue_30d' => Transaction::where('type', 'profit')
                ->where('created_at', '>=', now()->subDays(30))
                ->sum('amount'),
        ];
    }
    
    /**
     * Get chart data for graphs
     */
    private function getChartData(): array
    {
        // Revenue Chart - Last 7 days
        $revenueData = Transaction::where('type', 'profit')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $revenueDates = [];
        $revenueAmounts = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenueDates[] = now()->subDays($i)->format('D');
            
            $dayData = $revenueData->firstWhere('date', $date);
            $revenueAmounts[] = $dayData ? $dayData->total : 0;
        }
        
        // Cards Distribution
        $cardsDistribution = Investment::select('investment_card_id', DB::raw('COUNT(*) as count'))
            ->groupBy('investment_card_id')
            ->with('investmentCard')
            ->get();
        
        $cardLabels = [];
        $cardData = [];
        
        foreach ($cardsDistribution as $dist) {
            if ($dist->investmentCard) {
                $cardLabels[] = $dist->investmentCard->name . ' ($' . $dist->investmentCard->price . ')';
                $cardData[] = $dist->count;
            }
        }
        
        // If no data, use default
        if (empty($cardLabels)) {
            $cardLabels = ['Bronze ($200)', 'Silver ($500)', 'Gold ($1,000)', 'Platinum ($1,500)'];
            $cardData = [20, 28, 32, 20];
        }
        
        return [
            'revenue' => [
                'labels' => $revenueDates,
                'data' => $revenueAmounts,
            ],
            'cards' => [
                'labels' => $cardLabels,
                'data' => $cardData,
            ],
        ];
    }
    
    /**
     * Get recent platform activities
     */
    private function getRecentActivities(): array
    {
        $activities = [];
        
        // Recent users
        $newUsers = User::latest()
            ->limit(2)
            ->get();
        
        foreach ($newUsers as $user) {
            $activities[] = [
                'icon' => '👤',
                'color' => 'from-sky-500/10 to-blue-600/5',
                'title' => 'Nouvel utilisateur',
                'description' => $user->name . ' s\'est inscrit sur la plateforme',
                'time' => $user->created_at->diffForHumans(),
            ];
        }
        
        // Recent investments
        $recentInvestments = Investment::with(['user', 'investmentCard'])
            ->latest()
            ->limit(2)
            ->get();
        
        foreach ($recentInvestments as $investment) {
            $activities[] = [
                'icon' => '💳',
                'color' => 'from-green-500/10 to-emerald-600/5',
                'title' => 'Achat de carte',
                'description' => ($investment->user->name ?? 'Utilisateur') . ' - Carte ' . ($investment->investmentCard->name ?? 'Investment'),
                'time' => $investment->created_at->diffForHumans(),
            ];
        }
        
        // Recent withdrawals
        $recentWithdrawals = Withdrawal::with('user')
            ->latest()
            ->limit(2)
            ->get();
        
        foreach ($recentWithdrawals as $withdrawal) {
            $activities[] = [
                'icon' => '💰',
                'color' => 'from-amber-500/10 to-orange-600/5',
                'title' => 'Demande de retrait',
                'description' => ($withdrawal->user->name ?? 'Utilisateur') . ' demande un retrait de $' . number_format($withdrawal->amount, 2),
                'time' => $withdrawal->created_at->diffForHumans(),
            ];
        }
        
        // Sort by time and limit to 5
        usort($activities, function($a, $b) {
            return strcmp($b['time'], $a['time']);
        });
        
        return array_slice($activities, 0, 5);
    }
    
    /**
     * Get top investors by total invested amount
     */
    private function getTopInvestors()
    {
        return User::select('users.*')
            ->selectRaw('COUNT(investments.id) as investments_count')
            ->selectRaw('SUM(investments.amount) as total_invested')
            ->join('investments', 'users.id', '=', 'investments.user_id')
            ->where('investments.status', 'active')
            ->groupBy('users.id')
            ->orderByDesc('total_invested')
            ->limit(5)
            ->get();
    }
}