<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'project_url',
        'github_url',
        'technologies',
        'order',
        'is_active'
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get all active projects ordered by order
     */
    public static function getActiveOrdered()
    {
        return self::where('is_active', true)
                   ->orderBy('order')
                   ->get();
    }

    /**
     * Get all projects ordered by order
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
        $maxOrder = self::max('order');
        return $maxOrder ? $maxOrder + 1 : 1;
    }

    /**
     * Get technologies as comma-separated string
     */
    public function getTechnologiesStringAttribute()
    {
        return is_array($this->technologies) ? implode(', ', $this->technologies) : $this->technologies;
    }

    /**
     * Set technologies from comma-separated string
     */
    public function setTechnologiesStringAttribute($value)
    {
        $this->technologies = array_map('trim', explode(',', $value));
    }
}
