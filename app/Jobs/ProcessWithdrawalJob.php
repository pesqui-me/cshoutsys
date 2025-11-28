<?php

namespace App\Jobs;

use App\Models\Withdrawal;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessWithdrawalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Le retrait à traiter
     */
    public Withdrawal $withdrawal;

    /**
     * Nombre de tentatives
     */
    public int $tries = 2;

    /**
     * Timeout en secondes
     */
    public int $timeout = 60;

    /**
     * Créer une nouvelle instance du job
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
        $this->onQueue('withdrawals');
    }

    /**
     * Exécuter le job
     */
    public function handle(): void
    {
        // Vérifier que le retrait est bien approuvé
        $this->withdrawal->refresh();

        if ($this->withdrawal->status !== 'approved') {
            Log::info('Withdrawal not approved, skipping', [
                'withdrawal_id' => $this->withdrawal->id,
                'status' => $this->withdrawal->status,
            ]);
            return;
        }

        try {
            // 1. Marquer comme en cours de traitement
            $this->withdrawal->update([
                'status' => 'processing',
            ]);

            // 2. Créer une notification pour l'utilisateur
            UserNotification::create([
                'user_id' => $this->withdrawal->user_id,
                'title' => 'Retrait en cours de traitement',
                'message' => "Votre demande de retrait de {$this->withdrawal->formatted_amount} est en cours de traitement. Vous recevrez une confirmation une fois le transfert effectué.",
                'type' => 'info',
                'icon' => '⏳',
                'action_url' => route('user.withdrawals.show', $this->withdrawal->id),
            ]);

            // 3. Log de l'opération
            Log::channel('financial')->info('Withdrawal processing started', [
                'withdrawal_id' => $this->withdrawal->id,
                'user_id' => $this->withdrawal->user_id,
                'reference' => $this->withdrawal->reference,
                'amount' => $this->withdrawal->amount,
                'net_amount' => $this->withdrawal->net_amount,
                'payment_method' => $this->withdrawal->paymentMethod->name,
            ]);

            // 4. Ici, vous intégreriez l'API de paiement réelle
            // Exemple: $this->processPayment();

            // Pour l'instant, on considère que le traitement nécessite une action manuelle admin
            // Le statut reste "processing" jusqu'à ce qu'un admin marque comme "completed"

            Log::info('Withdrawal ready for manual processing', [
                'withdrawal_id' => $this->withdrawal->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to process withdrawal', [
                'withdrawal_id' => $this->withdrawal->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Remettre le statut à approved pour retry
            $this->withdrawal->update(['status' => 'approved']);

            throw $e;
        }
    }

    /**
     * Traiter le paiement via l'API (à implémenter)
     */
    protected function processPayment(): void
    {
        // TODO: Intégration avec les APIs de paiement
        // - Crypto: Bitcoin, Ethereum, USDT, etc.
        // - E-wallets: Perfect Money, Payeer
        // - Mobile Money: MTN, Moov
        // - Bank Transfer: virement bancaire

        $paymentMethod = $this->withdrawal->paymentMethod;
        $paymentDetails = $this->withdrawal->payment_details;

        switch ($paymentMethod->type) {
            case 'crypto':
                // $this->processCryptoPayment($paymentDetails);
                break;

            case 'e-wallet':
                // $this->processEWalletPayment($paymentDetails);
                break;

            case 'mobile-money':
                // $this->processMobileMoneyPayment($paymentDetails);
                break;

            case 'bank-transfer':
                // $this->processBankTransfer($paymentDetails);
                break;
        }
    }

    /**
     * Gérer l'échec du job
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Withdrawal processing failed after all retries', [
            'withdrawal_id' => $this->withdrawal->id,
            'error' => $exception->getMessage(),
        ]);

        // Créer une notification pour l'utilisateur
        UserNotification::create([
            'user_id' => $this->withdrawal->user_id,
            'title' => 'Problème avec votre retrait',
            'message' => 'Nous rencontrons un problème technique avec votre demande de retrait. Notre équipe a été notifiée et le traitera manuellement sous peu.',
            'type' => 'warning',
            'icon' => '⚠️',
            'action_url' => route('user.withdrawals.show', $this->withdrawal->id),
        ]);

        // TODO: Notifier les admins
    }

    /**
     * Tags pour le monitoring
     */
    public function tags(): array
    {
        return [
            'withdrawal:' . $this->withdrawal->id,
            'user:' . $this->withdrawal->user_id,
        ];
    }
}