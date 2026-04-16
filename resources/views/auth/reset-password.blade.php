<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Court Pulse</title>

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
            letter-spacing: -0.03em;
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
            margin-bottom: 36px;
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
            padding: 14px 46px 14px 16px;
            /* Right padding for eye icon */
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

        .invalid-msg {
            font-size: 0.72rem;
            color: #fca5a5;
            margin-top: 6px;
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

        /* Strength bar */
        .strength-bar {
            display: flex;
            gap: 6px;
            margin-top: 10px;
        }

        .strength-seg {
            height: 4px;
            flex: 1;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.1);
            transition: background 0.3s;
        }

        .strength-label {
            font-size: 0.72rem;
            color: var(--muted);
            margin-top: 6px;
            min-height: 16px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .match-label {
            font-size: 0.72rem;
            margin-top: 6px;
            min-height: 16px;
            font-weight: 600;
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
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                        style="height:40px; width:auto; margin-right:8px;">
                    Court Pulse
                </a>

                <h1 class="left-title">Create a New<br><span class="accent-italic">Strong Password.</span></h1>
                <p class="left-desc">Choose a password that's hard to guess. Mix uppercase, lowercase, numbers and
                    symbols.</p>
                <div class="rule-list">
                    <div class="rule-item">
                        <div class="rule-dot"></div> Minimum 8 characters required
                    </div>
                    <div class="rule-item">
                        <div class="rule-dot"></div> Use uppercase &amp; lowercase letters
                    </div>
                    <div class="rule-item">
                        <div class="rule-dot"></div> Include numbers and symbols
                    </div>
                    <div class="rule-item">
                        <div class="rule-dot"></div> Don't reuse old passwords
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

            @if ($errors->any())
                <div class="alert-cp alert-error">
                    <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;margin-top:1px"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="auth-heading">Set New Password</div>
            <div class="auth-sub">
                Create a strong new password for <br>
                <strong style="color:var(--white); font-weight: 700;">{{ request()->query('email', '') }}</strong>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                {{-- Laravel requires these hidden fields --}}
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->query('email', old('email')) }}">

                <div class="mb-4">
                    <label class="cp-label">New Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="newPass" required placeholder="Min. 8 characters"
                            class="cp-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            oninput="checkStrength(this.value)">
                        <button type="button" class="eye-btn" onclick="togglePass('newPass', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-seg" id="s1"></div>
                        <div class="strength-seg" id="s2"></div>
                        <div class="strength-seg" id="s3"></div>
                        <div class="strength-seg" id="s4"></div>
                    </div>
                    <div class="strength-label" id="strengthLabel"></div>
                    @error('password')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="cp-label">Confirm New Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password_confirmation" id="confirmPass" required
                            placeholder="Repeat your password"
                            class="cp-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            oninput="checkMatch()">
                        <button type="button" class="eye-btn" onclick="togglePass('confirmPass', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="match-label" id="matchLabel"></div>
                    @error('password_confirmation')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit mb-4">
                    Reset Password <i class="bi bi-arrow-right"></i>
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="auth-link">
                        <i class="bi bi-arrow-left" style="font-size:0.75rem;"></i> Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePass(id, btn) {
            const f = document.getElementById(id);
            const i = btn.querySelector('i');
            if (f.type === 'password') {
                f.type = 'text';
                i.className = 'bi bi-eye-slash';
            } else {
                f.type = 'password';
                i.className = 'bi bi-eye';
            }
        }

        function checkStrength(val) {
            const colors = {
                1: '#ef4444',
                2: '#f97316',
                3: '#eab308',
                4: '#22c55e'
            };
            const labels = {
                0: '',
                1: 'Weak',
                2: 'Fair',
                3: 'Good',
                4: 'Strong 💪'
            };
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            // Dark theme empty segment color: rgba(255, 255, 255, 0.1)
            [1, 2, 3, 4].forEach(i => {
                document.getElementById('s' + i).style.background = i <= score ? colors[score] :
                    'rgba(255, 255, 255, 0.1)';
            });
            const lbl = document.getElementById('strengthLabel');
            lbl.textContent = labels[score];
            lbl.style.color = colors[score] || 'var(--muted)';
            checkMatch();
        }

        function checkMatch() {
            const pw1 = document.getElementById('newPass').value;
            const pw2 = document.getElementById('confirmPass').value;
            const lbl = document.getElementById('matchLabel');
            if (!pw2) {
                lbl.textContent = '';
                return;
            }
            if (pw1 === pw2) {
                lbl.textContent = '✓ Passwords match';
                lbl.style.color = '#4ade80'; // Matching green
            } else {
                lbl.textContent = '✗ Passwords do not match';
                lbl.style.color = '#fca5a5'; // Error red
            }
        }
    </script>
</body>

</html>
