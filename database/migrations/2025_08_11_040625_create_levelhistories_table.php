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
        Schema::create('level_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');         // User who got upgraded
            $table->integer('from_level')->nullable();     // Previous level
            $table->integer('to_level');                   // New level
            $table->timestamp('upgraded_at');              // Exact upgrade time
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_history');
    }
};
