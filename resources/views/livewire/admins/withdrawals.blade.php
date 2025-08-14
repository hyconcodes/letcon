<?php

use Livewire\Volt\Component;

new class extends Component {
    public $withdrawals = [];
    public $activeTab = 'pending';
    public $notification = null;
    public $search = '';

    public function mount() {
        $this->loadWithdrawals();
    }

    public function loadWithdrawals() {
        $query = \App\Models\Withdrawal::query()
            ->with('user')
            ->where('status', $this->activeTab);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('bank_name', 'like', "%{$this->search}%")
                  ->orWhere('bank_account_name', 'like', "%{$this->search}%")
                  ->orWhere('bank_account_number', 'like', "%{$this->search}%")
                  ->orWhere('amount', 'like', "%{$this->search}%");
            });
        }

        $this->withdrawals = $query->latest()->get();
    }

    public function setTab($tab) {
        $this->activeTab = $tab;
        $this->loadWithdrawals();
    }
}; ?>

<div>
    <main class="p-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">Withdrawal Logs</h1>
            <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">View and manage withdrawal requests from users.</p>
        </div>

        <div class="mb-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
            <div class="border-b border-secondary-200 dark:border-secondary-700">
                <nav class="flex space-x-4 px-4" aria-label="Tabs">
                    <button 
                        wire:click="setTab('pending')"
                        class="px-3 py-2 text-sm font-medium {{ $activeTab === 'pending' ? 'border-b-2 border-primary-500 text-primary-600' : 'text-secondary-500 hover:text-secondary-700' }}"
                    >
                        Pending
                    </button>
                    <button 
                        wire:click="setTab('approved')"
                        class="px-3 py-2 text-sm font-medium {{ $activeTab === 'approved' ? 'border-b-2 border-primary-500 text-primary-600' : 'text-secondary-500 hover:text-secondary-700' }}"
                    >
                        Approved
                    </button>
                    <button 
                        wire:click="setTab('rejected')"
                        class="px-3 py-2 text-sm font-medium {{ $activeTab === 'rejected' ? 'border-b-2 border-primary-500 text-primary-600' : 'text-secondary-500 hover:text-secondary-700' }}"
                    >
                        Rejected
                    </button>
                </nav>
            </div>

            <div class="p-4">
                <div class="flex justify-end mb-4">
                    <div class="w-64">
                        <flux:input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Search withdrawals..."
                            class="block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"
                        />
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Bank Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-secondary-200 dark:divide-secondary-700">
                            @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-secondary-900 dark:text-white">{{ $withdrawal->user->name }}</div>
                                    <div class="text-sm text-secondary-500 dark:text-secondary-400">ID: {{ $withdrawal->user_id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-secondary-900 dark:text-white">₦{{ number_format($withdrawal->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-secondary-900 dark:text-white">{{ $withdrawal->bank_name }}</div>
                                    <div class="text-sm text-secondary-500 dark:text-secondary-400">{{ $withdrawal->bank_account_name }}</div>
                                    <div class="text-sm text-secondary-500 dark:text-secondary-400">{{ $withdrawal->bank_account_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $withdrawal->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-secondary-500 dark:text-secondary-400">
                                        {{ $withdrawal->comment ?? 'No comment' }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
