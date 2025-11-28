<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        return true; // L'utilisateur peut toujours mettre à jour son propre profil
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/', // Lettres, espaces, apostrophes, tirets
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^\+?[0-9]{8,20}$/', // Format international
            ],
            'country' => [
                'nullable',
                'string',
                'min:2',
                'max:100',
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.min' => 'Le nom doit contenir au moins 2 caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'name.regex' => 'Le nom ne peut contenir que des lettres, espaces, apostrophes et tirets.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone.regex' => 'Le numéro de téléphone doit être au format international (ex: +229XXXXXXXX).',
            'country.min' => 'Le pays doit contenir au moins 2 caractères.',
            'country.max' => 'Le pays ne doit pas dépasser 100 caractères.',
        ];
    }

    /**
     * Attributs personnalisés
     */
    public function attributes(): array
    {
        return [
            'name' => 'nom',
            'email' => 'email',
            'phone' => 'téléphone',
            'country' => 'pays',
        ];
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        // Nettoyer les données
        $data = [];

        if ($this->has('name')) {
            $data['name'] = trim($this->name);
        }

        if ($this->has('email')) {
            $data['email'] = trim(strtolower($this->email));
        }

        if ($this->has('phone')) {
            $data['phone'] = preg_replace('/\s+/', '', $this->phone);
        }

        if ($this->has('country')) {
            $data['country'] = trim($this->country);
        }

        $this->merge($data);
    }
}