<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Payment;
use App\Models\Referral;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the user with the given referral code
        $referrer = User::where('referral_code', 'ZMXMMJLY')->first();

        if (!$referrer) {
            $this->command->error("No user found with referral code: ZMXMMJLY");
            return;
        }

        // Create 4 users under this referrer
        for ($i = 0; $i < 4; $i++) {
            $userData = [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'username' => fake()->unique()->userName(),
                'password' => Hash::make('password'),
                'referral_code' => strtoupper(Str::random(8)),
                'email_verified_at' => now(),
                'phone' => fake()->phoneNumber(),
                'referred_by' => $referrer->id, // Assign referrer here
            ];

            $user = User::create($userData);
            $user->assignRole('member');

            // Create wallet for user
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);

            // Create initial payment for user
            $amount = 20000;
            Payment::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'status' => 'paid',
                'reference' => 'SEED_' . Str::random(8),
                'payment_method' => 'paystack',
                'payment_method_code' => 'card'
            ]);

            // Update wallet balance
            $wallet->increment('balance', $amount);

            // Create referral record
            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $user->id,
            ]);
        }

        $this->command->info("4 users created and linked under referrer: {$referrer->name} ({$referrer->referral_code})");
    }
}