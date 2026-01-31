<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'keywords',
        'content',
        'category_id',
        'is_published',
        'image'
    ];

    protected $attributes = [
        'category' => null,
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Set category to null when saving if category_id is set
        static::saving(function ($blog) {
            if ($blog->category_id !== null) {
                $blog->attributes['category'] = null;
            }
        });
    }

    /**
     * Get the category that owns the blog
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the category name (for backward compatibility with old category column)
     * Use this when you need the category name as a string
     */
    public function getCategoryNameAttribute()
    {
        // If category relationship exists, use it
        if ($this->relationLoaded('category') && $this->category) {
            return $this->category->name;
        }
        
        // If category_id is set, try to get the category
        if ($this->category_id) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
                    $category = $this->category()->first();
                    if ($category) {
                        return $category->name;
                    }
                }
            } catch (\Exception $e) {
                // Fall through to old column
            }
        }
        
        // Fallback to old category column if it exists
        if (isset($this->attributes['category']) && $this->attributes['category']) {
            return $this->attributes['category'];
        }
        
        return null;
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
