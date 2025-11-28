<?php

namespace App\Jobs;

use App\Models\UserInvestment;
use App\Models\Transaction;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessInvestmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * L'investissement à traiter
     */
    public UserInvestment $investment;

    /**
     * Nombre de tentatives
     */
    public int $tries = 3;

    /**
     * Timeout en secondes
     */
    public int $timeout = 120;

    /**
     * Créer une nouvelle instance du job
     */
    public function __construct(UserInvestment $investment)
    {
        $this->investment = $investment;
        $this->onQueue('investments');
    }

    /**
     * Exécuter le job
     */
    public function handle(): void
    {
        // Vérifier que l'investissement est toujours actif
        $this->investment->refresh();

        if ($this->investment->status !== 'active') {
            Log::warning('Investment not active, skipping', [
                'investment_id' => $this->investment->id,
                'status' => $this->investment->status,
            ]);
            return;
        }

        // Vérifier que les 48h sont bien écoulées
        $remainingTime = $this->investment->remaining_time;
        if ($remainingTime > 0) {
            Log::info('Investment not ready yet', [
                'investment_id' => $this->investment->id,
                'remaining_seconds' => $remainingTime,
            ]);
            
            // Re-scheduler pour plus tard
            self::dispatch($this->investment)->delay(now()->addSeconds($remainingTime));
            return;
        }

        DB::beginTransaction();

        try {
            // 1. Marquer l'investissement comme en traitement
            $this->investment->update([
                'status' => 'processing',
                'processing_starts_at' => now(),
            ]);

            // 2. Créditer les profits à l'utilisateur
            $user = $this->investment->user;
            $expectedProfit = $this->investment->expected_profit;

            $user->increment('balance', $expectedProfit);
            $user->increment('total_profit', $expectedProfit);
            $user->decrement('pending_profit', $expectedProfit);
            $user->decrement('active_investments');

            // 3. Créer une transaction de crédit de profit
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'user_investment_id' => $this->investment->id,
                'type' => 'profit_credit',
                'amount' => $expectedProfit,
                'currency' => 'USD',
                'status' => 'completed',
                'description' => "Profit de l'investissement {$this->investment->reference}",
                'metadata' => [
                    'investment_reference' => $this->investment->reference,
                    'card_name' => $this->investment->investmentCard->name,
                    'roi_percentage' => $this->investment->investmentCard->roi_percentage,
                ],
            ]);

            // 4. Marquer l'investissement comme complété
            $this->investment->update([
                'status' => 'completed',
                'actual_profit' => $expectedProfit,
                'completed_at' => now(),
            ]);

            // 5. Envoyer la notification (database + email)
            $user->notify(new \App\Notifications\InvestmentCompletedNotification($this->investment));

            // 6. Log de l'opération
            Log::channel('financial')->info('Investment completed successfully', [
                'investment_id' => $this->investment->id,
                'user_id' => $user->id,
                'reference' => $this->investment->reference,
                'profit' => $expectedProfit,
                'transaction_id' => $transaction->id,
            ]);

            DB::commit();

            // 7. Dispatch le job de notification email (si activé)
            // dispatch(new SendInvestmentCompletedNotification($this->investment));

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to process investment', [
                'investment_id' => $this->investment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Re-throw l'exception pour que Laravel retry automatiquement
            throw $e;
        }
    }

    /**
     * Gérer l'échec du job
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Investment processing failed after all retries', [
            'investment_id' => $this->investment->id,
            'error' => $exception->getMessage(),
        ]);

        // Créer une notification admin pour investigation
        UserNotification::create([
            'user_id' => $this->investment->user_id,
            'title' => 'Problème avec votre investissement',
            'message' => 'Nous rencontrons un problème technique avec votre investissement. Notre équipe a été notifiée et le traitera manuellement sous peu.',
            'type' => 'error',
            'icon' => '⚠️',
        ]);

        // TODO: Notifier les admins (email, Slack, etc.)
    }

    /**
     * Tags pour le monitoring
     */
    public function tags(): array
    {
        return [
            'investment:' . $this->investment->id,
            'user:' . $this->investment->user_id,
        ];
    }
}