<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to New Horizon Healthcare - Please Verify Your Email')
            ->greeting('Hello!')
            ->line('Welcome to New Horizon Healthcare! We\'re excited to have you join our team.')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $url)
            ->line('If you did not create an account, no further action is required.')
            ->line('Thank you for choosing New Horizon Healthcare as your staffing partner!');
    }
}