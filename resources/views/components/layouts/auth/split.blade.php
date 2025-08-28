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
                {{ config('app.name', 'letcon') }}
            </a>
            <div class="relative z-20 flex-grow mt-8">
                <div class="relative">
                    <img src="{{ asset('assets/people-2.jpg') }}" alt="Background image"
                        class="h-full w-full object-cover rounded-lg opacity-60">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            @php
                                $systemQuotes = [
                                    "Shop Smart, Live Better",
                                    "Your Success, Our Priority",
                                    "Building Wealth Through Smart Commerce",
                                    "Where Shopping Meets Financial Freedom",
                                    "Empowering Your Business Journey"
                                ];
                                $message = $systemQuotes[array_rand($systemQuotes)];
                            @endphp
                            <h2 class="text-3xl font-bold text-white mb-2">Welcome to Success!</h2>
                            <p class="text-lg text-white">TRANSFORMING COMMERCE & FINANCE</p>
                            <p class="text-lg text-white">EMPOWERING ENTREPRENEURS</p>
                            <br>
                            <p class="text-lg text-white">&ldquo;{{ $message }}&rdquo;</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative z-20 mt-auto">
                <div class="space-y-2 text-center">
                    <flux:heading size="lg" class="text-2xl font-bold" tag="h1">
                        Smart Commerce | Financial Empowerment
                    </flux:heading>
                    <div class="mt-4">
                        <flux:heading class="text-lg opacity-90" tag="h2">
                            Join our thriving marketplace where business meets financial growth. We provide cutting-edge tools and resources to help you build, scale, and manage your online business while maximizing your financial potential.
                        </flux:heading>
                        <meta name="description" content="Premier e-commerce platform offering comprehensive business solutions and financial empowerment tools. Join our community of successful entrepreneurs and unlock your business potential today.">
                        <meta name="keywords" content="e-commerce platform, financial empowerment, online business, digital marketplace, business growth, entrepreneurship, smart commerce">
                    </div>
                </div>
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
