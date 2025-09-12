<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiImage extends Model
{
    protected $fillable = [
        'image_path',
        'alt_text',
        'page_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getActiveImageForPage($pageType = 'skills')
    {
        return static::where('page_type', $pageType)
                    ->where('is_active', true)
                    ->first();
    }
}
