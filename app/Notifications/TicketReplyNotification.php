<?php

namespace App\Notifications;

use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Le ticket de support
     */
    public SupportTicket $ticket;

    /**
     * Le message de réponse
     */
    public SupportMessage $message;

    /**
     * Créer une nouvelle instance de notification
     */
    public function __construct(SupportTicket $ticket, SupportMessage $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
        $this->onQueue('notifications');
    }

    /**
     * Canaux de notification
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if ($notifiable->email_notifications) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Notification email
     */
    public function toMail(object $notifiable): MailMessage
    {
        $isFromSupport = $this->message->user->hasRole(['admin', 'super-admin', 'support']);
        $senderName = $isFromSupport ? 'L\'équipe support' : $this->message->user->name;

        $messagePreview = strlen($this->message->message) > 150 
            ? substr($this->message->message, 0, 150) . '...' 
            : $this->message->message;

        return (new MailMessage)
            ->subject('💬 Nouvelle réponse sur votre ticket #' . $this->ticket->reference)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line("Une nouvelle réponse a été ajoutée à votre ticket de support.")
            ->line("**Ticket** : {$this->ticket->reference}")
            ->line("**Sujet** : {$this->ticket->subject}")
            ->line("**Réponse de** : {$senderName}")
            ->line("**Message** :")
            ->line($messagePreview)
            ->action('Voir le ticket', route('user.support.show', $this->ticket->id))
            ->line('Vous pouvez répondre directement depuis votre espace client.')
            ->salutation('L\'équipe CASH OUT');
    }

    /**
     * Notification database (in-app)
     */
    public function toArray(object $notifiable): array
    {
        $isFromSupport = $this->message->user->hasRole(['admin', 'super-admin', 'support']);
        
        return [
            'title' => 'Nouvelle Réponse sur Ticket 💬',
            'message' => "Une nouvelle réponse a été ajoutée à votre ticket #{$this->ticket->reference} : {$this->ticket->subject}",
            'type' => 'info',
            'icon' => '💬',
            'ticket_id' => $this->ticket->id,
            'ticket_reference' => $this->ticket->reference,
            'ticket_subject' => $this->ticket->subject,
            'message_id' => $this->message->id,
            'sender_name' => $isFromSupport ? 'Support' : $this->message->user->name,
            'is_from_support' => $isFromSupport,
            'action_url' => route('user.support.show', $this->ticket->id),
            'action_text' => 'Voir le ticket',
        ];
    }
}