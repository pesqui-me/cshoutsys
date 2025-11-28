<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\SupportTicket;

class ReplySupportTicketRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        $ticket = $this->route('ticket');
        
        if (!$ticket instanceof SupportTicket) {
            $ticket = SupportTicket::find($ticket);
        }

        return $ticket && $this->user()->can('reply', $ticket);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'message' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
            'attachments' => [
                'nullable',
                'array',
                'max:3', // Maximum 3 fichiers par réponse
            ],
            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
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
            'message.required' => 'Le message est requis.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'message.max' => 'Le message ne doit pas dépasser 5000 caractères.',
            'attachments.max' => 'Vous ne pouvez joindre que 3 fichiers maximum par réponse.',
            'attachments.*.file' => 'Chaque pièce jointe doit être un fichier valide.',
            'attachments.*.mimes' => 'Les pièces jointes doivent être au format JPG, PNG, PDF, DOC ou DOCX.',
            'attachments.*.max' => 'Chaque pièce jointe ne doit pas dépasser 5MB.',
        ];
    }

    /**
     * Attributs personnalisés
     */
    public function attributes(): array
    {
        return [
            'message' => 'message',
            'attachments' => 'pièces jointes',
        ];
    }
}