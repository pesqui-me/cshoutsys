<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Le retrait approuvé
     */
    public Withdrawal $withdrawal;

    /**
     * Créer une nouvelle instance de notification
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
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
        $paymentMethod = $this->withdrawal->paymentMethod;
        $processingTime = config('settings.withdrawal_processing_time', '24-48 heures');

        return (new MailMessage)
            ->subject('✅ Votre retrait a été approuvé')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Excellente nouvelle ! Votre demande de retrait a été approuvée.')
            ->line("**Référence** : {$this->withdrawal->reference}")
            ->line("**Montant** : {$this->withdrawal->formatted_amount}")
            ->line("**Frais** : {$this->withdrawal->formatted_fees}")
            ->line("**Montant net** : {$this->withdrawal->formatted_net_amount}")
            ->line("**Moyen de paiement** : {$paymentMethod->name}")
            ->line("Votre retrait est maintenant en cours de traitement et sera effectué sous {$processingTime}.")
            ->action('Suivre mon retrait', route('user.withdrawals.show', $this->withdrawal->id))
            ->line('Vous recevrez une notification une fois le transfert effectué.')
            ->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Retrait Approuvé ✅',
            'message' => "Votre retrait de {$this->withdrawal->formatted_net_amount} a été approuvé et est en cours de traitement.",
            'type' => 'success',
            'icon' => '✅',
            'withdrawal_id' => $this->withdrawal->id,
            'withdrawal_reference' => $this->withdrawal->reference,
            'amount' => $this->withdrawal->amount,
            'fees' => $this->withdrawal->fees,
            'net_amount' => $this->withdrawal->net_amount,
            'payment_method' => $this->withdrawal->paymentMethod->name,
            'action_url' => route('user.withdrawals.show', $this->withdrawal->id),
            'action_text' => 'Suivre mon retrait',
        ];
    }
}