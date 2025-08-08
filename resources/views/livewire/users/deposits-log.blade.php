<?php

use Livewire\Volt\Component;

new class extends Component {
    public $deposits;
    public $showModal = false;
    public $selectedDeposit = null;
    public $search = '';

    public function mount()
    {
        $this->deposits = auth()->user()->payment()
            ->latest()
            ->get();
    }

    public function showDepositDetails($depositId)
    {
        $this->selectedDeposit = $this->deposits->find($depositId);
        $this->showModal = true;
    }

    public function getFilteredDepositsProperty()
    {
        return $this->deposits->filter(function($deposit) {
            return str_contains(strtolower($deposit->reference), strtolower($this->search)) ||
                   str_contains(strtolower($deposit->payment_method), strtolower($this->search)) ||
                   str_contains(strtolower($deposit->status), strtolower($this->search));
        });
    }
}; ?>

<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-accent-content dark:text-white mb-2">Deposit History</h2>
        <p class="text-accent-content dark:text-zinc-300 mb-6">Track all your deposit transactions</p>

        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Search deposits..." 
                   class="w-full px-4 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-accent-content dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="overflow-x-auto bg-white dark:bg-zinc-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-zinc-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-zinc-300 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-zinc-300 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-zinc-300 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-zinc-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-zinc-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($this->filteredDeposits as $deposit)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-zinc-300">
                                {{ $deposit->created_at->format('l, F j, Y g:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-zinc-300">
                                {{ number_format($deposit->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-zinc-300">
                                {{ $deposit->reference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-zinc-300">
                                {{ $deposit->payment_method }}
                                <span class="text-xs text-accent-content dark:text-zinc-400">({{ $deposit->payment_method_code }})</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $deposit->status === 'paid' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}
                                    {{ $deposit->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : '' }}
                                    {{ $deposit->status === 'failed' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : '' }}">
                                    {{ ucfirst($deposit->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="showDepositDetails({{ $deposit->id }})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-accent-content dark:text-zinc-300">
                                No deposits found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction Details Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-lg w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-accent-content dark:text-white">Transaction Details</h3>
                <button wire:click="$set('showModal', false)" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">User Name</div>
                    <div class="text-sm text-accent-content dark:text-white">{{ auth()->user()->name }}</div>
                    
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Email</div>
                    <div class="text-sm text-accent-content dark:text-white">{{ auth()->user()->email }}</div>
                    
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Amount</div>
                    <div class="text-sm text-accent-content dark:text-white">{{ number_format($selectedDeposit->amount, 2) }}</div>
                    
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Reference</div>
                    <div class="text-sm text-accent-content dark:text-white">{{ $selectedDeposit->reference }}</div>
                    
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Payment Method</div>
                    <div class="text-sm text-accent-content dark:text-white">
                        {{ $selectedDeposit->payment_method }}
                        ({{ $selectedDeposit->payment_method_code }})
                    </div>
                    
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Status</div>
                    <div class="text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $selectedDeposit->status === 'paid' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}
                            {{ $selectedDeposit->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : '' }}
                            {{ $selectedDeposit->status === 'failed' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : '' }}">
                            {{ ucfirst($selectedDeposit->status) }}
                        </span>
                    </div>
                    
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Date</div>
                    <div class="text-sm text-accent-content dark:text-white">
                        {{ $selectedDeposit->created_at->format('M d, Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
