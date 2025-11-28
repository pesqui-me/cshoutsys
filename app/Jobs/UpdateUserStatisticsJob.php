<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserInvestment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUserStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * L'utilisateur dont on met à jour les stats
     * Null = tous les utilisateurs
     */
    public ?User $user;

    /**
     * Nombre de tentatives
     */
    public int $tries = 2;

    /**
     * Timeout en secondes
     */
    public int $timeout = 600;

    /**
     * Créer une nouvelle instance du job
     */
    public function __construct(?User $user = null)
    {
        $this->user = $user;
        $this->onQueue('maintenance');
    }

    /**
     * Exécuter le job
     */
    public function handle(): void
    {
        try {
            if ($this->user) {
                // Mettre à jour un seul utilisateur
                $this->updateUserStats($this->user);
                
                Log::info('User statistics updated', [
                    'user_id' => $this->user->id,
                ]);
            } else {
                // Mettre à jour tous les utilisateurs
                $usersCount = 0;
                
                User::role('user')
                    ->chunk(100, function ($users) use (&$usersCount) {
                        foreach ($users as $user) {
                            $this->updateUserStats($user);
                            $usersCount++;
                        }
                    });

                Log::info('All users statistics updated', [
                    'users_count' => $usersCount,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Failed to update user statistics', [
                'user_id' => $this->user?->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Mettre à jour les statistiques d'un utilisateur
     */
    protected function updateUserStats(User $user): void
    {
        // Recalculer toutes les stats depuis la base de données
        
        // 1. Total investi (hors cancelled/refunded)
        $totalInvested = UserInvestment::where('user_id', $user->id)
            ->whereNotIn('status', ['cancelled', 'refunded'])
            ->sum('amount_paid');

        // 2. Total des profits réalisés (investissements complétés)
        $totalProfit = UserInvestment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('actual_profit');

        // 3. Profits en attente (investissements actifs)
        $pendingProfit = UserInvestment::where('user_id', $user->id)
            ->where('status', 'active')
            ->sum('expected_profit');

        // 4. Nombre d'investissements actifs
        $activeInvestments = UserInvestment::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        // Mettre à jour l'utilisateur
        $user->update([
            'total_invested' => $totalInvested,
            'total_profit' => $totalProfit,
            'pending_profit' => $pendingProfit,
            'active_investments' => $activeInvestments,
        ]);
    }

    /**
     * Gérer l'échec du job
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('User statistics update job failed', [
            'user_id' => $this->user?->id,
            'error' => $exception->getMessage(),
        ]);
    }

    /**
     * Tags pour le monitoring
     */
    public function tags(): array
    {
        $tags = ['statistics', 'maintenance'];
        
        if ($this->user) {
            $tags[] = 'user:' . $this->user->id;
        } else {
            $tags[] = 'all-users';
        }
        
        return $tags;
    }
}