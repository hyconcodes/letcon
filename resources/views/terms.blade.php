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


    <!-- Terms Section -->
    <section class="relative min-h-screen py-20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/people-1.webp') }}')"></div>
        <div class="absolute inset-0 bg-letcon-primary opacity-40"></div>
        <div class="absolute inset-0 bg-letcon-gold opacity-20"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                    Terms & Conditions
                </h1>
                <p class="text-xl text-white hidden">
                    Please read these terms carefully before using Letcon
                </p>
            </div>

            <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-2xl p-8">
                <div class="prose prose-lg max-w-none text-letcon-neutral-700">
                    <p class="lead">Welcome to Letcon. By registering, accessing, or using our platform, you agree to be bound by these Terms & Conditions. Please read them carefully.</p>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">1. Acceptance of Terms</h2>
                    <p>By creating an account or participating in Letcon's earning system, you acknowledge that you have read, understood, and agreed to these Terms & Conditions. If you do not agree, you must not use the platform.</p>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">2. Membership & Eligibility</h2>
                    <ul class="list-disc ml-6">
                        <li>Membership is open to individuals who are at least 18 years old.</li>
                        <li>You must provide accurate information during registration.</li>
                        <li>Each member is allowed only one account. Multiple accounts may result in suspension or termination.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">3. Payment & Joining Fee</h2>
                    <ul class="list-disc ml-6">
                        <li>Joining Letcon requires a one-time payment of ₦20,000.</li>
                        <li>Payments are processed securely via our approved payment gateways.</li>
                        <li>This payment is non-refundable once confirmed.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">4. KYC Verification</h2>
                    <ul class="list-disc ml-6">
                        <li>All members must complete KYC verification before withdrawals can be processed.</li>
                        <li>KYC requires providing valid identification (e.g., government-issued ID, phone verification).</li>
                        <li>Failure to complete KYC will result in account restrictions.</li>
                        <li>Letcon reserves the right to request additional verification.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">5. Earnings & Upgrades</h2>
                    <ul class="list-disc ml-6">
                        <li>Members progress through levels based on geometric progression rules.</li>
                        <li>Earnings per level are clearly defined in the Letcon dashboard.</li>
                        <li>Upgrades are automatic when referral and community requirements are met.</li>
                        <li>All earnings are recorded in the member's Letcon wallet.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">6. Referrals & Community Growth</h2>
                    <ul class="list-disc ml-6">
                        <li>Members are encouraged to invite others using their referral links.</li>
                        <li>Growth and earnings are dependent on community participation.</li>
                        <li>Letcon does not guarantee income for members who fail to meet requirements.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">7. Withdrawals & Wallet</h2>
                    <ul class="list-disc ml-6">
                        <li>Funds earned are stored in the member's wallet.</li>
                        <li>Withdrawals are only available to KYC-verified members.</li>
                        <li>Withdrawals are subject to verification and processing time.</li>
                        <li>System manipulation attempts will result in permanent suspension.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">8. Fair Use & Prohibited Activities</h2>
                    <p>Members agree not to:</p>
                    <ul class="list-disc ml-6">
                        <li>Create multiple or fake accounts</li>
                        <li>Use fraudulent payment methods</li>
                        <li>Share false information about Letcon</li>
                        <li>Engage in disruptive activities</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">9. Contact Information</h2>
                    <p>For support or inquiries:</p>
                    <ul class="list-none">
                        <li>📧 Email: support@letcon.com.ng</li>
                        <li>🌍 Website: www.letcon.com.ng</li>
                    </ul>

                    <div class="mt-8 p-6 bg-letcon-neutral-100 rounded-lg">
                        <h2 class="text-2xl font-bold text-letcon-neutral-900">⚖️ Agreement</h2>
                        <p>By using Letcon, you agree to abide by these Terms & Conditions and accept that participation is voluntary and earnings depend on compliance with the rules, including successful KYC verification.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
        <x-footer />

</body>

</html>
