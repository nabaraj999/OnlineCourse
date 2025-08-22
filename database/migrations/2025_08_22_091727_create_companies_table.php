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
        Schema::create('companies', function (Blueprint $table) {
           $table->id();
            $table->string('name', 255);
            $table->string('background_image')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('viber_number')->nullable();
            $table->string('registration_number')->unique()->nullable();
            $table->string('pan_number')->unique()->nullable();
            $table->text('description')->nullable(); // Added: Company description or about section
            $table->string('website_url')->nullable(); // Added: Main website URL
            $table->string('phone_number')->nullable(); // Added: Primary phone number
            $table->text('address')->nullable(); // Added: Full address (street, city, country, etc.)
            $table->date('founded_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
