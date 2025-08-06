<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <div
            class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800">
            <div class="absolute inset-0 bg-neutral-900"></div>
            <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                <span class="flex h-10 w-10 items-center justify-center rounded-md">
                    <x-app-logo-icon class="me-2 h-7 fill-current text-white" />
                </span>
                {{ config('app.name', 'Laravel') }}
            </a>
            <div class="relative z-20 flex-grow mt-8">
                <div class="relative">
                    <img src="{{ asset('assets/people-2.jpg') }}" alt="Background image"
                        class="h-full w-full object-cover rounded-lg opacity-60">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            @php
                                $financialQuotes = [
                                    ["The best investment you can make is in yourself.", "Warren Buffett"],
                                    ["An investment in knowledge pays the best interest.", "Benjamin Franklin"],
                                    ["The stock market is filled with individuals who know the price of everything, but the value of nothing.", "Philip Fisher"],
                                    ["Risk comes from not knowing what you're doing.", "Warren Buffett"],
                                    ["The four most dangerous words in investing are: 'this time it's different.'", "Sir John Templeton"]
                                ];
                                $randomQuote = $financialQuotes[array_rand($financialQuotes)];
                                [$message, $author] = $randomQuote;
                            @endphp
                            <h2 class="text-3xl font-bold text-white mb-2">Welcome Back!</h2>
                            <p class="text-lg text-white">Sign in to manage your finances</p>
                            <br>
                            <br>
                            <p class="text-lg text-white">&ldquo;{{ $message }}&rdquo;</p>
                            <p class="text-lg text-white">{{ $author }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @php
                [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
            @endphp

            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <flux:heading size="lg">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                    <footer>
                        <flux:heading>{{ trim($author) }}</flux:heading>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="w-full lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden"
                    wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                    </span>

                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
