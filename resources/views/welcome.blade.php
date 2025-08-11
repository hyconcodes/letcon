<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Letcon Global - Financial Empowerment Platform</title>

    <!-- Favicon -->
    <style>
        :root {
            --primary-color: #2ecc71; /* Emerald Green */
            --secondary-color: #27ae60; /* Darker Emerald Green */
            --text-color: #333333; /* Dark Gray */
            --light-bg: #f0fdf4; /* Light Green Background */
            --border-color: #cccccc; /* Light Gray */
            --accent-color: #3498db; /* Complementary Blue */
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
            position: relative;
        }

        .logo {
            color: white;
            font-size: 24px;
            font-weight: 600;
            z-index: 10;
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
        
        @media (max-width: 768px) {
            .header-container {
                padding: 10px 0;
            }
            
            .logo {
                font-size: 20px;
            }
        }
        
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
            z-index: 10;
        }
        
        .hamburger span {
            display: block;
            height: 3px;
            width: 100%;
            background-color: white;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        
        .hamburger.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }
        
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
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
            color: white;
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
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
            background-color: var(--light-bg);
        }

        .testimonial-image {
            width: 200px;
            height: 200px;
            margin: 0 auto 30px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid var(--accent-color);
            flex-shrink: 0;
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
            line-height: 1.6;
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
            color: white;
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

            .intro-content,
            .stats-grid {
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

        .section-heading,
        .updates-heading {
            color: var(--primary-color);
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .section-subheading,
        .updates-subheading {
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .article-card.full-width {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .article-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .article-content {
            padding: 30px;
        }

        .full-width .article-content {
            padding: 40px;
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
            --primary-color: #2ecc71; /* Emerald Green */
            --secondary-color: #27ae60; /* Darker Emerald Green */
            --text-color: #333333; /* Dark Gray */
            --light-bg: #f0fdf4; /* Light Green Background */
            --border-color: #cccccc; /* Light Gray */
            --accent-color: #3498db; /* Complementary Blue */
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
            --primary-color: #2ecc71; /* Emerald Green */
            --secondary-color: #27ae60; /* Darker Emerald Green */
            --accent-color: #3498db; /* Complementary Blue */
            --text-color: #333333; /* Dark Gray */
            --light-text: #666;
            --background-color: #fff;
            --light-background: #f0fdf4; /* Light Green Background */
            --border-color: #cccccc; /* Light Gray */
            --success-color: #2ecc71; /* Emerald Green */
            --warning-color: #f1c40f; /* Yellow */
            --error-color: #e74c3c; /* Red */
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
            color: white;
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
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
            color: white;
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
            
            .hamburger {
                display: flex;
            }
            
            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                height: 100vh;
                background-color: var(--secondary-color);
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 30px;
                transition: right 0.3s ease;
                z-index: 5;
                padding: 50px 0;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .nav-links a {
                font-size: 16px;
            }
            
            .update-card {
                flex-direction: column;
                text-align: center;
            }
            
            .update-image {
                width: 100%;
                max-width: 300px;
                margin: 0 auto 20px;
            }
            
            .intro-image {
                max-width: 300px;
                margin: 0 auto;
            }
            
            .article-card {
                max-width: 500px;
                margin: 0 auto 30px;
            }
        }

        @media (max-width: 480px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
            
            .hero h1 {
                font-size: 28px;
            }
            
            .hero p {
                font-size: 16px;
            }
            
            .intro-heading {
                font-size: 24px;
            }
            
            .stats-heading {
                font-size: 24px;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-number {
                font-size: 28px;
            }
            
            .testimonial-quote {
                font-size: 16px;
            }
            
            .testimonial-image {
                width: 150px;
                height: 150px;
            }
            
            .nav-links {
                width: 85%;
            }
            
            .hero {
                padding: 60px 0;
            }
            
            .btn-primary {
                padding: 8px 20px;
                font-size: 14px;
            }
            
            .intro-section,
            .stats-section,
            .testimonial-section,
            .updates-section {
                padding: 40px 0;
            }
            
            .cta-section {
                padding: 30px 0;
            }
            
            .cta-heading {
                font-size: 20px;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .newsletter-input {
                border-radius: 4px;
                margin-bottom: 10px;
            }
            
            .newsletter-button {
                border-radius: 4px;
                width: 100%;
            }
        }
    </style>
</head>

<body class="antialiased">
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">Letcon Global</div>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="nav-links">
                <a href="#">Home</a>
                <a href="#">About Us</a>
                <a href="#">How It Works</a>
                <a href="#">Testimonials</a>
                <a href="#">Contact</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
                @auth
                    @if(auth()->user()->hasRole('super-admin'))
                        <a href="{{ route('admin.dashboard') }}" style="color: var(--primary-color);">Admin Dashboard</a>
                    @else
                        <a href="{{ route('dashboard') }}" style="color: var(--primary-color);">My Dashboard</a>
                    @endif
                @endauth
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
            <p>A forward-thinking financial empowerment and networking platform committed to creating sustainable income
                opportunities.</p>
            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
        </div>
    </section>

    <!-- This is Letcon Global Section -->
    <section class="intro-section">
        <div class="container">
            <h2 class="intro-title">This is Letcon Global!</h2>
            <h3 class="intro-heading">Financial Empowerment Platform</h3>
            <div class="intro-content">
                <div class="intro-text">
                    <p>Letcon Global Company Limited (Letcon) is a forward-thinking financial empowerment and networking
                        platform committed to creating sustainable income opportunities through structured
                        collaboration, peer support, and progressive contribution models. Established with a vision to
                        foster financial inclusion and community-driven wealth creation, Letcon empowers individuals to
                        rise through levels of structured contributions and earn substantial returns.</p>
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
                <img src="{{ asset('assets/two-young-girls.jpg') }}" alt="Letcon Global Members">
            </div>
            <p class="testimonial-quote">"Our Mission: To build a trusted financial ecosystem where individuals can grow
                income, collaborate safely, and unlock prosperity through structured, transparent systems."</p>
            <p class="testimonial-quote">"Our Vision: To become Africa's most impactful financial collaboration
                platform, enabling communities to achieve collective success and financial freedom."</p>
            <div class="testimonial-author">Letcon Global</div>
            <div class="testimonial-role">Financial Empowerment Platform</div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-heading">How Letcon Works</h2>
            <p>Letcon operates a structured system where members register, contribute a specific financial amount, and
                move through defined Levels 1 to 10. At each level, members receive increased benefits and financial
                rewards based on participation and peer collaboration.</p>
            <a href="{{ route('register') }}" class="btn-primary">JOIN NOW</a>
        </div>
    </section>
    <!-- Updates Section -->
    <section class="updates-section">
        <div class="container">
            <h2 class="updates-heading">UPDATES</h2>
            <h3 class="updates-subheading">Latest News & Announcements</h3>

            <p class="updates-intro">Stay updated with Letcon Global's latest developments, success stories, and
                platform enhancements. Follow our journey as we build Africa's most impactful financial collaboration
                platform.</p>

            <div class="article-card full-width">
                {{-- <div class="article-image">
                    <img src="{{ asset('assets/people-3.webp') }}" alt="Letcon Global Launch">
                </div> --}}
                <div class="article-content">
                    <h4 class="article-title">Letcon Platform Launch</h4>
                    <p class="article-text">We're excited to announce the official launch of the Letcon Global platform,
                        designed to empower individuals through structured financial collaboration and peer support
                        systems.</p>
                    <a href="#" class="article-link">READ MORE</a>
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
                    <p class="footer-text">A forward-thinking financial empowerment and networking platform committed
                        to creating sustainable income opportunities through structured collaboration.</p>
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
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">How It Works</a></li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Slideshow functionality
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
            
            // Mobile menu functionality
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });
            
            // Close mobile menu when a link is clicked
            const navLinksItems = document.querySelectorAll('.nav-links a');
            navLinksItems.forEach(link => {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                });
            });
        });
    </script>
</body>

</html>
