<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'published_date',
        'link',
        'is_published',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_published' => 'boolean',
    ];

    /**
     * Scope for published citations
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get formatted date for display
     */
    public function getFormattedDateAttribute()
    {
        return $this->published_date?->format('d-m-Y');
    }
}
