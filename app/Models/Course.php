<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status', 'payment_status', 'completed_at')
            ->withTimestamps();
    }
}