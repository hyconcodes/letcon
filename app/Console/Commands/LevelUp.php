<?php

namespace App\Console\Commands;

use App\Models\LevelHistory;
use App\Models\LevelUpTrigger;
use App\Models\Referral;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Earning;
use App\Models\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LevelUp extends Command
{
    protected $signature = 'upgrade';
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

        // Already max level?
        if ($currentLevel >= 10) {
            return;
        }

        if ($currentLevel == 1) {
            $this->processLevelOneUpgrade($user, $upgradedUsers);
        } else {
            $this->processHigherLevelUpgrade($user, $upgradedUsers);
        }
    }

    /**
     * Handle Level 1 → 2 upgrade
     */
    private function processLevelOneUpgrade(User $user, &$upgradedUsers)
    {
        $count = Referral::where('referrer_id', $user->id)
            ->whereHas('referredUser.payments', function ($p) {
                $p->where('status', 'paid')->where('amount', 20000);
            })
            ->count();

        if ($count >= 4) {
            $this->upgradeUser($user, $upgradedUsers);
        }
    }

    /**
     * Handle Level 2+ upgrades using LevelUpTrigger
     */
    private function processHigherLevelUpgrade(User $user, &$upgradedUsers)
    {
        $currentLevel = $user->level;

        // Find 4 users who recently reached this level but not yet used as triggers
        $triggerUsers = User::where('level', $currentLevel)
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', LevelUpTrigger::where('user_id', $user->id)
                ->where('level', $currentLevel)->pluck('triggered_by'))
            ->take(4)
            ->get();

        if ($triggerUsers->count() == 4) {
            // Save triggers
            foreach ($triggerUsers as $triggerUser) {
                LevelUpTrigger::create([
                    'user_id'      => $user->id,
                    'triggered_by' => $triggerUser->id,
                    'level'        => $currentLevel,
                ]);
            }

            $this->upgradeUser($user, $upgradedUsers);
        }
    }

    /**
     * Upgrade a user, add wallet earnings, save history
     */
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
            9 => 20000000,
        ];

        $earnings = $earningsPerLevel[$currentLevel] ?? 0;

        try {
            DB::beginTransaction();

            // Update wallet
            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
            $wallet->earned_balance += $earnings;
            $wallet->save();

            // Upgrade user
            $user->update([
                'level' => $nextLevel,
                'upgraded_at' => now(),
            ]);

            // Record level history
            LevelHistory::create([
                'user_id' => $user->id,
                'from_level' => $currentLevel,
                'to_level' => $nextLevel,
                'upgraded_at' => now(),
            ]);

            // Record earning
            Earning::create([
                'user_id' => $user->id,
                'amount' => $earnings,
                'type' => 'level_upgrade',
                'description' => "Level upgrade earnings from Level {$currentLevel} to Level {$nextLevel}",
                'earned_at' => now(),
            ]);

            DB::commit();

            $message = "User {$user->name} (ID {$user->id}) upgraded from Level {$currentLevel} → {$nextLevel}, earned ₦{$earnings}";
            Log::info($message);
            $this->info($message);

            $upgradedUsers[] = [
                'name' => $user->name,
                'id' => $user->id,
                'new_level' => $nextLevel,
                'earnings' => $earnings,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error upgrading user {$user->id}: " . $e->getMessage());
            $this->error("Failed to upgrade user {$user->id}");
        }
    }
}
