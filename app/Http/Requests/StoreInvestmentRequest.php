<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Setting;

class StoreInvestmentRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\UserInvestment::class);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'card_id' => [
                'required',
                'exists:investment_cards,id',
                function ($attribute, $value, $fail) {
                    $card = \App\Models\InvestmentCard::find($value);
                    if ($card && !$card->is_active) {
                        $fail('Cette carte n\'est plus disponible.');
                    }
                },
            ],
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
                function ($attribute, $value, $fail) {
                    $method = \App\Models\PaymentMethod::find($value);
                    if ($method && !$method->is_active) {
                        $fail('Ce moyen de paiement n\'est plus disponible.');
                    }
                },
            ],
            'payment_proof' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120', // 5MB
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'card_id.required' => 'Veuillez sélectionner une carte d\'investissement.',
            'card_id.exists' => 'La carte sélectionnée n\'existe pas.',
            'payment_method_id.required' => 'Veuillez sélectionner un moyen de paiement.',
            'payment_method_id.exists' => 'Le moyen de paiement sélectionné n\'existe pas.',
            'payment_proof.file' => 'La preuve de paiement doit être un fichier.',
            'payment_proof.mimes' => 'La preuve de paiement doit être au format JPG, PNG ou PDF.',
            'payment_proof.max' => 'La preuve de paiement ne doit pas dépasser 5MB.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur
     */
    public function attributes(): array
    {
        return [
            'card_id' => 'carte d\'investissement',
            'payment_method_id' => 'moyen de paiement',
            'payment_proof' => 'preuve de paiement',
        ];
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        // Nettoyer les données si nécessaire
        if ($this->has('card_id')) {
            $this->merge([
                'card_id' => (int) $this->card_id,
            ]);
        }
    }
}