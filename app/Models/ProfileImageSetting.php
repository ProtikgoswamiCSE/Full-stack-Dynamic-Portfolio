<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_image',
        'image_alt_text',
        'background_color',
        'border_color',
        'shadow_color',
        'shadow_opacity'
    ];

    /**
     * Get the current profile image settings
     */
    public static function getSettings()
    {
        $settings = self::first();
        if (!$settings) {
            $settings = self::create([
                'background_color' => '#4CAF50',
                'border_color' => '#8B4513',
                'shadow_color' => '#4CAF50',
                'shadow_opacity' => 75
            ]);
        }
        return $settings;
    }

    /**
     * Update profile image settings
     */
    public static function updateSettings($data)
    {
        $settings = self::first();
        if (!$settings) {
            $settings = new self();
        }
        
        $settings->fill($data);
        $settings->save();
        
        return $settings;
    }
}
