<?php

use Livewire\Volt\Component;

new class extends Component {
    public $notification = null;
    public $editingNotification = null;
    public $notifications = [];
    
    public $type;
    public $title;
    public $body;
    public $link;

    public function mount() {
        $this->notifications = \App\Models\Notification::latest()->get();
    }

    public function rules() {
        return [
            'type' => 'required|in:success,error,info,warning,notice',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'link' => 'nullable|url'
        ];
    }

    public function createNotification() {
        $this->validate();

        \App\Models\Notification::create([
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link
        ]);

        $this->reset(['type', 'title', 'body', 'link']);
        $this->notification = ['type' => 'success', 'message' => 'Notification created successfully.'];
        $this->mount();
    }

    public function editNotification($id) {
        $this->editingNotification = \App\Models\Notification::find($id);
        $this->type = $this->editingNotification->type;
        $this->title = $this->editingNotification->title;
        $this->body = $this->editingNotification->body;
        $this->link = $this->editingNotification->link;
    }

    public function updateNotification() {
        $this->validate();

        $this->editingNotification->update([
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link
        ]);

        $this->reset(['editingNotification', 'type', 'title', 'body', 'link']);
        $this->notification = ['type' => 'success', 'message' => 'Notification updated successfully.'];
        $this->mount();
    }

    public function deleteNotification($id) {
        \App\Models\Notification::find($id)->delete();
        $this->notification = ['type' => 'success', 'message' => 'Notification deleted successfully.'];
        $this->mount();
    }
}; ?>

<div>
    <main class="p-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">Notification Management</h1>
            <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-400">Manage your notifications - create, edit and remove notifications.</p>
        </div>

        @if($notification)
        <div class="mb-4">
            <div class="rounded-md p-4 {{ $notification['type'] === 'success' ? 'bg-primary-50 dark:bg-primary-900/50' : 'bg-secondary-50 dark:bg-secondary-900/50' }}">
                <div class="flex">
                    <div class="ml-3">
                        <p class="{{ $notification['type'] === 'success' ? 'text-primary-800 dark:text-primary-200' : 'text-secondary-800 dark:text-secondary-200' }}">
                            {{ $notification['message'] }}
                        </p>
                    </div>
                    <button wire:click="$set('notification', null)" class="ml-auto text-secondary-400 hover:text-secondary-500">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="mb-6 bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-sm">
            <h2 class="text-xl font-bold mb-4 text-secondary-900 dark:text-white">
                {{ $editingNotification ? 'Edit Notification' : 'Create New Notification' }}
            </h2>
            <form wire:submit.prevent="{{ $editingNotification ? 'updateNotification' : 'createNotification' }}" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Type</label>
                    <flux:select wire:model="type" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white">
                        <option value="">Select Type</option>
                        {{-- <option value="success">Success</option>
                        <option value="error">Error</option>
                        <option value="info">Info</option> --}}
                        <option value="notice">Notice</option>
                        <option value="warning">Warning</option>
                    </flux:select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Title</label>
                    <flux:input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Body</label>
                    <flux:textarea wire:model="body" rows="3" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"></flux:textarea>
                    @error('body') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Link (Optional)</label>
                    <flux:input type="url" wire:model="link" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"/>
                    @error('link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <flux:button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md !text-white !bg-primary-600 !hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    {{ $editingNotification ? 'Update Notification' : 'Create Notification' }}
                </flux:button>
            </form>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
            <div class="p-4">
                <h2 class="text-xl font-bold mb-4 text-secondary-900 dark:text-white">Notifications List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Body</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Link</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-secondary-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-secondary-200 dark:divide-secondary-700">
                            @foreach($notifications as $notification)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                    {{ ucfirst($notification->type) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                    {{ $notification->title }}
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary-900 dark:text-white">
                                    {{ Str::limit($notification->body, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900 dark:text-white">
                                    @if($notification->link)
                                        <a href="{{ $notification->link }}" target="_blank" class="text-primary-600 hover:text-primary-900">View Link</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @can('update.notification')
                                    <button wire:click="editNotification({{ $notification->id }})" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                        Edit
                                    </button>
                                    @endcan
                                    @can('delete.notification')
                                    <button wire:click="deleteNotification({{ $notification->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Delete
                                    </button>
                                    @endcan
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
