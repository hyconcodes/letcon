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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('amount')->nullable(); // ₦20,000
            $table->unsignedTinyInteger('level')->default(1); // Level paid for
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending'); // pending, paid, failed
            $table->string('reference')->nullable(); // Paystack reference number
            $table->string('payment_method')->nullable(); // Payment method (e.g., bank transfer, card)
            $table->string('payment_method_code')->nullable(); // Payment method code (e.g., bank code, card type)
            $table->string('currency')->default('NGN'); // Currency (e.g., NGN)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
