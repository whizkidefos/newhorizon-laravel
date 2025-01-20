<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShiftReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $shift;

    public function __construct($shift)
    {
        $this->shift = $shift;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Upcoming Shift Reminder')
            ->line('This is a reminder for your upcoming shift tomorrow.')
            ->line('Location: ' . $this->shift->location)
            ->line('Start Time: ' . $this->shift->start_datetime->format('d M Y H:i'))
            ->action('View Shift Details', route('shifts.show', $this->shift))
            ->line('Please ensure you arrive on time.');
    }

    public function toArray($notifiable)
    {
        return [
            'shift_id' => $this->shift->id,
            'type' => 'reminder',
            'message' => 'Reminder: You have a shift tomorrow at ' . $this->shift->location
        ];
    }
}