<?php

namespace App\Console\Commands;

use App\Models\LevelHistory;
use App\Models\Referral;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Earning;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Ref extends Command
{
    protected $signature = 'reff';
    protected $description = 'Check referral payments and upgrade users automatically using strict GP pyramid rules';

    public function handle()
    {
        Log::info("==== Letcon Cron Started ====");
        $this->info("==== Letcon Cron Started ====");

        $users = User::where('level', '<', 10)->get();
        $upgradedUsers = [];

        foreach ($users as $user) {
            $this->processUser($user, $upgradedUsers);
        }

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

        // GP: Level 1 => 1, Level 2 => 4, Level 3 => 16, ...
        $requiredReferrals = pow(4, $currentLevel - 1);

        if ($currentLevel == 1) {
            $count = $this->countPaidReferrals($user->id);
            if ($count >= $requiredReferrals) {
                $this->upgradeUser($user, $upgradedUsers);
            }
            return;
        }

        // For Level 2 and above, check full pyramid structure
        $depth = $currentLevel;
        if ($this->hasFullGPPyramid($user->id, $depth)) {
            $this->upgradeUser($user, $upgradedUsers);
        }
    }

    private function countPaidReferrals($userId)
    {
        return Referral::where('referrer_id', $userId)
            ->whereHas('referredUser.payments', function ($p) {
                $p->where('status', 'paid')->where('amount', 20000);
            })
            ->count();
    }

    /**
     * Strict GP check: every level in the tree must be fully filled
     */
    private function hasFullGPPyramid($userId, $depth)
    {
        $currentLevelUsers = [$userId];

        for ($i = 0; $i < $depth; $i++) {
            $nextLevelUsers = Referral::whereIn('referrer_id', $currentLevelUsers)
                ->whereHas('referredUser.payments', function ($p) {
                    $p->where('status', 'paid')->where('amount', 20000);
                })
                ->pluck('referred_id')
                ->toArray();

            // Expected number at this depth
            $expectedAtThisDepth = pow(4, $i + 1);

            if (count($nextLevelUsers) < $expectedAtThisDepth) {
                return false; // Missing members in this depth
            }

            $currentLevelUsers = $nextLevelUsers;
        }

        return true; // All depths are complete
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

            // Update wallet balance
            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
            $wallet->earned_balance += $earnings;
            $wallet->save();

            // Update user level
            $user->level = $nextLevel;
            $user->save();

            // Record in level history
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
