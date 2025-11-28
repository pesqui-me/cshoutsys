<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Maintenance
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Activer le mode maintenance',
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'Le site est actuellement en maintenance. Nous revenons bientôt !',
                'type' => 'string',
                'description' => 'Message affiché en mode maintenance',
            ],

            // Retraits
            [
                'key' => 'min_withdrawal_amount',
                'value' => '50',
                'type' => 'integer',
                'description' => 'Montant minimum de retrait en USD',
            ],
            [
                'key' => 'max_withdrawal_amount',
                'value' => '50000',
                'type' => 'integer',
                'description' => 'Montant maximum de retrait en USD',
            ],
            [
                'key' => 'withdrawal_fee_percentage',
                'value' => '2',
                'type' => 'integer',
                'description' => 'Pourcentage de frais sur les retraits',
            ],
            [
                'key' => 'withdrawal_processing_time',
                'value' => '24-48 heures',
                'type' => 'string',
                'description' => 'Délai de traitement des retraits',
            ],

            // Investissements
            [
                'key' => 'investment_duration_hours',
                'value' => '48',
                'type' => 'integer',
                'description' => 'Durée des investissements en heures',
            ],

            // Parrainage
            [
                'key' => 'referral_commission_percentage',
                'value' => '5',
                'type' => 'integer',
                'description' => 'Pourcentage de commission sur les parrainages',
            ],
            [
                'key' => 'referral_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Activer le système de parrainage',
            ],

            // Site
            [
                'key' => 'site_name',
                'value' => 'CASH OUT',
                'type' => 'string',
                'description' => 'Nom du site',
            ],
            [
                'key' => 'site_email',
                'value' => 'support@cashout.com',
                'type' => 'string',
                'description' => 'Email de contact du site',
            ],
            [
                'key' => 'support_available',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Support client disponible',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'description' => $setting['description'],
                ]
            );
        }

        $this->command->info('✅ Settings créés avec succès!');
    }
}