<?php

use Livewire\Volt\Component;

new class extends Component {
    public function depositPaystack()
    {
        try {
            $client = new \GuzzleHttp\Client();
            
            // Generate unique reference
            $reference = 'PAY_'.time().'_'.auth()->id();
            
            $response = $client->post(env('PAYSTACK_PAYMENT_URL') . '/transaction/initialize', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'amount' => 20000 * 100, // Fixed amount of 20000 converted to kobo
                    'email' => auth()->user()->email,
                    'reference' => $reference,
                    'callback_url' => route('paystack.callback'),
                    'metadata' => [
                        'user_id' => auth()->id()
                    ]
                ]
            ]);

            $result = json_decode($response->getBody());

            if ($result->status) {
                // Store transaction reference
                session(['paystack_reference' => $reference]);
                
                // Redirect to Paystack payment page
                return redirect($result->data->authorization_url);
            }

            throw new \Exception('Could not initialize Paystack payment');

        } catch (\Exception $e) {
            session()->flash('error', 'Payment initialization failed: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function depositWema()
    {
        // Handle Wema bank deposit logic
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4 py-6">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-accent-content mb-4">Deposit Funds</h1>
        <p class="text-xl text-amber-200">Choose your preferred payment method below</p>
    </div>

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-4 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Paystack Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-center mb-4">
                <img src="https://website-v3-assets.s3.amazonaws.com/assets/img/hero/Paystack-mark-white-twitter.png" 
                     alt="Paystack Logo" 
                     class="h-24 rounded-lg">
            </div>
            <h2 class="text-2xl font-bold text-center mb-4 text-accent-content">Instant Deposit with Paystack</h2>
            <p class="text-zinc-600 mb-6 text-center">
                Make instant deposits securely using Paystack payment gateway
            </p>
            <div class="flex justify-center">
                <button wire:click="depositPaystack" 
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full">
                    Deposit Now
                </button>
                 {{-- <a href="{{ route('deposits.paystack') }}" 
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full">
                    Deposit Now
                </a> --}}
            </div>
        </div>
    <!-- Wema Bank Card -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-center mb-4">
            <img src="https://tse1.mm.bing.net/th/id/OIP.25RAYaTjaAa5Yq9KzPYbNwHaFk?rs=1&pid=ImgDetMain&o=7&rm=3" 
                 alt="Wema Bank Logo" 
                 class="h-24 rounded-lg">
        </div>
        <h2 class="text-2xl font-bold text-center mb-4 text-accent-content">Deposit with Wema Bank</h2>
        <p class="text-zinc-600 mb-6 text-center">
            Make direct bank transfers to your Wema Bank account
        </p>
        <div class="flex justify-center">
            <button wire:click="depositWema"
                    class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-6 rounded-full">
                Get Account Details
            </button>
        </div>
    </div>
</div>
