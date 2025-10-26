<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $users;
    public $search = '';
    public $userTypeFilter = '';
    public $accountStatusFilter = '';
    public $selectedUser = null;
    public $showAccountTypeModal = false;
    public $showAccountStatusModal = false;
    public $showEditDetailsModal = false;
    public $newUserType = '';
    public $newAccountStatus = '';
    public $editUsername = '';
    public $editUserUsername = '';
    public $editEmail = '';
    public $notification = null;
    public $totalUsers;
    public $filteredUsers;

    public function mount()
    {
        $this->authorize('view.member');
        $this->refreshUsers();
    }

    public function refreshUsers()
    {
        // Get total users count
        $this->totalUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'member');
        })->count();

        $query = User::whereHas('roles', function ($query) {
            $query->where('name', 'member');
        });

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->userTypeFilter) {
            $query->where('user_type', $this->userTypeFilter);
        }

        if ($this->accountStatusFilter) {
            $query->where('account_status', $this->accountStatusFilter);
        }

        $this->users = $query->orderBy('created_at', 'desc')->get();
        $this->filteredUsers = $this->users->count();
    }

    public function updatedSearch()
    {
        $this->refreshUsers();
    }

    public function updatedUserTypeFilter()
    {
        $this->refreshUsers();
    }

    public function updatedAccountStatusFilter()
    {
        $this->refreshUsers();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->newUserType = $this->selectedUser->user_type ?? 'individual';
        $this->newAccountStatus = $this->selectedUser->account_status ?? 'active';
        $this->editUsername = $this->selectedUser->name ?? '';
        $this->editUserUsername = $this->selectedUser->username ?? '';
        $this->editEmail = $this->selectedUser->email ?? '';
    }

    public function openAccountTypeModal($userId)
    {
        $this->selectUser($userId);
        $this->showAccountTypeModal = true;
    }

    public function openAccountStatusModal($userId)
    {
        $this->selectUser($userId);
        $this->showAccountStatusModal = true;
    }

    public function updateAccountType()
    {
        try {
            $this->validate([
                'newUserType' => 'required|in:individual,organization'
            ]);

            $this->selectedUser->update([
                'user_type' => $this->newUserType
            ]);

            $this->notification = [
                'type' => 'success',
                'message' => 'Account type updated successfully for ' . $this->selectedUser->name . '!',
            ];

            $this->closeAccountTypeModal();
            $this->refreshUsers();
        } catch (\Exception $e) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Error updating account type: ' . $e->getMessage(),
            ];
        }
    }

    public function updateAccountStatus()
    {
        try {
            $this->validate([
                'newAccountStatus' => 'required|in:active,paused'
            ]);

            $this->selectedUser->update([
                'account_status' => $this->newAccountStatus
            ]);

            $statusText = $this->newAccountStatus === 'active' ? 'activated' : 'paused';
            $this->notification = [
                'type' => 'success',
                'message' => 'Account ' . $statusText . ' successfully for ' . $this->selectedUser->name . '!',
            ];

            $this->closeAccountStatusModal();
            $this->refreshUsers();
        } catch (\Exception $e) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Error updating account status: ' . $e->getMessage(),
            ];
        }
    }

    public function closeAccountTypeModal()
    {
        $this->showAccountTypeModal = false;
        $this->selectedUser = null;
        $this->newUserType = '';
    }

    public function closeAccountStatusModal()
    {
        $this->showAccountStatusModal = false;
        $this->selectedUser = null;
        $this->newAccountStatus = '';
    }

    public function openEditDetailsModal($userId)
    {
        $this->selectUser($userId);
        $this->showEditDetailsModal = true;
    }

    public function closeEditDetailsModal()
    {
        $this->showEditDetailsModal = false;
        $this->selectedUser = null;
        $this->editUsername = '';
        $this->editUserUsername = '';
        $this->editEmail = '';
    }

    public function updateUserDetails()
    {
        try {
            $this->validate([
                'editUsername' => 'required|string|max:255',
                'editUserUsername' => 'required|string|max:255|unique:users,username,' . $this->selectedUser->id,
                'editEmail' => 'required|email|max:255|unique:users,email,' . $this->selectedUser->id,
            ]);

            $this->selectedUser->update([
                'name' => $this->editUsername,
                'username' => $this->editUserUsername,
                'email' => $this->editEmail,
            ]);

            $this->notification = [
                'type' => 'success',
                'message' => 'User details updated successfully for ' . $this->selectedUser->name . '!',
            ];

            $this->closeEditDetailsModal();
            $this->refreshUsers();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Validation error: ' . implode(', ', $e->validator->errors()->all()),
            ];
        } catch (\Exception $e) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Error updating user details: ' . $e->getMessage(),
            ];
        }
    }
}; ?>

