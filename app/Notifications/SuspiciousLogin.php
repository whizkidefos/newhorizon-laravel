<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SuspiciousLogin extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Suspicious Login Detected - New Horizon Healthcare')
            ->line('We detected a login to your account from a new device or location.')
            ->line('If this was you, you can ignore this message.')
            ->line('If you did not log in recently, we recommend changing your password immediately.')
            ->action('Change Password', url('/password/reset'))
            ->line('Thank you for helping us keep your account secure.');
    }
}