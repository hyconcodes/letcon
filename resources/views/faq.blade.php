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
        <div class="absolute inset-0 bg-letcon-primary opacity-30"></div>
        {{-- <div class="absolute inset-0 bg-letcon-gold opacity-20"></div> --}}

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
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">How credible is Letcon?</h3>
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
                            <p class="text-letcon-neutral-700">Letcon is a fully registered company in Nigeria with the CAC. 
                                We are also registered with the Federal Ministry of Trade and Investment as a fully operative 
                                Cooperative Body. Additionally, we ensure transparency, fraud deterrence and external auditing via 
                                The Special Control Unit Against Money Laundering (SCUML) by the EFCC.
                            </p>
                        </div>
                    </div>
                    <!-- FAQ Item 2 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Who is eligible for Letcon membership?</h3>
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
                            <p class="text-letcon-neutral-700">Letcon global is currently restricted to persons from Nigeria. Anybody of considerable age (+18) with a credible bank account is eligible to be a member of the Letcon Community. Letcon does not discriminate on gender, race or religion.</p>
                        </div>
                    </div>
                    <!-- FAQ Item 3 -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Who can I make complaints or inquiries to?</h3>
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
                            <p class="text-letcon-neutral-700">We are very concerned about timely response to questions or any issues our members/prospective members may be facing. You can use the contact form on the Contact Us page to send inquiry. Our support team will respond to it within 24hrs.</p>
                        </div>
                    </div>

                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = activeAccordion === 4 ? null : 4"
                            class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-letcon-neutral-50 transition-colors">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">How can I become a member?</h3>
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
                            <p class="text-letcon-neutral-700">To become a member of the Letcon community, you we register and get your community.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    

                    

                    <!-- FAQ Item 7 -->
                    

                    <!-- FAQ Item 8 -->
                    
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
