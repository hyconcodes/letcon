<header class="sticky top-0 z-50 bg-letcon-neutral-50/95 backdrop-blur-sm border-b border-letcon-neutral-200">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex items-center justify-between">
                <div class="flex items-center space-x-2 cursor-pointer" onclick="window.location.href='/'">
                    <div class="w-8 h-8 gradient-hero rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg"><img src="{{ asset('logo.png') }}"
                                alt=""></span>
                    </div>
                    <span class="text-2xl font-bold text-letcon-neutral-900">Letcon</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#about"
                        class="text-letcon-neutral-700 hover:text-letcon-primary transition-colors">About</a>
                    <a href="#how-it-works"
                        class="text-letcon-neutral-700 hover:text-letcon-primary transition-colors">How It Works</a>
                    <a href="#benefits"
                        class="text-letcon-neutral-700 hover:text-letcon-primary transition-colors">Benefits</a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-letcon-neutral-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('register') }}" class="btn-hero">Register</a>
                        <a href="{{ route('login') }}" class="btn-hero">Login</a>
                    @endguest
                    @auth
                        @if (auth()->user()->hasRole('super-admin'))
                            <a href="{{ route('admin.dashboard') }}" class="btn-hero">Admin Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-hero">My Dashboard</a>
                        @endif
                    @endauth
                </div>
            </nav>

            <!-- Mobile Menu Sidebar -->
            <div id="mobile-menu"
                class="fixed inset-y-0 left-0 transform -translate-x-full transition duration-300 ease-in-out w-full bg-green-50 shadow-lg z-50 md:hidden">
                <div class="p-6 space-y-6 bg-green-50">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 gradient-hero rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg"><img src="{{ asset('logo.png') }}"
                                        alt=""></span>
                            </div>
                            <span class="text-xl font-bold text-letcon-neutral-900">Letcon</span>
                        </div>
                        <button id="close-mobile-menu" class="text-letcon-neutral-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-col space-y-4">
                        <a href="#about"
                            class="text-letcon-neutral-700 hover:text-letcon-primary transition-colors">About</a>
                        <a href="#how-it-works"
                            class="text-letcon-neutral-700 hover:text-letcon-primary transition-colors">How It Works</a>
                        <a href="#benefits"
                            class="text-letcon-neutral-700 hover:text-letcon-primary transition-colors">Benefits</a>
                    </div>

                    <div class="flex flex-col space-y-4 pt-6 border-t">
                        @guest
                            <a href="{{ route('register') }}" class="btn-hero text-center">Register</a>
                            <a href="{{ route('login') }}" class="btn-hero text-center">Login</a>
                        @endguest
                        @auth
                            @if (auth()->user()->hasRole('super-admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn-hero text-center">Admin Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn-hero text-center">My Dashboard</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Mobile menu functionality
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const closeMobileMenu = document.getElementById('close-mobile-menu');

        function toggleMobileMenu() {
            mobileMenu.classList.toggle('-translate-x-full');
        }

        mobileMenuButton.addEventListener('click', toggleMobileMenu);
        closeMobileMenu.addEventListener('click', toggleMobileMenu);

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                mobileMenu.classList.add('-translate-x-full');
            }
        });
    </script>