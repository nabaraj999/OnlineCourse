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
        Schema::create('courses', function (Blueprint $table) {
           $table->id();
            $table->string('title', 100)->notNullable();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('restrict');
            $table->foreignId('company_id')->constrained('companies')->onDelete('restrict');
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->onDelete('set null');
            $table->date('start_date')->notNullable();
            $table->date('end_date')->nullable();
            $table->decimal('price', 10, 2)->notNullable()->check('price >= 0');
            $table->integer('total_seats')->notNullable()->check('total_seats >= 0');
            $table->integer('enrolled_seats')->default(0)->check('enrolled_seats <= total_seats');
            $table->time('daily_time')->nullable();
            $table->text('syllabus')->nullable();
            $table->string('photo', 50)->nullable();
            $table->enum('active_status', ['active', 'no'])->default('active');
            $table->decimal('rating', 3, 1)->default(0.0)->check('rating between 0 and 10');
            $table->string('slug', 100)->unique();
            $table->timestamps();

            $table->index('teacher_id');
            $table->index('company_id');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
