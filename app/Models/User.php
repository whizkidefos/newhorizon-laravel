<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'mobile_number',
        'job_role',
        'date_of_birth',
        'gender',
        'profile_photo',
        'national_insurance_number',
        'has_enhanced_dbs',
        'dbs_certificate',
        'nationality',
        'right_to_work_uk',
        'brp_number',
        'brp_document',
        'has_criminal_convictions',
        'password',
        'signature',
        'signature_date',
        'is_admin',
        'admin_level',
        'admin_created_at',
        'created_by_admin_id',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'postcode',
        'employee_id',
        'department',
        'position',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'signature_date' => 'date',
        'admin_created_at' => 'datetime',
        'is_admin' => 'boolean',
        'has_enhanced_dbs' => 'boolean',
        'right_to_work_uk' => 'boolean',
        'has_criminal_convictions' => 'boolean',
    ];

    public function shifts(): HasMany
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

    public function profileDetail()
    {
        return $this->hasOne(ProfileDetail::class);
    }

    public function bankDetail()
    {
        return $this->hasOne(BankDetail::class);
    }

    public function workHistory()
    {
        return $this->hasMany(WorkHistory::class);
    }

    public function trainingRecords()
    {
        return $this->hasMany(TrainingRecord::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withTimestamps()
            ->withPivot('status', 'payment_status', 'progress');
    }

    public function completedLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')
            ->withTimestamps()
            ->withPivot('completed_at');
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'causer');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Get the timesheets for the user.
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    /**
     * Get the complaints submitted by the user.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get the complaints resolved by the user.
     */
    public function resolvedComplaints()
    {
        return $this->hasMany(Complaint::class, 'resolved_by');
    }
}
