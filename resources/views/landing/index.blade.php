<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Pulse — India's Legal Professional Network</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --gold-hover: #B5952F;
            --gold-light: #F2D06B;
            --navy-deep: #0A1120;
            --navy-card: #1E293B;
            --navy-bg: #0F172A;
            --border-dim: rgba(255, 255, 255, 0.1);
            --text-dim: #94A3B8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--navy-bg);
            color: #F1F5F9;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* ── GOLD PATTERN OVERLAY ─────────────────────────── */
        .gold-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .gold-gradient-text {
            background: linear-gradient(to right, #D4AF37, #F2D06B, #D4AF37);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        /* ── NAVBAR ───────────────────────────────────────── */
        .navbar-cp {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 20px 0;
            border-bottom: 1px solid var(--border-dim);
            backdrop-filter: blur(8px);
            background: transparent;
            transition: all 0.3s;
        }

        .navbar-cp.scrolled {
            background: rgba(10, 17, 32, 0.95);
            padding: 14px 0;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .logo-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(212, 175, 55, 0.5);
            background: var(--navy-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .nav-link-cp {
            font-size: 0.875rem;
            font-weight: 500;
            color: #CBD5E1 !important;
            text-decoration: none !important;
            transition: color 0.2s !important;
        }

        .nav-link-cp:hover {
            color: var(--gold) !important;
        }

        .btn-nav-login {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gold) !important;
            border: 1px solid rgba(212, 175, 55, 0.5);
            padding: 8px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
            background: transparent;
        }

        .btn-nav-login:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        /* ── HERO ─────────────────────────────────────────── */
        .hero-section {
            position: relative;
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--navy-deep);
            overflow: hidden;
            padding: 120px 0 80px;
        }

        .hero-section .gold-pattern {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 0;
            background: linear-gradient(to bottom, rgba(10, 17, 32, 0.8), rgba(10, 17, 32, 0.9), var(--navy-bg));
        }

        .hero-glow-1 {
            position: absolute;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.05);
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        .hero-glow-2 {
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(30, 41, 59, 0.3);
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dim);
            backdrop-filter: blur(8px);
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #CBD5E1;
            margin-bottom: 28px;
            animation: fadeUp 0.5s ease both;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(1.2);
            }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 9vw, 6rem);
            font-weight: 700;
            line-height: 1.08;
            color: white;
            margin-bottom: 24px;
            animation: fadeUp 0.5s 0.1s ease both;
        }

        .hero-desc {
            font-size: clamp(1rem, 2vw, 1.2rem);
            font-weight: 300;
            color: #94A3B8;
            max-width: 600px;
            margin: 0 auto 36px;
            line-height: 1.75;
            animation: fadeUp 0.5s 0.2s ease both;
        }

        .hero-btns {
            animation: fadeUp 0.5s 0.3s ease both;
        }

        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            background: var(--gold);
            color: var(--navy-deep) !important;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
            transition: all 0.25s;
        }

        .btn-gold:hover {
            background: var(--gold-hover);
            color: var(--navy-deep) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(212, 175, 55, 0.4);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            background: transparent;
            color: white !important;
            border: 1px solid rgba(148, 163, 184, 0.4);
            transition: all 0.25s;
        }

        .btn-ghost:hover {
            border-color: #94A3B8;
            color: white !important;
        }

        /* ── STATS BAND ───────────────────────────────────── */
        .stats-band {
            background: var(--navy-deep);
            border-top: 1px solid var(--border-dim);
            border-bottom: 1px solid var(--border-dim);
            padding: 64px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 700;
            color: var(--gold);
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-dim);
        }

        .stat-divider {
            border-right: 1px solid var(--border-dim);
        }

        @media(max-width:575px) {
            .stat-divider {
                border-right: none;
            }
        }

        /* ── FEATURES SECTION ────────────────────────────── */
        .section-features {
            padding: 96px 0;
            background: var(--navy-bg);
        }

        .sec-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 700;
            color: white;
        }

        .gold-divider {
            width: 80px;
            height: 4px;
            border-radius: 999px;
            background: var(--gold);
            margin: 16px auto 0;
        }

        .feat-card {
            background: var(--navy-card);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 28px;
            height: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .feat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .feat-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: rgba(212, 175, 55, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .feat-card:hover .feat-icon-wrap {
            background: var(--gold);
            color: var(--navy-deep);
        }

        .feat-icon-wrap .material-symbols-outlined {
            font-size: 1.75rem;
            color: var(--gold);
            transition: color 0.3s;
        }

        .feat-card:hover .feat-icon-wrap .material-symbols-outlined {
            color: var(--navy-deep);
        }

        .feat-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .feat-desc {
            font-size: 0.88rem;
            color: var(--text-dim);
            line-height: 1.7;
        }

        /* ── PORTALS SECTION ─────────────────────────────── */
        .section-portals {
            padding: 96px 0;
            background: var(--navy-deep);
            position: relative;
            overflow: hidden;
        }

        .portals-glow {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 80%;
            background: rgba(30, 41, 59, 0.2);
            filter: blur(150px);
            border-radius: 50%;
            pointer-events: none;
        }

        .portal-card {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-dim);
            border-radius: 12px;
            padding: 32px;
            height: 100%;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
            position: relative;
        }

        .portal-card:hover {
            color: inherit;
            background: var(--navy-card);
            border-color: rgba(212, 175, 55, 0.5);
            transform: translateY(-8px);
        }

        .portal-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            transition: all 0.3s;
        }

        .portal-icon .material-symbols-outlined {
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .portal-card:hover .portal-icon {
            background: var(--gold) !important;
        }

        .portal-card:hover .portal-icon .material-symbols-outlined {
            color: var(--navy-deep) !important;
        }

        .portal-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            transition: color 0.3s;
        }

        .portal-card:hover .portal-title {
            color: var(--gold);
        }

        .portal-desc {
            font-size: 0.84rem;
            color: var(--text-dim);
            flex-grow: 1;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .portal-cta {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--gold);
            opacity: 0;
            transform: translateX(-8px);
            transition: all 0.3s;
        }

        .portal-card:hover .portal-cta {
            opacity: 1;
            transform: translateX(0);
        }

        /* ── HOW IT WORKS ────────────────────────────────── */
        .section-how {
            padding: 96px 0;
            background: var(--navy-bg);
            border-top: 1px solid var(--border-dim);
        }

        .how-step {
            background: var(--navy-card);
            border: 1px solid var(--border-dim);
            border-radius: 12px;
            padding: 28px;
            height: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .how-step:hover {
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-4px);
        }

        .step-num {
            position: absolute;
            bottom: -10px;
            right: 16px;
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.04);
            line-height: 1;
            pointer-events: none;
        }

        .step-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 18px;
        }

        .step-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .step-desc {
            font-size: 0.82rem;
            color: var(--text-dim);
            line-height: 1.65;
        }

        /* ── FOOTER ──────────────────────────────────────── */
        footer {
            background: var(--navy-deep);
            border-top: 1px solid var(--border-dim);
            padding: 64px 0 32px;
            color: var(--text-dim);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
        }

        .footer-desc {
            font-size: 0.82rem;
            line-height: 1.65;
            max-width: 260px;
        }

        .footer-head {
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            margin-bottom: 16px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-links a {
            font-size: 0.84rem;
            color: var(--text-dim);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        .footer-bottom {
            border-top: 1px solid var(--border-dim);
            margin-top: 48px;
            padding-top: 24px;
        }

        .footer-copy {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.3);
        }

        /* ── ANIMATIONS ──────────────────────────────────── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: all 0.65s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-1 {
            transition-delay: 0.1s;
        }

        .delay-2 {
            transition-delay: 0.2s;
        }

        .delay-3 {
            transition-delay: 0.3s;
        }

        /* divider between stats on mobile */
        @media(max-width:767px) {
            .stat-item {
                padding: 16px 0;
                border-bottom: 1px solid var(--border-dim);
            }

            .stat-item:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>

<body>

    <!-- ── NAVBAR ─────────────────────────────────────────────────────── -->
    <nav class="navbar-cp" id="navbar">
        <div class="container-xl px-4">
            <div class="d-flex align-items-center justify-content-between">
                <a href="/" class="nav-logo">
                    <div class="logo-circle">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                            style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    </div>
                    Court Pulse
                </a>
                <div class="d-none d-md-flex align-items-center gap-4">
                    <a href="#features" class="nav-link-cp">Features</a>
                    <a href="#portals" class="nav-link-cp">Portals</a>
                    <a href="#how-it-works" class="nav-link-cp">How It Works</a>
                    <a href="#stats" class="nav-link-cp">Community</a>
                    <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
                </div>
                <div class="d-md-none d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn-nav-login"
                        style="padding:6px 14px;font-size:0.8rem;">Login</a>
                    <a href="{{ route('register') }}" class="btn-gold"
                        style="padding:6px 14px;font-size:0.8rem;">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ── HERO ───────────────────────────────────────────────────────── -->
    <header class="hero-section">
        <div class="gold-pattern" style="position:absolute;inset:0;z-index:0;"></div>
        <div class="hero-overlay"></div>
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>

        <div class="container-xl px-4 position-relative" style="z-index:1;">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="badge-dot"></span>
                    The Premier Professional Network
                </div>
                <h1 class="hero-title">
                    Where <br>
                    <span class="gold-gradient-text fst-italic">Professionals Connect</span>
                </h1>
                <p class="hero-desc">
                    Court Pulse brings together Advocates, Clerks, Chartered Accountants and citizens — with verified
                    profiles, transparent feedback, and seamless legal networking across India.
                </p>
                <div class="hero-btns d-flex flex-column flex-sm-row align-items-center justify-content-center gap-3">
                    <a href="{{ route('register') }}" class="btn-gold">
                        <i class="bi bi-person-plus-fill"></i> Get Started Free
                    </a>
                    <a href="#features" class="btn-ghost">
                        Learn More <i class="bi bi-arrow-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ── STATS BAND ─────────────────────────────────────────────────── -->
    <section class="stats-band" id="stats">
        <div class="container-xl px-4">
            <div class="row g-0 text-center">
                <div class="col-6 col-md-3 stat-item stat-divider">
                    <div class="stat-num">{{ $totalAdvocates ?? '500' }}+</div>
                    <div class="stat-label">Verified Advocates</div>
                </div>
                <div class="col-6 col-md-3 stat-item stat-divider">
                    <div class="stat-num">{{ $totalClerks ?? '300' }}+</div>
                    <div class="stat-label">Court Clerks</div>
                </div>
                <div class="col-6 col-md-3 stat-item stat-divider">
                    <div class="stat-num">{{ $totalCourts ?? '50' }}+</div>
                    <div class="stat-label">Courts Listed</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="stat-num">24/7</div>
                    <div class="stat-label">Platform Access</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── FEATURES ───────────────────────────────────────────────────── -->
    <section class="section-features" id="features">
        <div class="container-xl px-4">
            <div class="text-center mb-5 reveal">
                <h2 class="sec-title">Elevating Legal Standards</h2>
                <div class="gold-divider"></div>
            </div>
            <div class="row g-4">
                <div class="col-md-4 reveal">
                    <div class="feat-card">
                        <div class="feat-icon-wrap">
                            <span class="material-symbols-outlined">verified_user</span>
                        </div>
                        <div class="feat-title">For Advocates</div>
                        <p class="feat-desc">Instantly access a directory of verified, skilled Court Clerks and CAs.
                            Filter by specialization, court, and city to find the perfect match for your practice.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal delay-1">
                    <div class="feat-card">
                        <div class="feat-icon-wrap">
                            <span class="material-symbols-outlined">trending_up</span>
                        </div>
                        <div class="feat-title">For Clerks & CAs</div>
                        <p class="feat-desc">Showcase your verified certifications, receive professional feedback, and
                            connect with Advocates and legal firms looking for your specific expertise.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal delay-2">
                    <div class="feat-card">
                        <div class="feat-icon-wrap">
                            <span class="material-symbols-outlined">lock_open</span>
                        </div>
                        <div class="feat-title">Feedback-Unlock System</div>
                        <p class="feat-desc">Our unique model rewards engagement — give a star rating to any
                            professional and their complete contact details are instantly unlocked for you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── PORTALS ────────────────────────────────────────────────────── -->
    <section class="section-portals" id="portals">
        <div class="portals-glow"></div>
        <div class="container-xl px-4 position-relative" style="z-index:1;">
            <div class="text-center mb-5 reveal">
                <h2 class="sec-title">Choose Your Portal</h2>
                <p class="mt-3"
                    style="color:var(--text-dim);max-width:480px;margin-left:auto;margin-right:auto;font-size:0.95rem;">
                    Secure access points tailored for every role in the legal ecosystem.
                </p>
            </div>
            <div class="row g-4">
                <!-- Advocate -->
                <div class="col-md-6 col-lg-3 reveal">
                    <a href="{{ route('register') }}?role=advocate" class="portal-card">
                        <div class="portal-icon" style="background:rgba(59,130,246,0.2);">
                            <span class="material-symbols-outlined" style="color:#60A5FA;">gavel</span>
                        </div>
                        <div class="portal-title">Advocate</div>
                        <p class="portal-desc">Manage your verified profile, search Clerks & CAs, upload legal
                            documents, and build your professional reputation.</p>
                        <div class="portal-cta">
                            Login / Register <span class="material-symbols-outlined"
                                style="font-size:1rem;">arrow_forward</span>
                        </div>
                    </a>
                </div>
                <!-- Clerk -->
                <div class="col-md-6 col-lg-3 reveal delay-1">
                    <a href="{{ route('register') }}?role=clerk" class="portal-card">
                        <div class="portal-icon" style="background:rgba(16,185,129,0.2);">
                            <span class="material-symbols-outlined" style="color:#34D399;">assignment_ind</span>
                        </div>
                        <div class="portal-title">Court Clerk</div>
                        <p class="portal-desc">Upload court credentials, connect with Advocates and CAs. Submit
                            compulsory feedback to unlock full contact access.</p>
                        <div class="portal-cta">
                            Login / Register <span class="material-symbols-outlined"
                                style="font-size:1rem;">arrow_forward</span>
                        </div>
                    </a>
                </div>
                <!-- CA -->
                <div class="col-md-6 col-lg-3 reveal delay-2">
                    <a href="{{ route('register') }}?role=ca" class="portal-card">
                        <div class="portal-icon" style="background:rgba(212,175,55,0.15);">
                            <span class="material-symbols-outlined" style="color:var(--gold);">account_balance</span>
                        </div>
                        <div class="portal-title">Chartered Accountant</div>
                        <p class="portal-desc">ICAI-verified profile, connect with legal professionals, manage
                            documents, and expand your legal-financial network.</p>
                        <div class="portal-cta">
                            Login / Register <span class="material-symbols-outlined"
                                style="font-size:1rem;">arrow_forward</span>
                        </div>
                    </a>
                </div>
                <!-- Guest -->
                <div class="col-md-6 col-lg-3 reveal delay-3">
                    <a href="{{ route('register') }}?role=guest" class="portal-card">
                        <div class="portal-icon" style="background:rgba(168,85,247,0.2);">
                            <span class="material-symbols-outlined" style="color:#C084FC;">person_search</span>
                        </div>
                        <div class="portal-title">Guest / Public</div>
                        <p class="portal-desc">No documents needed. Browse the directory of verified legal
                            professionals and give feedback to unlock full contact details.</p>
                        <div class="portal-cta">
                            Continue <span class="material-symbols-outlined"
                                style="font-size:1rem;">arrow_forward</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ── HOW IT WORKS ───────────────────────────────────────────────── -->
    <section class="section-how" id="how-it-works">
        <div class="container-xl px-4">
            <div class="text-center mb-5 reveal">
                <h2 class="sec-title">How Court Pulse Works</h2>
                <div class="gold-divider"></div>
                <p class="mt-3" style="color:var(--text-dim);font-size:0.92rem;">Four simple steps from registration
                    to verified network access.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="how-step">
                        <div class="step-num">01</div>
                        <div class="step-icon-wrap" style="background:rgba(212,175,55,0.12);">📝</div>
                        <div class="step-title">Register Free</div>
                        <p class="step-desc">Choose your role — Advocate, Clerk, CA, or Guest. Basic details only.
                            Takes under 2 minutes.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-1">
                    <div class="how-step">
                        <div class="step-num">02</div>
                        <div class="step-icon-wrap" style="background:rgba(26,39,68,0.3);">📂</div>
                        <div class="step-title">Upload Documents</div>
                        <p class="step-desc">Submit Bar Council cert, Court ID, ICAI membership, or other role-specific
                            credentials for review.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-2">
                    <div class="how-step">
                        <div class="step-num">03</div>
                        <div class="step-icon-wrap" style="background:rgba(74,103,65,0.15);">🛡️</div>
                        <div class="step-title">Get Verified</div>
                        <p class="step-desc">Admin reviews every document. Approved profiles receive a Verified badge
                            visible to the whole network.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-3">
                    <div class="how-step">
                        <div class="step-num">04</div>
                        <div class="step-icon-wrap" style="background:rgba(139,58,42,0.15);">⚡</div>
                        <div class="step-title">Connect & Grow</div>
                        <p class="step-desc">Search professionals, give feedback to unlock contacts, build your legal
                            network across India.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── FOOTER ─────────────────────────────────────────────────────── -->
    <footer>
        <div class="container-xl px-4">
            <div class="row g-4">
                <div class="col-lg-4 col-md-12">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                            style="width:32px;height:32px;object-fit:cover;border-radius:50%;">
                        Court Pulse
                    </div>
                    <p class="footer-desc">Empowering the legal community through digital connectivity and verified
                        professional networks across India.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#"
                            style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;transition:all 0.2s;text-decoration:none;color:var(--text-dim);"
                            onmouseover="this.style.background='var(--gold)';this.style.color='var(--navy-deep)';"
                            onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='var(--text-dim)';">
                            <i class="bi bi-twitter-x" style="font-size:0.85rem;"></i>
                        </a>
                        <a href="#"
                            style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;transition:all 0.2s;text-decoration:none;color:var(--text-dim);"
                            onmouseover="this.style.background='var(--gold)';this.style.color='var(--navy-deep)';"
                            onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='var(--text-dim)';">
                            <i class="bi bi-envelope" style="font-size:0.85rem;"></i>
                        </a>
                        <a href="#"
                            style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;transition:all 0.2s;text-decoration:none;color:var(--text-dim);"
                            onmouseover="this.style.background='var(--gold)';this.style.color='var(--navy-deep)';"
                            onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='var(--text-dim)';">
                            <i class="bi bi-linkedin" style="font-size:0.85rem;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-2 offset-lg-2">
                    <div class="footer-head">Platform</div>
                    <ul class="footer-links">
                        <li><a href="#features">For Advocates</a></li>
                        <li><a href="#features">For Clerks</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="footer-head">Join As</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('register') }}?role=advocate">Advocate</a></li>
                        <li><a href="{{ route('register') }}?role=clerk">Court Clerk</a></li>
                        <li><a href="{{ route('register') }}?role=ca">CA</a></li>
                        <li><a href="{{ route('register') }}?role=guest">Guest</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="footer-head">Legal</div>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Contact Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div class="footer-copy">© {{ date('Y') }} Court Pulse. All rights reserved.</div>
                <div class="footer-copy">Designed for Legal Excellence.</div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 60);
        });

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, {
            threshold: 0.12
        });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>

</html>
