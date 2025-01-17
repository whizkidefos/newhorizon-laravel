<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'user_id',
        'start_datetime',
        'end_datetime',
        'location',
        'status',
        'checkin_time',
        'checkout_time',
        'last_tracked_location',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
        'last_tracked_location' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}