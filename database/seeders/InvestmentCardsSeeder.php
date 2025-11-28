<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvestmentCard;

class InvestmentCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            [
                'name' => 'Carte 200$',
                'price' => 200.00,
                'expected_profit' => 3200.00,
                'roi_percentage' => 1600,
                'processing_hours' => 48,
                'description' => 'Carte d\'entrée idéale pour démarrer votre parcours d\'investissement.',
                'is_active' => true,
                'is_featured' => false,
                'order' => 1,
                'features' => [
                    'Investissement minimal',
                    'Retour rapide en 48h',
                    'Support 24/7',
                    'Zéro risque',
                ],
            ],
            [
                'name' => 'Carte 350$',
                'price' => 350.00,
                'expected_profit' => 5950.00,
                'roi_percentage' => 1700,
                'processing_hours' => 48,
                'description' => 'Option recommandée pour maximiser vos gains rapidement.',
                'is_active' => true,
                'is_featured' => true,
                'order' => 2,
                'features' => [
                    'ROI optimisé',
                    'Retour garanti',
                    'Priorité de traitement',
                    'Support VIP',
                ],
            ],
            [
                'name' => 'Carte 500$',
                'price' => 500.00,
                'expected_profit' => 8500.00,
                'roi_percentage' => 1700,
                'processing_hours' => 48,
                'description' => 'Carte populaire offrant un excellent équilibre rendement/risque.',
                'is_active' => true,
                'is_featured' => true,
                'order' => 3,
                'features' => [
                    'Meilleur rapport qualité/prix',
                    'ROI de 1700%',
                    'Traitement prioritaire',
                    'Conseiller dédié',
                ],
            ],
            [
                'name' => 'Carte 1000$',
                'price' => 1000.00,
                'expected_profit' => 20000.00,
                'roi_percentage' => 2000,
                'processing_hours' => 48,
                'description' => 'Investissement premium pour des gains substantiels.',
                'is_active' => true,
                'is_featured' => false,
                'order' => 4,
                'features' => [
                    'ROI Premium de 2000%',
                    'Gains maximisés',
                    'Service VIP exclusif',
                    'Gestionnaire de compte',
                ],
            ],
            [
                'name' => 'Carte 1500$',
                'price' => 1500.00,
                'expected_profit' => 45000.00,
                'roi_percentage' => 3000,
                'processing_hours' => 48,
                'description' => 'Carte élite pour investisseurs sérieux cherchant le maximum de rendement.',
                'is_active' => true,
                'is_featured' => true,
                'order' => 5,
                'features' => [
                    'ROI Élite de 3000%',
                    'Gains exceptionnels',
                    'Accès VIP Premium',
                    'Conseiller personnel 24/7',
                ],
            ],
        ];

        foreach ($cards as $card) {
            InvestmentCard::create($card);
        }

        $this->command->info('Investment Cards created successfully!');
    }
}