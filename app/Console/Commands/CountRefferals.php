<?php

namespace App\Console\Commands;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Console\Command;

class CountRefferals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count Refferals';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', 'olalekanpaul20@gmail.com')->first();
        $refferals = Referral::where('referrer_id', $user->id)->count();
        $this->info('User ' . $user->name . ' has ' . $refferals . ' refferals');
    }
}
