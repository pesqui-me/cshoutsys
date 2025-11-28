<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class UserInvestment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'investment_card_id',
        'reference',
        'amount_paid',
        'expected_profit',
        'actual_profit',
        'status',
        'purchased_at',
        'activated_at',
        'processing_starts_at',
        'completed_at',
        'admin_notes',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'expected_profit' => 'decimal:2',
        'actual_profit' => 'decimal:2',
        'purchased_at' => 'datetime',
        'activated_at' => 'datetime',
        'processing_starts_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Boot du model
     */
    protected static function boot()
    {
        parent::boot();

        // Générer automatiquement une référence unique lors de la création
        static::creating(function ($investment) {
            if (empty($investment->reference)) {
                $investment->reference = 'INV-' . date('Y') . '-' . str_pad(
                    static::max('id') + 1,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la carte d'investissement
     */
    public function investmentCard()
    {
        return $this->belongsTo(InvestmentCard::class);
    }

    /**
     * Relation avec les transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope pour les investissements actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope pour les investissements complétés
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope pour les investissements en attente
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending_payment', 'payment_processing']);
    }

    /**
     * Vérifier si l'investissement est actif
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Vérifier si l'investissement est complété
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Calculer le temps restant avant la fin du traitement (en secondes)
     */
    public function getRemainingTimeAttribute()
    {
        if (!$this->activated_at) {
            return null;
        }

        $processingHours = $this->investmentCard->processing_hours ?? 48;
        $endTime = $this->activated_at->addHours($processingHours);
        
        return max(0, Carbon::now()->diffInSeconds($endTime, false));
    }

    /**
     * Obtenir le pourcentage de progression (0-100)
     */
    public function getProgressPercentageAttribute()
    {
        if (!$this->activated_at) {
            return 0;
        }

        $processingHours = $this->investmentCard->processing_hours ?? 48;
        $totalSeconds = $processingHours * 3600;
        $elapsed = Carbon::now()->diffInSeconds($this->activated_at);
        
        return min(100, ($elapsed / $totalSeconds) * 100);
    }

    /**
     * Obtenir le statut en français
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending_payment' => 'En attente de paiement',
            'payment_processing' => 'Paiement en cours',
            'active' => 'Actif',
            'processing' => 'En traitement',
            'completed' => 'Complété',
            'cancelled' => 'Annulé',
            'refunded' => 'Remboursé',
            default => $this->status,
        };
    }

    /**
     * Obtenir la couleur du badge de statut
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending_payment' => 'warning',
            'payment_processing' => 'info',
            'active' => 'primary',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary',
        };
    }
}