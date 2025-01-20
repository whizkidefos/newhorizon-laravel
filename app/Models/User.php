<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile_phone',
        'username',
        'job_role',
        'password',
        'profile_photo',
        'dob',
        'gender',
        'postcode',
        'address',
        'country',
        'criminal_record',
        'ni_number',
        'dbs_status',
        'dbs_certificate',
        'nationality',
        'right_to_work',
        'brp_number',
        'brp_document',
        'work_history',
        'bank_sort_code',
        'bank_account_number',
        'bank_name',
        'signature',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'criminal_record' => 'boolean',
        'dbs_status' => 'boolean',
        'right_to_work' => 'boolean',
        'dob' => 'date',
    ];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
