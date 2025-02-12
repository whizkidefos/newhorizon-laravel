<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Shift extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'start_datetime',
        'end_datetime',
        'location',
        'department',
        'status',
        'rate_per_hour',
        'notes',
        'checkin_time',
        'checkout_time',
        'last_tracked_location',
        'timesheet_notes'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
        'last_tracked_location' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'in_progress' && 
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

    public function getStartDateAttribute()
    {
        return $this->start_datetime;
    }

    public function getStartTimeAttribute()
    {
        return $this->start_datetime;
    }

    public function getEndTimeAttribute()
    {
        return $this->end_datetime;
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->whereNull('user_id')
                    ->where('status', 'available')
                    ->where('start_datetime', '>', now());
    }

    public function isAvailable()
    {
        return is_null($this->user_id) && 
               $this->status === 'available' && 
               $this->start_datetime->isFuture();
    }

    public function canCheckIn()
    {
        return $this->user_id === auth()->id() && 
               $this->status === 'assigned' && 
               !$this->checkin_time;
    }

    public function canCheckOut()
    {
        return $this->user_id === auth()->id() && 
               $this->status === 'in_progress' && 
               $this->checkin_time && 
               !$this->checkout_time;
    }
}