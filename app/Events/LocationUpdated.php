<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shiftId;
    public $latitude;
    public $longitude;
    public $timestamp;

    public function __construct($shiftId, $latitude, $longitude)
    {
        $this->shiftId = $shiftId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timestamp = now();
    }

    public function broadcastOn()
    {
        return new PrivateChannel('shifts.' . $this->shiftId);
    }
}