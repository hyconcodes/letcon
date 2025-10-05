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
                        <div class="text-center text-white space-y-3">
                            <h2 class="text-2xl font-bold text-white mb-3">About Letcon Global</h2>
                            <div class="space-y-2 text-sm leading-relaxed max-w-md mx-auto">
                                <p><strong>Letcon Global Company Ltd</strong> is a Digitalised Cooperative System blending traditional African contribution systems (Ajo/Osusu) with modern financial technology.</p>

                                <p>We provide a transparent, structured platform for sustainable financial growth.</p>

                                <div class="mt-3 p-2 bg-black/20 rounded">
                                    <p class="font-semibold text-yellow-300 mb-1">🏛️ Government Certified</p>
                                    <p class="text-xs">Registered with C.A.C, SCUML, and Federal Ministry of Industry, Trade & Investment</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative z-20 mt-auto">
                <div class="space-y-4 text-center">
                    <div class="space-y-3">
                        <h3 class="text-lg font-bold text-yellow-300">Our Mission</h3>
                        <p class="text-sm opacity-90">To democratise wealth creation by transforming age-old cooperative savings into a scalable, digitised ecosystem that guarantees fairness, transparency, and long-term financial empowerment.</p>
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
