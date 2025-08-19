<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Payment;
use App\Models\Referral;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ProgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 16; $i++) {
            $userData = [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'username' => fake()->unique()->userName(),
                'password' => Hash::make('password'),
                'referral_code' => strtoupper(Str::random(8)),
                'email_verified_at' => now(),
                'phone' => fake()->phoneNumber(),
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
            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'status' => 'paid',
                'reference' => 'SEED_' . Str::random(8),
                'payment_method' => 'paystack',
                'payment_method_code' => 'card'
            ]);

            // Update wallet balance
            $wallet->increment('balance', $amount);

            // Get the oldest user with less than 4 referrals, excluding user with ID 1
            $referrer = User::role('member')
                ->where('id', '!=', 1)
                ->where('id', '!=', $user->id)
                ->withCount('referrals')
                ->having('referrals_count', '<', 4)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($referrer) {
                $user->referred_by = $referrer->id;
                $user->save();

                Referral::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                ]);
            }
        }
    }
}
