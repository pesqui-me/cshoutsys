<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Setting;

class StoreWithdrawalRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Withdrawal::class);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        $minWithdrawal = Setting::get('min_withdrawal_amount', 50);
        $maxWithdrawal = Setting::get('max_withdrawal_amount', 100000);

        return [
            'amount' => [
                'required',
                'numeric',
                "min:{$minWithdrawal}",
                "max:{$maxWithdrawal}",
                function ($attribute, $value, $fail) {
                    if ($value > $this->user()->balance) {
                        $fail('Solde insuffisant pour effectuer ce retrait.');
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
                    // Vérifier que c'est un moyen de paiement valide pour les retraits
                    if ($method && !in_array($method->type, ['crypto', 'e-wallet', 'mobile-money', 'bank-transfer'])) {
                        $fail('Ce moyen de paiement n\'est pas disponible pour les retraits.');
                    }
                },
            ],
            'payment_details' => [
                'required',
                'array',
                'min:1',
            ],
            'payment_details.*' => [
                'required',
                'string',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        $minWithdrawal = Setting::get('min_withdrawal_amount', 50);
        $maxWithdrawal = Setting::get('max_withdrawal_amount', 100000);

        return [
            'amount.required' => 'Veuillez entrer le montant du retrait.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => "Le montant minimum de retrait est de {$minWithdrawal}$.",
            'amount.max' => "Le montant maximum de retrait est de {$maxWithdrawal}$.",
            'payment_method_id.required' => 'Veuillez sélectionner un moyen de paiement.',
            'payment_method_id.exists' => 'Le moyen de paiement sélectionné n\'existe pas.',
            'payment_details.required' => 'Veuillez fournir vos informations de paiement.',
            'payment_details.array' => 'Les informations de paiement sont invalides.',
            'payment_details.*.required' => 'Tous les champs d\'information de paiement sont requis.',
            'payment_details.*.string' => 'Les informations de paiement doivent être du texte.',
            'payment_details.*.max' => 'Les informations de paiement ne doivent pas dépasser 255 caractères.',
            'notes.max' => 'Les notes ne doivent pas dépasser 1000 caractères.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur
     */
    public function attributes(): array
    {
        return [
            'amount' => 'montant',
            'payment_method_id' => 'moyen de paiement',
            'payment_details' => 'informations de paiement',
            'notes' => 'notes',
        ];
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        // Nettoyer le montant (enlever les espaces et virgules)
        if ($this->has('amount')) {
            $amount = str_replace([' ', ','], ['', '.'], $this->amount);
            $this->merge([
                'amount' => $amount,
            ]);
        }
    }
}