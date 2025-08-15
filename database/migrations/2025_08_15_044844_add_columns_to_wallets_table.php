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
        Schema::table('wallets', function (Blueprint $table) {
            $table->decimal('total_withdraw', 12, 2)->default(0);
            $table->decimal('pending_withdraw', 12, 2)->default(0);
            $table->decimal('rejected_withdraw', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('total_withdraw');
            $table->dropColumn('pending_withdraw');
            $table->dropColumn('rejected_withdraw');
        });
    }
};
