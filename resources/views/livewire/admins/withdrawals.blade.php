<?php

use Livewire\Volt\Component;

new class extends Component {
    public $withdrawals = [];
    public $activeTab = 'pending';
    public $notification = null;
    public $search = '';
    public $selectedWithdrawal = null;
    public $comment = '';
    public $selectedKYC = null;

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

    public function openRejectModal($withdrawalId) {
        $this->selectedWithdrawal = $withdrawalId;
        $this->comment = '';
    }

    public function closeRejectModal() {
        $this->selectedWithdrawal = null;
        $this->comment = '';
    }

    public function closeKYCModal() {
        $this->selectedKYC = null;
    }

    public function viewKYC($userId) {
        $this->selectedKYC = \App\Models\User::findOrFail($userId);
    }

    public function updateStatus($withdrawalId, $status, $requireComment = false) {
        $withdrawal = \App\Models\Withdrawal::findOrFail($withdrawalId);
        
        if (!auth()->user()->can($status.'.withdrawal')) {
            $this->notification = ['type' => 'error', 'message' => 'Unauthorized action'];
            return;
        }

        if ($withdrawal->status === 'approved') {
            $this->notification = ['type' => 'error', 'message' => 'Cannot modify approved withdrawals'];
            return;
        }

        if ($requireComment && empty($this->comment)) {
            $this->notification = ['type' => 'error', 'message' => 'Comment is required for rejection'];
            return;
        }

        if ($status === 'approve') {
            $user = $withdrawal->user;
            if ($user->wallet->pending_withdraw >= $withdrawal->amount) {
                $user->wallet->decrement('pending_withdraw', $withdrawal->amount);
                $user->wallet->increment('total_withdraw', $withdrawal->amount);
                $withdrawal->update(['status' => 'approved']);
                $this->notification = ['type' => 'success', 'message' => 'Withdrawal approved successfully'];
            } else {
                $this->notification = ['type' => 'error', 'message' => 'Insufficient pending withdrawal balance'];
                return;
            }
        } else {
            $withdrawal->update([
                'status' => $status === 'approve' ? 'approved' : ($status === 'reject' ? 'rejected' : 'pending'),
                'comment' => $requireComment ? $this->comment : $withdrawal->comment
            ]);

            // If status is reject, return the money to user's earned balance
            if ($status === 'reject') {
                $user = $withdrawal->user;
                $user->wallet->decrement('pending_withdraw', $withdrawal->amount);
                $user->wallet->increment('earned_balance', $withdrawal->amount);
            }

            $this->notification = ['type' => 'success', 'message' => 'Status updated successfully'];
        }

        $this->comment = '';
        $this->selectedWithdrawal = null;
        $this->loadWithdrawals();
    }
}; ?>

<div>
    <main class="p-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">Withdrawal Logs</h1>
            <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">View and manage withdrawal requests from users.</p>
        </div>

        @if($notification)
        <div class="mb-4 p-4 rounded-md {{ $notification['type'] === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
            {{ $notification['message'] }}
        </div>
        @endif

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
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Actions</th>
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
                                <td class="px-6 py-4">
                                    @if($withdrawal->status === 'pending')
                                        @can('approve.withdrawal')
                                        <button 
                                            wire:click="updateStatus({{ $withdrawal->id }}, 'approve')"
                                            class="text-sm bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 mr-2"
                                        >
                                            Approve
                                        </button>
                                        @endcan
                                        
                                        @can('reject.withdrawal')
                                        <button 
                                            wire:click="openRejectModal({{ $withdrawal->id }})"
                                            class="text-sm bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 mr-2"
                                        >
                                            Reject
                                        </button>
                                        @endcan
                                    {{-- @elseif($withdrawal->status === 'rejected')
                                        <button 
                                            wire:click="updateStatus({{ $withdrawal->id }}, 'pending')"
                                            class="text-sm bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 mr-2"
                                        >
                                            Move to Pending
                                        </button> --}}
                                    @endif
                                    <button 
                                        wire:click="viewKYC({{ $withdrawal->user_id }})"
                                        class="text-sm bg-purple-500 text-white px-3 py-1 rounded-md hover:bg-purple-600"
                                    >
                                        View KYC
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @if($selectedWithdrawal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg w-96">
            <h3 class="text-lg font-medium mb-4">Add Rejection Comment</h3>
            <textarea 
                wire:model="comment"
                class="w-full p-2 border rounded-md mb-4 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                rows="3"
                placeholder="Enter rejection reason..."
                required
            ></textarea>
            <div class="flex justify-end space-x-2">
                <button 
                    wire:click="closeRejectModal"
                    class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800"
                >
                    Cancel
                </button>
                <button 
                    wire:click="updateStatus({{ $selectedWithdrawal }}, 'reject', true)"
                    class="px-4 py-2 text-sm bg-red-500 text-white rounded-md hover:bg-red-600"
                >
                    Confirm Rejection
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($selectedKYC)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg w-96">
            <h3 class="text-lg font-medium mb-4">KYC Information</h3>
            <div class="space-y-4">
                @if($selectedKYC->user_type === 'organization')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organization Name</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $selectedKYC->name }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organization Image</label>
                        @if($selectedKYC->kyc_org_image)
                            <img src="{{ asset('storage/' . $selectedKYC->kyc_org_image) }}" alt="Organization KYC Image" class="mt-2 max-w-full h-auto rounded-lg">
                        @else
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">No organization image provided</div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Initiator KYC ID Image</label>
                        @if($selectedKYC->kyc_image)
                            <img src="{{ asset('storage/' . $selectedKYC->kyc_image) }}" alt="Personal KYC Image" class="mt-2 max-w-full h-auto rounded-lg">
                        @else
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">No personal image provided</div>
                        @endif
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">KYC Type</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ strtoupper($selectedKYC->kyc_type) ?? 'Not provided' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">BVN</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $selectedKYC->kyc_id ?? 'Not provided' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">KYC Image</label>
                        @if($selectedKYC->kyc_image)
                            <img src="{{ asset('storage/app/public/' . $selectedKYC->kyc_image) }}" alt="KYC Image" class="mt-2 max-w-full h-auto rounded-lg">
                        @else
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">No image provided</div>
                        @endif
                    </div>
                @endif
            </div>
            <div class="mt-6 flex justify-end">
                <button 
                    wire:click="closeKYCModal"
                    class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
