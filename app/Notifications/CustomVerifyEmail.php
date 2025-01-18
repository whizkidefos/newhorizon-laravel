<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;

class CustomVerifyEmail extends VerifyEmail
{
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Verify Your Email Address - New Horizon Healthcare')
            ->line('Welcome to New Horizon Healthcare! Please verify your email address to complete your registration.')
            ->line('Your email verification link is valid for 60 minutes.')
            ->action('Verify Email Address', $url)
            ->line('If you did not create an account, no further action is required.');
    }
}