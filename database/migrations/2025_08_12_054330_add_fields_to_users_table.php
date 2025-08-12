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
            // $table->string('is_org')->after('password')->default('no');
            // $table->string('org_name')->after('is_org')->nullable();
            // $table->string('org_picture')->after('org_name')->nullable();

            $table->string('country')->after('password')->nullable();
            $table->string('state')->after('country')->nullable();
            $table->string('city')->after('state')->nullable();
            $table->string('address')->after('city')->nullable();
            $table->string('postal_code')->after('address')->nullable();

            // bank withdraw details
            $table->string('bank_name')->after('postal_code')->nullable();
            $table->string('bank_account_name')->after('bank_name')->nullable();
            $table->string('bank_account_number')->after('bank_account_name')->nullable();
            $table->string('pin')->after('bank_account_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                // 'is_org',
                // 'org_name',
                // 'org_picture',
                'country',
                'state',
                'city',
                'address',
                'postal_code',
                'bank_name',
                'bank_account_name',
                'bank_account_number',
                'pin',
            ]);
        });
    }
};
