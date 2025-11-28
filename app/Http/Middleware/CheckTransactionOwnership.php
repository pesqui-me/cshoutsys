<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Transaction;

class CheckTransactionOwnership
{
    /**
     * Handle an incoming request.
     *
     * Vérifie que l'utilisateur connecté est bien le propriétaire de la transaction
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'ID de la transaction depuis la route
        $transactionId = $request->route('transaction');

        // Si c'est un objet, récupérer son ID
        if ($transactionId instanceof Transaction) {
            $transaction = $transactionId;
        } else {
            // Sinon, charger la transaction depuis la BDD
            $transaction = Transaction::find($transactionId);
        }

        // Vérifier que la transaction existe
        if (!$transaction) {
            abort(404, 'Transaction introuvable.');
        }

        // Vérifier la propriété (sauf pour les admins)
        if (!auth()->user()->hasRole(['super-admin', 'admin'])) {
            if ($transaction->user_id !== auth()->id()) {
                // Log de la tentative d'accès non autorisée
                logger()->warning('Unauthorized transaction access attempt', [
                    'user_id' => auth()->id(),
                    'transaction_id' => $transaction->id,
                    'transaction_owner_id' => $transaction->user_id,
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                ]);

                abort(403, 'Vous n\'avez pas accès à cette transaction.');
            }
        }

        return $next($request);
    }
}