<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'url',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getAllOrdered()
    {
        return static::orderBy('order')->get();
    }

    public static function getActiveOrdered()
    {
        return static::where('is_active', true)->orderBy('order')->get();
    }

    public static function getNextOrder()
    {
        $lastOrder = static::max('order');
        return $lastOrder ? $lastOrder + 1 : 1;
    }

    public function getIconClass()
    {
        $icons = [
            'facebook' => 'fab fa-facebook',
            'twitter' => 'fab fa-twitter',
            'linkedin' => 'fab fa-linkedin',
            'github' => 'fab fa-github',
            'instagram' => 'fab fa-instagram',
            'youtube' => 'fab fa-youtube',
            'telegram' => 'fab fa-telegram',
            'whatsapp' => 'fab fa-whatsapp',
        ];

        return $icons[$this->platform] ?? 'fas fa-link';
    }

    public function getColorClass()
    {
        $colors = [
            'facebook' => 'text-primary',
            'twitter' => 'text-info',
            'linkedin' => 'text-primary',
            'github' => 'text-dark',
            'instagram' => 'text-danger',
            'youtube' => 'text-danger',
            'telegram' => 'text-info',
            'whatsapp' => 'text-success',
        ];

        return $colors[$this->platform] ?? 'text-secondary';
    }
}
