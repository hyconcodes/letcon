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
        <div class="absolute inset-0 bg-letcon-primary opacity-30"></div>

        {{-- <!-- Gold overlay -->
        <div class="absolute inset-0 bg-letcon-gold opacity-20"></div> --}}

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid lg:grid-cols-1 gap-12 items-center">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h1 class="text-5xl lg:text-6xl font-bold text-white leading-tight">
                            "One hand cannot lift a load onto the head."
                            <span class="gradient-hero bg-clip-text text-transparent">Cooperation is necessary to achieve big tasks</span>
                        </h1>
                        
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
      

    <!-- Benefits Section -->
    <section id="benefits" class="py-20 bg-letcon-neutral-50">
        <div class="container mx-auto px-4">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl font-bold text-letcon-neutral-900">Why Choose Letcon</h2>
                
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">

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
                           
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Feature Highlights -->
           
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
                                    Unlock Your E-Commerce & Financial Potential
                                </h2>
                                <p class="text-xl text-letcon-neutral-700 max-w-2xl mx-auto">
                                    Join Letcon's innovative platform to access powerful e-commerce tools, financial growth opportunities, and a supportive global community. Start your journey to financial success through Digitalised Contribution today.
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
                                    <h3 class="font-semibold text-letcon-neutral-900">Low Risk</h3>
                                   
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
                                    <h3 class="font-semibold text-letcon-neutral-900">Government Certified</h3>
                                   
                                </div>
                            </div>

                            <div class="text-center space-y-6">
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <button class="btn-hero btn-xl text-lg group"
                                        onclick="window.location.href = '{{ route('register') }}'">
                                        Join Now
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
                    <div class="text-2xl font-bold">5,000+</div>
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
