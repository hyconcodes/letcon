<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class verifyAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Make API request to Paystack to get bank list
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Accept' => 'application/json',
            ])->get('https://api.paystack.co/bank');

            // Check if request was successful
            if ($response->successful()) {
                // Display the bank data
                $bankData = $response->json('data');
                $this->info('Successfully retrieved bank list:');
                $this->table(['Bank Name', 'Code'], 
                    collect($bankData)->map(fn($bank) => [
                        $bank['name'] ?? 'N/A',
                        $bank['code'] ?? 'N/A'
                    ])->toArray()
                );
            } else {
                $this->error('Failed to fetch bank list: ' . $response->status());
            }

        } catch (\Exception $e) {
            $this->error('Error occurred: ' . $e->getMessage());
        }
    }
}
