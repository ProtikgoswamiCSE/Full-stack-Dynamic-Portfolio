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
        Schema::table('ai_images', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_images', 'image_path')) {
                $table->string('image_path');
            }
            if (!Schema::hasColumn('ai_images', 'alt_text')) {
                $table->string('alt_text')->nullable();
            }
            if (!Schema::hasColumn('ai_images', 'page_type')) {
                $table->string('page_type')->default('skills');
            }
            if (!Schema::hasColumn('ai_images', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_images', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'alt_text', 'page_type', 'is_active']);
        });
    }
};
