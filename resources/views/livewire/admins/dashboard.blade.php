<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public function getMemberCount()
    {
        return User::role('member')->count();
    }

    public function getAgentCount() 
    {
        return User::role('admin')->count();
    }
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <!-- Total Members Card -->
            <div class="relative overflow-hidden rounded-xl bg-blue-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor" 
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Total Members</p>
                    <p class="text-2xl font-bold">{{ $this->getMemberCount() }}</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View All</button>
            </div>

            <!-- Total Agents Card -->
            <div class="relative overflow-hidden rounded-xl bg-green-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Total Agents</p>
                    <p class="text-2xl font-bold">{{ $this->getAgentCount() }}</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View All</button>
            </div>
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-xl font-bold">User Statistics</h2>
            <!-- Add user statistics content here -->
        </div>
    </div>
</div>
