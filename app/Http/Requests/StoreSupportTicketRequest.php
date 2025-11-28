<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportTicketRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\SupportTicket::class);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'subject' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],
            'category' => [
                'required',
                'in:payment,technical,account,general',
            ],
            'priority' => [
                'required',
                'in:low,medium,high',
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
            'attachments' => [
                'nullable',
                'array',
                'max:5', // Maximum 5 fichiers
            ],
            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:5120', // 5MB par fichier
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'subject.required' => 'Le sujet est requis.',
            'subject.min' => 'Le sujet doit contenir au moins 5 caractères.',
            'subject.max' => 'Le sujet ne doit pas dépasser 255 caractères.',
            'category.required' => 'Veuillez sélectionner une catégorie.',
            'category.in' => 'La catégorie sélectionnée est invalide.',
            'priority.required' => 'Veuillez sélectionner une priorité.',
            'priority.in' => 'La priorité sélectionnée est invalide.',
            'message.required' => 'Le message est requis.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'message.max' => 'Le message ne doit pas dépasser 5000 caractères.',
            'attachments.max' => 'Vous ne pouvez joindre que 5 fichiers maximum.',
            'attachments.*.file' => 'Chaque pièce jointe doit être un fichier valide.',
            'attachments.*.mimes' => 'Les pièces jointes doivent être au format JPG, PNG, PDF, DOC ou DOCX.',
            'attachments.*.max' => 'Chaque pièce jointe ne doit pas dépasser 5MB.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur
     */
    public function attributes(): array
    {
        return [
            'subject' => 'sujet',
            'category' => 'catégorie',
            'priority' => 'priorité',
            'message' => 'message',
            'attachments' => 'pièces jointes',
        ];
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        // Nettoyer le message (enlever les espaces superflus)
        if ($this->has('message')) {
            $this->merge([
                'message' => trim($this->message),
            ]);
        }

        if ($this->has('subject')) {
            $this->merge([
                'subject' => trim($this->subject),
            ]);
        }
    }
}