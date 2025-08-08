<?php

use Livewire\Volt\Component;

new class extends Component {
    public $balance = 0; // Example balance

    public function mount()
    {
        // Initialize data
        $this->balance = auth()->user()->wallet_balance ?? 0;
    }
}; ?>

<div class="p-4">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-yellow-600">My Wallet</h1>
        <p class="mt-2 text-gray-600">Manage your funds, transactions and financial activities</p>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Available Balance Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Available Earned</h3>
            <p class="text-2xl font-bold text-green-600 my-2">₦{{ number_format($balance, 2) }}</p>
            <button class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">View Details</button>
        </div>

        <!-- Fund Wallet Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Fund your e-wallet</h3>
            <p class="text-sm text-gray-600 my-2">Add money to your wallet</p>
            <a href="{{ route('boards', ['message' => 'Please subscribe to level 1 and make payment']) }}" 
               class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600">Fund Now</a>
        </div>

        <!-- Withdraw Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Withdraw To Bank</h3>
            <p class="text-sm text-gray-600 my-2">Transfer to your bank account</p>
            <button class="bg-purple-500 text-white px-4 py-2 rounded text-sm hover:bg-purple-600">Withdraw</button>
        </div>

        <!-- Balance Transfer Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Balance Transfer</h3>
            <p class="text-sm text-gray-600 my-2">Send money to other users</p>
            <button class="bg-indigo-500 text-white px-4 py-2 rounded text-sm hover:bg-indigo-600">Transfer</button>
        </div>

        <!-- Earning History Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Earning History</h3>
            <p class="text-sm text-gray-600 my-2">View your Letcon earnings</p>
            <button class="bg-yellow-500 text-white px-4 py-2 rounded text-sm hover:bg-yellow-600">View History</button>
        </div>

        <!-- Transaction History Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Transactions History</h3>
            <p class="text-sm text-gray-600 my-2">All Letcon transactions</p>
            <button class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600">View Transactions</button>
        </div>

        <!-- Withdrawal History Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Withdrawal History</h3>
            <p class="text-sm text-gray-600 my-2">Past withdrawal records</p>
            <button class="bg-teal-500 text-white px-4 py-2 rounded text-sm hover:bg-teal-600">View Withdrawals</button>
        </div>

        <!-- Deposit History Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">Deposit History</h3>
            <p class="text-sm text-gray-600 my-2">Past deposit records</p>
            <button class="bg-orange-500 text-white px-4 py-2 rounded text-sm hover:bg-orange-600">View
                Deposits</button>
        </div>
    </div>
</div>
