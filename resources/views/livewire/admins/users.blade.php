<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\WithPagination;

new class extends Component {
    public $users;
    public $search = '';
    public $levelFilter = '';
    public $totalUsers;
    public $filteredUsers;
    public $userToDelete = null;
    public $showDeleteModal = false;

    public function mount()
    {
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

        if ($this->levelFilter) {
            $query->where('level', $this->levelFilter);
        }

        $this->users = $query->orderBy('created_at', 'desc')->get();
        $this->filteredUsers = $this->users->count();
    }

    public function confirmDelete($userId)
    {
        $this->userToDelete = User::find($userId);
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        if ($this->userToDelete) {
            $this->userToDelete->delete();
            session()->flash('message', 'User deleted successfully.');
            $this->showDeleteModal = false;
            $this->userToDelete = null;
            $this->refreshUsers();
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }

    public function updatedSearch()
    {
        $this->refreshUsers();
    }

    public function updatedLevelFilter()
    {
        $this->refreshUsers();
    }
}; ?>

<div>
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
        <div class="p-2 sm:p-4">
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('message') }}
                </div>
            @endif

            <div class="mb-4 sm:mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-secondary-900 dark:text-white mb-2">Member Management</h1>
                <p class="text-sm sm:text-base text-secondary-500 dark:text-secondary-400">Manage and monitor all registered members</p>
                <div class="mt-2 sm:mt-3 flex flex-wrap gap-2 text-xs sm:text-sm">
                    <span class="text-secondary-600 dark:text-secondary-300">Total Members: {{ $totalUsers }}</span>
                    @if($levelFilter)
                        <span class="text-secondary-600 dark:text-secondary-300">| Level {{ $levelFilter }} Members: {{ $filteredUsers }}</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                <h2 class="text-lg sm:text-xl font-bold text-secondary-900 dark:text-white">Members List</h2>
                <div class="flex flex-col sm:flex-row w-full sm:w-auto gap-2 sm:gap-4">
                    <select wire:model.live="levelFilter" class="w-full sm:w-auto rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white">
                        <option value="">All Levels</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">Level {{ $i }}</option>
                        @endfor
                    </select>
                    <div class="w-full sm:w-64">
                        <flux:input type="text" wire:model.live.debounce.300ms="search" placeholder="Search members..." 
                            class="block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white" />
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto -mx-2 sm:mx-0">
                <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Profile</th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Info</th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Level & Status</th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-secondary-200 dark:divide-secondary-700">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if ($user->picture)
                                            <img class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover" src="{{ asset('storage/app/public/' . $user->picture) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-secondary-200 dark:bg-secondary-700 flex items-center justify-center">
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-secondary-500 dark:text-secondary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-2 sm:py-4">
                                    <div class="text-xs sm:text-sm text-secondary-900 dark:text-white font-medium">{{ $user->name }}</div>
                                    <div class="text-xs sm:text-sm text-secondary-900 dark:text-white font-medium">{{ $user->username ?? "nil" }}</div>
                                    <div class="text-xs sm:text-sm text-secondary-500 dark:text-secondary-400">{{ $user->email }}</div>
                                    <div class="text-xs sm:text-sm text-secondary-500 dark:text-secondary-400">{{ $user->phone }}</div>
                                </td>
                                <td class="px-3 sm:px-6 py-2 sm:py-4">
                                    <div class="text-xs sm:text-sm text-secondary-900 dark:text-white">Level: {{ $user->level ?? 'Basic' }}</div>
                                    <div class="text-xs sm:text-sm text-secondary-500 dark:text-secondary-400">
                                        <span class="hidden sm:inline">Upgraded: </span>{{ $user->levelHistory()->latest()->first()?->created_at->format('F j, Y g:i A') ?? 'Not upgraded yet' }}
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-2 sm:py-4">
                                    <button wire:click="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($showDeleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-sm mx-4">
            <h3 class="text-lg font-medium text-secondary-900 dark:text-white mb-4">Confirm Delete</h3>
            <p class="text-secondary-500 dark:text-secondary-400 mb-4">Are you sure you want to delete {{ $userToDelete->name }}? This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button wire:click="cancelDelete" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-white border border-secondary-300 rounded-md hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </button>
                <button wire:click="deleteUser" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
