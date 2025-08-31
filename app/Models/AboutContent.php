<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'custom_section',
        'title',
        'content',
        'image',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all active about contents ordered by order
     */
    public static function getAllOrdered()
    {
        return self::where('is_active', true)->orderBy('order')->get();
    }

    /**
     * Get content by section
     */
    public static function getBySection($section)
    {
        return self::where('section', $section)->where('is_active', true)->first();
    }

    /**
     * Get all sections
     */
    public static function getAllSections()
    {
        return self::where('is_active', true)->orderBy('order')->get()->groupBy('section');
    }

    /**
     * Get display name for section
     */
    public function getDisplaySectionAttribute()
    {
        if ($this->section === 'custom' && $this->custom_section) {
            return $this->custom_section;
        }
        
        $sectionNames = [
            'main' => 'Main About',
            'ai' => 'Artificial Intelligence',
            'programming' => 'Programming Specialization',
            'cybersecurity' => 'Cyber Security',
            'custom' => 'Custom Section'
        ];
        
        return $sectionNames[$this->section] ?? ucfirst($this->section);
    }
}
