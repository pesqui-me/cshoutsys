<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription
     */
    public function create(Request $request): View
    {
        // Récupérer le code de parrainage depuis l'URL
        $referralCode = $request->query('ref');
        
        return view('auth.register', compact('referralCode'));
    }

    /**
     * Traiter l'inscription
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation complète (3 étapes combinées)
        $validated = $request->validate([
            // Étape 1: Infos personnelles
            'nom' => ['required', 'string', 'min:2', 'max:100'],
            'prenom' => ['required', 'string', 'min:2', 'max:100'],
            
            // Étape 2: Contact
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'regex:/^\+?[0-9]{8,20}$/'],
            'pays' => ['required', 'string', 'max:100'],
            
            // Étape 3: Sécurité
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            
            // Parrainage optionnel
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
        ], [
            'nom.required' => 'Le nom est requis.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'telephone.required' => 'Le téléphone est requis.',
            'telephone.regex' => 'Le numéro de téléphone doit être au format international.',
            'pays.required' => 'Veuillez sélectionner un pays.',
            'password.required' => 'Le mot de passe est requis.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'referral_code.exists' => 'Le code de parrainage est invalide.',
        ]);

        DB::beginTransaction();

        try {
            // Combiner nom et prénom
            $fullName = $validated['nom'] . ' ' . $validated['prenom'];

            // Trouver le parrain si code fourni
            $referrer = null;
            if (!empty($validated['referral_code'])) {
                $referrer = User::where('referral_code', $validated['referral_code'])->first();
            }

            // Créer l'utilisateur
            $user = User::create([
                'name' => $fullName,
                'email' => $validated['email'],
                'phone' => $validated['telephone'],
                'country' => $validated['pays'],
                'password' => Hash::make($validated['password']),
                'referral_code' => $this->generateUniqueReferralCode(),
                'referred_by' => $referrer?->id,
                'is_active' => true, // Pas de vérification email
            ]);

            // Assigner le rôle "user"
            $user->assignRole('user');

            // Notifier le parrain si présent
            if ($referrer) {
                $referrer->notify(new \App\Notifications\NewReferralNotification($user));
            }

            // Envoyer notification de bienvenue
            $user->notify(new WelcomeNotification());

            // Log de l'activité
            activity()
                ->causedBy($user)
                ->log('Inscription réussie');

            // Event Laravel
            event(new Registered($user));

            DB::commit();

            // Connecter automatiquement l'utilisateur
            Auth::login($user);

            return redirect()->route('user.dashboard')
                ->with('success', "Bienvenue sur CASH OUT, {$user->name} ! 🎉");

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput($request->except('password', 'password_confirm'))
                ->with('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');
        }
    }

    /**
     * Générer un code de parrainage unique
     */
    protected function generateUniqueReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}