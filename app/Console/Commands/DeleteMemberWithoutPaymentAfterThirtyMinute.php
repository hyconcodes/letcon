<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
class DeleteMemberWithoutPaymentAfterThirtyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'letcon:delete-member';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users who have not paid 20,000 within 1 hour of signup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log start of command execution
        Log::info('Starting deletion of unpaid members');

        // Calculate the timestamp for 1 hour ago
        $oneHourAgo = Carbon::now()->subHour();
        Log::info('Checking users registered before: ' . $oneHourAgo);

        // Get users who registered more than 1 hour ago
        $users = User::where('created_at', '<=', $oneHourAgo)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'member');
                Log::debug('Filtering users with member role');
            })
            ->whereDoesntHave('payments', function ($query) {
                $query->where('amount', '>=', 20000)
                    ->where('status', 'paid');
                Log::debug('Filtering users without valid payments');
            })
            ->get();

        Log::info('Found ' . count($users) . ' users to delete');

        // Track deletion statistics
        $deletedCount = 0;
        $failedCount = 0;

        foreach ($users as $user) {
            try {
                // Log user details before deletion
                Log::info('Attempting to delete user', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'registration_date' => $user->created_at
                ]);

                // Delete the user
                $userId = $user->id;
                $user->delete();
                
                $deletedCount++;
                $this->info("Deleted user: {$userId} ({$user->name})");
                
                Log::info("Successfully deleted user: {$userId} ({$user->name})");
            } catch (\Exception $e) {
                $failedCount++;
                Log::error('Failed to delete user: ' . $userId, [
                    'error' => $e->getMessage()
                ]);
                $this->error("Failed to delete user {$userId}: " . $e->getMessage());
            }
        }

        // Log final statistics
        $summary = "Operation completed. Deleted: {$deletedCount}, Failed: {$failedCount}";
        Log::info($summary);
        $this->info($summary);
    }
}
