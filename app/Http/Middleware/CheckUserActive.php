<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * Vérifie que le compte utilisateur est actif
     * Déconnecte les utilisateurs dont le compte a été désactivé
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (auth()->check()) {
            $user = auth()->user();

            // Vérifier si le compte est actif
            if (!$user->is_active) {
                // Log de la tentative d'accès d'un compte inactif
                logger()->warning('Inactive account access attempt', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                ]);

                // Déconnecter l'utilisateur
                Auth::logout();

                // Invalider la session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Votre compte a été désactivé. Veuillez contacter le support pour plus d\'informations.');
            }
        }

        return $next($request);
    }
}