<main class="p-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">Member Account Management</h1>
        <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">Manage member account types and status - change account types between individual and organization, and pause/activate accounts.</p>
    </div>

    @if ($notification)
        <div class="mb-4">
            <div
                class="rounded-md p-4 {{ $notification['type'] === 'success' ? 'bg-primary-50 dark:bg-primary-900/50' : 'bg-secondary-50 dark:bg-secondary-900/50' }}">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @if ($notification['type'] === 'success')
                            <svg class="h-5 w-5 text-primary-400 dark:text-primary-300" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg class="h-5 w-5 text-secondary-400 dark:text-secondary-300" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p
                            class="{{ $notification['type'] === 'success' ? 'text-primary-800 dark:text-primary-200' : 'text-secondary-800 dark:text-secondary-200' }}">
                            {{ $notification['message'] }}
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button wire:click="$set('notification', null)"
                                class="{{ $notification['type'] === 'success' ? 'text-primary-500 dark:text-primary-400' : 'text-secondary-500 dark:text-secondary-400' }} hover:opacity-75">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Filters and Search -->
    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
        <div>
            <flux:input wire:model.live="search" placeholder="Search members..." />
        </div>
        <div>
            <flux:select wire:model.live="userTypeFilter" placeholder="Filter by Account Type">
                <option value="">All Account Types</option>
                <option value="individual">Individual</option>
                <option value="organization">Organization</option>
            </flux:select>
        </div>
        <div>
            <flux:select wire:model.live="accountStatusFilter" placeholder="Filter by Status">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="paused">Paused</option>
            </flux:select>
        </div>
        <div class="flex items-center text-sm text-secondary-600 dark:text-secondary-400">
            Showing {{ $filteredUsers }} of {{ $totalUsers }} members
        </div>
    </div>

    <!-- Members Table -->
    <div class="overflow-hidden rounded-lg border border-secondary-200 bg-white shadow dark:border-secondary-700 dark:bg-secondary-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                <thead class="bg-secondary-50 dark:bg-secondary-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-500 dark:text-secondary-400">
                            Member
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-500 dark:text-secondary-400">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-500 dark:text-secondary-400">
                            Account Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-500 dark:text-secondary-400">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-500 dark:text-secondary-400">
                            Level
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-500 dark:text-secondary-400">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-200 bg-white dark:divide-secondary-700 dark:bg-secondary-800">
                    @forelse ($users as $user)
                        <tr class="hover:bg-secondary-50 dark:hover:bg-secondary-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-medium">
                                            {{ $user->initials() }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-secondary-900 dark:text-white">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-secondary-500 dark:text-secondary-400">
                                            ID: {{ $user->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-secondary-900 dark:text-white">{{ $user->email }}</div>
                                <div class="text-sm text-secondary-500 dark:text-secondary-400">{{ $user->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->user_type === 'organization' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                    {{ ucfirst($user->user_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->account_status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ ucfirst($user->account_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                Level {{ $user->level }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <flux:button size="sm" variant="ghost" 
                                    class="text-indigo-600 hover:text-indigo-900 mr-2"
                                    wire:click="openEditDetailsModal({{ $user->id }})">
                                    Edit Details
                                </flux:button>
                                
                                <flux:button size="sm" variant="ghost" 
                                    class="text-blue-600 hover:text-blue-900 mr-2"
                                    wire:click="openAccountTypeModal({{ $user->id }})">
                                    Change Type
                                </flux:button>
                                
                                <flux:button size="sm" variant="ghost" 
                                    class="{{ $user->account_status === 'active' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}"
                                    wire:click="openAccountStatusModal({{ $user->id }})">
                                    {{ $user->account_status === 'active' ? 'Pause' : 'Activate' }}
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-secondary-500 dark:text-secondary-400">
                                No members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Details Modal -->
    <flux:modal wire:model="showEditDetailsModal" focusable class="max-w-lg">
        <form wire:submit="updateUserDetails" class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Member Details</flux:heading>
                
                <flux:subheading>
                    Update name, username, and email for <strong>{{ $selectedUser?->name }}</strong>. These changes will be reflected immediately.
                </flux:subheading>
            </div>
            
            <flux:input wire:model="editUsername" label="Name" placeholder="Enter full name" required />
            
            <flux:input wire:model="editUserUsername" label="Username" placeholder="Enter username" required />
            
            <flux:input wire:model="editEmail" label="Email Address" type="email" placeholder="Enter email address" required />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:button variant="filled" wire:click="closeEditDetailsModal">Cancel</flux:button>
                
                <flux:button variant="primary" type="submit">Update Details</flux:button>
            </div>
        </form>
    </flux:modal>

<!-- Account Type Modal -->
    @foreach ($users as $user)
        <flux:modal name="account-type-modal-{{ $user->id }}" wire:model="showAccountTypeModal" focusable class="max-w-lg">
            <form wire:submit="updateAccountType" class="space-y-6">
                <div>
                    <flux:heading size="lg">Change Account Type</flux:heading>
                    
                    <flux:subheading>
                        Change account type for <strong>{{ $selectedUser?->name ?? $user->name }}</strong>. This will update how the account is classified in the system.
                    </flux:subheading>
                </div>
                
                <flux:select wire:model="newUserType" label="Account Type" required>
                    <option value="individual">Individual</option>
                    <option value="organization">Organization</option>
                </flux:select>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <flux:modal.close>
                        <flux:button variant="filled">Cancel</flux:button>
                    </flux:modal.close>
                    
                    <flux:button variant="primary" type="submit">Update Account Type</flux:button>
                </div>
            </form>
        </flux:modal>
    @endforeach

    <!-- Account Status Modal -->
    @foreach ($users as $user)
        <flux:modal name="account-status-modal-{{ $user->id }}" wire:model="showAccountStatusModal" focusable class="max-w-lg">
            <form wire:submit="updateAccountStatus" class="space-y-6">
                <div>
                    <flux:heading size="lg">Change Account Status</flux:heading>
                    
                    <flux:subheading>
                        Change account status for <strong>{{ $selectedUser?->name ?? $user->name }}</strong>. 
                        @if ($newAccountStatus === 'paused')
                            Pausing this account will prevent the user from logging in until reactivated.
                        @endif
                    </flux:subheading>
                </div>
                
                <flux:select wire:model="newAccountStatus" label="Account Status" required>
                    <option value="active">Active</option>
                    <option value="paused">Paused</option>
                </flux:select>

                @if ($newAccountStatus === 'paused')
                    <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-md dark:bg-yellow-900/20 dark:border-yellow-800">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            <strong>Warning:</strong> This user will be logged out and unable to access their account until reactivated.
                        </p>
                    </div>
                @endif

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <flux:modal.close>
                        <flux:button variant="filled">Cancel</flux:button>
                    </flux:modal.close>
                    
                    <flux:button variant="{{ $newAccountStatus === 'paused' ? 'danger' : 'primary' }}" type="submit">
                        {{ $newAccountStatus === 'active' ? 'Activate' : 'Pause' }} Account
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endforeach
</main>