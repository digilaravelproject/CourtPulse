<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvocateProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bar_council_number',
        'enrollment_number',
        'enrollment_date',
        'high_court',
        'practice_areas',
        'experience_years',
        'bio',
        'office_address',
        'office_phone',
        'website',
        'is_verified',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'practice_areas' => 'array',
        'enrollment_date' => 'date',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
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
