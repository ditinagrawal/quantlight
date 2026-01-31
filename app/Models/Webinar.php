<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webinar extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'keywords',
        'content',
        'event_date',
        'event_time',
        'location',
        'registration_link',
        'is_published',
        'image'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
    ];

    /**
     * Get the registrations for this webinar
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(WebinarRegistration::class);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('public/' . $this->image);
        }
        return null;
    }
}
