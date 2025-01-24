<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'postcode',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'country',
        'cv_path',
        'combined_certificate_path',
        'work_history',
        'consent_given'
    ];

    protected $casts = [
        'consent_given' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
