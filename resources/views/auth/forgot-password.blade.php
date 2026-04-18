<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — DockIt</title>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            /* Brand Colors from Landing Page */
            --navy: #050812;
            --navy2: #080d1a;
            --navy3: #0b1120;
            --card: #0e1526;
            --card2: #111830;
            --blue: #B4B4FE;
            --blue2: #9999f0;
            --blue-glow: rgba(180, 180, 254, 0.3);
            --border: rgba(255, 255, 255, 0.06);
            --border2: rgba(180, 180, 254, 0.35);
            --text: #CBD5E1;
            --text2: #94A3B8;
            --muted: #4A5568;
            --white: #F8FAFC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            font-weight: 400;
            background: var(--navy);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ── LEFT PANEL ─────────────────────────────────── */
        .auth-left {
            flex: 1;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 64px;
            position: relative;
            overflow: hidden;
            border-right: 1px solid var(--border);
        }

        /* Accent cross pattern */
        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(180, 180, 254, .03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(180, 180, 254, .03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        /* Glow blobs */
        .left-glow-1 {
            position: absolute;
            top: -15%;
            right: -15%;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(180, 180, 254, .08) 0%, transparent 70%);
            pointer-events: none;
        }

        .left-glow-2 {
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(180, 180, 254, .05) 0%, transparent 70%);
            pointer-events: none;
        }

        .left-ring-1 {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.04);
            pointer-events: none;
        }

        .left-ring-2 {
            position: absolute;
            bottom: -120px;
            left: -60px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            border: 1px solid rgba(180, 180, 254, 0.08);
            pointer-events: none;
        }

        .left-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
        }

        /* Logo styling */
        .nav-logo {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--white);
            text-decoration: none;
            letter-spacing: .02em;
            margin-bottom: 56px;
            display: inline-flex;
        }

        .nav-logo img {
            border-radius: 6px;
        }

        .left-title {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 800;
            color: var(--white);
            line-height: 1.05;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
            text-transform: uppercase;
        }

        .accent-italic {
            color: var(--blue);
        }

        .left-desc {
            font-size: 0.95rem;
            color: var(--text2);
            line-height: 1.7;
            max-width: 400px;
            font-weight: 400;
            margin-bottom: 44px;
        }

        .rule-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .rule-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.85rem;
            color: var(--text2);
            font-weight: 500;
        }

        .rule-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--blue);
            flex-shrink: 0;
            box-shadow: 0 0 8px rgba(180, 180, 254, 0.4);
        }

        /* ── RIGHT PANEL (Dark Mode Native) ─────────────────────────────────── */
        .auth-right {
            width: 480px;
            background: var(--navy2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 48px;
            flex-shrink: 0;
            overflow-y: auto;
            position: relative;
            z-index: 2;
        }

        /* Mobile only logo */
        .mobile-logo {
            display: none;
            margin-bottom: 30px;
        }

        .auth-heading {
            font-family: 'Manrope', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 8px;
            letter-spacing: -0.02em;
            text-transform: uppercase;
        }

        .auth-sub {
            font-size: 0.85rem;
            color: var(--text2);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        /* alerts */
        .alert-cp {
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.82rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 24px;
            border: 1px solid;
            line-height: 1.5;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
            color: #4ade80;
        }

        /* form */
        .cp-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: block;
            margin-bottom: 8px;
        }

        .cp-input {
            width: 100%;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 0.88rem;
            color: var(--white);
            transition: all 0.25s;
            font-family: 'Manrope', sans-serif;
        }

        .cp-input:focus {
            outline: none;
            border-color: var(--border2);
            background: var(--card2);
            box-shadow: 0 0 0 3px rgba(180, 180, 254, 0.08);
        }

        .cp-input::placeholder {
            color: var(--muted);
        }

        .cp-input.is-invalid {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }

        .invalid-msg {
            font-size: 0.72rem;
            color: #fca5a5;
            margin-top: 6px;
        }

        /* Info box */
        .info-box {
            background: rgba(180, 180, 254, 0.05);
            border: 1px solid rgba(180, 180, 254, 0.15);
            border-radius: 8px;
            padding: 14px 16px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .info-box-text {
            font-size: 0.8rem;
            color: var(--text2);
            line-height: 1.6;
            font-weight: 500;
        }

        .info-box-text strong {
            color: var(--blue);
        }

        .btn-submit {
            width: 100%;
            background: var(--blue);
            color: #050812;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 800;
            cursor: pointer;
            font-family: 'Manrope', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: .06em;
            transition: all 0.25s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--blue2);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--blue-glow);
        }

        .auth-link {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .auth-link:hover {
            color: var(--white);
        }

        /* responsive */
        @media(max-width:991px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                width: 100%;
                min-height: 100vh;
                padding: 40px 32px;
                justify-content: center;
                background: var(--navy);
            }

            /* Center mobile logo */
            .mobile-logo {
                display: flex;
                align-self: center;
                margin-bottom: 30px;
            }
        }

        @media(max-width:480px) {
            .auth-right {
                padding: 32px 24px;
            }

            .auth-heading {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div style="display:flex;min-height:100vh;width:100%;">

        <div class="auth-left">
            <div class="left-glow-1"></div>
            <div class="left-glow-2"></div>
            <div class="left-ring-1"></div>
            <div class="left-ring-2"></div>
            <div class="left-content">

                <a href="{{ route('home') }}" class="nav-logo align-items-center">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="DockIt Logo"
                        style="height:40px; width:auto; margin-right:8px;">
                    DockIt
                </a>

                <h1 class="left-title">Recover Your<br><span class="accent-italic">Account.</span></h1>
                <p class="left-desc">Enter your registered email and we'll send a secure reset link. Valid for 60
                    minutes.</p>

                <div class="rule-list">
                    <div class="rule-item">
                        <div class="rule-dot"></div> Secure link sent instantly to your inbox
                    </div>
                    <div class="rule-item">
                        <div class="rule-dot"></div> Link expires in 60 minutes
                    </div>
                    <div class="rule-item">
                        <div class="rule-dot"></div> Your password stays safe until you reset
                    </div>
                    <div class="rule-item">
                        <div class="rule-dot"></div> DockIt never asks for your password
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-right">

            <a href="{{ route('home') }}" class="nav-logo mobile-logo align-items-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="DockIt Logo"
                    style="height:34px; width:auto; margin-right:8px;">
                DockIt
            </a>

            @if (session('status'))
                <div class="alert-cp alert-success">
                    <i class="bi bi-check-circle-fill" style="flex-shrink:0;margin-top:1px"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-cp alert-error">
                    <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;margin-top:1px"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="auth-heading">Forgot Password?</div>
            <div class="auth-sub">Enter your email address and we'll send you a link to reset your password.</div>

            <div class="info-box">
                <i class="bi bi-lightbulb-fill"
                    style="color:var(--blue);font-size:18px;flex-shrink:0;margin-top:1px"></i>
                <div class="info-box-text">
                    Check your <strong>spam / junk folder</strong> if you don't receive the email within a few minutes.
                </div>
            </div>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="cp-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="you@firm.legal" class="cp-input {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit mb-4">
                    <i class="bi bi-send-fill" style="font-size: 0.95rem;"></i> Send Reset Link
                </button>

                <div class="text-center mt-3">
                    <span style="font-size:0.85rem;color:var(--muted);font-weight:500;">Remember your password? </span>
                    <a href="{{ route('login') }}" class="auth-link">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
