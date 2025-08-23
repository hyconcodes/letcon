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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('kyc_type', ['nin', 'voters_card', 'driver_license', 'passport'])->after('pin')->nullable();
            $table->string('kyc_id')->after('kyc_type')->nullable();
            $table->string('kyc_image')->after('kyc_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kyc_type', 'kyc_id', 'kyc_image']);
        });
    }
};
