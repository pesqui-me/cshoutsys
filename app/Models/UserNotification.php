<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'action_url',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les notifications non lues
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Marquer comme lu
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Obtenir l'icône par défaut selon le type
     */
    public function getDefaultIconAttribute()
    {
        return match($this->type) {
            'success' => '✅',
            'warning' => '⚠️',
            'error' => '❌',
            'investment' => '💎',
            'payment' => '💳',
            'withdrawal' => '💰',
            'system' => '🔔',
            default => 'ℹ️',
        };
    }

    /**
     * Obtenir l'icône (personnalisé ou par défaut)
     */
    public function getIconDisplayAttribute()
    {
        return $this->icon ?? $this->default_icon;
    }
}