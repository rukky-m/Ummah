<?php

namespace App\Notifications\Support;

use App\Models\SupportTicket;
use App\Channels\Support\SmsWhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
 
class TicketOpened extends Notification implements ShouldQueue
{
    use Queueable;
 
    public $ticket;
 
    /**
     * Create a new notification instance.
     */
    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', SmsWhatsAppChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Support Ticket: ' . $this->ticket->subject)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new support ticket has been opened.')
                    ->line('Subject: ' . $this->ticket->subject)
                    ->line('Priority: ' . strtoupper($this->ticket->priority))
                    ->action('View Ticket', route('admin.support.show', $this->ticket))
                    ->line('Please respond as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'user_name' => $this->ticket->user->name,
            'type' => 'new_ticket',
        ];
    }
 
    /**
     * Get the SMS/WhatsApp representation of the notification.
     */
    public function toSmsWhatsApp(object $notifiable): array
    {
        return [
            'message' => "New Support Ticket: #{$this->ticket->id} - {$this->ticket->subject}. Priority: {$this->ticket->priority}.",
        ];
    }
}
