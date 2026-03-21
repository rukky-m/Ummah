<?php

namespace App\Notifications\Support;

use App\Models\SupportMessage;
use App\Channels\Support\SmsWhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
 
class NewMessageReceived extends Notification implements ShouldQueue
{
    use Queueable;
 
    public $message;
 
    /**
     * Create a new notification instance.
     */
    public function __construct(SupportMessage $message)
    {
        $this->message = $message;
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
        $url = $this->message->is_admin 
            ? route('support.show', $this->message->support_ticket_id) 
            : route('admin.support.show', $this->message->support_ticket_id);

        return (new MailMessage)
                    ->subject('New Message: ' . $this->message->ticket->subject)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('You have a new message on your support ticket.')
                    ->line('Message Preview: ' . substr($this->message->message, 0, 100) . '...')
                    ->action('View Conversation', $url)
                    ->line('Thank you for using our platform.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->message->support_ticket_id,
            'message_id' => $this->message->id,
            'from' => $this->message->is_admin ? 'Support' : $this->message->user->name,
            'type' => 'new_message',
        ];
    }
 
    /**
     * Get the SMS/WhatsApp representation of the notification.
     */
    public function toSmsWhatsApp(object $notifiable): array
    {
        $sender = $this->message->is_admin ? 'Support Team' : $this->message->user->name;
        return [
            'message' => "New message on Ticket #{$this->message->support_ticket_id} from {$sender}: " . substr($this->message->message, 0, 50) . "...",
        ];
    }
}
