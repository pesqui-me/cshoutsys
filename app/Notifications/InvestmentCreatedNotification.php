<?php

namespace App\Notifications;

use App\Models\UserInvestment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Le nouvel investissement
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
        $statusText = $this->getStatusText($this->investment->status);

        $mail = (new MailMessage)
            ->subject('📝 Nouvel investissement créé - ' . $this->investment->reference)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre demande d\'investissement a été créée avec succès.')
            ->line("**Référence** : {$this->investment->reference}")
            ->line("**Carte** : {$card->name}")
            ->line("**Montant** : {$this->investment->formatted_amount}")
            ->line("**Profit attendu** : {$this->investment->formatted_profit}")
            ->line("**Statut** : {$statusText}");

        if ($this->investment->status === 'pending_payment') {
            $mail->line('⚠️ **Action requise** : Veuillez uploader votre preuve de paiement pour que nous puissions activer votre investissement.')
                ->action('Uploader la preuve', route('user.investments.show', $this->investment->id));
        } else {
            $mail->action('Voir mon investissement', route('user.investments.show', $this->investment->id));
        }

        return $mail->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        $message = "Votre investissement de {$this->investment->formatted_amount} a été créé.";
        
        if ($this->investment->status === 'pending_payment') {
            $message .= " Veuillez uploader votre preuve de paiement.";
        }

        return [
            'title' => 'Nouvel Investissement Créé 📝',
            'message' => $message,
            'type' => 'info',
            'icon' => '📋',
            'investment_id' => $this->investment->id,
            'investment_reference' => $this->investment->reference,
            'status' => $this->investment->status,
            'action_url' => route('user.investments.show', $this->investment->id),
            'action_text' => 'Voir détails',
        ];
    }

    /**
     * Obtenir le texte du statut
     */
    protected function getStatusText(string $status): string
    {
        return match($status) {
            'pending_payment' => 'En attente de paiement',
            'payment_processing' => 'Paiement en cours de vérification',
            'active' => 'Actif',
            default => ucfirst($status),
        };
    }
}