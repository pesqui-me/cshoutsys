<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Withdrawal;

class RejectWithdrawalRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        $withdrawal = $this->route('withdrawal');
        
        if (!$withdrawal instanceof Withdrawal) {
            $withdrawal = Withdrawal::find($withdrawal);
        }

        return $withdrawal && $this->user()->can('reject', $withdrawal);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'rejection_reason' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
            'admin_notes' => [
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
        return [
            'rejection_reason.required' => 'La raison du rejet est requise.',
            'rejection_reason.min' => 'La raison du rejet doit contenir au moins 10 caractères.',
            'rejection_reason.max' => 'La raison du rejet ne doit pas dépasser 1000 caractères.',
            'admin_notes.max' => 'Les notes administrateur ne doivent pas dépasser 1000 caractères.',
        ];
    }

    /**
     * Attributs personnalisés
     */
    public function attributes(): array
    {
        return [
            'rejection_reason' => 'raison du rejet',
            'admin_notes' => 'notes administrateur',
        ];
    }
}