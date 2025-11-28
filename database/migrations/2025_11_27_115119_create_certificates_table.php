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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')
                  ->constrained('enrollments')
                  ->onDelete('cascade');
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->onDelete('cascade');
            $table->boolean('is_issued')->default(false);
            $table->timestamp('issued_at')->nullable();
            $table->string('certificate_number')->unique()->nullable(); // e.g., CERT-2025-001
            $table->timestamp('completed_at')->nullable(); // When student finished course
            $table->timestamps();

            // Ensure one certificate per enrollment + course
            $table->unique(['enrollment_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
