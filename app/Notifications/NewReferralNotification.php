<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReferralNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Le nouveau filleul
     */
    public User $referral;

    /**
     * Commission gagnée (optionnel)
     */
    public ?float $commission;

    /**
     * Créer une nouvelle instance de notification
     */
    public function __construct(User $referral, ?float $commission = null)
    {
        $this->referral = $referral;
        $this->commission = $commission;
        $this->onQueue('notifications');
    }

    /**
     * Canaux de notification
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if ($notifiable->email_notifications && $notifiable->promotion_notifications) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Notification email
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('🎉 Nouveau filleul inscrit !')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Excellente nouvelle ! Un nouveau membre s\'est inscrit via votre lien de parrainage.')
            ->line("**Nom du filleul** : {$this->referral->name}")
            ->line("**Date d'inscription** : " . $this->referral->created_at->format('d/m/Y H:i'));

        if ($this->commission && $this->commission > 0) {
            $formattedCommission = number_format($this->commission, 2) . ' USD';
            $mail->line("**Commission gagnée** : {$formattedCommission}")
                ->line('La commission a été créditée à votre solde.');
        }

        return $mail
            ->line('Continuez à partager votre lien de parrainage pour gagner plus de commissions !')
            ->action('Voir mes filleuls', route('user.profile.referral'))
            ->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        $message = "Un nouveau membre ({$this->referral->name}) s'est inscrit via votre lien de parrainage.";
        
        if ($this->commission && $this->commission > 0) {
            $formattedCommission = number_format($this->commission, 2) . ' USD';
            $message .= " Commission gagnée: {$formattedCommission}";
        }

        return [
            'title' => 'Nouveau Filleul ! 🎉',
            'message' => $message,
            'type' => 'success',
            'icon' => '👥',
            'referral_id' => $this->referral->id,
            'referral_name' => $this->referral->name,
            'commission' => $this->commission,
            'action_url' => route('user.profile.referral'),
            'action_text' => 'Voir mes filleuls',
        ];
    }
}