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
        Schema::create('discounts', function (Blueprint $table) {
           $table->id();
            $table->string('code')->unique()->notNullable()->index();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 5, 2)->notNullable()->check('value >= 0 AND value <= 100 WHEN type = "percentage"');
            $table->date('start_date')->notNullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Add index for performance on date-based queries
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
