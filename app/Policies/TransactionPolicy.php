<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des transactions
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir leurs transactions
        // Les admins peuvent voir toutes les transactions
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir une transaction spécifique
     */
    public function view(User $user, Transaction $transaction): Response
    {
        // Les admins peuvent voir toutes les transactions
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // L'utilisateur peut voir ses propres transactions
        return $user->id === $transaction->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès à cette transaction.');
    }

    /**
     * Détermine si l'utilisateur peut créer une transaction manuelle (admin)
     */
    public function create(User $user): Response
    {
        // Seuls les admins peuvent créer des transactions manuelles
        return $user->hasRole(['super-admin', 'admin'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent créer des transactions manuelles.');
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour une transaction
     */
    public function update(User $user, Transaction $transaction): Response
    {
        // Seuls les admins peuvent modifier les transactions
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent modifier les transactions.');
        }

        // Ne pas permettre de modifier les transactions complétées
        if ($transaction->status === 'completed') {
            return Response::deny('Les transactions complétées ne peuvent pas être modifiées.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut supprimer une transaction
     */
    public function delete(User $user, Transaction $transaction): Response
    {
        // Seuls les super-admins peuvent supprimer
        if (!$user->hasRole('super-admin')) {
            return Response::deny('Seuls les super-administrateurs peuvent supprimer des transactions.');
        }

        // Ne pas permettre de supprimer les transactions complétées
        if ($transaction->status === 'completed') {
            return Response::deny('Les transactions complétées ne peuvent pas être supprimées.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut changer le statut d'une transaction (admin)
     */
    public function changeStatus(User $user, Transaction $transaction): Response
    {
        // Seuls les admins peuvent changer le statut
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent changer le statut des transactions.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut télécharger le reçu
     */
    public function downloadReceipt(User $user, Transaction $transaction): Response
    {
        // Les admins peuvent télécharger tous les reçus
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // L'utilisateur peut télécharger le reçu de sa propre transaction complétée
        if ($user->id === $transaction->user_id && $transaction->status === 'completed') {
            return Response::allow();
        }

        return Response::deny('Vous ne pouvez pas télécharger ce reçu.');
    }

    /**
     * Détermine si l'utilisateur peut télécharger la preuve de paiement
     */
    public function downloadProof(User $user, Transaction $transaction): Response
    {
        // Les admins peuvent télécharger toutes les preuves
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // L'utilisateur peut télécharger sa propre preuve
        return $user->id === $transaction->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès à cette preuve de paiement.');
    }

    /**
     * Détermine si l'utilisateur peut exporter les transactions
     */
    public function export(User $user): Response
    {
        // Tous les utilisateurs peuvent exporter leurs propres transactions
        // Les admins peuvent exporter toutes les transactions
        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut voir les statistiques (admin)
     */
    public function viewStatistics(User $user): Response
    {
        // Seuls les admins peuvent voir les statistiques globales
        return $user->hasRole(['super-admin', 'admin'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent voir les statistiques globales.');
    }
}