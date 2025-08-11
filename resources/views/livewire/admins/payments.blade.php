<?php

use Livewire\Volt\Component;
use App\Models\Payment;
use App\Models\User;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $notification = null;
    public $editingPayment = null;
    public $search = '';
    public $confirmingDelete = false;
    public $deleteId = null;
    
    public $user_id;
    public $amount;
    public $level;
    public $status;
    public $reference;
    public $payment_method;
    public $payment_method_code;
    public $currency;

    public function with(): array
    {
        $payments = Payment::with('user')
            ->where(function($query) {
                $query->where('reference', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate(10);

        return [
            'payments' => $payments,
        ];
    }

    public function editPayment($id) {
        if(!auth()->user()->can('update.payment')) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Unauthorized action!'
            ];
            return;
        }

        $this->editingPayment = Payment::find($id);
        $this->user_id = $this->editingPayment->user_id;
        $this->amount = $this->editingPayment->amount;
        $this->level = $this->editingPayment->level;
        $this->status = $this->editingPayment->status;
        $this->reference = $this->editingPayment->reference;
        $this->payment_method = $this->editingPayment->payment_method;
        $this->payment_method_code = $this->editingPayment->payment_method_code;
        $this->currency = $this->editingPayment->currency;
    }

    public function updatePayment() {
        if(!auth()->user()->can('update.payment')) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Unauthorized action!'
            ];
            return;
        }

        $this->validate([
            'status' => 'required',
            'amount' => 'required|numeric',
            'level' => 'required',
            'payment_method' => 'required',
            'currency' => 'required'
        ]);

        $this->editingPayment->update([
            'status' => $this->status,
            'amount' => $this->amount,
            'level' => $this->level,
            'payment_method' => $this->payment_method,
            'currency' => $this->currency
        ]);
        
        $this->notification = [
            'type' => 'success',
            'message' => 'Payment updated successfully!'
        ];
        
        $this->editingPayment = null;
    }

    public function confirmDelete($id) {
        if(!auth()->user()->can('delete.payment')) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Unauthorized action!'
            ];
            return;
        }

        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function deletePayment() {
        if(!auth()->user()->can('delete.payment')) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Unauthorized action!'
            ];
            return;
        }

        Payment::find($this->deleteId)->delete();
        
        $this->notification = [
            'type' => 'success',
            'message' => 'Payment deleted successfully!'
        ];
        
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function cancelDelete() {
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }
}; ?>

<main class="p-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">Payment Management</h1>
        <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">View and manage payment transactions.</p>
    </div>

    @if($notification)
    <div class="mb-4">
        <div class="rounded-md p-4 {{ $notification['type'] === 'success' ? 'bg-primary-50 dark:bg-primary-900/50' : 'bg-secondary-50 dark:bg-secondary-900/50' }}">
            <div class="flex">
                <div class="flex-shrink-0">
                    @if($notification['type'] === 'success')
                        <svg class="h-5 w-5 text-primary-400 dark:text-primary-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <div class="ml-3">
                    <p class="{{ $notification['type'] === 'success' ? 'text-primary-800 dark:text-primary-200' : 'text-secondary-800 dark:text-secondary-200' }}">
                        {{ $notification['message'] }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button wire:click="$set('notification', null)" class="{{ $notification['type'] === 'success' ? 'text-primary-500 dark:text-primary-400' : 'text-secondary-500 dark:text-secondary-400' }} hover:opacity-75">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-secondary-900 dark:text-white">Payment Transactions</h2>
                <div class="flex items-center">
                    <flux:input type="text" wire:model.live.debounce.300ms="search" placeholder="Search payments..." 
                        class="rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"/>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">User Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Current Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Method Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Currency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-secondary-200 dark:divide-secondary-700">
                        @foreach($payments as $payment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->user->level }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->amount }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->level }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->status }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->reference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->payment_method }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->payment_method_code }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                {{ $payment->currency }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @can('update.payment')
                                <button wire:click="editPayment({{ $payment->id }})" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                    Edit
                                </button>
                                @endcan
                                @can('delete.payment')
                                <button wire:click="confirmDelete({{ $payment->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Delete
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

    @if($editingPayment)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-zinc-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="space-y-4">
                    <h3 class="text-lg font-medium leading-6 text-secondary-900 dark:text-white">Edit Payment</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Status</label>
                            <flux:select wire:model="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-zinc-700 dark:border-zinc-600">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </flux:select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Amount</label>
                            <flux:input type="number" wire:model="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-zinc-700 dark:border-zinc-600"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Level</label>
                            <flux:input type="text" wire:model="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-zinc-700 dark:border-zinc-600"/>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                    <button wire:click="updatePayment" class="inline-flex w-full justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 sm:col-start-2">Save</button>
                    <button wire:click="$set('editingPayment', null)" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($confirmingDelete)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-zinc-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-secondary-900 dark:text-white">Delete Payment</h3>
                        <div class="mt-2">
                            <p class="text-sm text-secondary-500 dark:text-secondary-400">Are you sure you want to delete this payment? This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="deletePayment" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                    <button wire:click="cancelDelete" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</main>
