<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualTransactionRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Transaction::class);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'type' => [
                'required',
                'in:profit_credit,bonus,commission,refund',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:1000000',
            ],
            'currency' => [
                'nullable',
                'string',
                'size:3',
                'in:USD,EUR,XOF',
            ],
            'description' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
            'payment_method_id' => [
                'nullable',
                'exists:payment_methods,id',
            ],
            'metadata' => [
                'nullable',
                'array',
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Veuillez sélectionner un utilisateur.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
            'type.required' => 'Veuillez sélectionner un type de transaction.',
            'type.in' => 'Le type de transaction sélectionné est invalide.',
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant minimum est de 0.01$.',
            'amount.max' => 'Le montant maximum est de 1,000,000$.',
            'currency.size' => 'La devise doit être un code à 3 lettres (ex: USD).',
            'currency.in' => 'La devise doit être USD, EUR ou XOF.',
            'description.required' => 'La description est requise.',
            'description.min' => 'La description doit contenir au moins 5 caractères.',
            'description.max' => 'La description ne doit pas dépasser 500 caractères.',
            'payment_method_id.exists' => 'Le moyen de paiement sélectionné n\'existe pas.',
        ];
    }

    /**
     * Attributs personnalisés
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'utilisateur',
            'type' => 'type',
            'amount' => 'montant',
            'currency' => 'devise',
            'description' => 'description',
            'payment_method_id' => 'moyen de paiement',
        ];
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        // Définir USD par défaut si non fourni
        if (!$this->has('currency') || empty($this->currency)) {
            $this->merge(['currency' => 'USD']);
        }

        // Nettoyer le montant
        if ($this->has('amount')) {
            $amount = str_replace([' ', ','], ['', '.'], $this->amount);
            $this->merge(['amount' => $amount]);
        }
    }
}