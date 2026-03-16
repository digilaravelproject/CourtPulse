<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $fillable = [
        'name',
        'type',
        'city',
        'state',
        'pincode',
        'address',
        'phone',
        'email',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByState($query, string $state)
    {
        return $query->where('state', 'like', '%' . $state . '%');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getTypelabelAttribute(): string
    {
        return match ($this->type) {
            'supreme'  => 'Supreme Court',
            'high'     => 'High Court',
            'district' => 'District Court',
            'session'  => 'Sessions Court',
            'civil'    => 'Civil Court',
            'criminal' => 'Criminal Court',
            'family'   => 'Family Court',
            'consumer' => 'Consumer Court',
            'tribunal' => 'Tribunal',
            default    => ucfirst($this->type),
        };
    }
}
