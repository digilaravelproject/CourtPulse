<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Court Pulse CA</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-w: 255px;
            --ink: #0e0e0f;
            --cream: #faf8f4;
            --amber: #c8872a;
            --gold: #d4a027;
            --border: #e5e0d8;
            --muted: #7a7068;
            --sidebar-bg: #1c1408;
            --sidebar-border: rgba(255, 255, 255, 0.07);
            --sidebar-text: rgba(255, 255, 255, 0.55);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--cream);
            color: var(--ink);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform 0.3s;
        }

        .sidebar-logo {
            padding: 22px 18px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon-sb {
            width: 34px;
            height: 34px;
            background: var(--gold);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .logo-text {
            font-family: 'Manrope', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }

        .logo-sub {
            font-family: 'Manrope', sans-serif;
            font-size: 0.55rem;
            color: var(--gold);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 14px 0;
        }

        .nav-section-label {
            font-family: 'Manrope', sans-serif;
            font-size: 0.56rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.2);
            padding: 10px 18px 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.85);
        }

        .sidebar-link.active {
            background: rgba(212, 160, 39, 0.15);
            color: var(--gold);
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--gold);
            border-radius: 0 2px 2px 0;
        }

        .sidebar-link i {
            width: 16px;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid var(--sidebar-border);
        }

        .user-card-sb {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar-sb {
            width: 34px;
            height: 34px;
            background: rgba(212, 160, 39, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: var(--gold);
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-name-sb {
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-role-sb {
            font-family: 'Manrope', sans-serif;
            font-size: 0.58rem;
            color: var(--gold);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .btn-logout {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.3);
            font-size: 1rem;
            cursor: pointer;
            margin-left: auto;
        }

        .btn-logout:hover {
            color: #ef4444;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: 58px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 14px;
            z-index: 100;
        }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .topbar-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-btn {
            width: 34px;
            height: 34px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.95rem;
            color: var(--muted);
            text-decoration: none;
            transition: all 0.2s;
        }

        .topbar-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .main-content {
            margin-left: var(--sidebar-w);
            padding-top: 58px;
            min-height: 100vh;
        }

        .page-content {
            padding: 24px;
        }

        .cp-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .cp-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .cp-card-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .cp-card-body {
            padding: 20px;
        }

        .cp-label {
            font-family: 'Manrope', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .cp-input {
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 10px 14px;
            font-size: 0.87rem;
            width: 100%;
            background: white;
            font-family: 'Manrope', sans-serif;
            transition: border-color 0.2s;
        }

        .cp-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 160, 39, 0.08);
        }

        .cp-select {
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 10px 14px;
            font-size: 0.87rem;
            width: 100%;
            background: white;
            font-family: 'Manrope', sans-serif;
        }

        .btn-cp-primary {
            background: var(--gold);
            color: white;
            border: none;
            padding: 9px 22px;
            border-radius: 7px;
            font-size: 0.87rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
        }

        .btn-cp-primary:hover {
            background: #b8891f;
            color: white;
        }

        .btn-cp-secondary {
            background: white;
            color: var(--ink);
            border: 1px solid var(--border);
            padding: 9px 22px;
            border-radius: 7px;
            font-size: 0.87rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
        }

        .badge-cp {
            font-family: 'Manrope', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 1px;
            padding: 3px 9px;
            border-radius: 4px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-active {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .badge-pending {
            background: rgba(200, 135, 42, 0.12);
            color: var(--amber);
        }

        .badge-rejected {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .alert-cp {
            border-radius: 8px;
            padding: 11px 16px;
            font-size: 0.83rem;
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 18px;
            border: 1px solid;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.08);
            border-color: rgba(34, 197, 94, 0.2);
            color: #16a34a;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.08);
            border-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        .alert-info {
            background: rgba(200, 135, 42, 0.08);
            border-color: rgba(200, 135, 42, 0.2);
            color: var(--amber);
        }

        @media(max-width:991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                left: 0;
            }

            .topbar-toggle {
                display: flex;
            }

            .page-content {
                padding: 16px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="position-fixed d-none bg-dark bg-opacity-50" id="sidebarOverlay" style="inset:0;z-index:199;"
        onclick="toggleSidebar()"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon-sb">📊</div>
            <div>
                <div class="logo-text">Court Pulse</div>
                <div class="logo-sub">CA Panel</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-label">My Space</div>
            <a href="{{ route('ca.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('ca.dashboard') ? 'active' : '' }}"><i
                    class="bi bi-grid-3x3-gap"></i> Dashboard</a>
            <a href="{{ route('ca.profile') }}"
                class="sidebar-link {{ request()->routeIs('ca.profile*') ? 'active' : '' }}"><i
                    class="bi bi-person-circle"></i> My Profile</a>
            <a href="{{ route('ca.documents') }}"
                class="sidebar-link {{ request()->routeIs('ca.documents*') ? 'active' : '' }}"><i
                    class="bi bi-file-earmark-arrow-up"></i> My Documents</a>
            <div class="nav-section-label">Network</div>
            <a href="{{ route('ca.search.advocates') }}"
                class="sidebar-link {{ request()->routeIs('ca.search*') ? 'active' : '' }}"><i class="bi bi-search"></i>
                Search Advocates</a>
            <a href="{{ route('feedback') }}"
                class="sidebar-link {{ request()->routeIs('ca.feedback*') ? 'active' : '' }}"><i
                    class="bi bi-star"></i> Feedback</a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-card-sb">
                <div class="user-avatar-sb">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div style="overflow:hidden">
                    <div class="user-name-sb">{{ auth()->user()->name }}</div>
                    <div class="user-role-sb">CA</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout"><i
                            class="bi bi-box-arrow-right"></i></button></form>
            </div>
        </div>
    </aside>
    <header class="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <a href="{{ route('ca.documents') }}" class="topbar-btn"><i class="bi bi-file-earmark-check"></i></a>
            <a href="{{ route('ca.profile') }}" class="topbar-btn"><i class="bi bi-person"></i></a>
        </div>
    </header>
    <main class="main-content">
        <div class="page-content">
            @if (session('success'))
                <div class="alert-cp alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-cp alert-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('d-none');
        }
        setTimeout(() => {
            document.querySelectorAll('.alert-cp').forEach(a => {
                a.style.transition = 'opacity 0.4s';
                a.style.opacity = '0';
                setTimeout(() => a.remove(), 400);
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>

</html>
