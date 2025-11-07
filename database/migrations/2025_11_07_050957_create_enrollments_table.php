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
       Schema::create('enrollments', function (Blueprint $table) {
  $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('payment_method_id')
                  ->constrained('payment_methods')
                  ->onDelete('cascade');
            $table->string('full_name');
            $table->string('email')->index();
            $table->string('phone', 15);
            $table->string('reference_code', 50)->unique();
            $table->string('screenshot_path');
            $table->string('screenshot_url')->nullable();
            $table->decimal('amount_paid', 10, 2);
            $table->string('password');
            $table->string('plain_password')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();

            // Indexes for performance
            $table->index(['status', 'enrolled_at']);
            $table->index('course_id');
            $table->index('payment_method_id');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
