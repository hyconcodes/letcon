<x-layouts.app :title="__(config('app.name') . ' - Dashboard')">
    @if (session('status'))
        <div id="alert-message" class="relative bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('status') }}
            <button onclick="closeAlert()" class="absolute top-1/2 right-4 transform -translate-y-1/2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('alert-message')?.remove();
            }, 3000);

            function closeAlert() {
                document.getElementById('alert-message')?.remove();
            }
        </script>
    @endif

    @php
        $user = Auth::user();
        $totalPaidAmount = $user->payment()->where('status', 'paid')->sum('amount');
        $incompleteProfile =
            !$user->phone ||
            !$user->picture ||
            !$user->country ||
            !$user->state ||
            !$user->city ||
            !$user->address ||
            !$user->bank_name ||
            !$user->bank_account_name ||
            !$user->bank_account_number ||
            !$user->pin;
    @endphp

    @if ($incompleteProfile)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
            <p class="font-bold">Important Notice!</p>
            <p>Please complete your profile by updating the following information:</p>
        </div>
    @endif

    @if ($totalPaidAmount < 20000)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
            <p class="font-bold">Deposit Requirement Notice!</p>
            <p>Note that withdrawals are only available from level 2.</p>
        </div>
    @endif

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3 lg:grid-cols-5">
            <!-- Current Balance Card - Blue -->
            <div class="relative overflow-hidden rounded-xl bg-blue-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Current Balance</p>
                    <p class="text-1xl font-bold">
                        ₦{{ number_format(Auth::user()->wallet()->sum('earned_balance') ?? 0, 2) }}</p>
                </div>
                {{-- <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button> --}}
            </div>

            <!-- Total Deposit Card - Purple -->
            <div class="relative overflow-hidden rounded-xl bg-purple-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Total Deposit</p>
                    <p class="text-1xl font-bold">₦{{ number_format($totalPaidAmount, 2) }}</p>
                </div>
                <div class="flex justify-between">
                    <a href="{{ route('deposits.log') }}"
                        class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30">View</a>
                    @if ($totalPaidAmount <= 0)
                        <a href="{{ route('boards') }}"
                            class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30">Deposit</a>
                    @endif
                </div>
            </div>

            <!-- Total Withdraw Card - Green -->
            <div class="relative overflow-hidden rounded-xl bg-green-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Total Withdraw</p>
                    <p class="text-1xl font-bold">₦0.00</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button>
            </div>

            <!-- Pending Withdraw Card - Orange -->
            <div class="relative overflow-hidden rounded-xl bg-orange-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Pending Withdraw</p>
                    <p class="text-1xl font-bold">₦0.00</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button>
            </div>

            <!-- Reject Withdraw Card - Red -->
            <div class="relative overflow-hidden rounded-xl bg-red-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Reject Withdraw</p>
                    <p class="text-1xl font-bold">₦0.00</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button>
            </div>
        </div>

        @php
            $latestNotification = \App\Models\Notification::latest()->first();
        @endphp

        @if($latestNotification)
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex items-start space-x-4 mb-6 bg-gradient-to-r from-emerald-500 to-blue-500 p-6 rounded-lg">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white">{{ $latestNotification->title ?? 'New Notification' }}</h2>
                        <span class="px-2 py-1 text-xs rounded-full bg-white/20 text-white">
                            {{ ucfirst($latestNotification->type ?? 'info') }}
                        </span>
                    </div>
                    <p class="mt-2 text-white/90">{{ $latestNotification->body }}</p>
                    @if($latestNotification->link)
                        <a href="{{ $latestNotification->link }}" class="inline-block mt-3 text-sm text-white hover:text-white/80">
                            Learn more →
                        </a>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <h2 class="text-xl font-bold mb-4">Transaction History</h2>
                <!-- Add transaction history content here -->
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>
