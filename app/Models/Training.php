<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'provider',
        'description',
        'completion_date',
        'expiry_date',
        'certificate_url',
        'status'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the user that owns the training record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active trainings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>', now());
            });
    }

    /**
     * Scope a query to only include expired trainings.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }
}
