<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabUpdate extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'image',
        'link',
        'categories',
        'published_date',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_published' => 'boolean',
    ];

    /**
     * Scope for published lab updates
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get categories as array
     */
    public function getCategoriesArrayAttribute(): array
    {
        if (empty($this->categories)) {
            return [];
        }
        return array_map('trim', explode(',', $this->categories));
    }

    /**
     * Get the image URL (supports both stored path and quantlight assets)
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }
        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, '/')) {
            return $this->image;
        }
        if (str_contains($this->image, 'quantlight/') || str_contains($this->image, 'assets/')) {
            return asset($this->image);
        }
        return asset('public/' . $this->image);
    }
}
