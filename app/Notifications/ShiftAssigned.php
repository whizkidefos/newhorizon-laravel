<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShiftAssigned extends Notification implements ShouldQueue
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
            ->subject('New Shift Assignment')
            ->line('You have been assigned to a new shift.')
            ->line('Location: ' . $this->shift->location)
            ->line('Date: ' . $this->shift->start_datetime->format('d M Y'))
            ->line('Time: ' . $this->shift->start_datetime->format('H:i') . ' - ' . $this->shift->end_datetime->format('H:i'))
            ->action('View Shift Details', route('shifts.show', $this->shift))
            ->line('Please confirm your availability for this shift.');
    }

    public function toArray($notifiable)
    {
        return [
            'shift_id' => $this->shift->id,
            'message' => 'You have been assigned to a new shift at ' . $this->shift->location,
            'start_datetime' => $this->shift->start_datetime,
        ];
    }
}