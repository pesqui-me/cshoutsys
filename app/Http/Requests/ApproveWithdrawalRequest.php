<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Withdrawal;

class ApproveWithdrawalRequest extends FormRequest
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

        return $withdrawal && $this->user()->can('approve', $withdrawal);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
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
            'admin_notes.max' => 'Les notes administrateur ne doivent pas dépasser 1000 caractères.',
        ];
    }

    /**
     * Attributs personnalisés
     */
    public function attributes(): array
    {
        return [
            'admin_notes' => 'notes administrateur',
        ];
    }
}