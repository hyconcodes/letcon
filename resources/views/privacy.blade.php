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


    <!-- Privacy Policy Section -->
    <section class="relative min-h-screen py-20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/people-1.webp') }}')"></div>
        <div class="absolute inset-0 bg-letcon-primary opacity-40"></div>
        <div class="absolute inset-0 bg-letcon-gold opacity-20"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h1 class="text-4xl lg:text-5xl font-bold text-letcon-neutral-900 mb-4">
                    Privacy Policy
                </h1>
                <p class="text-xl text-letcon-neutral-700">
                    At Letcon, your privacy is very important to us. This Privacy Policy explains how we collect, use,
                    store, and protect your information.
                </p>
            </div>

            <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8">
                <div class="prose prose-lg max-w-none text-letcon-neutral-700">
                    <p class="lead">By using Letcon, you consent to the practices described in this policy.</p>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">1. Information We Collect</h2>
                    <p>When you use Letcon, we may collect the following information:</p>
                    <ul class="list-disc ml-6">
                        <li>Personal Information: Name, email address, phone number, date of birth, government-issued ID
                            (for KYC)</li>
                        <li>Financial Information: Bank details, payment records, wallet transactions</li>
                        <li>Technical Information: Device type, IP address, browser, login data, and usage activity</li>
                        <li>Referral & Community Data: Your referrals, level progression, and community activity</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">2. How We Use Your Information</h2>
                    <ul class="list-disc ml-6">
                        <li>To create and manage your account</li>
                        <li>To process payments, track earnings, and handle withdrawals</li>
                        <li>To verify your identity through KYC compliance</li>
                        <li>To prevent fraud, multiple accounts, or unauthorized use</li>
                        <li>To provide customer support and communicate with you</li>
                        <li>To improve our platform's functionality and security</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">3. KYC & Identity Verification</h2>
                    <ul class="list-disc ml-6">
                        <li>All members must complete KYC verification to unlock full access and withdrawals</li>
                        <li>KYC data is securely stored and used only for identity verification</li>
                        <li>We comply with regulatory standards to prevent fraud, scams, or money laundering</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">4. Data Sharing & Disclosure</h2>
                    <p>We do not sell your personal data. However, we may share information in these cases:</p>
                    <ul class="list-disc ml-6">
                        <li>With payment processors to process transactions</li>
                        <li>With government authorities if legally required</li>
                        <li>With fraud-prevention and compliance partners</li>
                        <li>Within Letcon's internal teams for platform operations</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">5. Data Storage & Security</h2>
                    <ul class="list-disc ml-6">
                        <li>Your data is stored securely with encryption and access controls</li>
                        <li>We take reasonable steps to protect against unauthorized access</li>
                        <li>No system is 100% secure. You use Letcon at your own risk</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">6. Cookies & Tracking</h2>
                    <ul class="list-disc ml-6">
                        <li>Letcon may use cookies and similar technologies</li>
                        <li>Cookies help remember preferences and track platform activity</li>
                        <li>You can disable cookies, but this may affect functionality</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">7. Your Rights</h2>
                    <ul class="list-disc ml-6">
                        <li>Access and update your personal information</li>
                        <li>Request deletion of your account and data</li>
                        <li>Opt-out of promotional communications</li>
                        <li>File complaints about data misuse</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">8. Third-Party Links</h2>
                    <ul class="list-disc ml-6">
                        <li>Letcon may contain links to third-party sites</li>
                        <li>We are not responsible for external privacy practices</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">9. Policy Updates</h2>
                    <ul class="list-disc ml-6">
                        <li>Letcon may update this Privacy Policy periodically</li>
                        <li>Changes will be communicated through platform or email</li>
                        <li>Continued use means acceptance of revised policy</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-letcon-neutral-900 mt-8">10. Contact Us</h2>
                    <p>For privacy-related inquiries:</p>
                    <ul class="list-none">
                        <li>📧 Email: support@letcon.com.ng</li>
                        <li>🌍 Website: www.letcon.com.ng</li>
                    </ul>

                    <div class="mt-8 p-6 bg-letcon-neutral-100 rounded-lg">
                        <h2 class="text-2xl font-bold text-letcon-neutral-900">⚖️ Agreement</h2>
                        <p>By using Letcon, you agree to this Privacy Policy and consent to the collection, storage, and
                            use of your information as described above.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <x-footer />

</body>

</html>
