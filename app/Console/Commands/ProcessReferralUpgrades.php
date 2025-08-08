<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Referral;
use App\Models\User;
use App\Models\Wallet;
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
    protected $signature = 'letcon:process-upgrades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check referral payments and upgrade users automatically';

    /**
     * Execute the console command.
     */

    // Required referrals per level
    protected $levelRequirements = [
        1 => 4,
        2 => 16,
        3 => 64,
        4 => 256,
        5 => 1024,
        6 => 4096,
        7 => 16384,
        8 => 65536,
        9 => null // Level 10 is final
    ];

    // Earnings per level (after deduction)
    protected $earningsPerLevel = [
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

    public function handle()
    {
        Log::info("==== Letcon Cron Started ====");
        $this->info("==== Letcon Cron Started ====");

        // Get all users who are not level 10 yet
        $users = User::where('level', '<', 10)->get();

        foreach ($users as $user) {
            $this->processUser($user);
        }

        Log::info("==== Letcon Cron Completed ====");
        $this->info("==== Letcon Cron Completed ====");
    }

    private function processUser(User $user)
    {
        $currentLevel = $user->level;

        // If already at max level
        if ($currentLevel >= 10) {
            return;
        }

        $requiredCount = $this->levelRequirements[$currentLevel] ?? null;
        if (!$requiredCount) {
            return;
        }

        // Count qualified referrals at required depth
        $count = $this->countQualifiedReferrals($user->id, $currentLevel);

        $this->info("User {$user->id} (Level {$currentLevel}) has {$count} qualified referrals, needs {$requiredCount}");
        Log::info("User {$user->id} (Level {$currentLevel}) has {$count} qualified referrals, needs {$requiredCount}");

        if ($count >= $requiredCount) {
            $this->upgradeUser($user);
        }
    }

    private function countQualifiedReferrals($userId, $level)
    {
        // Depth needed = current level’s required count formula
        $depth = $level; // Level 1 = depth 1, Level 2 = depth 2, etc.

        $visited = [];
        $queue = [ ['id' => $userId, 'depth' => 0] ];
        $qualified = 0;

        while (!empty($queue)) {
            $current = array_shift($queue);
            $currentId = $current['id'];
            $currentDepth = $current['depth'];

            if ($currentDepth >= $depth) {
                continue;
            }

            $referrals = Referral::where('referrer_id', $currentId)
                ->with('referredUser')
                ->get();

            foreach ($referrals as $ref) {
                $refUser = $ref->referredUser;
                if (!$refUser) continue;

                // Level 1 check payments, others only check existence
                if ($level == 1) {
                    $hasPaid = Payment::where('user_id', $refUser->id)
                        ->where('status', 'paid')
                        ->where('amount', 20000)
                        ->exists();
                    if (!$hasPaid) {
                        continue;
                    }
                }

                $qualified++;
                $queue[] = ['id' => $refUser->id, 'depth' => $currentDepth + 1];
            }
        }

        return $qualified;
    }

    private function upgradeUser(User $user)
    {
        $currentLevel = $user->level;
        $nextLevel = $currentLevel + 1;

        // Earnings after deduction
        $earnings = $this->earningsPerLevel[$currentLevel] ?? 0;

        // Update wallet
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
        $wallet->earned_balance += $earnings;
        $wallet->save();

        // Upgrade user
        $user->level = $nextLevel;
        $user->upgraded_at = now();
        $user->save();

        $this->info("User {$user->name}: with ID: {$user->id} upgraded from Level {$currentLevel} to Level {$nextLevel}, earned ₦{$earnings}");
        Log::info("User {$user->name}: with ID: {$user->id} upgraded from Level {$currentLevel} to Level {$nextLevel}, earned ₦{$earnings}");
    }
}
