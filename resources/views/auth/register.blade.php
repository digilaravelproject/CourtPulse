<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Court Pulse</title>
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
            --border-dim: rgba(255, 255, 255, 0.1);
            --muted: #94A3B8;
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

        /* ── LEFT PANEL ──────────────────────────────────── */
        .auth-left {
            flex: 1;
            background: var(--navy-deep);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 64px;
            position: relative;
            overflow: hidden;
            border-right: 1px solid var(--border-dim);
        }

        /* Gold cross pattern — identical to landing page */
        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Glow blobs — same as landing hero */
        .glow-1 {
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

        .glow-2 {
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

        /* Decorative rings */
        .ring-1 {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.04);
            pointer-events: none;
        }

        .ring-2 {
            position: absolute;
            bottom: -100px;
            left: -60px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            border: 1px solid rgba(212, 175, 55, 0.08);
            pointer-events: none;
        }

        .left-inner {
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
            margin-bottom: 48px;
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
            font-size: clamp(1.9rem, 3vw, 2.6rem);
            font-weight: 700;
            color: white;
            line-height: 1.12;
            margin-bottom: 16px;
        }

        .left-title .gi {
            font-style: italic;
            color: var(--gold);
        }

        .left-desc {
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.42);
            line-height: 1.78;
            max-width: 340px;
            font-weight: 300;
            margin-bottom: 36px;
        }

        /* 2×2 role mini cards on left */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .role-mini {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 9px;
            padding: 13px 14px;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }

        .role-mini:hover,
        .role-mini.selected {
            background: rgba(212, 175, 55, 0.12);
            border-color: rgba(212, 175, 55, 0.38);
        }

        .rm-icon {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .rm-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.65);
            transition: color 0.2s;
        }

        .role-mini:hover .rm-name,
        .role-mini.selected .rm-name {
            color: var(--gold);
        }

        .rm-note {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.28);
            margin-top: 2px;
        }

        /* ── RIGHT PANEL ──────────────────────────────────── */
        .auth-right {
            width: 500px;
            flex-shrink: 0;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
            overflow-y: auto;
        }

        .auth-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 4px;
        }

        .auth-sub {
            font-size: 0.85rem;
            color: #64748B;
            margin-bottom: 24px;
        }

        /* Role tabs */
        .role-tabs {
            display: flex;
            gap: 4px;
            background: #F8FAFC;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 20px;
            border: 1px solid #E2E8F0;
        }

        .role-tab {
            flex: 1;
            padding: 8px 6px;
            border: none;
            background: transparent;
            color: #64748B;
            border-radius: 6px;
            font-size: 0.76rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            text-align: center;
        }

        .role-tab.active {
            background: white;
            color: #92650a;
            font-weight: 600;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }

        /* Notes */
        .note-box {
            border-radius: 8px;
            padding: 11px 13px;
            font-size: 0.77rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 16px;
            border: 1px solid;
        }

        .note-prof {
            background: rgba(212, 175, 55, 0.08);
            border-color: rgba(212, 175, 55, 0.25);
            color: #92650a;
        }

        .note-guest {
            background: rgba(34, 197, 94, 0.06);
            border-color: rgba(34, 197, 94, 0.2);
            color: #16a34a;
        }

        .note-error {
            background: rgba(239, 68, 68, 0.06);
            border-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
            font-size: 0.8rem;
            align-items: center;
        }

        /* Form */
        .cp-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.62rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #64748B;
            display: block;
            margin-bottom: 6px;
        }

        .cp-input,
        .cp-select {
            width: 100%;
            border: 1px solid #E2E8F0;
            border-radius: 7px;
            padding: 10px 13px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: #0F172A;
            background: #FAFAFA;
            transition: all 0.2s;
        }

        .cp-input:focus,
        .cp-select:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
            background: white;
        }

        .cp-input.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
        }

        .error-msg {
            font-size: 0.72rem;
            color: #ef4444;
            margin-top: 4px;
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
            margin-top: 8px;
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

        @media(max-width:960px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                width: 100%;
                min-height: 100vh;
                padding: 36px 24px;
            }
        }

        @media(max-width:480px) {
            .auth-right {
                padding: 28px 16px;
            }
        }
    </style>
</head>

<body>
    <div style="display:flex;min-height:100vh;width:100%;">

        <!-- ── LEFT PANEL ─────────────────────────────────────────── -->
        <div class="auth-left">
            <div class="glow-1"></div>
            <div class="glow-2"></div>
            <div class="ring-1"></div>
            <div class="ring-2"></div>

            <div class="left-inner">
                <a href="{{ route('home') }}" class="left-logo">
                    <div class="logo-badge">⚖</div>
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

        <!-- ── RIGHT PANEL ─────────────────────────────────────────── -->
        <div class="auth-right">
            <div class="auth-heading">Create Account</div>
            <div class="auth-sub">Join Court Pulse — India's legal professional network</div>

            @if ($errors->any())
                <div class="note-box note-error">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}
                </div>
            @endif

            <!-- Role Tabs -->
            <div class="role-tabs">
                <button type="button" class="role-tab" onclick="selectRole('advocate')">⚖ Advocate</button>
                <button type="button" class="role-tab" onclick="selectRole('clerk')">🗂 Clerk</button>
                <button type="button" class="role-tab" onclick="selectRole('ca')">📊 CA</button>
                <button type="button" class="role-tab" onclick="selectRole('guest')">👤 Guest</button>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'advocate') }}">

                <!-- Notes -->
                <div class="note-box note-prof" id="noteProf">
                    <i class="bi bi-clock-fill" style="flex-shrink:0;margin-top:1px;"></i>
                    <span>Professionals need document upload &amp; admin verification after registration.</span>
                </div>
                <div class="note-box note-guest d-none" id="noteGuest">
                    <i class="bi bi-check-circle-fill" style="flex-shrink:0;margin-top:1px;"></i>
                    <span>Guest accounts are activated instantly — no documents needed!</span>
                </div>

                <!-- Common Fields -->
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

                <!-- Role-specific fields -->
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

                <!-- Terms -->
                <div class="d-flex align-items-start gap-2 mt-3 mb-1">
                    <input type="checkbox" id="terms" name="terms" required
                        style="margin-top:3px;accent-color:var(--gold);width:15px;height:15px;flex-shrink:0;">
                    <label for="terms" style="font-size:0.8rem;color:#64748B;cursor:pointer;margin:0;">
                        I agree to the <a href="#" class="auth-link">Terms of Use</a>
                        and <a href="#" class="auth-link">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-person-plus-fill"></i> Create Account
                </button>
            </form>

            <div class="text-center mt-3">
                <span style="font-size:0.85rem;color:#64748B;">Already have an account? </span>
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
