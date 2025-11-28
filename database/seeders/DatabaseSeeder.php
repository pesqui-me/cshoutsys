<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            InvestmentCardsSeeder::class,
            PaymentMethodsSeeder::class,
            SettingsSeeder::class,
        ]);

        // Créer un utilisateur admin de test
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@cashout.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('super-admin');

        // Créer un utilisateur normal de test
        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@cashout.com',
            'password' => bcrypt('password'),
            'balance' => 5000.00,
            'total_invested' => 2000.00,
            'total_profit' => 15000.00,
            'pending_profit' => 8500.00,
            'active_investments' => 2,
            'is_active' => true,
        ]);
        $user->assignRole('user');

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@cashout.com / password');
        $this->command->info('User credentials: user@cashout.com / password');
    }
}