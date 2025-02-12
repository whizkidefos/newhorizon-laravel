<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Reference extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'relationship',
        'verified'
    ];

    protected $casts = [
        'verified' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
