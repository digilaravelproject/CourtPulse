<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class User extends Authenticatable
{
    use Notifiable, HasRoles, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'registration_step',
        'is_reviewed',
        'profile_photo',
        'address',
        'city',
        'state',
        'pincode',
        'otp',
        'otp_expires_at',
        'phone_verified_at',
        'user_group',
        'sub_role',
        'experience_years',
        'capabilities',
        'license_number',
        'past_employers',
        'court_id',
        'court_ids'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'court_ids' => 'array'
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function advocateProfile()
    {
        return $this->hasOne(AdvocateProfile::class);
    }

    public function clerkProfile()
    {
        return $this->hasOne(ClerkProfile::class);
    }

    public function caProfile()
    {
        return $this->hasOne(CaProfile::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function feedbacksGiven()
    {
        return $this->hasMany(Feedback::class, 'given_by');
    }

    public function feedbacksReceived()
    {
        return $this->hasMany(Feedback::class, 'given_to');
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function isVerified(): bool
    {
        return $this->status === 'active';
    }
}
