<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * Vérifie si le site est en mode maintenance
     * Les admins peuvent toujours accéder au site
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si le mode maintenance est activé
        $maintenanceMode = Setting::get('maintenance_mode', false);

        if ($maintenanceMode) {
            // Les admins peuvent toujours accéder
            if (auth()->check() && auth()->user()->hasRole(['super-admin', 'admin'])) {
                return $next($request);
            }

            // Récupérer le message de maintenance
            $maintenanceMessage = Setting::get(
                'maintenance_message',
                'Le site est actuellement en maintenance. Nous revenons bientôt !'
            );

            // Afficher la page de maintenance
            return response()->view('errors.maintenance', [
                'message' => $maintenanceMessage,
            ], 503);
        }

        return $next($request);
    }
}