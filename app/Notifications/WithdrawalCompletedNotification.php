<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Le retrait complété
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
        $paymentDetails = $this->withdrawal->payment_details;

        $mail = (new MailMessage)
            ->subject('✅ Votre retrait a été effectué')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre retrait a été effectué avec succès !')
            ->line("**Référence** : {$this->withdrawal->reference}")
            ->line("**Montant transféré** : {$this->withdrawal->formatted_net_amount}")
            ->line("**Moyen de paiement** : {$paymentMethod->name}")
            ->line("**Date de transfert** : " . $this->withdrawal->completed_at->format('d/m/Y H:i'));

        // Ajouter les détails du paiement selon le type
        if (isset($paymentDetails['wallet_address'])) {
            $mail->line("**Adresse wallet** : {$paymentDetails['wallet_address']}");
        } elseif (isset($paymentDetails['account_id'])) {
            $mail->line("**Compte** : {$paymentDetails['account_id']}");
        } elseif (isset($paymentDetails['phone_number'])) {
            $mail->line("**Téléphone** : {$paymentDetails['phone_number']}");
        }

        return $mail
            ->line('Le transfert devrait apparaître dans votre compte sous peu.')
            ->action('Voir le reçu', route('user.withdrawals.show', $this->withdrawal->id))
            ->line('Merci d\'utiliser CASH OUT !')
            ->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Retrait Effectué ✅',
            'message' => "Votre retrait de {$this->withdrawal->formatted_net_amount} a été effectué avec succès !",
            'type' => 'success',
            'icon' => '💸',
            'withdrawal_id' => $this->withdrawal->id,
            'withdrawal_reference' => $this->withdrawal->reference,
            'net_amount' => $this->withdrawal->net_amount,
            'payment_method' => $this->withdrawal->paymentMethod->name,
            'completed_at' => $this->withdrawal->completed_at->toIso8601String(),
            'action_url' => route('user.withdrawals.show', $this->withdrawal->id),
            'action_text' => 'Voir le reçu',
        ];
    }
}