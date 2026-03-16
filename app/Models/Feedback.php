<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'given_by',
        'given_to',
        'role_type',
        'rating',
        'comment',
        'is_compulsory',
        'is_anonymous',
    ];

    protected $casts = [
        'is_compulsory' => 'boolean',
        'is_anonymous'  => 'boolean',
        'rating'        => 'integer',
    ];

    public function giver()
    {
        return $this->belongsTo(User::class, 'given_by');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'given_to');
    }

    public function getGiverNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }
        return $this->giver?->name ?? 'Unknown';
    }
}
