<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'file_path',
        'verified',
        'expiry_date'
    ];

    protected $casts = [
        'verified' => 'boolean',
        'expiry_date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
