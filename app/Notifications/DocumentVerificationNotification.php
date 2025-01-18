<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentVerificationNotification extends Notification
{
    private $document;
    private $verification;

    public function __construct($document, $verification)
    {
        $this->document = $document;
        $this->verification = $verification;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Document Verification Update')
            ->line('Your document has been reviewed.')
            ->line('Status: ' . ucfirst($this->verification->status))
            ->line('Type: ' . $this->document->type)
            ->lineIf($this->verification->status === 'approved', 
                'Expires on: ' . $this->verification->expires_at->format('d M Y'))
            ->lineIf($this->verification->notes, 
                'Notes: ' . $this->verification->notes);
    }

    public function toArray($notifiable)
    {
        return [
            'document_id' => $this->document->id,
            'status' => $this->verification->status,
            'notes' => $this->verification->notes,
        ];
    }
}