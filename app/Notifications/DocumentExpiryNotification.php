<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentExpiryNotification extends Notification
{
    private $verification;

    public function __construct($verification)
    {
        $this->verification = $verification;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $daysUntilExpiry = now()->diffInDays($this->verification->expires_at);

        return (new MailMessage)
            ->subject('Document Expiring Soon')
            ->line('Your ' . $this->verification->document->type . ' is expiring soon.')
            ->line('Expiry Date: ' . $this->verification->expires_at->format('d M Y'))
            ->line('Days Remaining: ' . $daysUntilExpiry)
            ->action('Upload New Document', route('profile.documents'));
    }

    public function toArray($notifiable)
    {
        return [
            'document_id' => $this->verification->document_id,
            'expires_at' => $this->verification->expires_at,
            'days_remaining' => now()->diffInDays($this->verification->expires_at),
        ];
    }
}