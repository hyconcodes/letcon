<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Letcon - Digitalised Cooperative System | Building Wealth Together</title>
    <meta name="description" content="Join Letcon's digitalised cooperative platform. Modern Ajo/Osusu system with transparent relief payments, automatic reinvestment, and sustainable financial growth." />
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
</head>

<body class="font-inter antialiased bg-letcon-neutral-50 text-letcon-neutral-900">
    <!-- Header Component -->
    <x-header/>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-20 bg-gradient-to-br from-letcon-neutral-50 via-white to-letcon-neutral-100 overflow-hidden">
        <!-- Background elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 left-10 w-72 h-72 bg-letcon-primary rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-letcon-gold rounded-full blur-3xl"></div>
        </div>
        
        <!-- Hero image with responsive behavior -->
        <div class="absolute inset-0 lg:left-auto lg:right-0 lg:w-1/2 xl:w-1/2 2xl:w-5/12">
            <div class="relative w-full h-full">
                <img src="{{ asset('assets/letcon-hero-image.jpg') }}" 
                     alt="Modern digital cooperative platform" 
                     class="w-full h-full object-cover object-left lg:object-center"
                     loading="eager"
                     sizes="(max-width: 1024px) 100vw, 50vw">
                <!-- Responsive gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/70 to-transparent 
                            lg:bg-gradient-to-r lg:from-white lg:via-white/80 lg:to-transparent"></div>
            </div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl lg:max-w-2xl xl:max-w-3xl mx-auto lg:mx-0 text-center lg:text-left space-y-8 py-20 relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-letcon-primary/10 border border-letcon-primary/20 rounded-full text-sm font-medium text-letcon-primary">
                    <span class="w-2 h-2 bg-letcon-primary rounded-full animate-pulse"></span>
                    Government Certified • CAC: 8667652
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                    <span class="bg-gradient-to-r from-letcon-primary via-letcon-primary-light to-letcon-primary bg-clip-text text-transparent">
                        Digitalised Cooperative System
                    </span>
                    <br />
                    <span class="text-letcon-neutral-900">Building Wealth Together</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-letcon-neutral-700 max-w-2xl leading-relaxed">
                    Modern Ajo/Osusu platform blending traditional African contribution systems with cutting-edge financial technology
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-start pt-4">
                    <button class="px-8 py-4 bg-gradient-to-r from-letcon-primary to-letcon-primary-light text-white rounded-xl font-semibold text-lg hover:shadow-xl hover:-translate-y-1 transition-all"
                        onclick="window.location.href = '{{ route('register') }}'">
                        Join Now
                        <svg class="inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                    <button class="px-8 py-4 bg-white border-2 border-letcon-primary text-letcon-primary rounded-xl font-semibold text-lg hover:bg-letcon-primary hover:text-white transition-all">
                        Learn More
                    </button>
                </div>
                
                <div class="flex flex-wrap items-center justify-start gap-6 pt-8 text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-letcon-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-letcon-neutral-700">100% Transparent</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-letcon-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-letcon-neutral-700">Automatic Reinvestment</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-letcon-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-letcon-neutral-700">Community Driven</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-letcon-neutral-900">About Letcon Global</h2>
                    <p class="text-xl text-letcon-neutral-700 max-w-3xl mx-auto">
                        Nigeria's premier digitalised cooperative platform, certified and trusted
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mb-16">
                    <div class="bg-gradient-to-br from-letcon-neutral-50 to-white p-8 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-primary/30 transition-all hover:shadow-lg">
                        <div class="w-12 h-12 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-letcon-neutral-900 mb-4">Government Certified</h3>
                        <div class="space-y-3 text-letcon-neutral-700">
                            <p><strong>CAC Registration:</strong> RC 8667652</p>
                            <p><strong>SCUML Number:</strong> 132100698</p>
                            <p><strong>Tax ID:</strong> 33400606-0001</p>
                            <p><strong>Ministry:</strong> Federal Ministry of Industry, Trade and Investment</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-letcon-neutral-50 to-white p-8 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-primary/30 transition-all hover:shadow-lg">
                        <div class="w-12 h-12 bg-gradient-to-r from-letcon-gold to-letcon-gold-dark rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-letcon-neutral-900 mb-4">About Our Leadership</h3>
                        <p class="text-letcon-neutral-700 leading-relaxed">
                            <strong>CEO:</strong> Kosedake Olubusuyi Victor from Ekiti State, Nigeria. Led by visionary directors committed to financial empowerment and poverty eradication across Nigeria, regardless of language, tribe, or religion.
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-letcon-primary/5 to-letcon-gold/5 p-8 md:p-12 rounded-2xl border border-letcon-primary/20">
                    <p class="text-lg md:text-xl text-letcon-neutral-700 leading-relaxed text-center">
                        Letcon Global Company Ltd blends traditional African contribution systems (Ajo/Osusu) with modern financial technology. By digitalising cooperative practices, we provide a transparent, structured, and automated platform that empowers individuals and organisations to achieve sustainable financial growth.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-24 bg-gradient-to-br from-letcon-neutral-50 to-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white p-8 md:p-10 rounded-2xl border-2 border-letcon-primary/20 hover:border-letcon-primary/40 transition-all hover:shadow-xl">
                        <div class="w-16 h-16 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-letcon-neutral-900 mb-4">Our Mission</h3>
                        <p class="text-lg text-letcon-neutral-700 leading-relaxed">
                            To democratise wealth creation by transforming age-old cooperative savings into a scalable, digitised ecosystem that guarantees fairness, transparency, and long-term financial empowerment.
                        </p>
                    </div>

                    <div class="bg-white p-8 md:p-10 rounded-2xl border-2 border-letcon-gold/20 hover:border-letcon-gold/40 transition-all hover:shadow-xl">
                        <div class="w-16 h-16 bg-gradient-to-r from-letcon-gold to-letcon-gold-dark rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-letcon-neutral-900 mb-4">Our Vision</h3>
                        <p class="text-lg text-letcon-neutral-700 leading-relaxed">
                            To become one of the world's leading digitalised cooperative networks, enabling every member to build wealth, foster trust, and contribute to a global cycle of sustainability.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-letcon-neutral-900">Core Values</h2>
                    <p class="text-xl text-letcon-neutral-700">The principles that guide everything we do</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="group p-6 bg-gradient-to-br from-letcon-neutral-50 to-white rounded-xl border border-letcon-neutral-200 hover:border-letcon-primary/50 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-letcon-primary/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-2">Transparency</h3>
                        <p class="text-letcon-neutral-700">Clear rules on contributions, relief payments, and reinvestments</p>
                    </div>

                    <div class="group p-6 bg-gradient-to-br from-letcon-neutral-50 to-white rounded-xl border border-letcon-neutral-200 hover:border-letcon-primary/50 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-letcon-primary/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-2">Fairness</h3>
                        <p class="text-letcon-neutral-700">Every member benefits through structured progression and spillover</p>
                    </div>

                    <div class="group p-6 bg-gradient-to-br from-letcon-neutral-50 to-white rounded-xl border border-letcon-neutral-200 hover:border-letcon-primary/50 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-letcon-primary/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-2">Community</h3>
                        <p class="text-letcon-neutral-700">Inspired by Ajo/Osusu cooperative spirit, ensuring inclusivity</p>
                    </div>

                    <div class="group p-6 bg-gradient-to-br from-letcon-neutral-50 to-white rounded-xl border border-letcon-neutral-200 hover:border-letcon-primary/50 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-letcon-primary/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-2">Sustainability</h3>
                        <p class="text-letcon-neutral-700">Mandatory reinvestment and automatic re-entry guarantee continuity</p>
                    </div>

                    <div class="group p-6 bg-gradient-to-br from-letcon-neutral-50 to-white rounded-xl border border-letcon-neutral-200 hover:border-letcon-primary/50 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-letcon-primary/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-2">Innovation</h3>
                        <p class="text-letcon-neutral-700">Leveraging digital platforms to modernise traditional models</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-24 bg-gradient-to-br from-letcon-primary/5 to-letcon-gold/5">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-letcon-neutral-900">How It Works</h2>
                    <p class="text-xl text-letcon-neutral-700">Simple, transparent, and automated</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="relative">
                        <div class="bg-white p-6 rounded-2xl border-2 border-letcon-primary/20 hover:border-letcon-primary/40 hover:shadow-xl transition-all h-full">
                            <div class="w-12 h-12 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center text-white text-xl font-bold mb-4">1</div>
                            <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Join Level 1</h3>
                            <p class="text-letcon-neutral-700">Members join through contribution payment which serves as registration fee</p>
                        </div>
                        <div class="hidden lg:block absolute top-1/2 -right-3 w-6 h-0.5 bg-gradient-to-r from-letcon-primary to-transparent"></div>
                    </div>

                    <div class="relative">
                        <div class="bg-white p-6 rounded-2xl border-2 border-letcon-primary/20 hover:border-letcon-primary/40 hover:shadow-xl transition-all h-full">
                            <div class="w-12 h-12 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center text-white text-xl font-bold mb-4">2</div>
                            <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Receive Relief</h3>
                            <p class="text-letcon-neutral-700">From Level 2 onward, receive immediate relief payments automatically</p>
                        </div>
                        <div class="hidden lg:block absolute top-1/2 -right-3 w-6 h-0.5 bg-gradient-to-r from-letcon-primary to-transparent"></div>
                    </div>

                    <div class="relative">
                        <div class="bg-white p-6 rounded-2xl border-2 border-letcon-primary/20 hover:border-letcon-primary/40 hover:shadow-xl transition-all h-full">
                            <div class="w-12 h-12 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center text-white text-xl font-bold mb-4">3</div>
                            <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Final Payment</h3>
                            <p class="text-letcon-neutral-700">At the last level, receive full final payment with auto-reinvestment</p>
                        </div>
                        <div class="hidden lg:block absolute top-1/2 -right-3 w-6 h-0.5 bg-gradient-to-r from-letcon-primary to-transparent"></div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border-2 border-letcon-gold/20 hover:border-letcon-gold/40 hover:shadow-xl transition-all h-full">
                        <div class="w-12 h-12 bg-gradient-to-r from-letcon-gold to-letcon-gold-dark rounded-xl flex items-center justify-center text-white text-xl font-bold mb-4">4</div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Continuous Cycle</h3>
                        <p class="text-letcon-neutral-700">Auto-registration back to Level 1 ensures perpetual cooperative growth</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Unique Advantages -->
    <section id="benefits" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-letcon-neutral-900">Unique Advantages</h2>
                    <p class="text-xl text-letcon-neutral-700">What makes Letcon different</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="p-6 bg-gradient-to-br from-white to-letcon-neutral-50 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-primary/40 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Digitalised Cooperative</h3>
                        <p class="text-letcon-neutral-700">Modern form of Ajo/Osusu with structured levels and automated processes</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-white to-letcon-neutral-50 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-primary/40 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Early Relief Payment</h3>
                        <p class="text-letcon-neutral-700">Payments begin as early as Level 2, ensuring no participant feels excluded</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-white to-letcon-neutral-50 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-primary/40 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Automatic Reinvestment</h3>
                        <p class="text-letcon-neutral-700">Ensures sustainability and long-term growth for all members</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-white to-letcon-neutral-50 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-primary/40 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">One-Account Policy</h3>
                        <p class="text-letcon-neutral-700">Prevents abuse and maintains fairness for all members in the system</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-white to-letcon-neutral-50 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-primary/40 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Global Automatic System</h3>
                        <p class="text-letcon-neutral-700">Members get downlines through adverts on radio, social media, and other channels</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-white to-letcon-neutral-50 rounded-2xl border border-letcon-neutral-200 hover:border-letcon-gold/40 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 bg-gradient-to-r from-letcon-gold to-letcon-gold-dark rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-letcon-neutral-900 mb-3">Deals in Naira</h3>
                        <p class="text-letcon-neutral-700">A Nigerian company focused on improving lives without bias of language, tribe, or religion</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Letcon -->
    <section class="py-24 bg-gradient-to-br from-letcon-primary/5 to-letcon-gold/5">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-letcon-neutral-900 mb-8">Why Choose Letcon?</h2>
                <div class="bg-white p-8 md:p-12 rounded-3xl border-2 border-letcon-primary/20 shadow-xl">
                    <p class="text-lg md:text-xl text-letcon-neutral-700 leading-relaxed mb-8">
                        Letcon bridges the gap between traditional cooperative savings and modern financial technology, creating a trusted, reliable, and transparent platform where no member is left behind.
                    </p>
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-letcon-primary/10 to-letcon-gold/10 rounded-full border border-letcon-primary/30">
                        <svg class="w-6 h-6 text-letcon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-letcon-neutral-900 font-semibold text-lg">A digital family of contribution and empowerment</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="relative overflow-hidden rounded-3xl">
                    <div class="absolute inset-0 bg-gradient-to-r from-letcon-primary to-letcon-primary-light opacity-10"></div>
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-letcon-gold rounded-full blur-3xl"></div>
                    </div>
                    
                    <div class="relative bg-white border-2 border-letcon-primary/20 p-8 md:p-16 text-center space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-4xl md:text-5xl font-bold text-letcon-neutral-900">
                                Start Your Journey Today
                            </h2>
                            <p class="text-xl text-letcon-neutral-700 max-w-3xl mx-auto">
                                Join thousands of members building sustainable wealth through our digitalised cooperative system
                            </p>
                        </div>

                        <div class="grid md:grid-cols-3 gap-6 py-8">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-letcon-neutral-900">Quick Start</h3>
                                    <p class="text-sm text-letcon-neutral-700">Register in minutes</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-letcon-neutral-900">Instant Community</h3>
                                    <p class="text-sm text-letcon-neutral-700">Join a trusted network</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-letcon-primary to-letcon-primary-light rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-letcon-neutral-900">Secure Platform</h3>
                                    <p class="text-sm text-letcon-neutral-700">Government certified</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button class="px-10 py-4 bg-gradient-to-r from-letcon-primary to-letcon-primary-light text-white rounded-xl font-semibold text-lg hover:shadow-xl hover:-translate-y-1 transition-all inline-flex items-center justify-center gap-2"
                                onclick="window.location.href = '{{ route('register') }}'">
                                Join Letcon Now
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                            <button class="px-10 py-4 bg-white border-2 border-letcon-primary text-letcon-primary rounded-xl font-semibold text-lg hover:bg-letcon-primary hover:text-white transition-all"
                                onclick="window.location.href = 'https://wa.me/2347032468725'">
                                Chat with Us
                            </button>
                        </div>

                        <div class="flex flex-wrap items-center justify-center gap-6 pt-6 text-sm text-letcon-neutral-700">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-letcon-gold rounded-full"></div>
                                <span>Instant access</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-letcon-primary rounded-full"></div>
                                <span>24/7 support</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-letcon-gold rounded-full"></div>
                                <span>Transparent system</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Component -->
    <x-footer />
</body>

</html>