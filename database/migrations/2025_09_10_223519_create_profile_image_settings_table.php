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
        Schema::create('profile_image_settings', function (Blueprint $table) {
            $table->id();
            $table->string('profile_image')->nullable();
            $table->string('image_alt_text')->nullable();
            $table->string('background_color')->default('#4CAF50');
            $table->string('border_color')->default('#8B4513');
            $table->string('shadow_color')->default('#4CAF50');
            $table->integer('shadow_opacity')->default(75);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_image_settings');
    }
};
