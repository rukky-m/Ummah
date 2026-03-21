<?php

namespace App\Channels\Support;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsWhatsAppChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toSmsWhatsApp')) {
            Log::error("Notification " . get_class($notification) . " does not implement toSmsWhatsApp.");
            return;
        }

        $data = $notification->toSmsWhatsApp($notifiable);
        $phone = $notifiable->phone_number ?? $notifiable->phone;

        if (!$phone) {
            Log::warning("No phone number found for recipient " . ($notifiable->name ?? $notifiable->id));
            return;
        }

        // Placeholder for real API call (Twilio, Termii, Meta, etc.)
        Log::info("Sending SMS/WhatsApp to {$phone}: " . $data['message']);
        
        // Example logic for a provider:
        // $this->gateway->send($phone, $data['message']);
    }
}
