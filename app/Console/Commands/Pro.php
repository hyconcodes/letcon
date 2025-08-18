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
    protected $signature = 'pro';
    protected $description = 'Check referral payments and upgrade users automatically using GP rules';

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

        if ($currentLevel == 1) {
            // STRICT: must have 4 direct referrals who paid ₦20,000
            $count = $this->countPaidReferrals($user->id);
            if ($count >= 4) {
                $this->upgradeUser($user, $upgradedUsers);
            }
            return;
        }

        // From Level 2 upward: must have at least 4 users in downline at same level
        $downlineAtSameLevel = $this->countDownlineAtLevel($user->id, $currentLevel);
        if ($downlineAtSameLevel >= 4) {
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

    private function countDownlineAtLevel($userId, $level)
    {
        $checked = [];
        $queue = [$userId];
        $total = 0;

        while (!empty($queue)) {
            $currentIds = $queue;
            $queue = [];

            $nextLevelUsers = Referral::whereIn('referrer_id', $currentIds)
                ->pluck('referred_id')
                ->toArray();

            foreach ($nextLevelUsers as $id) {
                if (!in_array($id, $checked)) {
                    $checked[] = $id;

                    $downlineUser = User::find($id);
                    if ($downlineUser && $downlineUser->level == $level) {
                        $total++;
                    }

                    $queue[] = $id; // keep exploring deeper levels
                }
            }
        }

        return $total;
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
