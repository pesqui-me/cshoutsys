<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SupportTicket;
use Illuminate\Auth\Access\Response;

class SupportTicketPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des tickets
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir leurs tickets
        // Les admins et support peuvent voir tous les tickets
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir un ticket spécifique
     */
    public function view(User $user, SupportTicket $ticket): Response
    {
        // Les admins et support peuvent voir tous les tickets
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // L'utilisateur peut voir ses propres tickets
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès à ce ticket.');
    }

    /**
     * Détermine si l'utilisateur peut créer un ticket
     */
    public function create(User $user): Response
    {
        // Vérifier que le compte est actif
        if (!$user->is_active) {
            return Response::deny('Votre compte est désactivé. Contactez le support par email.');
        }

        // Vérifier le nombre de tickets ouverts
        $openTickets = SupportTicket::where('user_id', $user->id)
            ->whereIn('status', ['new', 'open', 'in_progress'])
            ->count();

        if ($openTickets >= 5) {
            return Response::deny('Vous avez trop de tickets ouverts. Veuillez attendre qu\'ils soient traités.');
        }

        // Vérifier qu'il n'y a pas de spam (rate limiting)
        $recentTickets = SupportTicket::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentTickets >= 3) {
            return Response::deny('Vous créez trop de tickets. Veuillez patienter avant d\'en créer un nouveau.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un ticket
     */
    public function update(User $user, SupportTicket $ticket): Response
    {
        // Les admins et support peuvent modifier
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // Les utilisateurs ne peuvent pas modifier leurs tickets directement
        return Response::deny('Vous ne pouvez pas modifier un ticket. Utilisez la fonction de réponse.');
    }

    /**
     * Détermine si l'utilisateur peut supprimer un ticket
     */
    public function delete(User $user, SupportTicket $ticket): Response
    {
        // Seuls les super-admins peuvent supprimer
        return $user->hasRole('super-admin')
            ? Response::allow()
            : Response::deny('Seuls les super-administrateurs peuvent supprimer des tickets.');
    }

    /**
     * Détermine si l'utilisateur peut répondre à un ticket
     */
    public function reply(User $user, SupportTicket $ticket): Response
    {
        // Les admins et support peuvent toujours répondre
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // Vérifier que c'est son ticket
        if ($user->id !== $ticket->user_id) {
            return Response::deny('Vous ne pouvez pas répondre au ticket d\'un autre utilisateur.');
        }

        // Vérifier que le ticket n'est pas fermé
        if ($ticket->status === 'closed') {
            return Response::deny('Ce ticket est fermé. Veuillez créer un nouveau ticket si nécessaire.');
        }

        return Response::allow();
    }

    /**
     * Détermine si l'utilisateur peut fermer un ticket
     */
    public function close(User $user, SupportTicket $ticket): Response
    {
        // Les admins et support peuvent fermer n'importe quel ticket
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // L'utilisateur peut fermer son propre ticket
        if ($user->id === $ticket->user_id) {
            // Seulement s'il est résolu ou ouvert
            if (in_array($ticket->status, ['resolved', 'open', 'in_progress'])) {
                return Response::allow();
            }
            return Response::deny('Ce ticket ne peut pas être fermé dans son état actuel.');
        }

        return Response::deny('Vous ne pouvez pas fermer le ticket d\'un autre utilisateur.');
    }

    /**
     * Détermine si l'utilisateur peut rouvrir un ticket
     */
    public function reopen(User $user, SupportTicket $ticket): Response
    {
        // Les admins et support peuvent rouvrir
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // L'utilisateur peut rouvrir son propre ticket fermé
        if ($user->id === $ticket->user_id && $ticket->status === 'closed') {
            // Vérifier qu'il ne rouvre pas trop souvent
            $recentReopens = SupportTicket::where('user_id', $user->id)
                ->where('updated_at', '>=', now()->subDay())
                ->whereIn('status', ['open', 'in_progress'])
                ->count();

            if ($recentReopens >= 3) {
                return Response::deny('Vous avez déjà réouvert plusieurs tickets récemment.');
            }

            return Response::allow();
        }

        return Response::deny('Vous ne pouvez pas rouvrir ce ticket.');
    }

    /**
     * Détermine si l'utilisateur peut assigner un ticket (admin/support)
     */
    public function assign(User $user, SupportTicket $ticket): Response
    {
        // Seuls les admins et support peuvent assigner
        return $user->hasRole(['super-admin', 'admin', 'support'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs et agents de support peuvent assigner des tickets.');
    }

    /**
     * Détermine si l'utilisateur peut changer le statut (admin/support)
     */
    public function changeStatus(User $user, SupportTicket $ticket): Response
    {
        // Seuls les admins et support peuvent changer le statut
        return $user->hasRole(['super-admin', 'admin', 'support'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs et agents de support peuvent changer le statut des tickets.');
    }

    /**
     * Détermine si l'utilisateur peut changer la priorité (admin)
     */
    public function changePriority(User $user, SupportTicket $ticket): Response
    {
        // Seuls les admins peuvent changer la priorité
        return $user->hasRole(['super-admin', 'admin'])
            ? Response::allow()
            : Response::deny('Seuls les administrateurs peuvent changer la priorité des tickets.');
    }

    /**
     * Détermine si l'utilisateur peut télécharger les pièces jointes
     */
    public function downloadAttachment(User $user, SupportTicket $ticket): Response
    {
        // Les admins et support peuvent télécharger
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // L'utilisateur peut télécharger les pièces jointes de son propre ticket
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès aux pièces jointes de ce ticket.');
    }

    /**
     * Détermine si l'utilisateur peut uploader des pièces jointes
     */
    public function uploadAttachment(User $user, SupportTicket $ticket): Response
    {
        // Les admins et support peuvent uploader
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return Response::allow();
        }

        // L'utilisateur peut uploader sur son propre ticket s'il n'est pas fermé
        if ($user->id === $ticket->user_id && $ticket->status !== 'closed') {
            return Response::allow();
        }

        return Response::deny('Vous ne pouvez pas ajouter de pièces jointes à ce ticket.');
    }
}