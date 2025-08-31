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
        Schema::create('academics', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->string('degree_title');
            $table->string('field_of_study');
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();
            $table->text('description')->nullable();
            $table->string('certificate_image')->nullable();
            $table->string('certificate_url')->nullable();
            $table->integer('order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academics');
    }
};
