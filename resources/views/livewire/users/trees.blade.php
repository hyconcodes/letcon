<?php

use Livewire\Volt\Component;
use App\Models\Referral;
use App\Models\User;
use App\Models\Payment;

new class extends Component {
    public $treeData = [];
    public $showModal = false;
    public $selectedUser = null;
    public $hasPaid = false;
    public $currentUser = null;

    public function mount()
    {
        $this->currentUser = User::with('referrer:id,name')
            ->select('id', 'name', 'picture', 'email', 'phone', 'referred_by', 'level')
            ->find(auth()->id());

        $referrals = User::where('referred_by', auth()->id())
            ->select('id', 'name', 'picture', 'email', 'phone', 'referred_by', 'level')
            ->with(['referrer:id,name'])
            ->take(4)
            ->get();

        $this->treeData[] = [
            'parent' => auth()->id(),
            'referrals' => $referrals,
        ];
    }

    public function showUserDetails($userId)
    {
        $this->selectedUser = User::with('referrer:id,name')->select('id', 'name', 'picture', 'email', 'phone', 'referred_by', 'level')->find($userId);

        // Check if user has paid
        $this->hasPaid = Payment::where('user_id', $userId)->where('status', 'paid')->exists();

        $this->showModal = true;
    }
}; ?>

