<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Créer une nouvelle instance de notification
     */
    public function __construct()
    {
        $this->onQueue('notifications');
    }

    /**
     * Canaux de notification
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Notification email
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 Bienvenue sur CASH OUT !')
            ->greeting('Bienvenue ' . $notifiable->name . ' !')
            ->line('Nous sommes ravis de vous accueillir sur CASH OUT, votre plateforme d\'investissement en ligne.')
            ->line('**Quelques étapes pour commencer :**')
            ->line('1️⃣ Explorez nos cartes d\'investissement (ROI jusqu\'à 3000%)')
            ->line('2️⃣ Choisissez une carte adaptée à votre budget')
            ->line('3️⃣ Effectuez votre premier investissement')
            ->line('4️⃣ Profitez de vos gains après 48h !')
            ->action('Découvrir les cartes', route('user.investments.buy-card'))
            ->line('💡 **Astuce** : Partagez votre lien de parrainage et gagnez des commissions sur les investissements de vos filleuls !')
            ->line('Si vous avez des questions, notre équipe de support est disponible 24/7.')
            ->action('Contacter le support', route('user.support.create'))
            ->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Bienvenue sur CASH OUT ! 🎉',
            'message' => 'Bienvenue ! Découvrez nos cartes d\'investissement et commencez à gagner dès aujourd\'hui.',
            'type' => 'info',
            'icon' => '👋',
            'action_url' => route('user.investments.buy-card'),
            'action_text' => 'Découvrir les cartes',
        ];
    }
}