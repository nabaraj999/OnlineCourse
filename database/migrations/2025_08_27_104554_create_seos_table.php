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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type', 50);
            $table->string('title', 100);
            $table->text('description');
            $table->string('keywords', 255);
            $table->string('slug', 100);
            $table->string('canonical_url', 255)->nullable();
            $table->string('og_title', 100)->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image', 255)->nullable();
            $table->string('twitter_card', 50)->nullable();
            $table->string('twitter_title', 100)->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image', 255)->nullable();
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->string('robots_txt_directives', 255)->nullable();
            $table->decimal('sitemap_priority', 3, 2)->default(0.5);
            $table->datetime('last_modified')->nullable();
            $table->text('schema_markup')->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->string('hreflang', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
