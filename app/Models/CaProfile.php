<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaProfile extends Model
{
    protected $fillable = [
        'user_id',
        'membership_number',
        'icai_region',
        'membership_date',
        'specializations',
        'experience_years',
        'bio',
        'firm_name',
        'office_address',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'specializations'  => 'array',
        'membership_date'  => 'date',
        'is_verified'      => 'boolean',
        'verified_at'      => 'datetime',
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
