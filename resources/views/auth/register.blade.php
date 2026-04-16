<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Court Pulse</title>

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

        /* ── LEFT PANEL ──────────────────────────────────── */
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
        .glow-1 {
            position: absolute;
            top: -15%;
            right: -15%;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(180, 180, 254, .08) 0%, transparent 70%);
            pointer-events: none;
        }

        .glow-2 {
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(180, 180, 254, .05) 0%, transparent 70%);
            pointer-events: none;
        }

        .left-inner {
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
            margin-bottom: 48px;
            display: inline-flex;
        }

        .nav-logo img {
            border-radius: 6px;
        }

        .left-title {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(2.2rem, 3.5vw, 3rem);
            font-weight: 800;
            color: var(--white);
            line-height: 1.05;
            margin-bottom: 16px;
            letter-spacing: -0.03em;
            text-transform: uppercase;
        }

        .left-title .gi {
            color: var(--blue);
        }

        .left-desc {
            font-size: 0.95rem;
            color: var(--text2);
            line-height: 1.7;
            max-width: 400px;
            font-weight: 400;
            margin-bottom: 40px;
        }

        /* 2×2 role mini cards on left */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .role-mini {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.25s;
            user-select: none;
        }

        .role-mini:hover,
        .role-mini.selected {
            background: var(--card2);
            border-color: var(--border2);
            transform: translateY(-2px);
        }

        .rm-icon {
            font-size: 1.3rem;
            margin-bottom: 6px;
        }

        .rm-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text);
            transition: color 0.2s;
            letter-spacing: .02em;
        }

        .role-mini:hover .rm-name,
        .role-mini.selected .rm-name {
            color: var(--blue);
        }

        .rm-note {
            font-size: 0.7rem;
            color: var(--muted);
            margin-top: 3px;
        }

        /* ── RIGHT PANEL (Dark Mode Native) ──────────────────────────────────── */
        .auth-right {
            width: 540px;
            flex-shrink: 0;
            background: var(--navy2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
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
            margin-bottom: 28px;
        }

        /* Role tabs (Dark Theme) */
        .role-tabs {
            display: flex;
            gap: 6px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 6px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
        }

        .role-tab {
            flex: 1;
            padding: 10px 6px;
            border: none;
            background: transparent;
            color: var(--text2);
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Manrope', sans-serif;
            text-align: center;
            letter-spacing: 0.02em;
        }

        .role-tab.active {
            background: var(--blue);
            color: var(--navy);
            font-weight: 800;
            box-shadow: 0 2px 8px var(--blue-glow);
        }

        /* Notes */
        .note-box {
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 0.8rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
            border: 1px solid;
            font-weight: 500;
        }

        .note-prof {
            background: rgba(180, 180, 254, 0.08);
            border-color: rgba(180, 180, 254, 0.25);
            color: var(--blue);
        }

        .note-guest {
            background: rgba(34, 197, 94, 0.06);
            border-color: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }

        .note-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        /* Form */
        .cp-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: block;
            margin-bottom: 8px;
        }

        .cp-input,
        .cp-select {
            width: 100%;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.88rem;
            color: var(--white);
            transition: all 0.25s;
            font-family: 'Manrope', sans-serif;
        }

        .cp-input:focus,
        .cp-select:focus {
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

        .error-msg {
            font-size: 0.72rem;
            color: #fca5a5;
            margin-top: 6px;
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
            margin-top: 12px;
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

        /* Checkbox styling */
        .checkbox-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 12px;
            margin-bottom: 8px;
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
            flex-shrink: 0;
            margin-top: 2px;
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

            /* Center mobile logo */
            .mobile-logo {
                display: flex;
                align-self: center;
                margin-bottom: 30px;
            }
        }

        @media(max-width:480px) {
            .auth-right {
                padding: 32px 20px;
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
            <div class="glow-1"></div>
            <div class="glow-2"></div>

            <div class="left-inner">
                <a href="{{ route('home') }}" class="nav-logo align-items-center">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                        style="height:40px; width:auto; margin-right:8px;">
                    Court Pulse
                </a>

                <h1 class="left-title">
                    Join the<br>Legal <span class="gi">Network</span><br>of India.
                </h1>
                <p class="left-desc">
                    Select your role and get registered. Professionals need document verification — guests get instant
                    access.
                </p>

                <div class="role-grid" id="leftRoleGrid">
                    <div class="role-mini" onclick="selectRole('advocate')">
                        <div class="rm-icon">⚖️</div>
                        <div class="rm-name">Advocate</div>
                        <div class="rm-note">Bar Council verified</div>
                    </div>
                    <div class="role-mini" onclick="selectRole('clerk')">
                        <div class="rm-icon">🗂️</div>
                        <div class="rm-name">Court Clerk</div>
                        <div class="rm-note">Court ID verified</div>
                    </div>
                    <div class="role-mini" onclick="selectRole('ca')">
                        <div class="rm-icon">📊</div>
                        <div class="rm-name">CA</div>
                        <div class="rm-note">ICAI verified</div>
                    </div>
                    <div class="role-mini" onclick="selectRole('guest')">
                        <div class="rm-icon">👤</div>
                        <div class="rm-name">Guest</div>
                        <div class="rm-note">Instant access</div>
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

            <div class="auth-heading">Create Account</div>
            <div class="auth-sub">Join Court Pulse — India's legal professional network</div>

            @if ($errors->any())
                <div class="note-box note-error">
                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="role-tabs">
                <button type="button" class="role-tab" onclick="selectRole('advocate')">⚖ Advocate</button>
                <button type="button" class="role-tab" onclick="selectRole('clerk')">🗂 Clerk</button>
                <button type="button" class="role-tab" onclick="selectRole('ca')">📊 CA</button>
                <button type="button" class="role-tab" onclick="selectRole('guest')">👤 Guest</button>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'advocate') }}">

                <div class="note-box note-prof" id="noteProf">
                    <i class="bi bi-shield-lock-fill mt-1"></i>
                    <span>Professionals require document upload &amp; admin verification after registration.</span>
                </div>
                <div class="note-box note-guest d-none" id="noteGuest">
                    <i class="bi bi-check-circle-fill mt-1"></i>
                    <span>Guest accounts are activated instantly — no documents needed!</span>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="cp-label">Full Name</label>
                        <input type="text" name="name"
                            class="cp-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Rajesh Kumar Sharma" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">Email Address</label>
                        <input type="email" name="email"
                            class="cp-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="you@example.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">Phone Number</label>
                        <input type="text" name="phone"
                            class="cp-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            placeholder="10-digit mobile" value="{{ old('phone') }}" maxlength="10" required>
                        @error('phone')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">Password</label>
                        <input type="password" name="password"
                            class="cp-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Min. 8 characters" required>
                        @error('password')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="cp-input"
                            placeholder="Repeat password" required>
                    </div>
                </div>

                <div id="advocateFields" class="mt-3">
                    <label class="cp-label">City / State of Practice</label>
                    <input type="text" name="city" class="cp-input" placeholder="e.g. Mumbai, Maharashtra"
                        value="{{ old('city') }}">
                </div>
                <div id="clerkFields" class="d-none mt-3">
                    <label class="cp-label">Court Name</label>
                    <input type="text" name="court_name_reg" class="cp-input"
                        placeholder="e.g. Bombay High Court" value="{{ old('court_name_reg') }}">
                </div>
                <div id="caFields" class="d-none mt-3">
                    <label class="cp-label">ICAI Membership Number</label>
                    <input type="text" name="membership_number_reg" class="cp-input" placeholder="e.g. 123456"
                        value="{{ old('membership_number_reg') }}">
                </div>

                <div class="checkbox-wrapper">
                    <input type="checkbox" id="terms" name="terms" class="custom-checkbox" required>
                    <label for="terms"
                        style="font-size:0.8rem;color:var(--text2);cursor:pointer;margin:0;font-weight:500;">
                        I agree to the <a href="#" class="auth-link">Terms of Use</a>
                        and <a href="#" class="auth-link">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Create Account <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="text-center mt-4">
                <span style="font-size:0.85rem;color:var(--muted);font-weight:500;">Already have an account? </span>
                <a href="{{ route('login') }}" class="auth-link">Sign in</a>
            </div>
        </div>
    </div>

    <script>
        const ROLES = ['advocate', 'clerk', 'ca', 'guest'];

        function selectRole(role) {
            document.getElementById('roleInput').value = role;

            // Tabs
            document.querySelectorAll('.role-tab').forEach((t, i) => {
                t.classList.toggle('active', ROLES[i] === role);
            });

            // Left mini cards
            document.querySelectorAll('.role-mini').forEach((c, i) => {
                c.classList.toggle('selected', ROLES[i] === role);
            });

            // Role fields
            document.getElementById('advocateFields').classList.toggle('d-none', role !== 'advocate');
            document.getElementById('clerkFields').classList.toggle('d-none', role !== 'clerk');
            document.getElementById('caFields').classList.toggle('d-none', role !== 'ca');

            // Notes
            document.getElementById('noteProf').classList.toggle('d-none', role === 'guest');
            document.getElementById('noteGuest').classList.toggle('d-none', role !== 'guest');
        }

        // Init — respect old() value or URL param
        const urlRole = new URLSearchParams(window.location.search).get('role');
        selectRole(urlRole || '{{ old('role', 'advocate') }}');
    </script>
</body>

</html>
