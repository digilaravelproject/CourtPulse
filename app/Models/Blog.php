<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'image_path',
    ];

    /**
     * Boot function to automatically generate clean, unique slugs on saving.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($blog) {
            if (empty($blog->slug) || $blog->isDirty('title')) {
                $blog->slug = static::generateUniqueSlug($blog->title, $blog->id);
            }
        });
    }

    /**
     * Generate a unique slug for the blog article.
     */
    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->when($excludeId, function ($q) use ($excludeId) {
            return $q->where('id', '!=', $excludeId);
        })->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Accessor to dynamically compute and format reading time based on content.
     */
    public function getReadTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = max(1, (int) ceil($words / 200));
        return $minutes . ' MIN' . ($minutes > 1 ? 'S' : '') . ' READ';
    }

    /**
     * Accessor to get public URL of the uploaded image.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->image_path) : '';
    }
}
