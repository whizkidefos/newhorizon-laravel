<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shiftId;
    public $location;

    public function __construct($shiftId, $location)
    {
        $this->shiftId = $shiftId;
        $this->location = $location;
    }

    public function broadcastOn()
    {
        return new Channel('shifts');
    }
}