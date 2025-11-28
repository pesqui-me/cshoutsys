<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserInvestment;

class CheckInvestmentOwnership
{
    /**
     * Handle an incoming request.
     *
     * Vérifie que l'utilisateur connecté est bien le propriétaire de l'investissement
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'ID de l'investissement depuis la route
        $investmentId = $request->route('investment');

        // Si c'est un objet, récupérer son ID
        if ($investmentId instanceof UserInvestment) {
            $investment = $investmentId;
        } else {
            // Sinon, charger l'investissement depuis la BDD
            $investment = UserInvestment::find($investmentId);
        }

        // Vérifier que l'investissement existe
        if (!$investment) {
            abort(404, 'Investissement introuvable.');
        }

        // Vérifier la propriété (sauf pour les admins)
        if (!auth()->user()->hasRole(['super-admin', 'admin'])) {
            if ($investment->user_id !== auth()->id()) {
                // Log de la tentative d'accès non autorisée
                logger()->warning('Unauthorized investment access attempt', [
                    'user_id' => auth()->id(),
                    'investment_id' => $investment->id,
                    'investment_owner_id' => $investment->user_id,
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                ]);

                abort(403, 'Vous n\'avez pas accès à cet investissement.');
            }
        }

        return $next($request);
    }
}