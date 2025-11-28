<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Setting;
use Illuminate\Auth\Access\Response;

class WithdrawalPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des retraits
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir leurs propres retraits
        // Les admins peuvent voir tous les retraits
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir un retrait spécifique
     */
    public function view(User $user, Withdrawal $withdrawal): Response
    {
        // Les admins peuvent voir tous les retraits
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // L'utilisateur peut voir ses propres retraits
        return $user->id === $withdrawal->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès à ce retrait.');
    }

    /**
     * Détermine si l'utilisateur peut créer un retrait
     */
    public function create(User $user): Response
    {
        // Vérifier que le compte est actif
        if (!$user->is_active) {
            return Response::deny('Votre compte est désactivé. Contactez le support.');
        }

        // Vérifier le solde minimum
        $minWithdrawal = Setting::get('min_withdrawal_amount', 50);
        if ($user->balance < $minWithdrawal) {
            return Response::deny("Votre solde est insuffisant. Le montant minimum de retrait est de {$minWithdrawal}$.");
        }

        // Vérifier le nombre de retraits en attente
        $pendingWithdrawals = Withdrawal::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'under_review', 'approved', 'processing'])
            ->count();

        if ($pendingWithdrawals >= 3) {
            return Response::deny('Vous avez déjà 3 demandes de retrait en cours. Veuillez attendre leur traitement.');
        }

        // Vérifier KYC si requis
        $requireKyc = Setting::get('kyc_required_for_withdrawal', true);
        if ($requireKyc && !$user->hasVerifiedKyc()) {
            return Response::deny('Vous devez compléter votre vérification KYC avant de pouvoir effectuer un retrait.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un retrait
     */
    public function update(User $user, Withdrawal $withdrawal): Response
    {
        // Seuls les admins peuvent modifier
        return $user->hasRole(['super-admin', 'admin'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent modifier les retraits.');
    }

    /**
     * Détermine si l'utilisateur peut supprimer un retrait
     */
    public function delete(User $user, Withdrawal $withdrawal): Response
    {
        // Seuls les super-admins peuvent supprimer
        return $user->hasRole('super-admin')
            ? Response::allow()
            : Response::deny('Seuls les super-administrateurs peuvent supprimer des retraits.');
    }

    /**
     * Détermine si l'utilisateur peut annuler un retrait
     */
    public function cancel(User $user, Withdrawal $withdrawal): Response
    {
        // Les admins peuvent annuler n'importe quel retrait
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // Vérifier que c'est bien son retrait
        if ($user->id !== $withdrawal->user_id) {
            return Response::deny('Vous ne pouvez pas annuler le retrait d\'un autre utilisateur.');
        }

        // Vérifier que le retrait peut être annulé
        if (!in_array($withdrawal->status, ['pending', 'under_review'])) {
            return Response::deny('Ce retrait ne peut plus être annulé.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut approuver un retrait (admin)
     */
    public function approve(User $user, Withdrawal $withdrawal): Response
    {
        // Seuls les admins peuvent approuver
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent approuver des retraits.');
        }

        // Vérifier que le retrait est en attente
        if (!in_array($withdrawal->status, ['pending', 'under_review'])) {
            return Response::deny('Ce retrait ne peut pas être approuvé dans son état actuel.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut rejeter un retrait (admin)
     */
    public function reject(User $user, Withdrawal $withdrawal): Response
    {
        // Seuls les admins peuvent rejeter
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent rejeter des retraits.');
        }

        // Vérifier que le retrait est en attente
        if (!in_array($withdrawal->status, ['pending', 'under_review', 'approved'])) {
            return Response::deny('Ce retrait ne peut pas être rejeté dans son état actuel.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut traiter un retrait (admin)
     */
    public function process(User $user, Withdrawal $withdrawal): Response
    {
        // Seuls les admins peuvent traiter
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent traiter des retraits.');
        }

        // Vérifier que le retrait est approuvé
        if ($withdrawal->status !== 'approved') {
            return Response::deny('Ce retrait doit être approuvé avant d\'être traité.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut compléter un retrait (admin)
     */
    public function complete(User $user, Withdrawal $withdrawal): Response
    {
        // Seuls les admins peuvent compléter
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent compléter des retraits.');
        }

        // Vérifier que le retrait est en traitement
        if (!in_array($withdrawal->status, ['processing', 'approved'])) {
            return Response::deny('Ce retrait ne peut pas être complété dans son état actuel.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut uploader une preuve de transfert (admin)
     */
    public function uploadProof(User $user, Withdrawal $withdrawal): Response
    {
        // Seuls les admins peuvent uploader des preuves
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent uploader des preuves de transfert.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut télécharger la preuve de transfert
     */
    public function downloadProof(User $user, Withdrawal $withdrawal): Response
    {
        // Les admins peuvent télécharger toutes les preuves
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // L'utilisateur peut télécharger sa propre preuve si le retrait est complété
        if ($user->id === $withdrawal->user_id && $withdrawal->status === 'completed') {
            return Response::allow();
        }

        return Response::deny('Vous n\'avez pas accès à cette preuve de transfert.');
    }
}