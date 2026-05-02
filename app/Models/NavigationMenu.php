<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    protected $fillable = [
        'key',
        'label',
        'route',
        'type',
        'icon',
        'is_visible',
        'order'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function scopeVisible(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('is_visible', true)->orderBy('order');
    }
}
