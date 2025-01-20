<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'date_passed',
        'certificate_file',
        'expiry_date'
    ];

    protected $casts = [
        'date_passed' => 'date',
        'expiry_date' => 'date',
        'status' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}