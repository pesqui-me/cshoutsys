<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des utilisateurs
     */
    public function viewAny(User $user): Response
    {
        // Seuls les admins peuvent voir la liste des utilisateurs
        return $user->hasRole(['super-admin', 'admin', 'support'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent voir la liste des utilisateurs.');
    }

    /**
     * Détermine si l'utilisateur peut voir un utilisateur spécifique
     */
    public function view(User $user, User $model): Response
    {
        // Les admins peuvent voir tous les utilisateurs
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // Un utilisateur peut voir son propre profil
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('Vous ne pouvez voir que votre propre profil.');
    }

    /**
     * Détermine si l'utilisateur peut créer un utilisateur (admin)
     */
    public function create(User $user): Response
    {
        // Seuls les admins peuvent créer des utilisateurs
        return $user->hasRole(['super-admin', 'admin'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent créer des utilisateurs.');
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un utilisateur
     */
    public function update(User $user, User $model): Response
    {
        // Les super-admins peuvent tout modifier
        if ($user->hasRole('super-admin')) {
            return Response::allow();
        }

        // Les admins peuvent modifier les utilisateurs normaux
        if ($user->hasRole('admin')) {
            // Mais pas les autres admins ou super-admins
            if ($model->hasRole(['super-admin', 'admin'])) {
                return Response::deny('Vous ne pouvez pas modifier un autre administrateur.');
            }
            return Response::allow();
        }

        // Un utilisateur peut modifier son propre profil (limité)
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('Vous ne pouvez modifier que votre propre profil.');
    }

    /**
     * Détermine si l'utilisateur peut supprimer un utilisateur
     */
    public function delete(User $user, User $model): Response
    {
        // On ne peut pas se supprimer soi-même
        if ($user->id === $model->id) {
            return Response::deny('Vous ne pouvez pas supprimer votre propre compte depuis l\'admin.');
        }

        // Seuls les super-admins peuvent supprimer
        if (!$user->hasRole('super-admin')) {
            return Response::deny('Seuls les super-administrateurs peuvent supprimer des utilisateurs.');
        }

        // Ne pas supprimer d'autres super-admins
        if ($model->hasRole('super-admin')) {
            return Response::deny('Vous ne pouvez pas supprimer un autre super-administrateur.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut activer/désactiver un compte
     */
    public function toggleStatus(User $user, User $model): Response
    {
        // On ne peut pas désactiver son propre compte
        if ($user->id === $model->id) {
            return Response::deny('Vous ne pouvez pas désactiver votre propre compte.');
        }

        // Les super-admins peuvent tout faire
        if ($user->hasRole('super-admin')) {
            return Response::allow();
        }

        // Les admins peuvent désactiver les utilisateurs normaux
        if ($user->hasRole('admin')) {
            if ($model->hasRole(['super-admin', 'admin'])) {
                return Response::deny('Vous ne pouvez pas désactiver un autre administrateur.');
            }
            return Response::allow();
        }

        return Response::deny('Seuls les administrateurs peuvent activer/désactiver des comptes.');
    }

    /**
     * Détermine si l'utilisateur peut modifier le solde d'un utilisateur
     */
    public function updateBalance(User $user, User $model): Response
    {
        // Seuls les admins peuvent modifier les soldes
        if (!$user->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Seuls les administrateurs peuvent modifier les soldes.');
        }

        // Ne pas modifier le solde d'un admin
        if ($model->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Vous ne pouvez pas modifier le solde d\'un administrateur.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut se connecter en tant qu'un autre utilisateur (impersonate)
     */
    public function impersonate(User $user, User $model): Response
    {
        // On ne peut pas s'impersonnifier soi-même
        if ($user->id === $model->id) {
            return Response::deny('Vous ne pouvez pas vous impersonnifier vous-même.');
        }

        // Seuls les super-admins peuvent impersonnifier
        if (!$user->hasRole('super-admin')) {
            return Response::deny('Seuls les super-administrateurs peuvent se connecter en tant qu\'un autre utilisateur.');
        }

        // Ne pas impersonnifier d'autres admins
        if ($model->hasRole(['super-admin', 'admin'])) {
            return Response::deny('Vous ne pouvez pas vous connecter en tant qu\'un autre administrateur.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut assigner des rôles
     */
    public function assignRole(User $user, User $model): Response
    {
        // Seuls les super-admins peuvent assigner des rôles
        if (!$user->hasRole('super-admin')) {
            return Response::deny('Seuls les super-administrateurs peuvent assigner des rôles.');
        }

        // On ne peut pas changer son propre rôle
        if ($user->id === $model->id) {
            return Response::deny('Vous ne pouvez pas changer votre propre rôle.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut voir les statistiques d'un utilisateur
     */
    public function viewStatistics(User $user, User $model): Response
    {
        // Les admins peuvent voir les stats de tous les utilisateurs
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // Un utilisateur peut voir ses propres stats
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('Vous ne pouvez voir que vos propres statistiques.');
    }

    /**
     * Détermine si l'utilisateur peut exporter la liste des utilisateurs
     */
    public function export(User $user): Response
    {
        // Seuls les admins peuvent exporter
        return $user->hasRole(['super-admin', 'admin'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent exporter la liste des utilisateurs.');
    }

    /**
     * Détermine si l'utilisateur peut voir l'historique d'activité
     */
    public function viewActivityLog(User $user, User $model): Response
    {
        // Les admins peuvent voir l'historique de tous
        if ($user->hasRole(['super-admin', 'admin'])) {
            return Response::allow();
        }

        // Un utilisateur peut voir son propre historique
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('Vous ne pouvez voir que votre propre historique.');
    }
}