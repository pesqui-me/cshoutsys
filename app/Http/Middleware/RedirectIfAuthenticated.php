<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Gérer une requête entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redirection selon le rôle de l'utilisateur
                return $this->redirectBasedOnRole($user);
            }
        }

        return $next($request);
    }

    /**
     * Rediriger selon le rôle de l'utilisateur
     */
    protected function redirectBasedOnRole($user): Response
    {
        // Super Admin & Admin
        if ($user->hasRole(['super-admin', 'admin'])) {
            return redirect()->route('admin.dashboard');
        }

        // Support
        if ($user->hasRole('support')) {
            return redirect()->route('admin.support.index');
        }

        // User par défaut
        return redirect()->route('user.dashboard');
    }
}