<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Court Pulse</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --gold-h: #B5952F;
            --navy-deep: #0A1120;
            --navy-card: #1E293B;
            --navy-bg: #0F172A;
            --border: rgba(255, 255, 255, 0.1);
            --border2: rgba(212, 175, 55, 0.3);
            --muted: #94A3B8;
            --text: #F1F5F9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy-bg);
            min-height: 100vh;
            display: flex;
        }

        /* ── LEFT PANEL ─────────────────────────────────── */
        .auth-left {
            flex: 1;
            background: var(--navy-deep);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 64px;
            position: relative;
            overflow: hidden;
            border-right: 1px solid var(--border);
        }

        /* Gold cross pattern same as landing */
        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Glow blobs */
        .left-glow-1 {
            position: absolute;
            top: -15%;
            right: -15%;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.05);
            filter: blur(100px);
            pointer-events: none;
        }

        .left-glow-2 {
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(30, 41, 59, 0.4);
            filter: blur(80px);
            pointer-events: none;
        }

        /* Decorative circles */
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
            border: 1px solid rgba(212, 175, 55, 0.08);
            pointer-events: none;
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        .left-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            margin-bottom: 56px;
        }

        .logo-badge {
            width: 40px;
            height: 40px;
            border-radius: 9px;
            border: 1px solid rgba(212, 175, 55, 0.4);
            background: rgba(212, 175, 55, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.1rem;
        }

        .left-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 700;
            color: white;
            line-height: 1.12;
            margin-bottom: 18px;
        }

        .left-title .gold-italic {
            font-style: italic;
            color: var(--gold);
        }

        .left-desc {
            font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.75;
            max-width: 360px;
            font-weight: 300;
            margin-bottom: 40px;
        }

        .role-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .role-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .role-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
            box-shadow: 0 0 6px rgba(212, 175, 55, 0.4);
        }

        /* ── RIGHT PANEL ─────────────────────────────────── */
        .auth-right {
            width: 440px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 48px;
            flex-shrink: 0;
        }

        .auth-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .auth-sub {
            font-size: 0.86rem;
            color: #64748B;
            margin-bottom: 32px;
        }

        /* alerts */
        .alert-cp {
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            border: 1px solid;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.06);
            border-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        .alert-info {
            background: rgba(212, 175, 55, 0.08);
            border-color: rgba(212, 175, 55, 0.25);
            color: #92650a;
        }

        /* form */
        .cp-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.63rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #64748B;
            display: block;
            margin-bottom: 7px;
        }

        .cp-input {
            width: 100%;
            border: 1px solid #E2E8F0;
            border-radius: 7px;
            padding: 11px 14px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: #0F172A;
            background: #FAFAFA;
            transition: all 0.2s;
        }

        .cp-input:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
            background: white;
        }

        .cp-input.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .cp-input {
            padding-right: 42px;
        }

        .eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 0;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .eye-btn:hover {
            color: #0F172A;
        }

        .btn-submit {
            width: 100%;
            background: var(--gold);
            color: var(--navy-deep);
            border: none;
            padding: 13px;
            border-radius: 8px;
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.25);
        }

        .btn-submit:hover {
            background: var(--gold-h);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(212, 175, 55, 0.35);
        }

        .divider {
            text-align: center;
            font-size: 0.78rem;
            color: #94A3B8;
            margin: 22px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #E2E8F0;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .auth-link {
            color: var(--gold);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .auth-link:hover {
            color: var(--gold-h);
        }

        .demo-box {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #F1F5F9;
        }

        .demo-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.58rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #94A3B8;
            margin-bottom: 10px;
        }

        .demo-row {
            font-size: 0.74rem;
            color: #64748B;
            margin-bottom: 4px;
        }

        .demo-val {
            font-family: 'JetBrains Mono', monospace;
            color: #0F172A;
            font-size: 0.72rem;
        }

        .demo-pass {
            font-family: 'JetBrains Mono', monospace;
            color: var(--gold);
            font-size: 0.72rem;
        }

        /* responsive */
        @media(max-width:900px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                width: 100%;
                min-height: 100vh;
                padding: 40px 28px;
                justify-content: center;
            }
        }

        @media(max-width:480px) {
            .auth-right {
                padding: 32px 20px;
            }
        }
    </style>
</head>

<body>

    <div style="display:flex;min-height:100vh;width:100%;">

        <!-- ── LEFT PANEL ─────────────────────────────────────────── -->
        <div class="auth-left">
            <div class="left-glow-1"></div>
            <div class="left-glow-2"></div>
            <div class="left-ring-1"></div>
            <div class="left-ring-2"></div>

            <div class="left-content">
                <a href="{{ route('home') }}" class="left-logo">
                    <div class="logo-badge">⚖</div>
                    Court Pulse
                </a>

                <h1 class="left-title">
                    India's Legal<br>Professional<br>
                    <span class="gold-italic">Network.</span>
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

        <!-- ── RIGHT PANEL ────────────────────────────────────────── -->
        <div class="auth-right">

            @if (session('info'))
                <div class="alert-cp alert-info">
                    <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-cp alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="auth-heading">Welcome back</div>
            <div class="auth-sub">Sign in to your Court Pulse account</div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="cp-label">Email Address</label>
                    <input type="email" name="email"
                        class="cp-input {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="you@example.com"
                        value="{{ old('email') }}" required autocomplete="email">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="cp-label" style="margin-bottom:0;">Password</label>
                        <a href="{{ route('password.request') }}" class="auth-link" style="font-size:0.73rem;">Forgot
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

                <!-- Remember -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <input type="checkbox" name="remember" id="remember"
                        style="accent-color:var(--gold);width:15px;height:15px;">
                    <label for="remember" style="font-size:0.82rem;color:#64748B;cursor:pointer;margin:0;">Remember
                        me</label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>

            <div class="divider">or</div>

            <div class="text-center">
                <span style="font-size:0.85rem;color:#64748B;">Don't have an account? </span>
                <a href="{{ route('register') }}" class="auth-link">Create one free</a>
            </div>

            <!-- Demo credentials -->
            <div class="demo-box">
                <div class="demo-label">Demo Accounts</div>
                <div class="demo-row">Admin: <span class="demo-val">admin@courtpulse.com</span></div>
                <div class="demo-row">Advocate: <span class="demo-val">advocate@courtpulse.com</span></div>
                <div class="demo-row">Password: <span class="demo-pass">Admin@12345</span></div>
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
