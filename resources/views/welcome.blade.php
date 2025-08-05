<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Letcon Global - Financial Empowerment Platform</title>

        <!-- Favicon -->
        <style>
            :root {
                --primary-color: #D4AF37; /* Gold */
                --secondary-color: #6B3E00; /* Bronze */
                --text-color: #2E2E2E; /* Charcoal */
                --light-bg: #FFF8E1; /* Soft Ivory */
                --border-color: #B0B0B0; /* Steel Gray */
                --accent-color: #6BBF59; /* Money Green */
            }
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'instrument-sans', sans-serif;
            }
            body {
                color: var(--text-color);
                background-color: var(--light-bg);
            }
            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 15px;
            }
            header {
                background-color: var(--secondary-color);
                padding: 15px 0;
                position: relative;
            }
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .logo {
                color: white;
                font-size: 24px;
                font-weight: 600;
            }
            .nav-links {
                display: flex;
                gap: 20px;
            }
            .nav-links a {
                color: white;
                text-decoration: none;
                font-size: 14px;
                text-transform: uppercase;
            }
            .hero {
                background-color: var(--secondary-color);
                color: white;
                text-align: center;
                padding: 80px 0;
                position: relative;
            }
            .hero h1 {
                font-size: 36px;
                margin-bottom: 15px;
            }
            .hero p {
                font-size: 18px;
                margin-bottom: 30px;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }
            .btn-primary {
                background-color: var(--primary-color);
                color: var(--secondary-color);
                padding: 10px 25px;
                border-radius: 25px;
                text-decoration: none;
                font-weight: 600;
                display: inline-block;
            }
            .intro-section {
                padding: 60px 0;
            }
            .intro-title {
                color: var(--primary-color);
                font-size: 18px;
                margin-bottom: 10px;
            }
            .intro-heading {
                font-size: 28px;
                margin-bottom: 30px;
                color: var(--secondary-color);
            }
            .intro-content {
                display: flex;
                align-items: center;
                gap: 40px;
            }
            .intro-text {
                flex: 1;
            }
            .intro-image {
                flex: 1;
                border-radius: 50%;
                overflow: hidden;
                background-color: var(--primary-color);
            }
            .intro-image img {
                width: 100%;
                height: auto;
                display: block;
            }
            .features {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
                margin-top: 20px;
            }
            .feature {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 15px;
            }
            .feature-icon {
                width: 20px;
                height: 20px;
                background-color: var(--primary-color);
                border-radius: 50%;
                flex-shrink: 0;
            }
            .stats-section {
                background-color: #f5f5f5;
                padding: 60px 0;
                text-align: center;
            }
            .stats-heading {
                font-size: 28px;
                margin-bottom: 40px;
                color: var(--secondary-color);
            }
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 30px;
            }
            .stat-card {
                background-color: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            }
            .stat-icon {
                font-size: 36px;
                color: var(--primary-color);
                margin-bottom: 15px;
            }
            .stat-number {
                font-size: 32px;
                font-weight: 600;
                margin-bottom: 10px;
                color: var(--secondary-color);
            }
            .stat-label {
                font-size: 16px;
                color: #666;
            }
            .testimonial-section {
                padding: 60px 0;
                text-align: center;
            }
            .testimonial-quote {
                font-style: italic;
                font-size: 18px;
                max-width: 800px;
                margin: 0 auto 20px;
            }
            .testimonial-author {
                font-weight: 600;
                color: var(--secondary-color);
            }
            .testimonial-role {
                font-size: 14px;
                color: #666;
            }
            .cta-section {
                background-color: var(--secondary-color);
                color: white;
                padding: 40px 0;
                text-align: center;
            }
            .cta-heading {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .footer {
                background-color: var(--secondary-color);
                color: white;
                padding: 60px 0 20px;
            }
            .footer-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 30px;
                margin-bottom: 40px;
            }
            .footer-logo {
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 15px;
            }
            .footer-text {
                font-size: 14px;
                color: #ccc;
                margin-bottom: 20px;
            }
            .footer-heading {
                font-size: 18px;
                margin-bottom: 20px;
            }
            .footer-links {
                list-style: none;
            }
            .footer-links li {
                margin-bottom: 10px;
            }
            .footer-links a {
                color: #ccc;
                text-decoration: none;
                font-size: 14px;
            }
            .footer-links a:hover {
                color: var(--primary-color);
            }
            .newsletter-form {
                display: flex;
                margin-bottom: 20px;
            }
            .newsletter-input {
                flex: 1;
                padding: 10px;
                border: none;
                border-radius: 4px 0 0 4px;
            }
            .newsletter-button {
                background-color: var(--primary-color);
                color: var(--secondary-color);
                border: none;
                padding: 10px 15px;
                border-radius: 0 4px 4px 0;
                font-weight: 600;
                cursor: pointer;
            }
            .social-icons {
                display: flex;
                gap: 15px;
            }
            .social-icon {
                width: 30px;
                height: 30px;
                background-color: #444;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                text-decoration: none;
            }
            .copyright {
                text-align: center;
                padding-top: 20px;
                border-top: 1px solid #444;
                font-size: 14px;
                color: #ccc;
            }
            @media (max-width: 768px) {
                .intro-content, .stats-grid {
                    flex-direction: column;
                    grid-template-columns: 1fr;
                }
                .footer-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }
            /* Updates Section Styles */
            .updates-section {
                padding: 60px 0;
                background-color: var(--light-bg);
            }
            .section-heading, .updates-heading {
                color: var(--primary-color);
                text-align: center;
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 10px;
            }
            .section-subheading, .updates-subheading {
                text-align: center;
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 30px;
            }
            .updates-intro {
                text-align: center;
                max-width: 800px;
                margin: 0 auto 40px;
                color: #666;
            }
            .articles-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 30px;
            }
            .article-card {
                background-color: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
            .article-image img {
                width: 100%;
                height: auto;
                display: block;
            }
            .article-content {
                padding: 20px;
            }
            .article-title {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 10px;
            }
            .article-text {
                color: #666;
                margin-bottom: 15px;
                font-size: 14px;
                line-height: 1.5;
            }
            .article-link {
                display: inline-block;
                color: var(--primary-color);
                font-weight: 600;
                font-size: 14px;
                text-decoration: none;
            }
            @media (max-width: 480px) {
                .footer-grid {
                    grid-template-columns: 1fr;
                }
                .articles-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        
        <!-- Additional Styles -->
        <style>
            :root {
                --primary-color: #D4AF37; /* Gold */
                --secondary-color: #6B3E00; /* Bronze */
                --text-color: #2E2E2E; /* Charcoal */
                --light-bg: #FFF8E1; /* Soft Ivory */
                --border-color: #B0B0B0; /* Steel Gray */
                --accent-color: #6BBF59; /* Money Green */
            }
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'instrument-sans', sans-serif;
            }
            body {
                color: var(--text-color);
                background-color: var(--light-bg);
            }
            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 15px;
            }
            header {
                background-color: var(--secondary-color);
                padding: 15px 0;
                position: relative;
            }
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .logo {
                color: white;
                font-size: 24px;
                font-weight: 600;
            }
            .nav-links {
                display: flex;
                gap: 20px;
            }
            .nav-links a {
                color: white;
                text-decoration: none;
                font-size: 14px;
                text-transform: uppercase;
            }
        </style>

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles -->
    <style>
        :root {
            --primary-color: #D4AF37; /* Gold */
            --secondary-color: #6B3E00; /* Bronze */
            --accent-color: #6BBF59; /* Money Green */
            --text-color: #2E2E2E; /* Charcoal */
            --light-text: #666;
            --background-color: #fff;
            --light-background: #FFF8E1; /* Soft Ivory */
            --border-color: #B0B0B0; /* Steel Gray */
            --success-color: #6BBF59; /* Money Green */
            --warning-color: #D4AF37; /* Gold */
            --error-color: #6B3E00; /* Bronze */
            --border-radius: 4px;
            --box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'instrument-sans', sans-serif;
        }
        body {
            color: var(--text-color);
            background-color: var(--light-bg);
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        header {
            background-color: var(--secondary-color);
            padding: 15px 0;
            position: relative;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            color: white;
            font-size: 24px;
            font-weight: 600;
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            text-transform: uppercase;
        }
        .hero {
            background-color: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        .hero-slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .hero-slideshow img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .hero-slideshow img.active {
            opacity: 0.3;
        }
        .hero .container {
            position: relative;
            z-index: 1;
        }
        .hero h1 {
            font-size: 36px;
            margin-bottom: 15px;
        }
        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }
        .intro-section {
            padding: 60px 0;
        }
        .intro-title {
            color: var(--primary-color);
            font-size: 18px;
            margin-bottom: 10px;
        }
        .intro-heading {
            font-size: 28px;
            margin-bottom: 30px;
            color: var(--secondary-color);
        }
        .intro-content {
            display: flex;
            align-items: center;
            gap: 40px;
        }
        .intro-text {
            flex: 1;
        }
        .intro-image {
            flex: 1;
            border-radius: 50%;
            overflow: hidden;
            background-color: var(--primary-color);
        }
        .intro-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        .feature {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 15px;
        }
        .feature-icon {
            width: 20px;
            height: 20px;
            background-color: var(--primary-color);
            border-radius: 50%;
            flex-shrink: 0;
        }
        .stats-section {
            background-color: #f5f5f5;
            padding: 60px 0;
            text-align: center;
        }
        .stats-heading {
            font-size: 28px;
            margin-bottom: 40px;
            color: var(--secondary-color);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .stat-card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .stat-icon {
            font-size: 36px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .stat-number {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--secondary-color);
        }
        .stat-label {
            font-size: 16px;
            color: #666;
        }
        .testimonial-section {
            padding: 60px 0;
            text-align: center;
        }
        .testimonial-image {
            width: 200px;
            height: 200px;
            margin: 0 auto 30px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid var(--accent-color);
        }
        .testimonial-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .testimonial-quote {
            font-style: italic;
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto 20px;
        }
        .testimonial-author {
            font-weight: 600;
            color: var(--secondary-color);
        }
        .testimonial-role {
            font-size: 14px;
            color: #666;
        }
        .cta-section {
            background-color: var(--secondary-color);
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        .cta-heading {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .updates-section {
            padding: 60px 0;
        }
        .updates-heading {
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
        }
        .updates-subheading {
            font-size: 24px;
            margin-bottom: 40px;
            text-align: center;
        }
        .update-card {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .update-image {
            width: 150px;
            height: 100px;
            background-color: #eee;
            border-radius: 5px;
            overflow: hidden;
        }
        .update-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .update-content h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .update-content p {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .read-more {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 60px 0 20px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }
        .footer-logo {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .footer-text {
            font-size: 14px;
            color: #ccc;
            margin-bottom: 20px;
        }
        .footer-heading {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .footer-links {
            list-style: none;
        }
        .footer-links li {
            margin-bottom: 10px;
        }
        .footer-links a {
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
        }
        .footer-links a:hover {
            color: var(--primary-color);
        }
        .newsletter-form {
            display: flex;
            margin-bottom: 20px;
        }
        .newsletter-input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px 0 0 4px;
        }
        .newsletter-button {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            padding: 10px 15px;
            border-radius: 0 4px 4px 0;
            font-weight: 600;
            cursor: pointer;
        }
        .social-icons {
            display: flex;
            gap: 15px;
        }
        .social-icon {
            width: 30px;
            height: 30px;
            background-color: #444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #444;
            font-size: 14px;
            color: #ccc;
        }
        @media (max-width: 768px) {
            .intro-content {
                flex-direction: column;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 480px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="antialiased">
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">Letcon Global</div>
            <nav class="nav-links">
                <a href="#">Home</a>
                <a href="#">About Us</a>
                <a href="#">How It Works</a>
                <a href="#">Testimonials</a>
                <a href="#">Contact</a>
                <a href="#">Login</a>
                <a href="#" style="color: var(--primary-color);">My Dashboard</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-slideshow">
            <img src="{{ asset('assets/people-1.webp') }}" alt="People collaborating" class="active">
            <img src="{{ asset('assets/people-2.jpg') }}" alt="Community members">
            <img src="{{ asset('assets/two-standing-young-girl.webp') }}" alt="Young professionals">
        </div>
        <div class="container">
            <h1>Welcome To Letcon Global</h1>
            <p>A forward-thinking financial empowerment and networking platform committed to creating sustainable income opportunities.</p>
            <a href="#" class="btn-primary">Get Started</a>
        </div>
    </section>

    <!-- This is Letcon Global Section -->
    <section class="intro-section">
        <div class="container">
            <h2 class="intro-title">This is Letcon Global!</h2>
            <h3 class="intro-heading">Financial Empowerment Platform</h3>
            <div class="intro-content">
                <div class="intro-text">
                    <p>Letcon Global Company Limited (Letcon) is a forward-thinking financial empowerment and networking platform committed to creating sustainable income opportunities through structured collaboration, peer support, and progressive contribution models. Established with a vision to foster financial inclusion and community-driven wealth creation, Letcon empowers individuals to rise through levels of structured contributions and earn substantial returns.</p>
                    <div class="features">
                        <div class="feature">
                            <div class="feature-icon"></div>
                            <div>Transparent Payouts</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"></div>
                            <div>Level-based Progression</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"></div>
                            <div>Peer-to-peer Support</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"></div>
                            <div>Secure Member Dashboard</div>
                        </div>
                    </div>
                    <a href="#" class="btn-primary" style="margin-top: 20px;">READ ABOUT US</a>
                </div>
                <div class="intro-image">
                    <img src="{{ asset('assets/one-man.webp') }}" alt="Letcon Global Team">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <h2 class="stats-heading">Building Financial Freedom Through Structured Collaboration</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-number">10</div>
                    <div class="stat-label">Progressive Levels</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🏆</div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Transparent System</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🔥</div>
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Member Support</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">
            <div class="testimonial-image">
                <img src="{{ asset('assets/people-3.webp') }}" alt="Letcon Global Community">
            </div>
            <p class="testimonial-quote">"Our Mission: To build a trusted financial ecosystem where individuals can grow income, collaborate safely, and unlock prosperity through structured, transparent systems."</p>
            <p class="testimonial-quote">"Our Vision: To become Africa's most impactful financial collaboration platform, enabling communities to achieve collective success and financial freedom."</p>
            <div class="testimonial-author">Letcon Global</div>
            <div class="testimonial-role">Financial Empowerment Platform</div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-heading">How Letcon Works</h2>
            <p>Letcon operates a structured system where members register, contribute a specific financial amount, and move through defined Levels 1 to 10. At each level, members receive increased benefits and financial rewards based on participation and peer collaboration.</p>
            <a href="#" class="btn-primary">JOIN NOW</a>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">
            <div class="testimonial-image">
                <img src="{{ asset('assets/two-young-girls.jpg') }}" alt="Letcon Global Members">
            </div>
            <p class="testimonial-quote">"Our Mission: To build a trusted financial ecosystem where individuals can grow income, collaborate safely, and unlock prosperity through structured, transparent systems."</p>
            <p class="testimonial-quote">"Our Vision: To become Africa's most impactful financial collaboration platform, enabling communities to achieve collective success and financial freedom."</p>
            <div class="testimonial-author">Letcon Global</div>
            <div class="testimonial-role">Financial Empowerment Platform</div>
        </div>
    </section>
    
    <!-- Updates Section -->
    <section class="updates-section">
        <div class="container">
            <h2 class="updates-heading">UPDATES</h2>
            <h3 class="updates-subheading">Latest News & Announcements</h3>
            
            <p class="updates-intro">Stay updated with Letcon Global's latest developments, success stories, and platform enhancements. Follow our journey as we build Africa's most impactful financial collaboration platform.</p>
            
            <div class="articles-grid">
                <div class="article-card">
                    
                    <div class="article-content">
                        <h4 class="article-title">Letcon Platform Launch</h4>
                        <p class="article-text">We're excited to announce the official launch of the Letcon Global platform, designed to empower individuals through structured financial collaboration and peer support systems.</p>
                        <a href="#" class="article-link">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo">Letcon Global</div>
                    <p class="footer-text">A forward-thinking financial empowerment and networking platform committed to creating sustainable income opportunities through structured collaboration.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon">f</a>
                        <a href="#" class="social-icon">t</a>
                        <a href="#" class="social-icon">in</a>
                    </div>
                </div>
                <div>
                    <h4 class="footer-heading">Navigation</h4>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Plans</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-heading">Legal</h4>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-heading">Newsletter</h4>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Your email">
                        <button type="submit" class="newsletter-button">SUBSCRIBE</button>
                    </form>
                </div>
            </div>
            <div class="copyright">
                LETCON GLOBAL | ALL RIGHTS RESERVED | support@letcon.com.ng | LETCON.COM.NG
            </div>
        </div>
    </footer>
    <script>
        // Slideshow functionality
        document.addEventListener('DOMContentLoaded', function() {
            const slideshowImages = document.querySelectorAll('.hero-slideshow img');
            let currentImageIndex = 0;
            
            function showNextImage() {
                // Remove active class from current image
                slideshowImages[currentImageIndex].classList.remove('active');
                
                // Move to next image or back to first if at the end
                currentImageIndex = (currentImageIndex + 1) % slideshowImages.length;
                
                // Add active class to new current image
                slideshowImages[currentImageIndex].classList.add('active');
            }
            
            // Change image every 5 seconds
            setInterval(showNextImage, 5000);
        });
    </script>
</body>
</html>