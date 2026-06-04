<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContactSetting extends Model
{
    use HasFactory;

    protected $table = 'contact_settings';

    protected $fillable = [
        'office_image',
        'office_title',
        'address_title',
        'address_content',
        'phone_title',
        'phone_number',
        'phone_hours',
        'email_title',
        'email_support',
        'email_info',
        'support_text',
        'footer_badge',
    ];

    /**
     * Accessor to get the image URL, falling back to the default office photo if none is uploaded.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->office_image) {
            return Storage::disk('public')->url($this->office_image);
        }

        return 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1000';
    }
}
