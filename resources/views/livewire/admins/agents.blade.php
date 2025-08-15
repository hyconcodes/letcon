<?php

use Livewire\Volt\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

new class extends Component {
    public $users;
    public $name = '';
    public $email = '';
    public $username = '';
    public $password = '';
    public $phone = '';
    public $editingUser = null;
    public $confirmingDeletion = false;
    public $userToDelete = null;
    public $notification = null;

    public function mount() {
        $this->users = User::role('admin')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createAgent() {
        try {
            $this->validate([
                'name' => 'required|min:3',
                'username' => 'required|min:3|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'phone' => 'nullable|string'
            ]);
            
            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'phone' => $this->phone,
                'level' => 11
            ]);

            $user->assignRole('admin');

            $this->notification = [
                'type' => 'success',
                'message' => 'Agent created successfully!'
            ];

            $this->reset(['name', 'username', 'email', 'password', 'phone']);
            $this->users = User::role('admin')->orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Error creating agent: ' . $e->getMessage()
            ];
        }
    }

    public function editAgent($userId) {
        $this->editingUser = User::findOrFail($userId);
        $this->name = $this->editingUser->name;
        $this->username = $this->editingUser->username;
        $this->email = $this->editingUser->email;
        $this->phone = $this->editingUser->phone;
    }

    public function updateAgent() {
        try {
            $this->validate([
                'name' => 'required|min:3',
                'username' => 'required|min:3|unique:users,username,' . $this->editingUser->id,
                'email' => 'required|email|unique:users,email,' . $this->editingUser->id,
                'phone' => 'nullable|string',
                'password' => 'nullable|min:8'
            ]);

            $data = [
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
            ];

            if ($this->password) {
                $data['password'] = bcrypt($this->password);
            }

            $this->editingUser->update($data);

            $this->notification = [
                'type' => 'success',
                'message' => 'Agent updated successfully!'
            ];

            $this->reset(['editingUser', 'name', 'username', 'email', 'password', 'phone']);
            $this->users = User::role('admin')->orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Error updating agent: ' . $e->getMessage()
            ];
        }
    }

    public function confirmDelete($userId) {
        $this->userToDelete = User::findOrFail($userId);
        $this->confirmingDeletion = true;
    }

    public function deleteAgent() {
        try {
            $this->userToDelete->delete();
            $this->notification = [
                'type' => 'success',
                'message' => 'Agent deleted successfully!'
            ];
            $this->reset(['confirmingDeletion', 'userToDelete']);
            $this->users = User::role('admin')->orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            $this->notification = [
                'type' => 'error',
                'message' => 'Error deleting agent: ' . $e->getMessage()
            ];
        }
    }

    public function cancelDelete() {
        $this->reset(['confirmingDeletion', 'userToDelete']);
    }
}; ?>

<main class="p-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">Agent Management</h1>
        <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">Manage your organization's agents - create, edit and remove agent accounts.</p>
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
                    @else
                        <svg class="h-5 w-5 text-secondary-400 dark:text-secondary-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
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

    <div class="mb-6 bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-sm">
        <h2 class="text-xl font-bold mb-4 text-secondary-900 dark:text-white">
            {{ $editingUser ? 'Edit Agent' : 'Create New Agent' }}
        </h2>
        <form wire:submit.prevent="{{ $editingUser ? 'updateAgent' : 'createAgent' }}" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Name</label>
                <flux:input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
                @error('name') <span class="text-secondary-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Username</label>
                <flux:input type="text" wire:model="username" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
                @error('username') <span class="text-secondary-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Email</label>
                <flux:input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
                @error('email') <span class="text-secondary-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Phone</label>
                <flux:input type="text" wire:model="phone" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
                @error('phone') <span class="text-secondary-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">
                    Password {{ $editingUser ? '(leave blank to keep current)' : '' }}
                </label>
                <flux:input type="password" wire:model="password" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
                @error('password') <span class="text-secondary-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <flux:button type="submit" class="btn-primary">
                {{ $editingUser ? 'Update Agent' : 'Create Agent' }}
            </flux:button>
        </form>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
        <div class="p-4">
            <h2 class="text-xl font-bold mb-4 text-secondary-900 dark:text-white">Agents List</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-secondary-200 dark:divide-secondary-700">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($user->picture)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->picture }}" alt="{{ $user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-secondary-200 dark:bg-secondary-700 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-secondary-500 dark:text-secondary-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-secondary-900 dark:text-white font-medium">{{ $user->name }}</div>
                                <div class="text-sm text-secondary-500 dark:text-secondary-400">{{ '@' . $user->username }}</div>
                                <div class="text-sm text-secondary-500 dark:text-secondary-400">{{ $user->email }}</div>
                                <div class="text-sm text-secondary-500 dark:text-secondary-400">{{ $user->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="editAgent({{ $user->id }})" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                    Edit
                                </button>
                                <button wire:click="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($confirmingDeletion)
    <div class="fixed inset-0 bg-secondary-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-secondary-900 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-secondary-900 dark:text-white">Delete Agent</h3>
                        <div class="mt-2">
                            <p class="text-sm text-secondary-500 dark:text-secondary-400">
                                Are you sure you want to delete the agent "{{ $userToDelete->name }}"? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteAgent" class="btn-secondary sm:ml-3 sm:w-auto">Delete</button>
                    <button wire:click="cancelDelete" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-secondary-800 px-3 py-2 text-sm font-semibold text-secondary-900 dark:text-white shadow-sm ring-1 ring-inset ring-secondary-300 dark:ring-secondary-600 hover:bg-secondary-50 dark:hover:bg-secondary-700 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</main>
