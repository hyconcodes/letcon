<?php

namespace App\Console\Commands;

use App\Models\LevelHistory;
use App\Models\Referral;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Earning;
use App\Models\LevelSupporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Level extends Command
{
    protected $signature = 'level';
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

    private function processUser(User $user, array &$upgradedUsers)
    {
        $currentLevel = (int) $user->level;
        if ($currentLevel >= 10) {
            return;
        }

        if ($currentLevel === 1) {
            // STRICT rule: must have 4 direct referrals who paid ₦20,000
            $count = $this->countPaidReferrals($user->id);
            if ($count >= 4) {
                $this->upgradeUser($user, $upgradedUsers, []); // no supporters recorded for L1→L2
            }
            return;
        }

        // For levels >= 2, user needs the FIRST 4 *new* supporters who ARRIVED at this same level
        // AFTER (or at the time) the user entered this level (i.e., "met him in this level").
        $supporters = $this->getNewSupporters($user, $currentLevel);

        if ($supporters->count() >= 4) {
            $this->upgradeUser($user, $upgradedUsers, $supporters->take(4));
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
     * Get the timestamp when this user entered a given level.
     */
    private function getArrivalAtLevel(User $user, int $level): ?string
    {
        return LevelHistory::where('user_id', $user->id)
            ->where('to_level', $level)
            ->value('upgraded_at'); // string|datetime|null
    }

    /**
     * Find the FIRST 4 *new* supporters:
     *  - Users whose current level == $currentLevel
     *  - Who arrived (level_history.to_level == $currentLevel) at or after the time THIS user arrived
     *  - Not the user himself
     *  - Not already recorded as supporters for this user at this level (defensive)
     *  - Ordered by their arrival time ASC (the first four to meet him there)
     */
    private function getNewSupporters(User $user, int $currentLevel)
    {
        $arrival = $this->getArrivalAtLevel($user, $currentLevel);
        if (!$arrival) {
            // If we can’t determine when the user entered this level, don’t auto-upgrade.
            return collect();
        }

        // Exclude any already-saved supporters for this user at this level (defensive)
        $alreadySavedIds = LevelSupporter::where('user_id', $user->id)
            ->where('level', $currentLevel) // we store pre-upgrade level
            ->pluck('supporter_id')
            ->toArray();

        // Pick from ANY users (not restricted to direct referrals)
        // who are at the same level and arrived after/at this user's arrival.
        return User::join('level_history', function ($join) use ($currentLevel) {
                $join->on('users.id', '=', 'level_history.user_id')
                     ->where('level_history.to_level', '=', $currentLevel);
            })
            ->where('users.level', $currentLevel)
            ->where('users.id', '!=', $user->id)
            ->when(!empty($alreadySavedIds), function ($q) use ($alreadySavedIds) {
                $q->whereNotIn('users.id', $alreadySavedIds);
            })
            ->where('level_history.upgraded_at', '>=', $arrival)
            ->orderBy('level_history.upgraded_at', 'asc')
            ->select('users.*', 'level_history.upgraded_at as arrived_at_level')
            ->limit(4 - count($alreadySavedIds))
            ->get();
    }

    private function upgradeUser(User $user, array &$upgradedUsers, $supporters = [])
    {
        $currentLevel = (int) $user->level;
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

            // Update wallet balance
            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
            $wallet->earned_balance = ($wallet->earned_balance ?? 0) + $earnings;
            $wallet->save();

            // Update user level
            $user->level = $nextLevel;
            $user->save();

            // Record in level history (preserve your from/to structure)
            LevelHistory::create([
                'user_id'     => $user->id,
                'from_level'  => $currentLevel,
                'to_level'    => $nextLevel,
                'upgraded_at' => now(),
            ]);

            // Record the earning transaction (preserve your fields)
            Earning::create([
                'user_id'     => $user->id,
                'amount'      => $earnings,
                'type'        => 'level_upgrade',
                'description' => "Level upgrade earnings from Level {$currentLevel} to Level {$nextLevel}",
                'earned_at'   => now(),
            ]);

            // 🚨 Save the supporters who enabled this upgrade
            // Store the PRE-UPGRADE level (the level they and the user were on)
            foreach ($supporters as $supporter) {
                // Avoid duplicates (defensive)
                $exists = LevelSupporter::where('user_id', $user->id)
                    ->where('supporter_id', $supporter->id)
                    ->where('level', $currentLevel)
                    ->exists();

                if (!$exists) {
                    LevelSupporter::create([
                        'user_id'      => $user->id,
                        'supporter_id' => $supporter->id,
                        'level'        => $currentLevel, // 👈 pre-upgrade level
                    ]);
                }
            }

            DB::commit();

            $message = "User {$user->name} (ID {$user->id}) upgraded from Level {$currentLevel} to Level {$nextLevel}, earned ₦{$earnings}";
            $this->info($message);
            Log::info($message);

            $upgradedUsers[] = [
                'name'       => $user->name,
                'id'         => $user->id,
                'new_level'  => $nextLevel,
                'earnings'   => $earnings,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error upgrading user {$user->id}: " . $e->getMessage());
            $this->error("Failed to upgrade user {$user->id}");
        }
    }
}
