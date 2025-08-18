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
        Schema::create('level_up_triggers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // user who got upgraded
            $table->unsignedBigInteger('triggered_by'); // user who contributed to upgrade
            $table->integer('level'); // level that was triggered
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('triggered_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_up_triggers');
    }
};
