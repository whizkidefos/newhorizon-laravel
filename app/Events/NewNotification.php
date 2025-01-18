<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $message;
    public $type;

    public function __construct($userId, $message, $type = 'info')
    {
        $this->userId = $userId;
        $this->message = $message;
        $this->type = $type;
    }

    public function broadcastOn()
    {
        return new Channel('notifications.' . $this->userId);
    }
}