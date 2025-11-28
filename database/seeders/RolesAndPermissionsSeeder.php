<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            // Utilisateurs
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage user balance',

            // Cartes d'investissement
            'view investment cards',
            'create investment cards',
            'edit investment cards',
            'delete investment cards',

            // Investissements
            'view all investments',
            'approve investments',
            'reject investments',
            'cancel investments',

            // Transactions
            'view all transactions',
            'create transactions',
            'edit transactions',
            'delete transactions',

            // Retraits
            'view all withdrawals',
            'approve withdrawals',
            'reject withdrawals',
            'process withdrawals',

            // Moyens de paiement
            'view payment methods',
            'create payment methods',
            'edit payment methods',
            'delete payment methods',

            // Support
            'view all tickets',
            'assign tickets',
            'resolve tickets',
            'delete tickets',

            // Paramètres
            'view settings',
            'edit settings',

            // Dashboard
            'view admin dashboard',
            'view statistics',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer les rôles et assigner les permissions

        // Super Admin - Toutes les permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Presque toutes les permissions sauf suppression
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users',
            'edit users',
            'manage user balance',
            'view investment cards',
            'create investment cards',
            'edit investment cards',
            'view all investments',
            'approve investments',
            'reject investments',
            'view all transactions',
            'create transactions',
            'edit transactions',
            'view all withdrawals',
            'approve withdrawals',
            'reject withdrawals',
            'process withdrawals',
            'view payment methods',
            'create payment methods',
            'edit payment methods',
            'view all tickets',
            'assign tickets',
            'resolve tickets',
            'view settings',
            'view admin dashboard',
            'view statistics',
        ]);

        // Support Agent - Permissions limitées au support
        $support = Role::create(['name' => 'support']);
        $support->givePermissionTo([
            'view users',
            'view all investments',
            'view all transactions',
            'view all withdrawals',
            'view all tickets',
            'assign tickets',
            'resolve tickets',
        ]);

        // User - Rôle par défaut (permissions implicites via policies)
        Role::create(['name' => 'user']);

        $this->command->info('Roles and Permissions created successfully!');
    }
}