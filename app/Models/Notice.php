<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Notice extends Model
{
    protected $fillable = [
        'court_id',
        'title',
        'pdf_path',
        'show_new_badge',
    ];

    protected $casts = [
        'show_new_badge' => 'boolean',
    ];

    /**
     * Get the court associated with the notice/circular.
     */
    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }
}
