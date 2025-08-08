<?php

use Livewire\Volt\Component;

new class extends Component {
    public function depositPaystack()
    {
        try {
            // Check if user has already made one-time payment
            $existingPayment = App\Models\Payment::where('user_id', auth()->id())
                ->where('status', 'paid')
                ->first();

            if ($existingPayment) {
                session()->flash('error', 'You have already made the one-time payment.');
                return redirect()->back();
            }

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

            // Log the error for failed initialization
            \Log::error('Paystack payment initialization failed: Payment could not be initialized', [
                'user_id' => auth()->id(),
                'reference' => $reference,
                'response' => $result
            ]);
            
            session()->flash('error', 'We encountered an issue processing your payment. Our team has been notified. Please try again in a few minutes.');
            return redirect()->back();

        } catch (\Exception $e) {
            // Log detailed error information
            \Log::error('Paystack payment initialization failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'reference' => $reference ?? null
            ]);
            
            session()->flash('error', 'We\'re currently experiencing technical difficulties with our payment system. Please try again later or contact support if the issue persists.');
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
        <div class="bg-red-500 text-white p-4 rounded-md mb-4 flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4 flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
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
