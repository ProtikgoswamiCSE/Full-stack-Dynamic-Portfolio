<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'name',
        'icon_class',
        'url',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get active social media links ordered by order
     */
    public static function getActiveLinks()
    {
        return self::where('is_active', true)
                   ->orderBy('order')
                   ->get();
    }

    /**
     * Get all social media links ordered by order
     */
    public static function getAllOrdered()
    {
        return self::orderBy('order')->get();
    }

    /**
     * Get next order number
     */
    public static function getNextOrder()
    {
        $lastOrder = self::max('order');
        return $lastOrder ? $lastOrder + 1 : 1;
    }
}
