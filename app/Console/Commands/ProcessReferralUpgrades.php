<?php

namespace App\Console\Commands;

use App\Models\Levelhistory;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Earning;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use PDOException;

class ProcessReferralUpgrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'ref-upgrade';
    protected $signature = 'ref';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check referral payments and upgrade users automatically';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        Log::info("==== Letcon Cron Started ====");
        $this->info("==== Letcon Cron Started ====");

        $users = User::where('level', '<', 10)->get();
        $upgradedUsers = [];

        foreach ($users as $user) {
            $this->processUser($user, $upgradedUsers);
        }

        // Upgrade summary
        if (!empty($upgradedUsers)) {
            $summary = "=== Upgrade Summary ===\n";
            foreach ($upgradedUsers as $upgrade) {
                $summary .= "User: {$upgrade['name']} (ID: {$upgrade['id']}) - ";
                $summary .= "Upgraded to Level {$upgrade['new_level']}, Earned ₦{$upgrade['earnings']}\n";
            }
            Log::info($summary);
            $this->info($summary);
        } else {
            Log::info("No users were upgraded in this run.");
            $this->info("No users were upgraded in this run.");
        }

        Log::info("==== Letcon Cron Completed ====");
        $this->info("==== Letcon Cron Completed ====");
    }

    private function processUser(User $user, &$upgradedUsers)
    {
        $currentLevel = $user->level;
        if ($currentLevel >= 10) {
            return;
        }

        if ($currentLevel == 1) {
            $count = $this->countPaidReferrals($user->id);
            if ($count >= 4) {
                $this->upgradeUser($user, $upgradedUsers);
            }
            return;
        }

        // For level 2 and above
        $arrivalsCount = $this->countNewArrivalsToLevel($user);
        if ($arrivalsCount >= 4) {
            $this->upgradeUser($user, $upgradedUsers);
        }
    }

    private function countPaidReferrals($userId)
    {
        return Referral::where('referrer_id', $userId)
            ->whereHas('referredUser', function ($q) {
                $q->whereHas('payments', function ($p) {
                    $p->where('status', 'paid')->where('amount', 20000);
                });
            })
            ->count();
    }

    private function countNewArrivalsToLevel(User $user)
    {
        // Find when this user entered their current level
        $history = LevelHistory::where('user_id', $user->id)
            ->where('to_level', $user->level)
            ->orderBy('upgraded_at', 'desc')
            ->first();

        if (!$history) {
            return 0;
        }

        // Count how many other users entered this level after him
        return Levelhistory::where('to_level', $user->level)
            ->where('upgraded_at', '>', $history->upgraded_at)
            ->count();
    }

    private function upgradeUser(User $user, &$upgradedUsers)
    {
        $currentLevel = $user->level;
        $nextLevel = $currentLevel + 1;

        $earningsPerLevel = [
            1 => 32000,
            2 => 64000,
            3 => 128000,
            4 => 256000,
            5 => 512000,
            6 => 1024000,
            7 => 2048000,
            8 => 4096000,
            9 => 20000000
        ];

        $earnings = $earningsPerLevel[$currentLevel] ?? 0;

        try {
            DB::beginTransaction();

            // Update wallet
            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
            $wallet->earned_balance += $earnings;
            $wallet->save();

            // Save level change
            $user->level = $nextLevel;
            $user->save();

            // Record in history
            LevelHistory::create([
                'user_id' => $user->id,
                'from_level' => $currentLevel,
                'to_level' => $nextLevel,
                'upgraded_at' => now()
            ]);

            // Record the earning transaction
            Earning::create([
                'user_id' => $user->id,
                'amount' => $earnings,
                'type' => 'level_upgrade',
                'description' => "Level upgrade earnings from Level {$currentLevel} to Level {$nextLevel}",
                'earned_at' => now()
            ]);

            DB::commit();

            $message = "User {$user->name} (ID {$user->id}) upgraded from Level {$currentLevel} to Level {$nextLevel}, earned ₦{$earnings}";
            $this->info($message);
            Log::info($message);

            $upgradedUsers[] = [
                'name' => $user->name,
                'id' => $user->id,
                'new_level' => $nextLevel,
                'earnings' => $earnings
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error upgrading user {$user->id}: " . $e->getMessage());
            $this->error("Failed to upgrade user {$user->id}");
        }
    }
}
