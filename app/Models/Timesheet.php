<?php

namespace App\Models;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'shift_id',
        'date',
        'start_time',
        'end_time',
        'hours_worked',
        'break_duration',
        'tasks_completed',
        'notes',
        'status',
        'rejection_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'hours_worked' => 'decimal:2',
        'break_duration' => 'decimal:2',
    ];

    /**
     * Get the user that owns the timesheet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shift associated with the timesheet.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
