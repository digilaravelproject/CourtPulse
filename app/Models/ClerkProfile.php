<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClerkProfile extends Model
{
    protected $fillable = [
        'user_id',
        'clerk_id_number',
        'court_name',
        'court_city',
        'court_state',
        'department',
        'experience_years',
        'bio',
        'advocate_contacts',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'advocate_contacts' => 'array',
        'is_verified'       => 'boolean',
        'verified_at'       => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
