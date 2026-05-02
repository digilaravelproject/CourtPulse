<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Court extends Model
{
    protected $fillable = [
        'name',
        'city',
        'area',
        'pincode',
    ];
}
