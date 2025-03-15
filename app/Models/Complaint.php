<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Shift;

class Complaint extends Model
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
        'title',
        'description',
        'severity',
        'status',
        'resolution_notes',
        'resolved_by',
        'resolved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the user that owns the complaint.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shift associated with the complaint.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Get the user who resolved the complaint.
     */
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
