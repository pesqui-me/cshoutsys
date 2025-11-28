<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserInvestment;
use App\Models\Transaction;
use App\Models\UserNotification;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Afficher le dashboard utilisateur
     */
    public function index()
    {
        $user = Auth::user();

        // Statistiques utilisateur
        $stats = [
            'balance' => $user->balance,
            'total_invested' => $user->total_invested,
            'pending_profit' => $user->pending_profit,
            'active_investments' => $user->active_investments,
        ];

        // Investissements actifs avec compte à rebours
        $activeInvestments = UserInvestment::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('investmentCard')
            ->orderBy('activated_at', 'desc')
            ->get();

        // Calculer le temps restant pour le premier investissement
        $nextCompletion = null;
        if ($activeInvestments->isNotEmpty()) {
            $firstInvestment = $activeInvestments->first();
            $remainingSeconds = $firstInvestment->remaining_time;
            
            if ($remainingSeconds > 0) {
                $nextCompletion = [
                    'hours' => floor($remainingSeconds / 3600),
                    'minutes' => floor(($remainingSeconds % 3600) / 60),
                    'seconds' => $remainingSeconds % 60,
                    'total_seconds' => $remainingSeconds,
                ];
            }
        }

        // Dernières transactions (5 dernières)
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with(['userInvestment.investmentCard', 'paymentMethod'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Notifications non lues
        $unreadNotifications = $user->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('account.dashboard', compact(
            'user',
            'stats',
            'activeInvestments',
            'nextCompletion',
            'recentTransactions',
            'unreadNotifications'
        ));
    }

    /**
     * Obtenir les statistiques en temps réel (AJAX)
     */
    public function getStats(Request $request)
    {
        $user = Auth::user();

        // Rafraîchir les données depuis la base
        $user->refresh();

        return response()->json([
            'balance' => $user->formatted_balance,
            'total_invested' => $user->formatted_total_invested,
            'pending_profit' => $user->formatted_pending_profit,
            'active_investments' => $user->active_investments,
        ]);
    }

    /**
     * Obtenir le temps restant pour un investissement (AJAX)
     */
    public function getRemainingTime(Request $request, $investmentId)
    {
        $investment = UserInvestment::where('id', $investmentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $remainingSeconds = $investment->remaining_time;

        if ($remainingSeconds <= 0) {
            // L'investissement est terminé, mettre à jour le statut
            if ($investment->status === 'active') {
                $investment->update(['status' => 'processing']);
            }

            return response()->json([
                'completed' => true,
                'remaining_seconds' => 0,
            ]);
        }

        return response()->json([
            'completed' => false,
            'remaining_seconds' => $remainingSeconds,
            'hours' => floor($remainingSeconds / 3600),
            'minutes' => floor(($remainingSeconds % 3600) / 60),
            'seconds' => $remainingSeconds % 60,
            'progress' => $investment->progress_percentage,
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markNotificationsRead()
    {
        Auth::user()->unreadNotifications()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifications marquées comme lues',
        ]);
    }

    /**
     * Marquer une notification spécifique comme lue
     */
    public function markNotificationRead($notificationId)
    {
        $notification = UserNotification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue',
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function deleteNotification($notificationId)
    {
        $notification = UserNotification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification supprimée',
        ]);
    }
}