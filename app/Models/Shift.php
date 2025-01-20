<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'start_datetime',
        'end_datetime',
        'location',
        'status',
        'rate_per_hour',
        'notes',
        'checkin_time',
        'checkout_time',
        'last_tracked_location'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
        'last_tracked_location' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'assigned' && 
               $this->checkin_time && 
               !$this->checkout_time;
    }

    public function getDurationAttribute()
    {
        if ($this->checkin_time && $this->checkout_time) {
            return $this->checkin_time->diffInHours($this->checkout_time);
        }
        return $this->start_datetime->diffInHours($this->end_datetime);
    }
}