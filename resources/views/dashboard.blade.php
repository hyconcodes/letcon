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
                    <p class="text-1xl font-bold">₦{{ number_format(Auth::user()->wallet()->sum('total_withdraw') ?? 0, 2) }}</p>
                </div>
                <div class="flex justify-between gap-2">
                    <a href="{{ route('withdrawal.log') }}"
                        class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30">View</a>
                    <a href="{{ route('withdrawal') }}"
                        class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30">Withdraw</a>
                </div>
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
                    <p class="text-1xl font-bold">₦{{ number_format(Auth::user()->wallet()->sum('pending_withdraw') ?? 0, 2) }}</p>
                </div>
                <a href="{{ route('withdrawal.log') }}"
                    class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30">View</a>
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
                    <p class="text-1xl font-bold"></p>
                </div>
                <a href="{{ route('withdrawal.log') }}"
                    class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30">View</a>
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
                {{-- <h2 class="text-xl font-bold mb-4">Transaction History</h2> --}}
                {{-- <h2 class="text-xl font-bold mb-4">......</h2> --}}
                <img src="{{ asset('assets/lecton-dash.png') }}" alt="">
                <!-- Add transaction history content here -->
            </div>
        </div>
        @endif
    </div>

    <!-- WhatsApp Floating Icon -->
    <a href="https://wa.me/2347032468725" 
       target="_blank"
       class="fixed bottom-4 right-4 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-colors duration-300 z-50 flex items-center justify-center">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>

    <!-- Email Floating Icon -->
    <a href="mailto:letconglobalcompany@gmail.com"
       class="fixed bottom-20 right-4 bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600 transition-colors duration-300 z-50 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </a>
</x-layouts.app>
