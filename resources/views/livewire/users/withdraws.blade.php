<?php

use Livewire\Volt\Component;

new class extends Component {
    public $amount;
    public $pin;
    public $notification = null;
    public $user;
    public $wallet;
    public $canWithdraw = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->wallet = $this->user->wallet;
        $this->canWithdraw = $this->user->level >= 2;

        if (!$this->canWithdraw) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Only Level 2 users and above can withdraw funds.',
            ];
        }
    }

    public function withdraw()
    {
        if (!$this->canWithdraw) {
            $this->notification = [
                'type' => 'error',
                'message' => 'You are not authorized to make withdrawals. Please upgrade to Level 2 or higher.',
            ];
            return;
        }

        $this->validate([
            'amount' => ['required', 'numeric', 'min:1000', 'max:'.$this->wallet->earned_balance],
            'pin' => 'required|numeric|digits:4',
        ], [
            'amount.min' => 'Withdrawal amount must be at least 1000 Naira.',
            'amount.max' => 'Withdrawal amount cannot exceed your available balance.',
        ]);

        if ($this->pin != $this->user->pin) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Invalid PIN provided.',
            ];
            return;
        }

        if ($this->amount > $this->wallet->earned_balance) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Insufficient balance.',
            ];
            return;
        }

        // Create withdrawal request
        \App\Models\Withdrawal::create([
            'user_id' => $this->user->id,
            'amount' => $this->amount,
            'bank_name' => $this->user->bank_name,
            'bank_account_name' => $this->user->bank_account_name,
            'bank_account_number' => $this->user->bank_account_number,
            'status' => 'pending'
        ]);

        $this->notification = [
            'type' => 'success',
            'message' => 'Your Withdrawal is on its way!',
        ];

        $this->reset(['amount', 'pin']);
    }
}; ?>

<div>
    <main class="p-2">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">Withdraw Funds</h1>
            <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">Request withdrawal of your funds to your
                bank account.</p>
        </div>

        <div class="flex flex-col mb-6 space-y-4 w-full lg:w-4/5 mx-auto">
            <img src="{{ asset('assets/1000-front.jpg') }}" alt="1000 Naira Front" class="w-full h-auto rounded-lg shadow-lg">
            <img src="{{ asset('assets/1000-back.webp') }}" alt="1000 Naira Back" class="w-full h-auto rounded-lg shadow-lg">
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm mb-6">
            <div class="mb-4 text-secondary-700 dark:text-secondary-300">
                <p class="font-semibold">Withdrawal Info:</p>
                <ul class="list-disc ml-6 mt-2">
                    <li>Available Balance: ₦{{ number_format($wallet->earned_balance, 2) }}</li>
                    <li>Minimum: ₦1,000</li>
                    <li>Charge: 0.01%</li>
                    <li>Processing Time: 24 hours</li>
                </ul>
            </div>
        </div>

        @if ($notification)
            <div class="mb-4">
                <div
                    class="rounded-md p-4 {{ $notification['type'] === 'success' ? 'bg-primary-50 dark:bg-primary-900/50' : 'bg-red-50 dark:bg-red-900/50' }}">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if ($notification['type'] === 'success')
                                <svg class="h-5 w-5 text-primary-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-sm {{ $notification['type'] === 'success' ? 'text-primary-800' : 'text-red-800' }}">
                                {{ $notification['message'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($canWithdraw)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-secondary-900 dark:text-white">Bank Details</h3>
                    <div class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">
                        <p>Bank: {{ $user->bank_name }}</p>
                        <p>Account Name: {{ $user->bank_account_name }}</p>
                        <p>Account Number: {{ $user->bank_account_number }}</p>
                    </div>
                </div>

                <form wire:submit.prevent="withdraw" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Amount
                            (NGN)</label>
                        <flux:input type="number" wire:model="amount"
                            class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white" />
                        @error('amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">PIN</label>
                        <flux:input type="password" wire:model="pin" maxlength="4"
                            class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white" />
                        @error('pin')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <flux:button type="submit" class="cursor-pointer btn-primary w-full">
                        Withdraw
                    </flux:button>
                </form>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-yellow-900/50 rounded-xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            Access Restricted
                        </h3>
                        <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            You need to be at least Level 2 to make withdrawals. Please upgrade your account level to continue.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </main>
</div>
