<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'content'
    ];

    /**
     * Get content by section
     */
    public static function getContent($section, $default = '')
    {
        $content = self::where('section', $section)->first();
        return $content ? $content->content : $default;
    }

    /**
     * Update or create content for a section
     */
    public static function updateContent($section, $content)
    {
        return self::updateOrCreate(
            ['section' => $section],
            ['content' => $content]
        );
    }
}
