<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bank_name',
        'sort_code',
        'account_number',
        'account_name'
    ];

    protected $hidden = [
        'sort_code',
        'account_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
