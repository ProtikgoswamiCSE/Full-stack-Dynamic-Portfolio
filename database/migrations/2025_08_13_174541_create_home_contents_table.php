<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique(); // e.g., 'title', 'subtitle', 'skills_list'
            $table->text('content'); // The actual content
            $table->timestamps();
        });

        Schema::create('social_media_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // e.g., 'github', 'facebook', 'instagram'
            $table->string('name'); // Display name
            $table->string('icon_class'); // FontAwesome icon class
            $table->text('url');
            $table->integer('order')->default(0); // For ordering
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_links');
        Schema::dropIfExists('home_contents');
    }
};
