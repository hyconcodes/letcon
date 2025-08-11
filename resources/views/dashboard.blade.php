<x-layouts.app :title="__(config('app.name') . ' - Dashboard')">
    @if(session('status'))
        <div id="alert-message" class="relative bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('status') }}
            <button onclick="closeAlert()" class="absolute top-1/2 right-4 transform -translate-y-1/2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <script>
            // Auto-hide alert after 3 seconds
            setTimeout(function() {
                document.getElementById('alert-message')?.remove();
            }, 3000);

            // Function to close alert manually
            function closeAlert() {
                document.getElementById('alert-message')?.remove();
            }
        </script>
    @endif
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3 lg:grid-cols-5">
            <!-- Current Balance Card - Blue -->
            <div class="relative overflow-hidden rounded-xl bg-blue-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Current Balance</p>
                    <p class="text-2xl font-bold">₦{{ number_format(Auth::user()->wallet()->sum('earned_balance') ?? 0, 2) }}</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button>
            </div>

            <!-- Total Deposit Card - Purple -->
            <div class="relative overflow-hidden rounded-xl bg-purple-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Total Deposit</p>
                    <p class="text-2xl font-bold">₦{{ number_format(Auth::user()->payment()->where('status', 'paid')->sum('amount') ?? 0, 2) }}</p>
                </div>
                <a href="{{ route('deposits.log') }}" class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30">View</a>
            </div>
            <!-- Total Withdraw Card - Green -->
            <div class="relative overflow-hidden rounded-xl bg-green-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Total Withdraw</p>
                    <p class="text-2xl font-bold">₦0.00</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button>
            </div>


            <!-- Pending Withdraw Card - Orange -->
            <div class="relative overflow-hidden rounded-xl bg-orange-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Pending Withdraw</p>
                    <p class="text-2xl font-bold">₦0.00</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button>
            </div>

            <!-- Reject Withdraw Card - Red -->
            <div class="relative overflow-hidden rounded-xl bg-red-500 p-4 text-white shadow-lg">
                <svg class="absolute right-2 top-2 h-8 w-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <div class="mb-4">
                    <p class="text-sm opacity-75">Reject Withdraw</p>
                    <p class="text-2xl font-bold">₦0.00</p>
                </div>
                <button class="rounded-lg bg-white/20 px-3 py-1 text-sm hover:bg-white/30">View</button>
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-xl font-bold">Transaction History</h2>
            <!-- Add transaction history content here -->
        </div>
    </div>
</x-layouts.app>
