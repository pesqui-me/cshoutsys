<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Obtenir le chemin vers lequel l'utilisateur doit être redirigé
     * lorsqu'il n'est pas authentifié.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Si la requête attend du JSON (API), ne pas rediriger
        if ($request->expectsJson()) {
            return null;
        }

        // Rediriger vers la page de login
        return route('login');
    }
}