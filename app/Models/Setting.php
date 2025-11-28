<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Récupérer une valeur de setting avec cache
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            // Cast selon le type
            return match ($setting->type) {
                'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'integer' => (int) $setting->value,
                'json' => json_decode($setting->value, true),
                default => $setting->value,
            };
        });
    }

    /**
     * Définir une valeur de setting
     */
    public static function set(string $key, mixed $value, string $type = 'string', ?string $description = null): self
    {
        // Convertir la valeur selon le type
        $valueToStore = match ($type) {
            'boolean' => $value ? '1' : '0',
            'integer' => (string) $value,
            'json' => json_encode($value),
            default => (string) $value,
        };

        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $valueToStore,
                'type' => $type,
                'description' => $description,
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");

        return $setting;
    }

    /**
     * Vérifier si un setting existe
     */
    public static function has(string $key): bool
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Supprimer un setting
     */
    public static function remove(string $key): bool
    {
        Cache::forget("setting_{$key}");
        return self::where('key', $key)->delete() > 0;
    }

    /**
     * Récupérer tous les settings
     */
    public static function allSettings(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return self::query()->get($columns);
    }

    /**
     * Clear tous les caches de settings
     */
    public static function clearCache(): void
    {
        $settings = self::allSettings(['key']);
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
    }
}