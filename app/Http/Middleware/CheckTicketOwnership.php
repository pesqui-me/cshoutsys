<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SupportTicket;

class CheckTicketOwnership
{
    /**
     * Handle an incoming request.
     *
     * Vérifie que l'utilisateur connecté est bien le propriétaire du ticket
     * ou un agent de support assigné
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'ID du ticket depuis la route
        $ticketId = $request->route('ticket');

        // Si c'est un objet, récupérer son ID
        if ($ticketId instanceof SupportTicket) {
            $ticket = $ticketId;
        } else {
            // Sinon, charger le ticket depuis la BDD
            $ticket = SupportTicket::find($ticketId);
        }

        // Vérifier que le ticket existe
        if (!$ticket) {
            abort(404, 'Ticket introuvable.');
        }

        $user = auth()->user();

        // Les admins et support agents ont accès à tous les tickets
        if ($user->hasRole(['super-admin', 'admin', 'support'])) {
            return $next($request);
        }

        // Vérifier la propriété pour les utilisateurs normaux
        if ($ticket->user_id !== $user->id) {
            // Log de la tentative d'accès non autorisée
            logger()->warning('Unauthorized ticket access attempt', [
                'user_id' => $user->id,
                'ticket_id' => $ticket->id,
                'ticket_owner_id' => $ticket->user_id,
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);

            abort(403, 'Vous n\'avez pas accès à ce ticket.');
        }

        return $next($request);
    }
}