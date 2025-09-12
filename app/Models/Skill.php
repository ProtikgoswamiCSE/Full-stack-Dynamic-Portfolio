<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon_class',
        'image',
        'proficiency_percent',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'proficiency_percent' => 'integer',
        'order' => 'integer',
    ];

    public static function getAllOrderedActive()
    {
        return static::where('is_active', true)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    public static function getNextOrder(): int
    {
        $max = static::max('order');
        return $max ? $max + 1 : 1;
    }
}


