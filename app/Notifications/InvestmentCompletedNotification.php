<?php

namespace App\Notifications;

use App\Models\UserInvestment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * L'investissement complété
     */
    public UserInvestment $investment;

    /**
     * Créer une nouvelle instance de notification
     */
    public function __construct(UserInvestment $investment)
    {
        $this->investment = $investment;
        $this->onQueue('notifications');
    }

    /**
     * Canaux de notification
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        // Ajouter email si l'utilisateur a activé les notifications email
        if ($notifiable->email_notifications && $notifiable->investment_notifications) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Notification email
     */
    public function toMail(object $notifiable): MailMessage
    {
        $card = $this->investment->investmentCard;
        $profit = $this->investment->formatted_profit;
        $total = $this->investment->formatted_total_return;

        return (new MailMessage)
            ->subject('🎉 Félicitations ! Votre investissement est complété')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Excellente nouvelle ! Votre investissement est complété avec succès.')
            ->line("**Carte d'investissement** : {$card->name}")
            ->line("**Montant investi** : {$this->investment->formatted_amount}")
            ->line("**Profit gagné** : {$profit}")
            ->line("**Total reçu** : {$total}")
            ->line("**ROI** : {$card->roi_percentage}%")
            ->line('Le profit a été automatiquement crédité à votre solde.')
            ->action('Voir mon investissement', route('user.investments.show', $this->investment->id))
            ->line('Vous pouvez maintenant effectuer un retrait ou réinvestir vos gains.')
            ->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Investissement Complété ! 🎉',
            'message' => "Félicitations ! Votre investissement de {$this->investment->formatted_amount} est complété. Vous avez gagné {$this->investment->formatted_profit} !",
            'type' => 'success',
            'icon' => '💰',
            'investment_id' => $this->investment->id,
            'investment_reference' => $this->investment->reference,
            'card_name' => $this->investment->investmentCard->name,
            'amount' => $this->investment->amount_paid,
            'profit' => $this->investment->actual_profit,
            'total' => $this->investment->total_return,
            'action_url' => route('user.investments.show', $this->investment->id),
            'action_text' => 'Voir détails',
        ];
    }

    /**
     * Tags pour le monitoring
     */
    public function tags(): array
    {
        return [
            'investment-completed',
            'user:' . $this->investment->user_id,
        ];
    }
}