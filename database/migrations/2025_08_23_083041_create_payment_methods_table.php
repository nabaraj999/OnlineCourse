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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id(); // INT PRIMARY KEY
            $table->string('method_name', 50); // VARCHAR(50)
            $table->text('description'); // TEXT
            $table->boolean('active')->default(true); // BOOLEAN DEFAULT TRUE
            $table->string('account_holder', 50); // VARCHAR(50)
            $table->integer('amount_number'); // INT
            $table->string('qr', 255); // VARCHAR(255)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
