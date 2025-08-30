<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Earning;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $selectedType = '';
    public $sortField = 'earned_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function with(): array
    {
        return [
            'earnings' => Earning::query()
                ->where('user_id', auth()->id())
                ->when($this->search, function ($query) {
                    $query->where('description', 'like', '%' . $this->search . '%');
                })
                ->when($this->selectedType, function ($query) {
                    $query->where('type', $this->selectedType);
                })
                ->when($this->dateFrom, function ($query) {
                    $query->whereDate('earned_at', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query) {
                    $query->whereDate('earned_at', '<=', $this->dateTo);
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
            'types' => Earning::distinct()->pluck('type'),
        ];
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field ? ($this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortField = $field;
    }
}; ?>

<div class="p-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-accent dark:text-accent">Earnings History</h1>
        <p class="text-sm text-accent-content dark:text-accent-content">Track and manage your earnings over time</p>
    </div>

    <div class="mb-4 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" type="search" placeholder="Search by description..."
                class="w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-accent-content dark:text-accent-content shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
        <div class="flex gap-2">
            <flux:select wire:model.live="selectedType"
                class="rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-accent-content dark:text-accent-content shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">All Types</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </flux:select>
            <flux:input wire:model.live="dateFrom" type="date"
                class="rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-accent-content dark:text-accent-content shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            <flux:input wire:model.live="dateTo" type="date"
                class="rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-accent-content dark:text-accent-content shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-zinc-800 rounded-lg shadow">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-700">
                <tr>
                    <th wire:click="sortBy('earned_at')"
                        class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-accent-content uppercase tracking-wider cursor-pointer">
                        Earned Date
                        @if ($sortField === 'earned_at')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th wire:click="sortBy('type')"
                        class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-accent-content uppercase tracking-wider cursor-pointer">
                        Type
                        @if ($sortField === 'type')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th wire:click="sortBy('description')"
                        class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-accent-content uppercase tracking-wider cursor-pointer">
                        Description
                        @if ($sortField === 'description')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th wire:click="sortBy('amount')"
                        class="px-6 py-3 text-left text-xs font-medium text-accent-content dark:text-accent-content uppercase tracking-wider cursor-pointer">
                        Amount
                        @if ($sortField === 'amount')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse($earnings as $earning)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-accent-content">
                            {{ $earning->earned_at->format('M j, Y g:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-accent-content">
                            {{ ucfirst($earning->type) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-accent-content">
                            {{ $earning->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-content dark:text-accent-content">
                            ₦{{ number_format($earning->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-accent-content dark:text-accent-content">
                            No earnings found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $earnings->links() }}
    </div>
</div>
