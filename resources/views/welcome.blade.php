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
    <section class="relative min-h-screen flex items-center py-20 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/people-1.webp') }}')"></div>

        <!-- Green overlay -->
        <div class="absolute inset-0 bg-letcon-primary opacity-40"></div>

        <!-- Gold overlay -->
        <div class="absolute inset-0 bg-letcon-gold opacity-20"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid lg:grid-cols-1 gap-12 items-center">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h1 class="text-5xl lg:text-6xl font-bold text-white leading-tight">
                            The World's First
                            <span class="gradient-hero bg-clip-text text-transparent">Digital Contribution System</span>
                        </h1>
                        <p class="text-xl text-white leading-relaxed">
                            Pioneer the future with Letcon - the first company globally to implement an automated control system 
                            using pyramid progression patterns. Experience revolutionary digital contribution management
                            that's changing how wealth building works.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="btn-hero btn-xl text-lg"
                            onclick="window.location.href = '{{ route('register') }}'">
                            Get Started Today
                        </button>
                        <button
                            class="btn-outline-hero btn-xl text-lg border-white text-white hover:bg-white hover:text-letcon-primary">
                            Learn More
                        </button>
                    </div>

                    <div class="flex items-center space-x-8 text-sm text-white">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                            <span>100% Transparent</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-letcon-gold rounded-full"></div>
                            <span>Community Driven</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                            <span>Sustainable Growth</span>
                        </div>
                    </div>
                </div>

                <div class="relative hidden">
                    <div class="relative z-10 transform hover:scale-105 transition-transform duration-500">
                        <img src="{{ asset('assets/letcon-hero-image.jpg') }}"
                            alt="Financial empowerment and community growth - diverse professionals collaborating for wealth building"
                            class="w-full h-auto rounded-2xl shadow-elevation-3" />
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 gradient-accent rounded-full opacity-20 blur-xl">
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 gradient-hero rounded-full opacity-20 blur-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-letcon-neutral-50">
        <div class="container mx-auto px-4">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl font-bold text-letcon-neutral-900">About Letcon</h2>
                <p class="text-xl text-letcon-neutral-700 max-w-3xl mx-auto">
                    We are the world's first digital contribution company implementing an automated control system
                    based on pyramid progression patterns. Our revolutionary platform sets new standards in
                    financial technology, offering a structured and systematic approach to wealth building.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card group">
                    <div class="p-8 text-center space-y-4">
                        <div
                            class="mx-auto w-16 h-16 gradient-hero rounded-2xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-letcon-neutral-900">Wealth Empowerment</h3>
                        <p class="text-letcon-neutral-700 leading-relaxed">Build sustainable income through proven
                            strategies and transparent financial growth opportunities.</p>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 text-center space-y-4">
                        <div
                            class="mx-auto w-16 h-16 gradient-hero rounded-2xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-letcon-neutral-900">Structured Referrals</h3>
                        <p class="text-letcon-neutral-700 leading-relaxed">Benefit from a fair and transparent referral
                            system designed to reward community building and collaboration.</p>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 text-center space-y-4">
                        <div
                            class="mx-auto w-16 h-16 gradient-hero rounded-2xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-letcon-neutral-900">Transparent Upgrades</h3>
                        <p class="text-letcon-neutral-700 leading-relaxed">Clear, honest progression paths with no
                            hidden fees or surprise requirements. Your success is our success.</p>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 text-center space-y-4">
                        <div
                            class="mx-auto w-16 h-16 gradient-hero rounded-2xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-letcon-neutral-900">Community Growth</h3>
                        <p class="text-letcon-neutral-700 leading-relaxed">Join a supportive network focused on
                            collective success and sustainable wealth building for all members.</p>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center">
                <div class="gradient-subtle rounded-2xl p-8 md:p-12">
                    <h3 class="text-2xl font-bold text-letcon-neutral-900 mb-4">Our Mission</h3>
                    <p class="text-lg text-letcon-neutral-700 max-w-4xl mx-auto leading-relaxed">
                        To democratize wealth building by creating a transparent, community-focused platform where
                        every member has the opportunity to achieve financial empowerment through structured growth,
                        mutual support, and sustainable income generation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 gradient-subtle">
        <div class="container mx-auto px-4">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl font-bold text-letcon-neutral-900">How Letcon Works</h2>
                <p class="text-xl text-letcon-neutral-700 max-w-3xl mx-auto">
                    As the world's first digital contribution company, we operate an innovative automated control system 
                    based on pyramid progression patterns. Experience a revolutionary approach to structured financial growth.
                </p>
            </div>

            <!-- Steps Process -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
                <div class="relative">
                    <div class="card h-full">
                        <div class="p-8 text-center space-y-6">
                            <div class="relative">
                                <div
                                    class="w-16 h-16 gradient-hero rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-letcon-gold rounded-full flex items-center justify-center text-xs font-bold text-letcon-neutral-900">
                                    01</div>
                            </div>
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Join the Community</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Sign up and become part of our global
                                financial empowerment network. Start your journey with transparent onboarding and clear
                                expectations.</p>
                        </div>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 transform -translate-y-1/2 z-10">
                        <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <div class="card h-full">
                        <div class="p-8 text-center space-y-6">
                            <div class="relative">
                                <div
                                    class="w-16 h-16 gradient-hero rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-letcon-gold rounded-full flex items-center justify-center text-xs font-bold text-letcon-neutral-900">
                                    02</div>
                            </div>
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Build Your Network</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Invite others to join and benefit from
                                our structured referral system. Every referral strengthens both your network and earning
                                potential.</p>
                        </div>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 transform -translate-y-1/2 z-10">
                        <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <div class="card h-full">
                        <div class="p-8 text-center space-y-6">
                            <div class="relative">
                                <div
                                    class="w-16 h-16 gradient-hero rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-letcon-gold rounded-full flex items-center justify-center text-xs font-bold text-letcon-neutral-900">
                                    03</div>
                            </div>
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Achieve Level Growth</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Move up step by step like a pyramid —
                                each level doubles your earnings and grows your community.</p>
                        </div>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 transform -translate-y-1/2 z-10">
                        <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <div class="card h-full">
                        <div class="p-8 text-center space-y-6">
                            <div class="relative">
                                <div
                                    class="w-16 h-16 gradient-hero rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-letcon-gold rounded-full flex items-center justify-center text-xs font-bold text-letcon-neutral-900">
                                    04</div>
                            </div>
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Earn Sustainable Income</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Generate consistent returns through
                                community growth, level bonuses, and transparent reward structures designed for
                                long-term success.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Levels System -->
            <div class="space-y-12">
                <div class="text-center">
                    <h3 class="text-3xl font-bold text-letcon-neutral-900 mb-4">Growth Levels & Benefits</h3>
                    <p class="text-lg text-letcon-neutral-700 max-w-2xl mx-auto">
                        Progress through our transparent level system with clear requirements and increasing benefits at
                        each stage.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Royal -->
                    <div class="card border-2 border-letcon-primary">
                        <div class="p-6 space-y-4">
                            <div class="text-center">
                                <h4 class="text-xl font-bold text-letcon-neutral-900 mb-2">Royal</h4>
                                <p class="text-sm text-letcon-neutral-700 font-medium">Starter Earners (Level 2–3)</p>
                            </div>

                            <div class="space-y-2">
                                <p class="text-sm text-letcon-neutral-700">
                                    Begin your journey as a Royal member. This stage is for new earners unlocking their
                                    first steps of growth, building a foundation and earning between levels 2 and 3.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Golden -->
                    <div class="card border-2 border-letcon-gold">
                        <div class="p-6 space-y-4">
                            <div class="text-center">
                                <h4 class="text-xl font-bold text-letcon-neutral-900 mb-2">Golden</h4>
                                <p class="text-sm text-letcon-neutral-700 font-medium">Higher Earners (Level 4–6)</p>
                            </div>

                            <div class="space-y-2">
                                <p class="text-sm text-letcon-neutral-700">
                                    Golden members are established achievers with growing influence and income. At this
                                    stage, earners advance steadily through levels 4 to 6 with higher rewards and
                                    recognition.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Millionaire -->
                    <div class="card border-2 border-letcon-gold-dark">
                        <div class="p-6 space-y-4">
                            <div class="text-center">
                                <h4 class="text-xl font-bold text-letcon-neutral-900 mb-2">Millionaire</h4>
                                <p class="text-sm text-letcon-neutral-700 font-medium">Max Earners (Level 7–10)</p>
                            </div>

                            <div class="space-y-2">
                                <p class="text-sm text-letcon-neutral-700">
                                    The ultimate stage of Letcon’s empowerment journey. Millionaire members dominate
                                    levels 7 to 10, unlocking maximum earnings, legacy rewards, and global recognition.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="text-center">
                    <button class="btn-hero btn-lg" onclick="window.location.href = '{{ route('register') }}'">Start
                        Your Journey Today</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-20 bg-letcon-neutral-50">
        <div class="container mx-auto px-4">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl font-bold text-letcon-neutral-900">Why Choose Letcon</h2>
                <p class="text-xl text-letcon-neutral-700 max-w-3xl mx-auto">
                    Join the world's first digital contribution company implementing an automated control system based on pyramid progression patterns. Experience a revolutionary approach to financial growth through our innovative platform.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                {{-- <div class="card group">
                    <div class="p-8 space-y-4">
                        <div
                            class="w-14 h-14 gradient-hero rounded-xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Sustainable Income</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Build multiple revenue streams through
                                referrals, level bonuses, and community growth rewards.</p>
                            <div class="text-sm font-medium text-letcon-primary">Up to 40% commission rates</div>
                        </div>
                    </div>
                </div> --}}

                <div class="card group">
                    <div class="p-8 space-y-4">
                        <div
                            class="w-14 h-14 gradient-hero rounded-xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Global Community</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Connect with like-minded individuals
                                worldwide, sharing knowledge and supporting each other's success.</p>
                            <div class="text-sm font-medium text-letcon-primary">Members in 50+ countries</div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-4">
                        <div
                            class="w-14 h-14 gradient-hero rounded-xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Fast Growth Potential</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Accelerate your financial journey with
                                proven strategies and structured advancement opportunities.</p>
                            <div class="text-sm font-medium text-letcon-primary">Average 3x growth in year 1</div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-4">
                        <div
                            class="w-14 h-14 gradient-hero rounded-xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Life-Changing Impact</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Transform not just your finances, but
                                your entire approach to wealth building and community support.</p>
                            <div class="text-sm font-medium text-letcon-primary">94% member satisfaction</div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-4">
                        <div
                            class="w-14 h-14 gradient-hero rounded-xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Complete Transparency</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">No hidden fees, clear requirements, and
                                honest communication about opportunities and expectations.</p>
                            <div class="text-sm font-medium text-letcon-primary">100% fee transparency</div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-4">
                        <div
                            class="w-14 h-14 gradient-hero rounded-xl flex items-center justify-center group-hover:shadow-glow-primary transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-semibold text-letcon-neutral-900">Recognition & Rewards</h3>
                            <p class="text-letcon-neutral-700 leading-relaxed">Celebrate achievements with community
                                recognition, exclusive events, and milestone rewards.</p>
                            <div class="text-sm font-medium text-letcon-primary">Monthly recognition programs</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Highlights -->
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div>
                        <h3 class="text-3xl font-bold text-letcon-neutral-900 mb-4">Built for Your Success</h3>
                        <p class="text-lg text-letcon-neutral-700 leading-relaxed mb-6">
                            Every aspect of Letcon is designed with your financial empowerment in mind.
                            From transparent processes to supportive community features, we've created
                            an ecosystem where your success is inevitable.
                        </p>
                    </div>

                    <div class="space-y-4">
                        {{-- <div class="flex items-start space-x-4">
                            <div
                                class="w-6 h-6 gradient-hero rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <div class="w-2 h-2 bg-white rounded-full"></div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-letcon-neutral-900">Proven Track Record</h4>
                                <p class="text-letcon-neutral-700">Thousands of success stories from members who've
                                    achieved financial freedom.</p>
                            </div>
                        </div> --}}

                        <div class="flex items-start space-x-4">
                            <div
                                class="w-6 h-6 gradient-hero rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <div class="w-2 h-2 bg-white rounded-full"></div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-letcon-neutral-900">Continuous Support</h4>
                                <p class="text-letcon-neutral-700">24/7 community support, training resources, and
                                    mentorship opportunities.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div
                                class="w-6 h-6 gradient-hero rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <div class="w-2 h-2 bg-white rounded-full"></div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-letcon-neutral-900">Scalable Growth</h4>
                                <p class="text-letcon-neutral-700">Start at any level and scale your earnings as your
                                    network and skills grow.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-6">
                        <img src="{{ asset('assets/letcon-community-icon-Bwn6nnFj.jpg') }}"
                            alt="Community growth and networking - interconnected people building wealth together"
                            class="w-full h-48 object-cover rounded-2xl shadow-elevation-2" />
                        <div class="text-center p-6 gradient-subtle rounded-xl">
                            <div class="text-2xl font-bold text-letcon-primary mb-1">10,000+</div>
                            <div class="text-sm text-letcon-neutral-700">Active Members</div>
                        </div>
                    </div>

                    {{-- <div class="space-y-6 mt-8">
                        <div class="text-center p-6 gradient-accent rounded-xl">
                            <div class="text-2xl font-bold text-white mb-1">$2.5M+</div>
                            <div class="text-sm text-white/80">Total Earnings Distributed</div>
                        </div>
                        <img src="src/assets/growth-icon.jpg"
                            alt="Financial growth and wealth building - upward trending graphs representing income growth"
                            class="w-full h-48 object-cover rounded-2xl shadow-elevation-2" />
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 gradient-subtle hidden">
        <div class="container mx-auto px-4">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl font-bold text-letcon-neutral-900">Success Stories</h2>
                <p class="text-xl text-letcon-neutral-700 max-w-3xl mx-auto">
                    Hear from real members who have transformed their financial lives through
                    Letcon's community-driven wealth building platform.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="card group">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center justify-between">
                            <svg class="w-8 h-8 text-letcon-primary opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <div class="flex space-x-1">
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </div>
                        </div>

                        <blockquote class="text-letcon-neutral-700 leading-relaxed italic">
                            "Letcon transformed my financial future. In just 18 months, I've built a sustainable income
                            stream that exceeds my day job. The community support is incredible."
                        </blockquote>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-letcon-neutral-900">Sarah Chen</div>
                                    <div class="text-sm text-letcon-neutral-700">Singapore</div>
                                    <div class="text-sm text-letcon-neutral-700">Digital Marketing Specialist</div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-letcon-neutral-200">
                                <div
                                    class="text-sm font-medium text-letcon-primary bg-letcon-primary/10 px-3 py-1 rounded-full inline-block">
                                    Built $4,200/month passive income
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center justify-between">
                            <svg class="w-8 h-8 text-letcon-primary opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <div class="flex space-x-1">
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </div>
                        </div>

                        <blockquote class="text-letcon-neutral-700 leading-relaxed italic">
                            "The transparency was what convinced me to join. Every step is clearly explained, and there
                            are no hidden surprises. I've achieved financial freedom I never thought possible."
                        </blockquote>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-letcon-neutral-900">Marcus Johnson</div>
                                    <div class="text-sm text-letcon-neutral-700">London, UK</div>
                                    <div class="text-sm text-letcon-neutral-700">Former Teacher</div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-letcon-neutral-200">
                                <div
                                    class="text-sm font-medium text-letcon-primary bg-letcon-primary/10 px-3 py-1 rounded-full inline-block">
                                    Reached Champion level in 14 months
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center justify-between">
                            <svg class="w-8 h-8 text-letcon-primary opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <div class="flex space-x-1">
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </div>
                        </div>

                        <blockquote class="text-letcon-neutral-700 leading-relaxed italic">
                            "As someone who's tried many opportunities, Letcon stands out for its genuine community
                            focus. The referral system actually helps everyone succeed together."
                        </blockquote>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-letcon-neutral-900">Elena Rodriguez</div>
                                    <div class="text-sm text-letcon-neutral-700">Mexico City</div>
                                    <div class="text-sm text-letcon-neutral-700">Entrepreneur</div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-letcon-neutral-200">
                                <div
                                    class="text-sm font-medium text-letcon-primary bg-letcon-primary/10 px-3 py-1 rounded-full inline-block">
                                    Helped 50+ people start their journey
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center justify-between">
                            <svg class="w-8 h-8 text-letcon-primary opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <div class="flex space-x-1">
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </div>
                        </div>

                        <blockquote class="text-letcon-neutral-700 leading-relaxed italic">
                            "What I love about Letcon is the structured approach. The levels are clear, the requirements
                            are fair, and the community genuinely wants to see you succeed."
                        </blockquote>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-letcon-neutral-900">James Wilson</div>
                                    <div class="text-sm text-letcon-neutral-700">Toronto, Canada</div>
                                    <div class="text-sm text-letcon-neutral-700">IT Professional</div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-letcon-neutral-200">
                                <div
                                    class="text-sm font-medium text-letcon-primary bg-letcon-primary/10 px-3 py-1 rounded-full inline-block">
                                    Achieved 300% ROI in first year
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center justify-between">
                            <svg class="w-8 h-8 text-letcon-primary opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <div class="flex space-x-1">
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </div>
                        </div>

                        <blockquote class="text-letcon-neutral-700 leading-relaxed italic">
                            "The global community aspect is amazing. I've connected with successful people worldwide and
                            learned strategies I never would have discovered alone."
                        </blockquote>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-letcon-neutral-900">Priya Patel</div>
                                    <div class="text-sm text-letcon-neutral-700">Mumbai, India</div>
                                    <div class="text-sm text-letcon-neutral-700">Financial Consultant</div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-letcon-neutral-200">
                                <div
                                    class="text-sm font-medium text-letcon-primary bg-letcon-primary/10 px-3 py-1 rounded-full inline-block">
                                    Built network across 12 countries
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card group">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center justify-between">
                            <svg class="w-8 h-8 text-letcon-primary opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <div class="flex space-x-1">
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <svg class="w-4 h-4 fill-letcon-gold text-letcon-gold" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </div>
                        </div>

                        <blockquote class="text-letcon-neutral-700 leading-relaxed italic">
                            "Letcon didn't just change my income - it changed my mindset about wealth building. The
                            community-driven approach creates lasting success for everyone involved."
                        </blockquote>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-letcon-neutral-900">David Kim</div>
                                    <div class="text-sm text-letcon-neutral-700">Seoul, South Korea</div>
                                    <div class="text-sm text-letcon-neutral-700">Business Owner</div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-letcon-neutral-200">
                                <div
                                    class="text-sm font-medium text-letcon-primary bg-letcon-primary/10 px-3 py-1 rounded-full inline-block">
                                    Scaled to 6-figure annual earnings
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center">
                <div class="gradient-hero rounded-2xl p-8 md:p-12 text-white">
                    <h3 class="text-2xl font-bold mb-4">Join Thousands of Successful Members</h3>
                    <p class="text-lg text-white/90 max-w-2xl mx-auto mb-6">
                        Every success story started with a single decision to take action.
                        Your financial transformation begins the moment you join our community.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <div class="flex items-center space-x-2">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 bg-white/20 border-2 border-white rounded-full"></div>
                                <div class="w-8 h-8 bg-white/20 border-2 border-white rounded-full"></div>
                                <div class="w-8 h-8 bg-white/20 border-2 border-white rounded-full"></div>
                                <div class="w-8 h-8 bg-white/20 border-2 border-white rounded-full"></div>
                                <div class="w-8 h-8 bg-white/20 border-2 border-white rounded-full"></div>
                            </div>
                            <span class="text-sm">10,000+ members</span>
                        </div>
                        <div class="text-sm">•</div>
                        <div class="text-sm">4.9/5 average rating</div>
                        <div class="text-sm">•</div>
                        <div class="text-sm">94% would recommend</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-letcon-neutral-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="card border-2 border-letcon-primary/20 shadow-elevation-3 overflow-hidden">
                    <div class="gradient-hero p-1">
                        <div class="bg-letcon-neutral-50 m-0 p-12 space-y-8">
                            <div class="text-center space-y-6">
                                <h2 class="text-4xl font-bold text-letcon-neutral-900">
                                    Ready to Transform Your Financial Future?
                                </h2>
                                <p class="text-xl text-letcon-neutral-700 max-w-2xl mx-auto">
                                    Join Letcon today and start building sustainable wealth through our proven
                                    community-driven platform. Your journey to financial empowerment begins now.
                                </p>
                            </div>

                            <div class="grid md:grid-cols-3 gap-6 my-12">
                                <div class="text-center space-y-3">
                                    <div
                                        class="w-12 h-12 gradient-hero rounded-xl flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-letcon-neutral-900">Quick Start</h3>
                                    <p class="text-sm text-letcon-neutral-700">Get started in under 5 minutes with our
                                        streamlined onboarding process</p>
                                </div>

                                <div class="text-center space-y-3">
                                    <div
                                        class="w-12 h-12 gradient-hero rounded-xl flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-letcon-neutral-900">Instant Community</h3>
                                    <p class="text-sm text-letcon-neutral-700">Connect immediately with mentors and
                                        peers ready to support your success</p>
                                </div>

                                <div class="text-center space-y-3">
                                    <div
                                        class="w-12 h-12 gradient-hero rounded-xl flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-letcon-neutral-900">Zero Risk</h3>
                                    <p class="text-sm text-letcon-neutral-700">100% transparent with clear expectations
                                        and no hidden commitments</p>
                                </div>
                            </div>

                            <div class="text-center space-y-6">
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <button class="btn-hero btn-xl text-lg group"
                                        onclick="window.location.href = '{{ route('register') }}'">
                                        Join Letcon Now
                                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                    <button class="btn-outline-hero btn-xl text-lg"
                                        onclick="window.location.href = 'https://wa.me/2347032468725'">
                                        Chat with Us
                                    </button>
                                </div>

                                <div
                                    class="flex flex-col sm:flex-row items-center justify-center gap-6 text-sm text-letcon-neutral-700">
                                    {{-- <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-letcon-primary rounded-full"></div>
                                        <span>No setup fees</span>
                                    </div> --}}
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-letcon-gold rounded-full"></div>
                                        <span>Instant access</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-letcon-primary rounded-full"></div>
                                        <span>24/7 support</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Indicators -->
            <div class="mt-16 text-center hidden">
                <p class="text-letcon-neutral-700 mb-8">Trusted by thousands of members worldwide</p>
                <div class="flex flex-wrap justify-center items-center gap-8 opacity-60">
                    <div class="text-2xl font-bold">10,000+</div>
                    <div class="w-px h-8 bg-letcon-neutral-200"></div>
                    <div class="text-2xl font-bold">50+</div>
                    <div class="w-px h-8 bg-letcon-neutral-200"></div>
                    <div class="text-2xl font-bold">$2.5M+</div>
                    <div class="w-px h-8 bg-letcon-neutral-200"></div>
                    <div class="text-2xl font-bold">94%</div>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-8 text-sm text-letcon-neutral-700 mt-2">
                    <div>Active Members</div>
                    <div class="hidden sm:block">•</div>
                    <div>Countries</div>
                    <div class="hidden sm:block">•</div>
                    <div>Distributed</div>
                    <div class="hidden sm:block">•</div>
                    <div>Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />
</body>

</html>
