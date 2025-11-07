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
           $table->id();

            // Core Info
            $table->string('method_name', 100);                    // e.g., eSewa, Khalti, IME Pay, Bank Transfer
            $table->string('slug', 100)->unique();                 // For clean URLs if needed later
            $table->text('description')->nullable();               // Optional long description

            // Payment Details
            $table->string('account_holder', 100);                 // Name on account
            $table->string('account_number', 50);                  // Mobile no / Account no
            $table->string('qr_code', 255)->nullable();            // Stored as: public/qr/esewa.png
            $table->text('instructions')->nullable();              // HTML instructions: <ol><li>Scan QR...</li></ol>

            // Status & Visibility
            $table->boolean('active')->default(true)->index();     // Show in frontend?
            $table->integer('sort_order')->default(0);             // For manual ordering

            // Timestamps
            $table->timestamps();
            $table->index(['active', 'sort_order']);
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
