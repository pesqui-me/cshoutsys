<?php

namespace App\Models\Traits;

trait HasKyc
{
    /**
     * Vérifier si l'utilisateur a complété sa vérification KYC
     */
    public function hasVerifiedKyc(): bool
    {
        // Si vous avez une colonne kyc_verified dans la table users
        // return $this->kyc_verified === true;
        
        // Ou si vous utilisez une table séparée pour le KYC
        // return $this->kycVerification && $this->kycVerification->status === 'approved';
        
        // Pour l'instant, on retourne true par défaut
        // À implémenter selon vos besoins
        return true;
    }

    /**
     * Vérifier si l'utilisateur a soumis des documents KYC
     */
    public function hasSubmittedKyc(): bool
    {
        // Vérifier s'il y a des documents dans la collection 'documents'
        return $this->getMedia('documents')->isNotEmpty();
    }

    /**
     * Obtenir le statut KYC
     */
    public function getKycStatus(): string
    {
        if (!$this->hasSubmittedKyc()) {
            return 'not_submitted';
        }

        if ($this->hasVerifiedKyc()) {
            return 'approved';
        }

        return 'pending';
    }

    /**
     * Obtenir le statut KYC en français
     */
    public function getKycStatusLabel(): string
    {
        return match($this->getKycStatus()) {
            'not_submitted' => 'Non soumis',
            'pending' => 'En cours de vérification',
            'approved' => 'Vérifié',
            'rejected' => 'Rejeté',
            default => 'Inconnu',
        };
    }
}