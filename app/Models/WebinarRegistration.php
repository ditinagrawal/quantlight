<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebinarRegistration extends Model
{
    protected $fillable = [
        'webinar_id',
        'name',
        'email',
        'phone',
        'location',
        'extra_field_1',
        'extra_field_2',
    ];

    protected $attributes = [
        'extra_field_1' => 'default_value_1',
        'extra_field_2' => 'default_value_2',
    ];

    /**
     * Get the webinar that owns the registration
     */
    public function webinar(): BelongsTo
    {
        return $this->belongsTo(Webinar::class);
    }
}
