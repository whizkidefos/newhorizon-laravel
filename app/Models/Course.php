<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration',
        'status',
        'image_url',
        'requirements',
        'what_you_will_learn',
        'is_featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status', 'payment_status', 'progress')
            ->withTimestamps();
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function lessons(): HasMany
    {
        return $this->hasManyThrough(Lesson::class, Module::class)->orderBy('lessons.order');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active');
    }
}