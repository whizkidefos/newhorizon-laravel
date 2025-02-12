<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'type',
        'salary',
        'requirements',
        'benefits',
        'is_featured',
        'status'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'requirements' => 'array',
        'benefits' => 'array',
    ];
}
