<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Models
use App\Models\UserInvestment;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\SupportTicket;
use App\Models\User;

// Policies
use App\Policies\InvestmentPolicy;
use App\Policies\WithdrawalPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\SupportTicketPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        UserInvestment::class => InvestmentPolicy::class,
        Withdrawal::class => WithdrawalPolicy::class,
        Transaction::class => TransactionPolicy::class,
        SupportTicket::class => SupportTicketPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Enregistrer les policies
        $this->registerPolicies();

        // Gates personnalisés (optionnel)
        
        // Gate pour vérifier si l'utilisateur est admin
        Gate::define('access-admin', function (User $user) {
            return $user->hasRole(['super-admin', 'admin']);
        });

        // Gate pour vérifier si l'utilisateur est super-admin
        Gate::define('access-super-admin', function (User $user) {
            return $user->hasRole('super-admin');
        });

        // Gate pour vérifier si l'utilisateur est support
        Gate::define('access-support', function (User $user) {
            return $user->hasRole(['super-admin', 'admin', 'support']);
        });

        // Gate pour vérifier si l'utilisateur peut créer des transactions manuelles
        Gate::define('create-manual-transaction', function (User $user) {
            return $user->hasRole(['super-admin', 'admin']);
        });

        // Gate pour vérifier si l'utilisateur peut voir les logs
        Gate::define('view-logs', function (User $user) {
            return $user->hasRole('super-admin');
        });

        // Gate pour vérifier si l'utilisateur peut gérer les paramètres
        Gate::define('manage-settings', function (User $user) {
            return $user->hasRole('super-admin');
        });

        // Gate pour vérifier si l'utilisateur peut voir les rapports
        Gate::define('view-reports', function (User $user) {
            return $user->hasRole(['super-admin', 'admin']);
        });

        // Gate pour vérifier si l'utilisateur peut exporter des données
        Gate::define('export-data', function (User $user) {
            return $user->hasRole(['super-admin', 'admin']);
        });

        // Super Admin peut tout faire
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });
    }
}