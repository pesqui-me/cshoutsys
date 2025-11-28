<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Traiter la tentative de connexion
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentifier l'utilisateur (avec rate limiting dans LoginRequest)
        $request->authenticate();

        // Régénérer la session pour prévenir la fixation de session
        $request->session()->regenerate();

        // Vérifier si l'utilisateur est actif
        $user = Auth::user();
        
        if (!$user->is_active) {
            Auth::logout();
            
            return back()->withErrors([
                'email' => 'Votre compte a été désactivé. Veuillez contacter le support.',
            ])->onlyInput('email');
        }

        // Log de l'activité (optionnel)
        activity()
            ->causedBy($user)
            ->log('Connexion réussie');

        // Redirection selon le rôle
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Rediriger selon le rôle de l'utilisateur
     */
    protected function redirectBasedOnRole($user): RedirectResponse
    {
        // Super Admin & Admin
        if ($user->hasRole(['super-admin', 'admin'])) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', "Bienvenue {$user->name} ! 👋");
        }

        // Support
        if ($user->hasRole('support')) {
            return redirect()->intended(route('admin.support.index'))
                ->with('success', "Bienvenue {$user->name} ! 👋");
        }

        // User par défaut
        return redirect()->intended(route('user.dashboard'))
            ->with('success', "Bienvenue {$user->name} ! 👋");
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Log de l'activité
        activity()
            ->causedBy($user)
            ->log('Déconnexion');

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}