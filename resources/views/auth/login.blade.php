<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Court Pulse</title>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
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
            letter-spacing: -0.03em;
            text-transform: uppercase;
        }

        .left-title .accent {
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

        .role-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .role-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.85rem;
            color: var(--text2);
            font-weight: 500;
        }

        .role-dot {
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
            margin-bottom: 36px;
        }

        /* alerts */
        .alert-cp {
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.82rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            border: 1px solid;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-info {
            background: rgba(180, 180, 254, 0.1);
            border-color: rgba(180, 180, 254, 0.3);
            color: var(--blue);
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

        .input-wrap {
            position: relative;
        }

        .input-wrap .cp-input {
            padding-right: 46px;
        }

        .eye-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px;
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .eye-btn:hover {
            color: var(--white);
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
        }

        .btn-submit:hover {
            background: var(--blue2);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--blue-glow);
        }

        .divider {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
            margin: 28px 0;
            position: relative;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: var(--border);
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
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

        .demo-box {
            margin-top: 32px;
            padding: 24px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .demo-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-row {
            font-size: 0.78rem;
            color: var(--text2);
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
        }

        .demo-val {
            color: var(--white);
            font-weight: 600;
        }

        .demo-pass {
            color: var(--blue);
            font-weight: 700;
        }

        /* Checkbox styling */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-checkbox {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1px solid var(--border2);
            border-radius: 4px;
            background: var(--card);
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .custom-checkbox:checked {
            background: var(--blue);
            border-color: var(--blue);
        }

        .custom-checkbox:checked::after {
            content: '';
            width: 4px;
            height: 9px;
            border: solid #050812;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) translateY(-1px);
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

            /* ✅ Logo Center Alignment for Mobile */
            .mobile-logo {
                display: flex;
                align-self: center;
                /* Center horizontally */
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

            <div class="left-content">

                <a href="{{ route('home') }}" class="nav-logo align-items-center">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                        style="height:40px; width:auto; margin-right:8px;">
                    Court Pulse
                </a>

                <h1 class="left-title">
                    India's Legal<br>Professional<br>
                    <span class="accent">Network.</span>
                </h1>
                <p class="left-desc">
                    Verified advocates, court clerks, and CAs — all in one trusted platform for India's legal ecosystem.
                </p>

                <div class="role-list">
                    <div class="role-item">
                        <div class="role-dot"></div> Advocates — Bar Council Verified
                    </div>
                    <div class="role-item">
                        <div class="role-dot"></div> Court Clerks — Court ID Verified
                    </div>
                    <div class="role-item">
                        <div class="role-dot"></div> Chartered Accountants — ICAI Verified
                    </div>
                    <div class="role-item">
                        <div class="role-dot"></div> Guest Users — Instant Access
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-right">

            <a href="{{ route('home') }}" class="nav-logo mobile-logo align-items-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                    style="height:34px; width:auto; margin-right:8px;">
                Court Pulse
            </a>

            @if (session('info'))
                <div class="alert-cp alert-info">
                    <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-cp alert-error">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="auth-heading">Welcome back</div>
            <div class="auth-sub">Sign in to your Court Pulse account</div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="cp-label">Email Address</label>
                    <input type="email" name="email"
                        class="cp-input {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="you@firm.legal"
                        value="{{ old('email') }}" required autocomplete="email">
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="cp-label" style="margin-bottom:0;">Password</label>
                        <a href="{{ route('password.request') }}" class="auth-link" style="font-size:0.75rem;">Forgot
                            password?</a>
                    </div>
                    <div class="input-wrap">
                        <input type="password" name="password" id="passField" class="cp-input" placeholder="••••••••"
                            required autocomplete="current-password">
                        <button type="button" class="eye-btn" onclick="togglePass()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="checkbox-wrapper mb-5">
                    <input type="checkbox" name="remember" id="remember" class="custom-checkbox">
                    <label for="remember"
                        style="font-size:0.85rem;color:var(--text2);cursor:pointer;margin:0;font-weight:500;">Remember
                        me</label>
                </div>

                <button type="submit" class="btn-submit">
                    Sign In <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="divider">Or Continue With</div>

            <div class="text-center">
                <span style="font-size:0.85rem;color:var(--muted);font-weight:500;">Don't have an account? </span>
                <a href="{{ route('register') }}" class="auth-link">Create one free</a>
            </div>

            <div class="demo-box">
                <div class="demo-label"><i class="bi bi-terminal"></i> Demo Credentials</div>
                <div class="demo-row">Admin: <span class="demo-val">admin@courtpulse.com</span></div>
                <div class="demo-row">Advocate: <span class="demo-val">advocate@courtpulse.com</span></div>
                <div class="demo-row mt-1">Password: <span class="demo-pass">Admin@12345</span></div>
            </div>
        </div>

    </div>

    <script>
        function togglePass() {
            const f = document.getElementById('passField');
            const i = document.getElementById('eyeIcon');
            if (f.type === 'password') {
                f.type = 'text';
                i.className = 'bi bi-eye-slash';
            } else {
                f.type = 'password';
                i.className = 'bi bi-eye';
            }
        }
    </script>
</body>

</html>
