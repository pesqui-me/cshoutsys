<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserInvestment;
use Illuminate\Auth\Access\Response;

class InvestmentPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des investissements
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir leurs propres investissements
        // Les admins peuvent voir tous les investissements
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir un investissement spécifique
     */
    public function view(User $user, UserInvestment $investment): Response
    {
        // Les admins peuvent voir tous les investissements
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // L'utilisateur peut voir ses propres investissements
        return $user->id === $investment->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès à cet investissement.');
    }

    /**
     * Détermine si l'utilisateur peut créer un investissement
     */
    public function create(User $user): Response
    {
        // Vérifier que le compte est actif
        if (!$user->is_active) {
            return Response::deny('Votre compte est désactivé. Contactez le support.');
        }

        // Vérifier qu'il n'y a pas trop d'investissements en attente
        $pendingInvestments = UserInvestment::where('user_id', $user->id)
            ->whereIn('status', ['pending_payment', 'payment_processing'])
            ->count();

        if ($pendingInvestments >= 5) {
            return Response::deny('Vous avez trop d\'investissements en attente. Veuillez finaliser les paiements en cours.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un investissement
     */
    public function update(User $user, UserInvestment $investment): Response
    {
        // Seuls les admins peuvent modifier les investissements
        return $user->hasRole(['super-admin', 'admin'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent modifier les investissements.');
    }

    /**
     * Détermine si l'utilisateur peut supprimer un investissement
     */
    public function delete(User $user, UserInvestment $investment): Response
    {
        // Seuls les super-admins peuvent supprimer
        return $user->hasRole('super-admin')
            ? Response::allow()
            : Response::deny('Seuls les super-administrateurs peuvent supprimer des investissements.');
    }

    /**
     * Détermine si l'utilisateur peut annuler un investissement
     */
    public function cancel(User $user, UserInvestment $investment): Response
    {
        // Les admins peuvent annuler n'importe quel investissement
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // Vérifier que c'est bien son investissement
        if ($user->id !== $investment->user_id) {
            return Response::deny('Vous ne pouvez pas annuler l\'investissement d\'un autre utilisateur.');
        }

        // Vérifier que l'investissement peut être annulé
        if (!in_array($investment->status, ['pending_payment', 'payment_processing'])) {
            return Response::deny('Cet investissement ne peut plus être annulé.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut approuver un investissement (admin)
     */
    public function approve(User $user, UserInvestment $investment): Response
    {
        // Seuls les admins peuvent approuver
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent approuver des investissements.');
        }

        // Vérifier que l'investissement est en attente
        if (!in_array($investment->status, ['pending_payment', 'payment_processing'])) {
            return Response::deny('Cet investissement ne peut pas être approuvé dans son état actuel.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut activer un investissement (admin)
     */
    public function activate(User $user, UserInvestment $investment): Response
    {
        // Seuls les admins peuvent activer
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent activer des investissements.');
        }

        // Vérifier que l'investissement n'est pas déjà actif
        if ($investment->status === 'active') {
            return Response::deny('Cet investissement est déjà actif.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut compléter un investissement (admin)
     */
    public function complete(User $user, UserInvestment $investment): Response
    {
        // Seuls les admins peuvent compléter
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent compléter des investissements.');
        }

        // Vérifier que l'investissement est actif ou en traitement
        if (!in_array($investment->status, ['active', 'processing'])) {
            return Response::deny('Cet investissement ne peut pas être complété dans son état actuel.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut rembourser un investissement (admin)
     */
    public function refund(User $user, UserInvestment $investment): Response
    {
        // Seuls les admins peuvent rembourser
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent rembourser des investissements.');
        }

        // Vérifier que l'investissement n'est pas déjà remboursé
        if ($investment->status === 'refunded') {
            return Response::deny('Cet investissement a déjà été remboursé.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut télécharger la preuve de paiement
     */
    public function downloadProof(User $user, UserInvestment $investment): Response
    {
        // Les admins peuvent télécharger toutes les preuves
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // L'utilisateur peut télécharger sa propre preuve
        return $user->id === $investment->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès à cette preuve de paiement.');
    }
}