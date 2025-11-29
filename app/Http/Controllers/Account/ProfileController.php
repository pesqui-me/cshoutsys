<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use App\Models\UserNotification;

class ProfileController extends Controller
{
    /**
     * Afficher le profil utilisateur
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('account.profile', compact('user'));
    }

    /**
     * Mettre à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
        ]);

        return back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }

    /**
     * Mettre à jour l'avatar
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Supprimer l'ancien avatar s'il existe
            if ($user->hasMedia('avatar')) {
                $user->clearMediaCollection('avatar');
            }

            // Ajouter le nouveau avatar
            $user->addMedia($request->file('avatar'))
                ->toMediaCollection('avatar');

            DB::commit();

            return back()->with('success', 'Votre photo de profil a été mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de votre photo.');
        }
    }

    /**
     * Supprimer l'avatar
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->hasMedia('avatar')) {
            $user->clearMediaCollection('avatar');
            return back()->with('success', 'Votre photo de profil a été supprimée avec succès.');
        }

        return back()->with('error', 'Vous n\'avez pas de photo de profil à supprimer.');
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Votre mot de passe a été modifié avec succès.');
    }

    /**
     * ⭐ Afficher les notifications (CORRIGÉ COMPLET)
     */
    public function notifications(Request $request)
    {
        $user = Auth::user();

        // Filtrer par statut
        $query = UserNotification::where('user_id', $user->id);

        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->unread();
            } elseif ($request->filter === 'read') {
                $query->where('is_read', true);
            }
        }

        // Filtrer par type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $notifications = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        // ⭐ Compter les non lues
        $unreadCount = UserNotification::where('user_id', $user->id)
            ->unread()
            ->count();

        // Stats
        $stats = [
            'total' => UserNotification::where('user_id', $user->id)->count(),
            'unread' => $unreadCount,
            'read' => UserNotification::where('user_id', $user->id)->where('is_read', true)->count(),
        ];

        return view('account.notifications', compact('user', 'notifications', 'unreadCount', 'stats'));
    }

    /**
     * ⭐ Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = UserNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->markAsRead();

        // Si action_url existe, rediriger vers cette URL
        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * ⭐ Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        UserNotification::where('user_id', Auth::id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * ⭐ Supprimer une notification
     */
    public function deleteNotification($id)
    {
        $notification = UserNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return back()->with('success', 'Notification supprimée.');
    }

    /**
     * ⭐ Supprimer toutes les notifications lues
     */
    public function deleteAllRead()
    {
        $deleted = UserNotification::where('user_id', Auth::id())
            ->where('is_read', true)
            ->delete();

        return back()->with('success', $deleted . ' notification(s) supprimée(s).');
    }

    /**
     * Mettre à jour les préférences de notification
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'investment_notifications' => 'boolean',
            'withdrawal_notifications' => 'boolean',
            'promotion_notifications' => 'boolean',
        ]);

        // Stocker les préférences dans un champ JSON
        $preferences = [
            'email' => $request->boolean('email_notifications'),
            'sms' => $request->boolean('sms_notifications'),
            'investment' => $request->boolean('investment_notifications'),
            'withdrawal' => $request->boolean('withdrawal_notifications'),
            'promotion' => $request->boolean('promotion_notifications'),
        ];

        // Si vous avez un champ preferences dans users table:
        // $user->update(['preferences' => $preferences]);

        return back()->with('success', 'Vos préférences de notification ont été mises à jour.');
    }

    /**
     * Afficher les informations de parrainage
     */
    public function referral()
    {
        $user = Auth::user();
        
        // Statistiques de parrainage
        $referralStats = [
            'total_referrals' => $user->referrals()->count(),
            'active_referrals' => $user->referrals()->where('is_active', true)->count(),
            'total_commission' => 0, // À calculer selon votre logique
        ];

        // Liste des filleuls
        $referrals = $user->referrals()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Lien de parrainage
        $referralLink = route('register') . '?ref=' . $user->referral_code;

        return view('user.profile.referral', compact('user', 'referralStats', 'referrals', 'referralLink'));
    }

    /**
     * Afficher l'activité récente
     */
    public function activity()
    {
        $user = Auth::user();

        // Activités récentes (combinaison de plusieurs types d'événements)
        $activities = collect();

        // Investissements récents
        if (method_exists($user, 'investments')) {
            $investments = $user->investments()
                ->with('investmentCard')
                ->latest()
                ->limit(10)
                ->get()
                ->map(function($investment) {
                    return [
                        'type' => 'investment',
                        'icon' => '💎',
                        'title' => 'Achat de ' . $investment->investmentCard->name,
                        'description' => 'Montant: ' . $investment->investmentCard->formatted_price,
                        'date' => $investment->created_at,
                        'url' => route('user.investments.show', $investment->id),
                    ];
                });
            $activities = $activities->concat($investments);
        }

        // Transactions récentes
        if (method_exists($user, 'transactions')) {
            $transactions = $user->transactions()
                ->latest()
                ->limit(10)
                ->get()
                ->map(function($transaction) {
                    return [
                        'type' => 'transaction',
                        'icon' => '💳',
                        'title' => $transaction->type_label,
                        'description' => 'Montant: ' . $transaction->formatted_amount,
                        'date' => $transaction->created_at,
                        'url' => route('user.transactions.show', $transaction->id),
                    ];
                });
            $activities = $activities->concat($transactions);
        }

        // Retraits récents
        if (method_exists($user, 'withdrawals')) {
            $withdrawals = $user->withdrawals()
                ->latest()
                ->limit(10)
                ->get()
                ->map(function($withdrawal) {
                    return [
                        'type' => 'withdrawal',
                        'icon' => '💰',
                        'title' => 'Demande de retrait',
                        'description' => 'Montant: ' . $withdrawal->formatted_amount . ' - ' . $withdrawal->status_label,
                        'date' => $withdrawal->created_at,
                        'url' => route('user.withdrawals.show', $withdrawal->id),
                    ];
                });
            $activities = $activities->concat($withdrawals);
        }

        // Combiner et trier toutes les activités
        $activities = $activities
            ->sortByDesc('date')
            ->take(20);

        return view('user.profile.activity', compact('activities'));
    }

    /**
     * Supprimer le compte (soft delete)
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
            'confirmation' => 'required|in:DELETE',
        ]);

        $user = Auth::user();

        // Vérifier qu'il n'y a pas d'investissements actifs
        if (method_exists($user, 'investments') && $user->active_investments > 0) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre compte avec des investissements actifs.');
        }

        // Vérifier qu'il n'y a pas de retraits en attente
        if (method_exists($user, 'withdrawals')) {
            $pendingWithdrawals = $user->withdrawals()
                ->whereIn('status', ['pending', 'under_review', 'approved', 'processing'])
                ->count();

            if ($pendingWithdrawals > 0) {
                return back()->with('error', 'Vous ne pouvez pas supprimer votre compte avec des retraits en attente.');
            }
        }

        DB::beginTransaction();

        try {
            // Soft delete de l'utilisateur
            $user->delete();

            // Déconnecter l'utilisateur
            Auth::logout();

            DB::commit();

            return redirect()
                ->route('login')
                ->with('success', 'Votre compte a été supprimé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Une erreur est survenue lors de la suppression de votre compte.');
        }
    }
}