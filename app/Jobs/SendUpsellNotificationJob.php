<?php

namespace App\Jobs;

use App\Models\UserInvestment;
use App\Models\UserNotification;
use App\Models\InvestmentCard;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendUpsellNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * L'investissement qui déclenche l'upsell
     */
    public UserInvestment $investment;

    /**
     * Nombre de tentatives
     */
    public int $tries = 2;

    /**
     * Timeout en secondes
     */
    public int $timeout = 30;

    /**
     * Créer une nouvelle instance du job
     */
    public function __construct(UserInvestment $investment)
    {
        $this->investment = $investment;
        $this->onQueue('notifications');
    }

    /**
     * Exécuter le job
     */
    public function handle(): void
    {
        // Vérifier que l'upsell est activé
        if (!Setting::get('enable_upsell', true)) {
            Log::info('Upsell disabled, skipping notification', [
                'investment_id' => $this->investment->id,
            ]);
            return;
        }

        // Vérifier que c'est un investissement de 200$
        if ($this->investment->investmentCard->price != 200) {
            Log::info('Not a 200$ investment, skipping upsell', [
                'investment_id' => $this->investment->id,
                'price' => $this->investment->investmentCard->price,
            ]);
            return;
        }

        // Vérifier que l'utilisateur n'a pas déjà acheté la carte 350$
        $user = $this->investment->user;
        $hasCard350 = UserInvestment::where('user_id', $user->id)
            ->whereHas('investmentCard', function($query) {
                $query->where('price', 350);
            })
            ->exists();

        if ($hasCard350) {
            Log::info('User already has 350$ card, skipping upsell', [
                'user_id' => $user->id,
            ]);
            return;
        }

        // Vérifier que l'investissement initial est toujours actif ou complété
        $this->investment->refresh();
        if (!in_array($this->investment->status, ['active', 'completed'])) {
            Log::info('Investment not active/completed, skipping upsell', [
                'investment_id' => $this->investment->id,
                'status' => $this->investment->status,
            ]);
            return;
        }

        // Récupérer la carte 350$
        $upsellCard = InvestmentCard::where('price', 350)
            ->where('is_active', true)
            ->first();

        if (!$upsellCard) {
            Log::warning('350$ card not found or not active', [
                'investment_id' => $this->investment->id,
            ]);
            return;
        }

        // Créer la notification d'upsell
        try {
            UserNotification::create([
                'user_id' => $user->id,
                'title' => '🎁 Offre Spéciale Limitée !',
                'message' => "Passez à la carte {$upsellCard->name} ({$upsellCard->formatted_price}) et gagnez encore plus ! ROI de {$upsellCard->formatted_roi}. Cette offre expire dans 24h.",
                'type' => 'info',
                'icon' => '⭐',
                'action_url' => route('user.investments.buy-card') . '?card=' . $upsellCard->id,
            ]);

            Log::info('Upsell notification sent', [
                'user_id' => $user->id,
                'investment_id' => $this->investment->id,
                'upsell_card_id' => $upsellCard->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send upsell notification', [
                'investment_id' => $this->investment->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Gérer l'échec du job
     */
    public function failed(\Throwable $exception): void
    {
        Log::warning('Upsell notification job failed', [
            'investment_id' => $this->investment->id,
            'error' => $exception->getMessage(),
        ]);

        // Pas critique, on ne fait rien de spécial
    }

    /**
     * Tags pour le monitoring
     */
    public function tags(): array
    {
        return [
            'upsell',
            'user:' . $this->investment->user_id,
        ];
    }
}