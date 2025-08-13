<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::where('email', 'haliatolabisi@gmail.com')->update(['email_verified_at' => now()]);

        // $user1 = User::where('name', 'Katell Alvarado')->first();
        // $user1->update([
        //     'email' => 'user1@gmail.com',
        //     'email_verified_at' => now()
        // ]);
        // $user1->assignRole('member');

        // $user2 = User::where('name', 'Ignatius Livingston')->first();
        // $user2->update([
        //     'email' => 'user2@gmail.com',
        //     'email_verified_at' => now()
        // ]);
        // $user2->assignRole('member');

        // $user3 = User::where('name', 'Celeste Adams')->first();
        // $user3->update([
        //     'email' => 'user3@gmail.com',
        //     'email_verified_at' => now()
        // ]);
        // $user3->assignRole('member');

        // $user4 = User::where('name', 'Dominic Workman')->first();
        // $user4->update([
        //     'email' => 'user4@gmail.com',
        //     'email_verified_at' => now()
        // ]);
        // $user4->assignRole('member');


        //
        // $userEmails = [
        //     'xozexefol@mailinator.com',
        //     'xonobizyj@mailinator.com', 
        //     'giwimosovy@mailinator.com',
        //     'hizi@mailinator.com'
        // ];

        // foreach ($userEmails as $email) {
        //     $user = User::where('email', $email)->first();
        //     if ($user) {
        //         // Create payment record
        //         $payment = Payment::create([
        //             'user_id' => $user->id,
        //             'amount' => 20000,
        //             'status' => 'paid',
        //             'reference' => 'SEED_' . uniqid(),
        //             'payment_method' => 'paystack',
        //             'payment_method_code' => 'card'
        //         ]);

        //         // Create or update wallet
        //         $wallet = Wallet::firstOrCreate(
        //             ['user_id' => $user->id],
        //             ['balance' => 0]
        //         );

        //         $wallet->increment('balance', 20000);
        //     }
        // }




        // $all_users = User::all();
        // foreach ($all_users as $user) {
        //     $user->referred_by = null;
        //     $user->save();

        //     info($user->name . ' referred by: ' . $user->referred_by);
        // }


        // create a super admin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'username' => 'superadmin',
        ]);

        // assign super admin role
        $superAdmin = User::where('username', 'superadmin')->first();
        $superAdmin->assignRole('super-admin');

        // create username for all users that does not have username

        $users = User::whereNull('username')->get();

        foreach ($users as $user) {
            $user->username = strtolower(str_replace(' ', '', $user->name));
            $user->save();
        }
    }
}