<main class="p-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-semibold text-center mb-2 text-accent-content">Referral Network</h1>
        <p class="text-white-600 text-center mb-6">View your downline structure and team members</p>

        <div class="tree-container relative">
            <!-- Current User Card -->
            <div class="flex justify-center">
                <div class="flex flex-col items-center">
                    <div wire:click="showUserDetails({{ $currentUser->id }})"
                        class="w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden border-4 border-gold-400 shadow-lg flex items-center justify-center bg-white cursor-pointer hover:border-blue-500 transition-colors">
                        @if ($currentUser->picture)
                            <img src="{{ asset('storage/' . $currentUser->picture) }}" alt="Profile Photo"
                                class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <span class="text-xs md:text-sm font-medium mt-2">{{ $currentUser->name }}</span>

                    <!-- Vertical line from parent -->
                    <div class="w-px h-8 md:h-16 bg-gray-300 mt-2"></div>
                </div>
            </div>

            <!-- Referrals Level -->
            <div class="overflow-x-auto min-w-full">
                <div class="min-w-max px-4">
                    @foreach ($treeData as $nodes)
                        <div class="relative">
                            <!-- Horizontal line container -->
                            <div class="absolute left-1/2 -translate-x-1/2 w-[80%] h-px bg-gray-300"></div>

                            <!-- Referrals container -->
                            <div class="flex justify-center gap-8 md:gap-20 pt-4">
                                @foreach ($nodes['referrals'] as $referral)
                                    <div class="flex flex-col items-center">
                                        <!-- Vertical line to referral -->
                                        <div class="w-px h-6 md:h-8 bg-gray-300 -mt-4"></div>

                                        <div wire:click="showUserDetails({{ $referral->id }})"
                                            class="w-12 h-12 md:w-16 md:h-16 rounded-full overflow-hidden border-2 border-gold-400 shadow-lg flex items-center justify-center bg-white cursor-pointer hover:border-blue-500 transition-colors">
                                            @if ($referral->picture)
                                                <img src="{{ asset('storage/' . $referral->picture) }}" alt="Profile Photo"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 md:w-8 md:h-8 text-yellow-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-[10px] md:text-xs font-medium mt-2 text-center">{{ $referral->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- User Details Modal -->
    @if ($showModal)
        <div
            class="fixed inset-0 bg-black bg-opacity-50 dark:bg-zinc-900 dark:bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-zinc-800 rounded-lg p-4 md:p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg md:text-xl font-semibold dark:text-white">User Details</h3>
                    <button wire:click="$set('showModal', false)"
                        class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center mb-4">
                    <div
                        class="w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden border-2 border-gold-400 dark:border-gold-600 mr-3 md:mr-4">
                        @if ($selectedUser->picture)
                            <img src="{{ asset('storage/' . $selectedUser->picture) }}" alt="Profile Photo"
                                class="w-full h-full object-cover">
                        @else
                            <svg class="w-full h-full text-yellow-500 dark:text-yellow-400 p-4" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base md:text-lg font-semibold dark:text-white">{{ $selectedUser->name }}</h4>
                        <p class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400">Referral Code:
                            {{ $selectedUser->referral_code ?? 'N/A' }}</p>
                        <p class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400">Referred By:
                            {{ $selectedUser->referrer->name ?? 'N/A' }}</p>
                        <p
                            class="text-xs md:text-sm {{ $hasPaid ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            Status: {{ $hasPaid ? 'Paid' : 'Unpaid' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-2 md:space-y-3 text-sm md:text-base">
                    <div class="flex justify-between">
                        <span class="font-medium dark:text-white">Phone:</span>
                        <span class="dark:text-zinc-300">{{ $selectedUser->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium dark:text-white">Email:</span>
                        <span class="dark:text-zinc-300 break-all">{{ $selectedUser->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium dark:text-white">Board:</span>
                        <span class="dark:text-zinc-300">ROUND {{ $selectedUser->level }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</main>













































{{-- use Livewire\Volt\Component;
use App\Models\Referral;
use App\Models\User;
use App\Models\Payment;

new class extends Component {
    public $level;
    public $treeData = [];
    public $showModal = false;
    public $selectedUser = null;
    public $hasPaid = false;
    public $currentUser = null;

    public function mount($level = 3)
    {
        $this->level = min(10, max(1, intval($level)));
        $this->currentUser = User::with('referrer:id,name')
            ->select('id', 'name', 'picture', 'email', 'phone', 'referred_by', 'level')
            ->find(auth()->id());
        $this->buildTree(auth()->id(), 1);
    }

    private function buildTree($userId, $currentLevel)
    {
        if ($currentLevel > $this->level) return;

        $referrals = User::where('referred_by', $userId)
            ->select('id', 'name', 'picture', 'email', 'phone', 'referred_by', 'level')
            ->with(['referrer:id,name'])
            ->take(4)
            ->get();

        $this->treeData[$currentLevel][] = [
            'parent' => $userId,
            'referrals' => $referrals
        ];

        foreach ($referrals as $referral) {
            $this->buildTree($referral->id, $currentLevel + 1);
        }
    }

    public function showUserDetails($userId)
    {
        $this->selectedUser = User::with('referrer:id,name')
            ->select('id', 'name', 'picture', 'email', 'phone', 'referred_by', 'level')
            ->find($userId);
            
        // Check if user has paid
        $this->hasPaid = Payment::where('user_id', $userId)
            ->where('status', 'paid')
            ->exists();
            
        $this->showModal = true;
    }
} --}}

{{-- <main class="p-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-semibold text-center mb-2">Referral Network</h1>
        <p class="text-gray-600 text-center mb-6">View your downline structure and team members</p>

        <!-- Current User Card -->
        <div class="flex justify-center mb-8">
            <div class="flex flex-col items-center">
                <div wire:click="showUserDetails({{ $currentUser->id }})" 
                     class="w-20 h-20 rounded-full overflow-hidden border-4 border-gold-400 shadow-lg flex items-center justify-center bg-white cursor-pointer hover:border-blue-500 transition-colors">
                    @if ($currentUser->picture)
                        <img src="{{ Storage::url($currentUser->picture) }}" 
                             alt="Profile Photo"
                             class="w-full h-full object-cover">
                    @else
                        <svg class="w-12 h-12 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>
                <span class="text-sm font-medium mt-2">{{ $currentUser->name }}</span>
                <div class="w-px h-8 bg-gray-300 mt-2"></div>
            </div>
        </div>
        
        <div class="overflow-x-auto min-w-max">
            @foreach ($treeData as $level => $nodes)
                <div class="flex justify-center mb-8">
                    <div class="flex flex-wrap justify-center gap-8">
                        @foreach ($nodes as $node)
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    @foreach ($node['referrals'] as $index => $referral)
                                        <div class="flex flex-col items-center">
                                            <div wire:click="showUserDetails({{ $referral->id }})" 
                                                 class="w-14 h-14 rounded-full overflow-hidden border-2 border-gold-400 shadow-lg flex items-center justify-center bg-white cursor-pointer hover:border-blue-500 transition-colors">
                                                @if ($referral->picture)
                                                    <img src="{{ Storage::url($referral->picture) }}" 
                                                         alt="Profile Photo"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <span class="text-xs font-medium mt-1">{{ $referral->name }}</span>
                                            
                                            @if ($level < count($treeData))
                                                <div class="w-px h-6 bg-gray-300 mt-2"></div>
                                            @endif
                                        </div>
                                        
                                        @if ($index < count($node['referrals']) - 1)
                                            <div class="w-full flex justify-center">
                                                <div class="w-8 h-px bg-gray-300 my-2"></div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- User Details Modal -->
    @if ($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 dark:bg-zinc-900 dark:bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold dark:text-white">User Details</h3>
                <button wire:click="$set('showModal', false)" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex items-center mb-4">
                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gold-400 dark:border-gold-600 mr-4">
                    @if ($selectedUser->picture)
                        <img src="{{ Storage::url($selectedUser->picture) }}" 
                             alt="Profile Photo"
                             class="w-full h-full object-cover">
                    @else
                        <svg class="w-full h-full text-yellow-500 dark:text-yellow-400 p-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <h4 class="text-lg font-semibold dark:text-white">{{ $selectedUser->name }}</h4>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Referral Code: {{ $selectedUser->referral_code ?? "N/A" }}</p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Referred By: {{ $selectedUser->referrer->name ?? 'N/A' }}</p>
                    <p class="text-sm {{ $hasPaid ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        Status: {{ $hasPaid ? 'Paid' : 'Unpaid' }}
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="font-medium dark:text-white">Phone:</span>
                    <span class="dark:text-zinc-300">{{ $selectedUser->phone ?? "N/A" }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium dark:text-white">Email:</span>
                    <span class="dark:text-zinc-300">{{ $selectedUser->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium dark:text-white">Board:</span>
                    <span class="dark:text-zinc-300">ROUND {{ $selectedUser->level }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</main> --}}
