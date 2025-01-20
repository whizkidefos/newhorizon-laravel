<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ShiftCancelled extends Notification
{
    use Queueable;

    protected $shift;
    protected $reason;

    public function __construct($shift, $reason = null)
    {
        $this->shift = $shift;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Shift Cancelled')
            ->line('Unfortunately, your shift has been cancelled.')
            ->line('Shift Details:')
            ->line('Location: ' . $this->shift->location)
            ->line('Date: ' . $this->shift->start_datetime->format('d M Y'))
            ->line('Time: ' . $this->shift->start_datetime->format('H:i'))
            ->when($this->reason, function ($message) {
                return $message->line('Reason: ' . $this->reason);
            })
            ->line('Please contact us if you have any questions.');
    }

    public function toArray($notifiable)
    {
        return [
            'shift_id' => $this->shift->id,
            'type' => 'cancellation',
            'message' => 'Your shift at ' . $this->shift->location . ' has been cancelled',
            'reason' => $this->reason
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'shift_id' => $this->shift->id,
            'message' => 'Your shift has been cancelled',
            'time' => now()->toISOString()
        ];
    }
}