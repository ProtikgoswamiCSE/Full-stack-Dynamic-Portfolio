<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    protected $fillable = [
        'institution_name',
        'degree_title',
        'field_of_study',
        'start_year',
        'end_year',
        'description',
        'certificate_image',
        'certificate_url',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'start_year' => 'integer',
        'end_year' => 'integer'
    ];

    /**
     * Get active academic records ordered by display order
     */
    public static function getActiveOrdered()
    {
        return static::where('is_active', true)
                    ->orderBy('order')
                    ->get();
    }

    /**
     * Get all academic records ordered by display order
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

    /**
     * Get academic period display
     */
    public function getAcademicPeriodAttribute()
    {
        if ($this->start_year && $this->end_year) {
            return $this->start_year . '-' . $this->end_year;
        } elseif ($this->start_year) {
            return $this->start_year . '-Present';
        } elseif ($this->end_year) {
            return 'Completed ' . $this->end_year;
        }
        return 'N/A';
    }
}
