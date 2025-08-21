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

class LetconUpgrade extends Command
{
    protected $signature = 'letcon:upgrade';
    protected $description = 'Check referral payments and upgrade users automatically using strict GP pyramid rules with registration order priority for Level 3+';

    public function handle()
    {
        Log::info("==== Letcon Cron Started ====");
        $this->info("==== Letcon Cron Started ====");

        // Process Level 1 → 2 upgrades first (no registration order priority needed)
        $this->processLevel1Users();

        // Process Level 2 → 3 and above upgrades (with registration order priority)
        $this->processHigherLevelUsers();

        Log::info("==== Letcon Cron Completed ====");
        $this->info("==== Letcon Cron Completed ====");
    }

    private function processLevel1Users()
    {
        $level1Users = User::where('level', 1)->get();
        $upgradedUsers = [];

        foreach ($level1Users as $user) {
            $this->processLevel1User($user, $upgradedUsers);
        }

        if (!empty($upgradedUsers)) {
            $summary = "=== Level 1 → 2 Upgrades ===\n";
            foreach ($upgradedUsers as $upgrade) {
                $summary .= "User: {$upgrade['name']} (ID: {$upgrade['id']}) - ";
                $summary .= "Upgraded to Level {$upgrade['new_level']}, Earned ₦{$upgrade['earnings']}\n";
            }
            Log::info($summary);
            $this->info($summary);
        } else {
            Log::info("No Level 1 → 2 upgrades this run.");
            $this->info("No Level 1 → 2 upgrades this run.");
        }
    }

    private function processHigherLevelUsers()
    {
        // 🚨 KEY: For Level 2 → 3 and above, process users by when they arrived at their current level
        // This ensures that users who reached their current level first get upgrade priority
        $higherLevelUsers = User::join('level_history', function ($join) {
                $join->on('users.id', '=', 'level_history.user_id')
                     ->whereColumn('level_history.to_level', 'users.level');
            })
            ->whereBetween('users.level', [2, 9])
            ->orderBy('level_history.upgraded_at', 'ASC') // Level arrival time priority
            ->select('users.*', 'level_history.upgraded_at as current_level_arrival')
            ->get();

        $upgradedUsers = [];

        foreach ($higherLevelUsers as $user) {
            $this->processHigherLevelUser($user, $upgradedUsers);
        }

        if (!empty($upgradedUsers)) {
            $summary = "=== Higher Level Upgrades (Level Arrival Order Priority) ===\n";
            foreach ($upgradedUsers as $upgrade) {
                $summary .= "User: {$upgrade['name']} (ID: {$upgrade['id']}) - ";
                $summary .= "Arrived at Level {$upgrade['old_level']}: {$upgrade['level_arrival']} - ";
                $summary .= "Level {$upgrade['old_level']} → {$upgrade['new_level']}, Earned ₦{$upgrade['earnings']}\n";
            }
            Log::info($summary);
            $this->info($summary);
        } else {
            Log::info("No higher level upgrades this run.");
            $this->info("No higher level upgrades this run.");
        }
    }

    private function processLevel1User(User $user, array &$upgradedUsers)
    {
        // STRICT rule: must have 4 direct referrals who paid ₦20,000
        $count = $this->countPaidReferrals($user->id);
        if ($count >= 4) {
            $this->upgradeUser($user, $upgradedUsers, []); // no supporters recorded for L1→L2
        }
    }

    private function processHigherLevelUser(User $user, array &$upgradedUsers)
    {
        $currentLevel = (int) $user->level;
        
        // For levels >= 2, user needs the FIRST 4 *new* supporters who ARRIVED at this same level
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

    private function getArrivalAtLevel(User $user, int $level): ?string
    {
        return LevelHistory::where('user_id', $user->id)
            ->where('to_level', $level)
            ->value('upgraded_at');
    }

    private function getNewSupporters(User $user, int $currentLevel)
    {
        $arrival = $this->getArrivalAtLevel($user, $currentLevel);
        if (!$arrival) {
            return collect();
        }

        // Supporters already linked to this user at this level
        $alreadySavedIds = LevelSupporter::where('user_id', $user->id)
            ->where('level', $currentLevel)
            ->pluck('supporter_id')
            ->toArray();

        // 🚨 Supporters who already supported ANYONE at this level (global uniqueness)
        $alreadyUsedGlobally = LevelSupporter::where('level', $currentLevel)
            ->pluck('supporter_id')
            ->toArray();

        // Get supporters ordered by when they arrived at this level (earliest arrival first)
        // This ensures supporters who reached the level first become supporters first
        return User::join('level_history', function ($join) use ($currentLevel) {
            $join->on('users.id', '=', 'level_history.user_id')
                ->where('level_history.to_level', '=', $currentLevel);
        })
            ->where('users.level', $currentLevel)
            ->where('users.id', '!=', $user->id)
            ->whereNotIn('users.id', $alreadySavedIds)
            ->whereNotIn('users.id', $alreadyUsedGlobally) // prevents reuse across users
            ->where('level_history.upgraded_at', '>=', $arrival)
            ->orderBy('level_history.upgraded_at', 'asc') // 🚨 ORDER BY LEVEL ARRIVAL TIME
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

            // Record level history
            LevelHistory::create([
                'user_id'     => $user->id,
                'from_level'  => $currentLevel,
                'to_level'    => $nextLevel,
                'upgraded_at' => now(),
            ]);

            // Record earning transaction
            Earning::create([
                'user_id'     => $user->id,
                'amount'      => $earnings,
                'type'        => 'level_upgrade',
                'description' => "Level upgrade earnings from Level {$currentLevel} to Level {$nextLevel}",
                'earned_at'   => now(),
            ]);

            // Save supporters (with uniqueness check)
            foreach ($supporters as $supporter) {
                $exists = LevelSupporter::where('supporter_id', $supporter->id)
                    ->where('level', $currentLevel)
                    ->exists();

                if (!$exists) {
                    LevelSupporter::create([
                        'user_id'      => $user->id,
                        'supporter_id' => $supporter->id,
                        'level'        => $currentLevel,
                    ]);
                }
            }

            DB::commit();

            $message = "User {$user->name} (ID {$user->id}) upgraded from Level {$currentLevel} to Level {$nextLevel}, earned ₦{$earnings}";
            
            // Add special logging for Level 3+ upgrades to highlight level arrival priority
            if ($nextLevel >= 3) {
                $levelArrival = $user->current_level_arrival ?? 'Unknown';
                $priorityMessage = "🚨 PRIORITY UPGRADE: User {$user->id} selected for Level {$nextLevel} based on level arrival time: {$levelArrival}";
                Log::info($priorityMessage);
                $this->info($priorityMessage);
            }
            
            $this->info($message);
            Log::info($message);

            $upgradedUsers[] = [
                'name'          => $user->name,
                'id'            => $user->id,
                'level_arrival' => isset($user->current_level_arrival) ? 
                                   \Carbon\Carbon::parse($user->current_level_arrival)->format('Y-m-d H:i:s') : 
                                   'Unknown',
                'old_level'     => $currentLevel,
                'new_level'     => $nextLevel,
                'earnings'      => $earnings,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error upgrading user {$user->id}: " . $e->getMessage());
            $this->error("Failed to upgrade user {$user->id}");
        }
    }
}