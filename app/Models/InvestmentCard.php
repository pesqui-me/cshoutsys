<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class InvestmentCard extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'price',
        'expected_profit',
        'roi_percentage',
        'processing_hours',
        'description',
        'is_active',
        'is_featured',
        'order',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'expected_profit' => 'decimal:2',
        'roi_percentage' => 'integer',
        'processing_hours' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'features' => 'array',
    ];

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('card_image')
            ->singleFile() // Une seule image par carte
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(200)
                    ->height(200)
                    ->sharpen(10);

                $this->addMediaConversion('preview')
                    ->width(600)
                    ->height(400)
                    ->sharpen(10);
            });
    }

    /**
     * Relation avec les investissements utilisateurs
     */
    public function userInvestments()
    {
        return $this->hasMany(UserInvestment::class);
    }

    /**
     * Scope pour les cartes actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les cartes en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Calculer le ROI en pourcentage
     */
    public function getFormattedRoiAttribute()
    {
        return $this->roi_percentage . '%';
    }

    /**
     * Obtenir le prix formaté
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Obtenir le gain attendu formaté
     */
    public function getFormattedProfitAttribute()
    {
        return '$' . number_format($this->expected_profit, 2);
    }
}