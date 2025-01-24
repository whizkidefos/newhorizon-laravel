<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class WorkHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'start_date',
        'end_date',
        'responsibilities',
        'reference_name',
        'reference_contact',
        'reference_email',
        'reference_position',
        'can_contact_reference',
        'reason_for_leaving',
        'is_verified',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'verified_at' => 'datetime',
        'can_contact_reference' => 'boolean',
        'is_verified' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getCurrentAttribute()
    {
        return is_null($this->end_date);
    }

    public function getDurationAttribute()
    {
        $start = $this->start_date;
        $end = $this->end_date ?? now();
        return $start->diffForHumans($end, true);
    }
}
