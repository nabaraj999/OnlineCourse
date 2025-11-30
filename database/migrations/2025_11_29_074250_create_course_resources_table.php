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
        Schema::create('course_resources', function (Blueprint $table) {
           $table->id();
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->onDelete('cascade');

            $table->foreignId('uploaded_by')
                  ->nullable()
                  ->constrained('teachers')
                  ->onDelete('set null');

            $table->enum('type', [
                'ppt', 'pdf', 'video', 'image', 'assignment', 'note', 'link', 'other'
            ])->default('other');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();        // Stored file
            $table->text('external_url')->nullable();       // YouTube, Drive, etc.
            $table->date('resource_date')->nullable();      // Class/day this belongs to
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);

            $table->timestamps();

            // Indexes for fast queries
            $table->index('course_id');
            $table->index('uploaded_by');
            $table->index('resource_date');
            $table->index('type');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_resources');
    }
};
