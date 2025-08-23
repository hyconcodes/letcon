<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Letcon - Global Financial Empowerment Platform | Sustainable Wealth Building</title>
    <meta name="description"
        content="Join Letcon's global financial empowerment platform. Build sustainable income through structured referrals, transparent upgrades, and community-driven wealth growth. Start your financial journey today." />
    <meta name="keywords"
        content="Letcon, financial empowerment, referral system, community wealth, sustainable income, wealth building, financial growth, global platform" />
    <meta name="author" content="Letcon" />
    <link rel="canonical" href="/" />

    <meta property="og:title" content="Letcon - Global Financial Empowerment Platform" />
    <meta property="og:description"
        content="Build sustainable income through structured referrals and community-driven wealth growth with Letcon." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('logo.png') }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@letconglobal" />
    <meta name="twitter:image" content="{{ asset('logo.png') }}" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'letcon-primary': 'hsl(142, 75%, 35%)',
                        'letcon-primary-light': 'hsl(142, 65%, 55%)',
                        'letcon-primary-dark': 'hsl(142, 85%, 25%)',
                        'letcon-gold': 'hsl(45, 95%, 50%)',
                        'letcon-gold-light': 'hsl(45, 85%, 65%)',
                        'letcon-gold-dark': 'hsl(35, 85%, 40%)',
                        'letcon-neutral-50': 'hsl(210, 20%, 98%)',
                        'letcon-neutral-100': 'hsl(210, 15%, 95%)',
                        'letcon-neutral-200': 'hsl(210, 10%, 87%)',
                        'letcon-neutral-700': 'hsl(210, 15%, 25%)',
                        'letcon-neutral-900': 'hsl(210, 20%, 15%)',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="font-inter antialiased bg-letcon-neutral-50 text-letcon-neutral-900">
    <!-- Header -->
    <x-header/>

    <!-- Hero Section -->
    <section class="relative min-h-screen py-20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/people-1.webp') }}')"></div>
        <div class="absolute inset-0 bg-letcon-primary opacity-40"></div>
        <div class="absolute inset-0 bg-letcon-gold opacity-20"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                    Frequently Asked Questions
                </h1>
                <p class="text-xl text-white">
                    Everything you need to know about Letcon
                </p>
            </div>

            <div class="max-w-4xl mx-auto space-y-4">
                <!-- FAQ Accordion Items -->
                <div x-data="{ activeAccordion: null }" class="space-y-4">
                    <!-- FAQ Item 1 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">What is Letcon?</h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 1 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 1" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700">Letcon is a structured earning platform built on a
                                geometric progression (GP) pyramid system. It allows members to grow step by step
                                through defined levels, doubling their income potential while expanding their community.
                            </p>
                        </div>
                    </div>
                    <!-- FAQ Item 2 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">How do I join Letcon?</h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 2 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 2" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700">You can join Letcon by registering and making a one-time
                                payment of ₦20,000. Once your payment is confirmed, you start at Level 1 and can begin
                                referring others.</p>
                        </div>
                    </div>
                    <!-- FAQ Item 3 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Do I need to keep paying money to
                                move up levels?</h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 3 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 3" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700">No. Only the first ₦20,000 one-time payment is required.
                                Upgrades to higher levels happen automatically when you meet the referral and downline
                                requirements — no extra payments are needed.</p>
                        </div>
                    </div>

                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 4 ? null : 4"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">How do I move from one level to
                                another?</h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 4 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 4" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700">Advancement depends on:</p>
                            <ul class="list-disc ml-6 mt-2 space-y-2 text-letcon-neutral-700">
                                <li>Having required referrals (direct or indirect)</li>
                                <li>Ensuring your downlines have also upgraded</li>
                                <li>System checks based on registration order (first come, first move)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 5 ? null : 5"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">How much can I earn on Letcon?
                            </h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 5 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 5" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700 mb-3">Earnings progress with each level:</p>
                            <ul class="space-y-2 text-letcon-neutral-700">
                                <li><span class="font-semibold">Royal (Levels 2–3):</span> ₦32,000 – ₦64,000</li>
                                <li><span class="font-semibold">Golden (Levels 4–6):</span> ₦128,000 – ₦512,000</li>
                                <li><span class="font-semibold">Millionaire (Levels 7–10):</span> ₦1,024,000 –
                                    ₦20,000,000</li>
                                <li class="mt-4 font-semibold">Total Potential Earnings: ₦28,180,000+</li>
                            </ul>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 6 ? null : 6"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">How is the money I earn stored?
                            </h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 6 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 6" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700">
                                Earnings are automatically recorded in your Letcon wallet. From there, you can withdraw
                                or use it within the system, depending on platform policies.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 7 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 7 ? null : 7"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Is Letcon safe and transparent?
                            </h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 7 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 7" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700">
                                Yes. The platform runs on a strict earning logic with proper record-keeping, logging,
                                and fairness. Every user's progression and earnings are trackable, leaving no room for
                                hidden deductions.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 8 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 8 ? null : 8"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Can I join Letcon without
                                referring people?</h3>
                            <svg :class="{ 'rotate-180': activeAccordion === 8 }"
                                class="w-6 h-6 transform transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeAccordion === 8" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="px-8 pb-6">
                            <p class="text-letcon-neutral-700">
                                Referrals are important for growth, but the system is built to support community effort.
                                Even if you don't directly refer many, you can still benefit from downline support as
                                the structure expands.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alpine.js for accordion functionality -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Footer -->
    <x-footer />

</body>

</html>
