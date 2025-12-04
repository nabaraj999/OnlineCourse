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
        Schema::create('course_seos', function (Blueprint $table) {
           $table->id();

            // One-to-one relationship with courses table
            $table->foreignId('course_id')
                  ->unique()
                  ->constrained('courses')
                  ->onDelete('cascade');

            // SEO core fields
            $table->string('meta_title', 70)->nullable();                    // Recommended: ≤60-70 chars
            $table->string('meta_description', 160)->nullable();             // Recommended: ≤155-160 chars
            $table->text('meta_keywords')->nullable();                       // Optional (comma-separated or JSON)

            // Open Graph / Social sharing (Facebook, LinkedIn, etc.)
            $table->string('og_title', 100)->nullable();
            $table->string('og_description', 200)->nullable();
            $table->string('og_image', 255)->nullable();                     // URL or storage path
            $table->enum('og_type', ['website', 'article', 'product', 'course'])->default('course');

            // Twitter Card
            $table->string('twitter_title', 70)->nullable();
            $table->string('twitter_description', 200)->nullable();
            $table->string('twitter_image', 255)->nullable();
            $table->enum('twitter_card', ['summary', 'summary_large_image', 'app', 'player'])
                  ->default('summary_large_image');

            // Canonical URL (useful when you have filters or query params)
            $table->string('canonical_url', 255)->nullable();

            // Robots directives
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);

            // Structured Data / JSON-LD extras (optional rich snippets)
            $table->json('structured_data')->nullable(); // You can store custom Course JSON-LD here

            // H1 override (sometimes different from course title for SEO)
            $table->string('seo_h1', 100)->nullable();

            // Extra fields for future use
            $table->text('faq_schema')->nullable();        // JSON array of FAQPage schema
            $table->text('breadcrumb_override')->nullable(); // JSON for custom breadcrumbs

            // Indexes for fast lookup
            $table->index('course_id');
            $table->index('noindex');
            $table->index('meta_title');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_seos');
    }
};
