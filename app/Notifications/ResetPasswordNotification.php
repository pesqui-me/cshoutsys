<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Le token de réinitialisation du mot de passe
     */
    public string $token;

    /**
     * Créer une nouvelle instance de notification
     */
    public function __construct(string $token)
    {
        $this->token = $token;
        $this->onQueue('notifications');
    }

    /**
     * Canaux de notification
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Obtenir la représentation mail de la notification
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe - CASH OUT')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
            ->action('Réinitialiser le mot de passe', $url)
            ->line('Ce lien de réinitialisation expirera dans **60 minutes**.')
            ->line('Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune action n\'est requise. Votre mot de passe actuel reste inchangé.')
            ->salutation('L\'équipe CASH OUT 💎');
    }

    /**
     * Tags pour le monitoring
     */
    public function tags(): array
    {
        return ['password-reset', 'email'];
    }
}