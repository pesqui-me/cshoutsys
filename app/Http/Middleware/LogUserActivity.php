<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * Log les activités importantes des utilisateurs
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Exécuter la requête
        $response = $next($request);

        // Logger seulement si l'utilisateur est authentifié
        if (auth()->check()) {
            // Actions importantes à logger
            $importantActions = [
                'POST',
                'PUT',
                'PATCH',
                'DELETE',
            ];

            // Logger les actions importantes
            if (in_array($request->method(), $importantActions)) {
                $this->logActivity($request, $response);
            }

            // Mettre à jour le last_login_at si c'est la première requête de la session
            if (!session('activity_logged')) {
                auth()->user()->update(['last_login_at' => now()]);
                session(['activity_logged' => true]);
            }
        }

        return $response;
    }

    /**
     * Logger l'activité de l'utilisateur
     */
    protected function logActivity(Request $request, Response $response): void
    {
        $user = auth()->user();

        // Données à logger
        $logData = [
            'user_id' => $user->id,
            'email' => $user->email,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route' => $request->route() ? $request->route()->getName() : null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status_code' => $response->getStatusCode(),
            'timestamp' => now()->toDateTimeString(),
        ];

        // Ne pas logger les données sensibles (mots de passe, etc.)
        $input = $request->except(['password', 'password_confirmation', 'current_password']);

        if (!empty($input)) {
            $logData['input'] = $input;
        }

        // Logger dans un canal dédié
        Log::channel('activity')->info('User Activity', $logData);
    }
}