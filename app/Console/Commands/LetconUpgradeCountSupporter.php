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

class LetconUpgradeCountSupporter extends Command
{
    protected $signature = 'letcon:upgrade_count_supporter';
    protected $description = 'Check referral payments and upgrade users automatically using strict GP pyramid rules with incremental supporter storage';

    public function handle()
    {
        Log::info("==== Letcon Cron Started ====");
        $this->info("==== Letcon Cron Started ====");

        // Process Level 1 → 2 upgrades first
        $this->processLevel1Users();

        // Process Level 2+ users for both supporter assignment AND upgrades
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
        // Process users by when they arrived at their current level
        $higherLevelUsers = User::join('level_history', function ($join) {
                $join->on('users.id', '=', 'level_history.user_id')
                     ->whereColumn('level_history.to_level', 'users.level');
            })
            ->whereBetween('users.level', [2, 9])
            ->orderBy('level_history.upgraded_at', 'ASC') // Level arrival time priority
            ->select('users.*', 'level_history.upgraded_at as current_level_arrival')
            ->get();

        $upgradedUsers = [];
        $supporterAssignments = [];

        foreach ($higherLevelUsers as $user) {
            // First, assign any new supporters to this user
            $newSupportersAssigned = $this->assignNewSupporters($user);
            if ($newSupportersAssigned > 0) {
                $supporterAssignments[] = [
                    'user' => $user->name,
                    'user_id' => $user->id,
                    'new_supporters' => $newSupportersAssigned,
                    'total_supporters' => $this->getTotalSupporters($user)
                ];
            }

            // Then, check if user can be upgraded
            $this->processHigherLevelUser($user, $upgradedUsers);
        }

        // Log supporter assignments
        if (!empty($supporterAssignments)) {
            $supporterSummary = "=== New Supporter Assignments ===\n";
            foreach ($supporterAssignments as $assignment) {
                $supporterSummary .= "User: {$assignment['user']} (ID: {$assignment['user_id']}) - ";
                $supporterSummary .= "Got {$assignment['new_supporters']} new supporters (Total: {$assignment['total_supporters']}/4)\n";
            }
            Log::info($supporterSummary);
            $this->info($supporterSummary);
        }

        // Log upgrades
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
        
        // Check if user already has 4 supporters and can upgrade
        $totalSupporters = $this->getTotalSupporters($user);
        if ($totalSupporters >= 4) {
            // Get all supporters for this user at this level
            $supporters = LevelSupporter::where('user_id', $user->id)
                ->where('level', $currentLevel)
                ->with('supporter')
                ->get()
                ->pluck('supporter');

            $this->upgradeUser($user, $upgradedUsers, $supporters);
        }
    }

    /**
     * Assign new supporters to a user as they become available
     * Returns the number of new supporters assigned
     */
    private function assignNewSupporters(User $user): int
    {
        $currentLevel = (int) $user->level;
        $arrival = $this->getArrivalAtLevel($user, $currentLevel);
        
        if (!$arrival) {
            return 0;
        }

        // Get current supporter count
        $currentSupporterCount = $this->getTotalSupporters($user);
        
        // If user already has 4 supporters, no need to assign more
        if ($currentSupporterCount >= 4) {
            return 0;
        }

        // Get new available supporters
        $newSupporters = $this->getAvailableSupporters($user, $currentLevel, $arrival);
        $newSupportersAssigned = 0;

        DB::beginTransaction();
        try {
            foreach ($newSupporters as $supporter) {
                // Double-check this supporter hasn't been assigned while we're processing
                $alreadyUsed = LevelSupporter::where('supporter_id', $supporter->id)
                    ->where('level', $currentLevel)
                    ->exists();

                if (!$alreadyUsed && $currentSupporterCount < 4) {
                    LevelSupporter::create([
                        'user_id'      => $user->id,
                        'supporter_id' => $supporter->id,
                        'level'        => $currentLevel,
                        'assigned_at'  => now(), // Track when supporter was assigned
                    ]);
                    
                    $currentSupporterCount++;
                    $newSupportersAssigned++;
                    
                    Log::info("Supporter assigned: User {$supporter->id} now supports User {$user->id} at Level {$currentLevel} ({$currentSupporterCount}/4)");
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error assigning supporters to user {$user->id}: " . $e->getMessage());
        }

        return $newSupportersAssigned;
    }

    /**
     * Get total supporters already assigned to this user at their current level
     */
    private function getTotalSupporters(User $user): int
    {
        return LevelSupporter::where('user_id', $user->id)
            ->where('level', $user->level)
            ->count();
    }

    /**
     * Get available supporters who can be assigned to this user
     */
    private function getAvailableSupporters(User $user, int $currentLevel, string $arrival)
    {
        // Supporters already linked to this user at this level
        $alreadySavedIds = LevelSupporter::where('user_id', $user->id)
            ->where('level', $currentLevel)
            ->pluck('supporter_id')
            ->toArray();

        // Supporters who already supported ANYONE at this level (global uniqueness)
        $alreadyUsedGlobally = LevelSupporter::where('level', $currentLevel)
            ->pluck('supporter_id')
            ->toArray();

        // Get available supporters ordered by when they arrived at this level
        return User::join('level_history', function ($join) use ($currentLevel) {
            $join->on('users.id', '=', 'level_history.user_id')
                ->where('level_history.to_level', '=', $currentLevel);
        })
            ->where('users.level', $currentLevel)
            ->where('users.id', '!=', $user->id)
            ->whereNotIn('users.id', array_merge($alreadySavedIds, $alreadyUsedGlobally))
            ->where('level_history.upgraded_at', '>=', $arrival)
            ->orderBy('level_history.upgraded_at', 'asc')
            ->select('users.*', 'level_history.upgraded_at as arrived_at_level')
            ->take(4 - count($alreadySavedIds)) // Only get what we need
            ->get();
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

            // Note: Supporters are already stored incrementally, no need to store them again here

            DB::commit();

            $message = "User {$user->name} (ID {$user->id}) upgraded from Level {$currentLevel} to Level {$nextLevel}, earned ₦{$earnings}";
            
            // Add special logging for Level 3+ upgrades
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