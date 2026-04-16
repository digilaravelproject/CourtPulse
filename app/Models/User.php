<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

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
        'pincode'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

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
