<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Payment;
use App\Models\Wallet;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use WithPagination;

    public $users;
    public $search = '';
    public $selectedUser = null;
    public $amount = 20000; // Fixed amount
    public $showPaymentModal = false;
    public $paymentMethod = 'cash';

    public function mount()
    {
        $this->authorize('record.payment');
        $this->refreshUsers();
    }

    public function refreshUsers()
    {
        $query = User::role('member');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->users = $query->latest()->take(10)->get();
    }

    public function showPaymentForm($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->showPaymentModal = true;
    }

    public function recordPayment()
    {
        $this->validate([
            'paymentMethod' => 'required|string'
        ]);

        // Create payment record
        $payment = Payment::create([
            'user_id' => $this->selectedUser->id,
            'amount' => $this->amount, // Using fixed amount
            'status' => 'paid',
            'reference' => 'MANUAL-' . time(),
            'payment_method' => $this->paymentMethod,
            'payment_method_code' => $this->paymentMethod
        ]);

        // Create or update wallet
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $this->selectedUser->id],
            ['balance' => 0]
        );

        $wallet->increment('balance', $this->amount);

        session()->flash('message', 'Payment recorded successfully!');
        $this->reset(['paymentMethod', 'showPaymentModal', 'selectedUser']);
        $this->refreshUsers();
    }

    public function cancelPayment()
    {
        $this->reset(['paymentMethod', 'showPaymentModal', 'selectedUser']);
    }

    public function updatedSearch()
    {
        $this->refreshUsers();
    }
}; ?>

<div>
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
        <div class="p-4">
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('message') }}
                </div>
            @endif

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-secondary-900 dark:text-white mb-2">Record Payment</h1>
                <p class="text-secondary-500 dark:text-secondary-400">Record payments for members manually</p>
            </div>

            <div class="mb-4">
                <flux:input type="text" wire:model.live.debounce.300ms="search" 
                    placeholder="Search members by name or email..." 
                    class="w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
            </div>

            <!-- Responsive table wrapper -->
            <div class="overflow-x-auto">
                <!-- Mobile view (< 640px) -->
                <div class="sm:hidden">
                    @forelse ($users as $user)
                        <div class="bg-white dark:bg-zinc-800 p-4 mb-4 rounded-lg shadow">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium text-secondary-900 dark:text-white">#{{ $user->id }}</span>
                                <span class="text-sm text-secondary-500">{{ $user->created_at->format('Y-m-d') }}</span>
                            </div>
                            <div class="mb-2">
                                <h3 class="font-medium text-secondary-900 dark:text-white">{{ $user->name }}</h3>
                                <p class="text-sm text-secondary-500">{{ $user->email }}</p>
                            </div>
                            <div class="mt-3">
                                @if($user->payments()->where('status', 'paid')->exists())
                                    <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-600 rounded-md cursor-not-allowed">
                                        Recorded
                                    </button>
                                @else
                                    <button wire:click="showPaymentForm({{ $user->id }})" 
                                        class="w-full px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                        Record Payment
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-secondary-500 dark:text-secondary-400">
                            No members found
                        </div>
                    @endforelse
                </div>

                <!-- Desktop view (≥ 640px) -->
                <div class="hidden sm:block">
                    <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Joined Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-secondary-200 dark:divide-secondary-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500 dark:text-secondary-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500 dark:text-secondary-400">{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($user->payments()->where('status', 'paid')->exists())
                                            <button disabled class="px-4 py-2 bg-gray-300 text-gray-600 rounded-md cursor-not-allowed">
                                                Recorded
                                            </button>
                                        @else
                                            <button wire:click="showPaymentForm({{ $user->id }})" 
                                                class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                                Record Payment
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-secondary-500 dark:text-secondary-400">
                                        No members found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($showPaymentModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-medium text-secondary-900 dark:text-white mb-4">Record Payment for {{ $selectedUser->name }}</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Amount</label>
                    <flux:input type="text" disabled value="20,000" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white bg-gray-100" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Payment Method</label>
                    <flux:select wire:model="paymentMethod" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white">
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="card">Card</option>
                    </flux:select>
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                <button wire:click="cancelPayment" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-secondary-700 bg-white border border-secondary-300 rounded-md hover:bg-secondary-50">
                    Cancel
                </button>
                <button wire:click="recordPayment" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700">
                    Record Payment
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
