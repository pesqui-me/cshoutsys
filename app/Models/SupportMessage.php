<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SupportMessage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'message',
        'is_admin_reply',
    ];

    protected $casts = [
        'is_admin_reply' => 'boolean',
    ];

    /**
     * Relation avec le ticket
     */
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
            ->singleFile();
    }

    /**
     * Relation avec l'utilisateur (auteur du message)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}