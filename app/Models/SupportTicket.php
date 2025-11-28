<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SupportTicket extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'reference',
        'subject',
        'category',
        'priority',
        'status',
        'assigned_to',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Boot du model
     */
    protected static function boot()
    {
        parent::boot();

        // Générer automatiquement une référence unique
        static::creating(function ($ticket) {
            if (empty($ticket->reference)) {
                $ticket->reference = 'TCK-' . date('Y') . '-' . str_pad(
                    static::max('id') + 1,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    /**
     * Register media collections (pour les pièces jointes)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
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
     * Relation avec l'agent assigné
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relation avec les messages
     */
    public function messages()
    {
        return $this->hasMany(SupportMessage::class);
    }

    /**
     * Scope pour les tickets nouveaux
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope pour les tickets ouverts
     */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['new', 'open', 'in_progress']);
    }

    /**
     * Scope pour les tickets résolus
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Obtenir le statut en français
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'new' => 'Nouveau',
            'open' => 'Ouvert',
            'in_progress' => 'En cours',
            'resolved' => 'Résolu',
            'closed' => 'Fermé',
            default => $this->status,
        };
    }

    /**
     * Obtenir la catégorie en français
     */
    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'payment' => 'Paiement',
            'technical' => 'Technique',
            'account' => 'Compte',
            'general' => 'Général',
            default => $this->category,
        };
    }

    /**
     * Obtenir la priorité en français
     */
    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'low' => 'Basse',
            'medium' => 'Moyenne',
            'high' => 'Haute',
            default => $this->priority,
        };
    }

    /**
     * Obtenir la couleur du badge de priorité
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            default => 'secondary',
        };
    }
}