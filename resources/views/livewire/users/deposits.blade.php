<?php

use Livewire\Volt\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

new class extends Component {
    public $showWemaModal = false;

    public function showWemaDetails()
    {
        $this->showWemaModal = true;
    }

    public function hideWemaDetails() 
    {
        $this->showWemaModal = false;
    }

    public function depositPaystack()
    {
        session()->flash('error', 'Paystack payment is not available at the moment. Please try other method.');
        return redirect()->back();
        // try {
        //     // Check if user has already made one-time payment
        //     $existingPayment = App\Models\Payment::where('user_id', auth()->id())
        //         ->where('status', 'paid')
        //         ->first();

        //     if ($existingPayment) {
        //         session()->flash('error', 'You have already made the one-time payment.');
        //         return redirect()->back();
        //     }

        //     $client = new \GuzzleHttp\Client();

        //     // Generate unique reference
        //     $reference = 'PAY_' . time() . '_' . auth()->id();

        //     $response = $client->post(env('PAYSTACK_PAYMENT_URL') . '/transaction/initialize', [
        //         'headers' => [
        //             'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
        //             'Content-Type' => 'application/json',
        //         ],
        //         'json' => [
        //             'amount' => 20000 * 100, // Fixed amount of 20000 converted to kobo
        //             'email' => auth()->user()->email,
        //             'reference' => $reference,
        //             'callback_url' => route('paystack.callback'),
        //             'metadata' => [
        //                 'user_id' => auth()->id(),
        //             ],
        //         ],
        //     ]);

        //     $result = json_decode($response->getBody());

        //     if ($result->status) {
        //         // Store transaction reference
        //         session(['paystack_reference' => $reference]);

        //         // Redirect to Paystack payment page
        //         return redirect($result->data->authorization_url);
        //     }

        //     // Log the error for failed initialization
        //     \Log::error('Paystack payment initialization failed: Payment could not be initialized', [
        //         'user_id' => auth()->id(),
        //         'reference' => $reference,
        //         'response' => $result,
        //     ]);

        //     session()->flash('error', 'We encountered an issue processing your payment. Our team has been notified. Please try again in a few minutes.');
        //     return redirect()->back();
        // } catch (\Exception $e) {
        //     // Log detailed error information
        //     \Log::error('Paystack payment initialization failed: ' . $e->getMessage(), [
        //         'user_id' => auth()->id(),
        //         'error' => $e->getMessage(),
        //         'trace' => $e->getTraceAsString(),
        //         'reference' => $reference ?? null,
        //     ]);

        //     session()->flash('error', 'We\'re currently experiencing technical difficulties with our payment system. Please try again later or contact support if the issue persists.');
        //     return redirect()->back();
        // }
    }

    public function depositOpay()
    {
        session()->flash('error', 'OPay payment is not available at the moment. Please try other method.');
        return redirect()->back();
        // try {
        //     // Check if user has already made one-time payment
        //     $existingPayment = App\Models\Payment::where('user_id', auth()->id())
        //         ->where('status', 'paid')
        //         ->first();

        //     if ($existingPayment) {
        //         session()->flash('error', 'You have already made the one-time payment.');
        //         return redirect()->back();
        //     }

        //     $reference = Str::uuid()->toString();

        //     $data = [
        //         'country' => 'NG',
        //         'reference' => $reference,
        //         'amount' => [
        //             'total' => 20000 * 100,
        //             'currency' => 'NGN',
        //         ],
        //         'returnUrl' => route('wallets'),
        //         'callbackUrl' => route('opay.callback'),
        //         // 'cancelUrl' => route('opay.cancel'),
        //         'evokeOpay' => true,
        //         'customerVisitSource' => 'WEB',
        //         'expireAt' => 30,
        //         'userInfo' => [
        //             'userEmail' => auth()->user()->email,
        //             'userId' => auth()->id(),
        //             'userMobile' => auth()->user()->phone ?? '',
        //             'userName' => auth()->user()->name,
        //         ],
        //         'product' => [
        //             'name' => 'Level 1 Contribution',
        //             'description' => 'Letcon one-time deposit payment',
        //         ],
        //         // 'payMethod' => 'BankCard',
        //     ];

        //     $response = Http::withHeaders([
        //         'Content-Type' => 'application/json',
        //         'Authorization' => 'Bearer ' . env('OPAY_PUBLIC_KEY'),
        //         'MerchantId' => env('OPAY_MERCHANT_ID'),
        //     ])->post('https://testapi.opaycheckout.com/api/v1/international/cashier/create', $data);

        //     $result = $response->json();

        //     if ($response->successful() && isset($result['data']['cashierUrl'])) {
        //         // Store transaction reference
        //         session(['opay_reference' => $reference]);

        //         // Redirect to OPay checkout page
        //         return redirect()->away($result['data']['cashierUrl']);
        //     }

        //     // If cashierUrl is missing, log an error
        //     \Log::error('OPay payment initialization failed', [
        //         'user_id' => auth()->id(),
        //         'reference' => $reference,
        //         'response' => $result,
        //     ]);

        //     session()->flash('error', 'We encountered an issue processing your payment. Please try again.');
        //     return redirect()->back();
        // } catch (\Exception $e) {
        //     // Log detailed error information
        //     \Log::error('OPay payment initialization failed: ' . $e->getMessage(), [
        //         'user_id' => auth()->id(),
        //         'error' => $e->getMessage(),
        //         'trace' => $e->getTraceAsString(),
        //         'reference' => $reference ?? null,
        //     ]);

        //     session()->flash('error', 'We\'re currently experiencing technical difficulties with our payment system. Please try again later.');
        //     return redirect()->back();
        // }
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4 flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Wema Bank Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-center mb-4">
                <img src="https://tse1.mm.bing.net/th/id/OIP.25RAYaTjaAa5Yq9KzPYbNwHaFk?r=0&cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3"
                    alt="Wema Bank Logo" class="h-24 rounded-lg">
            </div>
            <h2 class="text-2xl font-bold text-center mb-4 text-accent-content">Bank Transfer via Wema Bank</h2>
            <p class="text-zinc-600 mb-6 text-center">
                Make direct bank transfer to our Wema Bank account
            </p>
            <div class="flex justify-center">
                <button wire:click="showWemaDetails"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full">
                    View Account Details
                </button>
            </div>
        </div>

        <!-- Paystack Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-center mb-4">
                <img src="https://website-v3-assets.s3.amazonaws.com/assets/img/hero/Paystack-mark-white-twitter.png"
                    alt="Paystack Logo" class="h-24 rounded-lg">
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
            </div>
        </div>

        <!-- OPay Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-center mb-4">
                <img src="https://tse3.mm.bing.net/th/id/OIP.sotJOgk9mHTGGw-c8Tc08QHaHC?rs=1&pid=ImgDetMain&o=7&rm=3"
                    alt="OPay Logo" class="h-24 rounded-lg">
            </div>
            <h2 class="text-2xl font-bold text-center mb-4 text-accent-content">Deposit with OPay</h2>
            <p class="text-zinc-600 mb-6 text-center">
                Make instant deposits using your OPay wallet
            </p>
            <div class="flex justify-center">
                <button wire:click="depositOpay"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full">
                    Pay with OPay
                </button>
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating Icon -->
    <a href="https://wa.me/2349072236347" target="_blank" 
        class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-colors">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.4 3.6C18.2 1.4 15.2 0 12 0 5.4 0 0 5.4 0 12c0 2.1.6 4.2 1.6 6L0 24l6.2-1.6c1.8.9 3.8 1.4 5.8 1.4 6.6 0 12-5.4 12-12 0-3.2-1.4-6.2-3.6-8.4zM12 22c-1.8 0-3.6-.5-5.2-1.4l-.4-.2-3.8 1 1-3.8-.2-.4C2.5 15.6 2 13.8 2 12 2 6.5 6.5 2 12 2c2.6 0 5 1 6.8 2.8C20.6 6.6 21.6 9 21.6 12c0 5.5-4.5 10-9.6 10zm5.2-7.4c-.3-.1-1.8-.9-2.1-1-.3-.1-.5-.1-.7.1-.2.2-.8.9-1 1.1-.2.2-.4.2-.7.1-.3-.1-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.4.1-.1.2-.3.3-.5.1-.2 0-.4 0-.5 0-.1-.7-1.7-1-2.3-.3-.6-.6-.5-.8-.5-.2 0-.4 0-.6 0-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1 2.8 1.2 3c.2.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4 0-.1-.2-.2-.5-.3z"/>
        </svg>
    </a>

    <!-- Wema Bank Details Modal -->
    @if($showWemaModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-80 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg max-w-md w-full">
            <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Wema Bank Account Details</h3>
            <div class="space-y-4">
                <div>
                    <p class="font-semibold text-gray-700 dark:text-gray-300">Account Number:</p>
                    <p class="text-xl text-blue-600 dark:text-blue-400">0126924655</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-700 dark:text-gray-300">Account Name:</p>
                    <p class="text-xl text-blue-600 dark:text-blue-400">Letcon Global Company Ltd.</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-700 dark:text-gray-300">Bank:</p>
                    <p class="text-xl text-blue-600 dark:text-blue-400">Wema Bank</p>
                </div>
                <div class="mt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        After making the payment, please click the WhatsApp icon to submit:
                        <ul class="list-disc ml-6 mt-2 text-gray-600 dark:text-gray-400">
                            <li>Payment receipt</li>
                            <li>Depositor's name</li>
                            <li>Your registered name</li>
                            <li>Email address</li>
                            <li>Time of payment</li>
                            <li>Bank transferred from</li>
                        </ul>
                    </p>
                </div>
            </div>
            <button wire:click="hideWemaDetails" 
                class="mt-6 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 transition-colors duration-200">
                Close
            </button>
        </div>
    </div>
    @endif
</div>
