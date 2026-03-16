<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Court Pulse</title>
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
            --navy-bg: #0F172A;
            --border: rgba(255, 255, 255, 0.1);
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

        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

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

        .gold-italic {
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

        .rule-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rule-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .rule-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
            box-shadow: 0 0 6px rgba(212, 175, 55, 0.4);
        }

        .auth-right {
            width: 440px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 48px;
            flex-shrink: 0;
            overflow-y: auto;
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
            line-height: 1.6;
        }

        .alert-cp {
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.82rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 20px;
            border: 1px solid;
            line-height: 1.5;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.06);
            border-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        .cp-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.63rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #64748B;
            display: block;
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .cp-input {
            width: 100%;
            border: 1px solid #E2E8F0;
            border-radius: 7px;
            padding: 11px 44px 11px 14px;
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
        }

        .invalid-msg {
            font-size: 0.78rem;
            color: #ef4444;
            margin-top: 5px;
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

        /* Strength bar */
        .strength-bar {
            display: flex;
            gap: 4px;
            margin-top: 7px;
        }

        .strength-seg {
            height: 3px;
            flex: 1;
            border-radius: 2px;
            background: #F1F5F9;
            transition: background 0.3s;
        }

        .strength-label {
            font-size: 0.72rem;
            color: #94A3B8;
            margin-top: 4px;
            min-height: 16px;
            transition: color 0.3s;
        }

        .match-label {
            font-size: 0.72rem;
            margin-top: 4px;
            min-height: 16px;
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

        .auth-link {
            color: var(--gold);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .auth-link:hover {
            color: var(--gold-h);
        }

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

        <!-- LEFT -->
        <div class="auth-left">
            <div class="left-glow-1"></div>
            <div class="left-glow-2"></div>
            <div class="left-ring-1"></div>
            <div class="left-ring-2"></div>
            <div class="left-content">
                <a href="{{ route('home') }}" class="left-logo">
                    <div class="logo-badge">⚖</div> Court Pulse
                </a>
                <h1 class="left-title">Create a New<br><span class="gold-italic">Strong Password.</span></h1>
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

        <!-- RIGHT -->
        <div class="auth-right">

            @if ($errors->any())
                <div class="alert-cp alert-error">
                    <i class="bi bi-exclamation-circle-fill" style="flex-shrink:0;margin-top:1px"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="auth-heading">Set New Password</div>
            <div class="auth-sub">
                Create a strong new password for <strong
                    style="color:#0F172A;">{{ request()->query('email', '') }}</strong>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                {{-- Laravel requires these hidden fields --}}
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->query('email', old('email')) }}">

                <!-- New Password -->
                <div class="mb-3">
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

                <!-- Confirm Password -->
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
                    <i class="bi bi-shield-check"></i> Reset Password
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

            [1, 2, 3, 4].forEach(i => {
                document.getElementById('s' + i).style.background = i <= score ? colors[score] : '#F1F5F9';
            });
            const lbl = document.getElementById('strengthLabel');
            lbl.textContent = labels[score];
            lbl.style.color = colors[score] || '#94A3B8';
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
                lbl.style.color = '#22c55e';
            } else {
                lbl.textContent = '✗ Passwords do not match';
                lbl.style.color = '#ef4444';
            }
        }
    </script>
</body>

</html>
