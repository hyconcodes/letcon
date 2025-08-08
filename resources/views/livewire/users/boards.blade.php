<?php

use Livewire\Volt\Component;
use App\Models\Payment;
use App\Models\User;

new class extends Component {
    public function hasLevel($level)
    {
        $user = auth()->user();
        return $user && $user->level >= $level && Payment::where('user_id', $user->id)
            ->where('status', 'paid')
            // ->where('level', $level)
            ->exists();
    }

    public function canAccessLevel($level) 
    {
        $user = auth()->user();
        return $user && $user->level >= $level;
    }
}; ?>

<div>
    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-4 rounded-md mb-4 flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4 flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
    @if (request()->query('message'))
        <div class="bg-yellow-500 text-white p-4 rounded-md mb-4 flex justify-between items-center">
            <span>{{ request()->query('message') }}</span>
            <button onclick="this.parentElement.remove()" class="focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-4">
        <!-- Heading -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-[#FFD700]">LETCON BOARD PORTFOLIO</h1>
            <p class="text-lg text-gray-500 mt-2">
                Choose your investment level and start earning
            </p>
        </div>

        <!-- Levels -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php
                $levels = [
                    ['round' => 1, 'name' => 'Registration', 'amount' => '20K', 'payout' => null, 'emoji' => null],
                    ['round' => 2, 'name' => 'ROUND 2', 'amount' => '40K', 'payout' => '32K', 'emoji' => '🥉'],
                    ['round' => 3, 'name' => 'ROUND 3', 'amount' => '80K', 'payout' => '64K', 'emoji' => '🥈'],
                    ['round' => 4, 'name' => 'ROUND 4', 'amount' => '160K', 'payout' => '128K', 'emoji' => '🥇'],
                    ['round' => 5, 'name' => 'ROUND 5', 'amount' => '320K', 'payout' => '256K', 'emoji' => '🏆'],
                    ['round' => 6, 'name' => 'ROUND 6', 'amount' => '640K', 'payout' => '512K', 'emoji' => '👑'],
                    ['round' => 7, 'name' => 'ROUND 7', 'amount' => '1.28M', 'payout' => '1.02M', 'emoji' => '💎'],
                    ['round' => 8, 'name' => 'ROUND 8', 'amount' => '2.56M', 'payout' => '2.05M', 'emoji' => '💫'],
                    ['round' => 9, 'name' => 'ROUND 9', 'amount' => '5.12M', 'payout' => '4.10M', 'emoji' => '⭐'],
                    ['round' => 10, 'name' => 'ROUND 10', 'amount' => '10M', 'payout' => '20M', 'emoji' => '🌟'],
                ];
            @endphp

            @foreach($levels as $level)
                <div class="bg-white shadow-md rounded-lg p-6 text-center border border-gray-100">
                    <div class="flex items-center justify-center gap-2">
                        <h2 class="text-lg font-semibold text-[#FFD700]">{{ $level['name'] }}</h2>
                        @if($level['emoji'])
                            <span class="text-2xl">{{ $level['emoji'] }}</span>
                        @endif
                    </div>
                    <p class="text-2xl font-bold text-green-600 mt-4">₦{{ $level['amount'] }}</p>
                    @if($level['payout'])
                        <p class="mt-2 text-gray-500">Board payout ₦{{ $level['payout'] }}</p>
                    @endif
                    <div class="mt-6 space-y-2">
                        @if($this->hasLevel($level['round']))
                            <button class="w-full bg-green-500 text-white font-semibold py-2 rounded-lg">
                                Subscribed
                            </button>
                            <a href="{{ route('trees', ['level' => $level['round']]) }}"
                                class="block w-full border border-blue-500 text-blue-500 font-semibold py-2 rounded-lg hover:bg-blue-50">
                                Check Tree
                            </a>
                        @elseif($this->canAccessLevel($level['round']))
                            <a href="{{ route('deposits') }}"
                                class="block w-full border border-blue-500 text-blue-500 font-semibold py-2 rounded-lg hover:bg-blue-50">
                                Subscribe
                            </a>
                        @else
                            <button class="w-full bg-gray-200 text-gray-500 font-semibold py-2 rounded-lg cursor-not-allowed">
                                Locked
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
