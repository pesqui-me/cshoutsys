<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Withdrawal;

class CheckWithdrawalOwnership
{
    /**
     * Handle an incoming request.
     *
     * Vérifie que l'utilisateur connecté est bien le propriétaire du retrait
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'ID du retrait depuis la route
        $withdrawalId = $request->route('withdrawal');

        // Si c'est un objet, récupérer son ID
        if ($withdrawalId instanceof Withdrawal) {
            $withdrawal = $withdrawalId;
        } else {
            // Sinon, charger le retrait depuis la BDD
            $withdrawal = Withdrawal::find($withdrawalId);
        }

        // Vérifier que le retrait existe
        if (!$withdrawal) {
            abort(404, 'Retrait introuvable.');
        }

        // Vérifier la propriété (sauf pour les admins)
        if (!auth()->user()->hasRole(['super-admin', 'admin'])) {
            if ($withdrawal->user_id !== auth()->id()) {
                // Log de la tentative d'accès non autorisée
                logger()->warning('Unauthorized withdrawal access attempt', [
                    'user_id' => auth()->id(),
                    'withdrawal_id' => $withdrawal->id,
                    'withdrawal_owner_id' => $withdrawal->user_id,
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                ]);

                abort(403, 'Vous n\'avez pas accès à ce retrait.');
            }
        }

        return $next($request);
    }
}