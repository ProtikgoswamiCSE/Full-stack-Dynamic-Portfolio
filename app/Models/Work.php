<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'company_name',
        'position',
        'image_url',
        'work_url',
        'start_date',
        'end_date',
        'is_current',
        'technologies',
        'order',
        'is_active'
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_active' => 'boolean',
        'is_current' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get all active works ordered by order
     */
    public static function getActiveOrdered()
    {
        return self::where('is_active', true)
                   ->orderBy('order')
                   ->get();
    }

    /**
     * Get all works ordered by order
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

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute()
    {
        if ($this->is_current) {
            return $this->start_date ? $this->start_date->format('M Y') . ' - Present' : 'Present';
        }
        
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('M Y') . ' - ' . $this->end_date->format('M Y');
        }
        
        if ($this->start_date) {
            return $this->start_date->format('M Y');
        }
        
        return '';
    }
}
