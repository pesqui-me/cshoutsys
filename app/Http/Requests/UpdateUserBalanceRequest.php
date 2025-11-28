<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserBalanceRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        $user = $this->route('user');
        
        if (!$user instanceof User) {
            $user = User::find($user);
        }

        return $user && $this->user()->can('updateBalance', $user);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'action' => [
                'required',
                'in:add,subtract,set',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:1000000',
                function ($attribute, $value, $fail) {
                    $user = $this->route('user');
                    if (!$user instanceof User) {
                        $user = User::find($user);
                    }

                    // Si on soustrait, vérifier que le solde ne devient pas négatif
                    if ($this->action === 'subtract' && $value > $user->balance) {
                        $fail('Le montant à soustraire est supérieur au solde actuel.');
                    }
                },
            ],
            'reason' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'action.required' => 'Veuillez sélectionner une action.',
            'action.in' => 'L\'action sélectionnée est invalide.',
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant minimum est de 0.01$.',
            'amount.max' => 'Le montant maximum est de 1,000,000$.',
            'reason.required' => 'La raison est requise.',
            'reason.min' => 'La raison doit contenir au moins 5 caractères.',
            'reason.max' => 'La raison ne doit pas dépasser 500 caractères.',
        ];
    }

    /**
     * Attributs personnalisés
     */
    public function attributes(): array
    {
        return [
            'action' => 'action',
            'amount' => 'montant',
            'reason' => 'raison',
        ];
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        // Nettoyer le montant
        if ($this->has('amount')) {
            $amount = str_replace([' ', ','], ['', '.'], $this->amount);
            $this->merge(['amount' => $amount]);
        }
    }
}