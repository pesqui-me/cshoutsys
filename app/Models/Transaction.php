<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Transaction extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'user_investment_id',
        'payment_method_id',
        'reference',
        'type',
        'amount',
        'currency',
        'status',
        'description',
        'metadata',
        'admin_notes',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Boot du model
     */
    protected static function boot()
    {
        parent::boot();

        // Générer automatiquement une référence unique
        static::creating(function ($transaction) {
            if (empty($transaction->reference)) {
                $transaction->reference = 'TXN-' . date('Y') . '-' . str_pad(
                    static::max('id') + 1,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    /**
     * Register media collections (pour les preuves de paiement)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('payment_proof')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf']);
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'investissement
     */
    public function userInvestment()
    {
        return $this->belongsTo(UserInvestment::class);
    }

    /**
     * Relation avec le moyen de paiement
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Scope pour les transactions complétées
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope pour les transactions en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope par type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Obtenir le type en français
     */
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'investment_purchase' => 'Achat de carte',
            'profit_credit' => 'Crédit de gains',
            'withdrawal' => 'Retrait',
            'refund' => 'Remboursement',
            'bonus' => 'Bonus',
            'commission' => 'Commission',
            default => $this->type,
        };
    }

    /**
     * Obtenir le statut en français
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'En attente',
            'processing' => 'En traitement',
            'completed' => 'Complété',
            'failed' => 'Échoué',
            'cancelled' => 'Annulé',
            'refunded' => 'Remboursé',
            default => $this->status,
        };
    }

    /**
     * Obtenir la couleur du badge
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            'refunded' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Obtenir le montant formaté
     */
    public function getFormattedAmountAttribute()
    {
        $symbol = $this->currency === 'USD' ? '$' : $this->currency;
        return $symbol . number_format($this->amount, 2);
    }
}