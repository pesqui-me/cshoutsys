<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Le retrait rejeté
     */
    public Withdrawal $withdrawal;

    /**
     * La raison du rejet
     */
    public string $reason;

    /**
     * Créer une nouvelle instance de notification
     */
    public function __construct(Withdrawal $withdrawal, string $reason)
    {
        $this->withdrawal = $withdrawal;
        $this->reason = $reason;
        $this->onQueue('notifications');
    }

    /**
     * Canaux de notification
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if ($notifiable->email_notifications && $notifiable->withdrawal_notifications) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Notification email
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('❌ Votre retrait a été rejeté')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Nous avons le regret de vous informer que votre demande de retrait a été rejetée.')
            ->line("**Référence** : {$this->withdrawal->reference}")
            ->line("**Montant** : {$this->withdrawal->formatted_amount}")
            ->line("**Raison du rejet** :")
            ->line($this->reason)
            ->line("Le montant de {$this->withdrawal->formatted_amount} a été recrédité à votre solde.")
            ->action('Voir mon solde', route('user.dashboard'))
            ->line('Si vous avez des questions, n\'hésitez pas à contacter notre support.')
            ->action('Contacter le support', route('user.support.create'))
            ->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Retrait Rejeté ❌',
            'message' => "Votre retrait de {$this->withdrawal->formatted_amount} a été rejeté. Montant recrédité à votre solde. Raison: {$this->reason}",
            'type' => 'error',
            'icon' => '❌',
            'withdrawal_id' => $this->withdrawal->id,
            'withdrawal_reference' => $this->withdrawal->reference,
            'amount' => $this->withdrawal->amount,
            'rejection_reason' => $this->reason,
            'action_url' => route('user.withdrawals.show', $this->withdrawal->id),
            'action_text' => 'Voir détails',
        ];
    }
}