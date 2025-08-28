<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'certificate_image',
        'certificate_url',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get active achievements ordered by display order
     */
    public static function getActiveOrdered()
    {
        return static::where('is_active', true)
                    ->orderBy('order')
                    ->get();
    }

    /**
     * Get all achievements ordered by display order
     */
    public static function getAllOrdered()
    {
        return static::orderBy('order')->get();
    }

    /**
     * Get certificate image URL
     */
    public function getCertificateImageUrlAttribute()
    {
        if ($this->certificate_image) {
            return asset('storage/' . $this->certificate_image);
        }
        return $this->certificate_url;
    }
}
