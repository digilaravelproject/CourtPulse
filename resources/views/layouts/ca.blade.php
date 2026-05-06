<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — DockIt CA</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: "#050812",
                        navy2: "#080d1a",
                        navy3: "#0b1120",
                        blue: "#B4B4FE",
                        blue2: "#9999f0",
                    },
                    fontFamily: {
                        sans: ["Manrope", "sans-serif"],
                    },
                }
            }
        }
    </script>
    <style>
        :root {
            --sidebar-w: 260px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Manrope', sans-serif; background: #050812; }
        
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-w);
            background: #080d1a; border-right: 1px solid rgba(255,255,255,0.05);
            display: flex; flex-direction: column; z-index: 200;
        }
        .sidebar-logo {
            padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; gap: 12px;
        }
        .logo-icon-sb {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, #B4B4FE, #9999f0);
            display: flex; align-items: center; justify-content: center; color: #050812;
            font-size: 1rem; font-weight: 800;
        }
        .logo-text { font-size: 1.2rem; font-weight: 800; color: white; }
        .logo-sub { font-size: 0.55rem; color: #B4B4FE; letter-spacing: 2px; text-transform: uppercase; }
        
        .sidebar-nav { flex: 1; overflow-y: auto; padding: 14px 0; }
        .nav-section-label {
            font-size: 0.55rem; letter-spacing: 2px; text-transform: uppercase;
            color: rgba(255,255,255,0.25); padding: 12px 20px 6px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px; padding: 10px 20px;
            color: rgba(255,255,255,0.45); text-decoration: none;
            font-size: 0.85rem; font-weight: 600; transition: all 0.3s;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.8); }
        .sidebar-link.active { background: rgba(180,180,254,0.1); color: #B4B4FE; }
        .sidebar-link.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px; background: #B4B4FE;
        }
        .sidebar-link i { width: 18px; font-size: 0.9rem; }
        
        .sidebar-footer {
            padding: 14px 20px; border-top: 1px solid rgba(255,255,255,0.05);
        }
        .user-card-sb { display: flex; align-items: center; gap: 10px; }
        .user-avatar-sb {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(180,180,254,0.15); border: 1px solid rgba(180,180,254,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; color: #B4B4FE; font-weight: 700;
        }
        .user-name-sb { font-size: 0.8rem; font-weight: 600; color: white; }
        .user-role-sb { font-size: 0.55rem; color: #B4B4FE; letter-spacing: 1px; text-transform: uppercase; }
        .btn-logout { background: none; border: none; color: rgba(255,255,255,0.3); font-size: 1rem; cursor: pointer; margin-left: auto; }
        .btn-logout:hover { color: #ef4444; }
        
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: 60px;
            background: #080d1a; border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; padding: 0 24px; gap: 14px; z-index: 100;
        }
        .topbar-toggle { display: none; background: none; border: none; font-size: 1.2rem; cursor: pointer; color: white; }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: white; }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }
        .topbar-btn {
            width: 36px; height: 36px; border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: rgba(255,255,255,0.5); text-decoration: none; transition: all 0.3s;
        }
        .topbar-btn:hover { border-color: #B4B4FE; color: #B4B4FE; }
        
        .main-content { margin-left: var(--sidebar-w); padding-top: 60px; min-height: 100vh; }
        .page-content { padding: 24px; }
        
        .cp-card {
            background: #080d1a; border: 1px solid rgba(255,255,255,0.05);
            border-radius: 24px; overflow: hidden;
        }
        .cp-card-header {
            padding: 16px 24px; border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .cp-card-title { font-size: 1rem; font-weight: 700; color: white; }
        .cp-card-body { padding: 24px; }
        
        .cp-label {
            font-size: 0.65rem; letter-spacing: 1px; text-transform: uppercase;
            color: rgba(255,255,255,0.4); margin-bottom: 6px; font-weight: 600;
        }
        .cp-input {
            border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
            padding: 12px 16px; font-size: 0.87rem; width: 100%;
            background: #050812; color: white; font-family: 'Manrope', sans-serif;
            transition: border-color 0.2s;
        }
        .cp-input:focus { outline: none; border-color: #B4B4FE; box-shadow: 0 0 0 3px rgba(180,180,254,0.1); }
        .cp-select {
            border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
            padding: 12px 16px; font-size: 0.87rem; width: 100%;
            background: #050812; color: white; font-family: 'Manrope', sans-serif;
        }
        
        .btn-cp-primary {
            background: linear-gradient(135deg, #B4B4FE, #9999f0); color: #050812;
            border: none; padding: 12px 24px; border-radius: 12px;
            font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .btn-cp-primary:hover { background: white; transform: scale(1.02); }
        
        .btn-cp-secondary {
            background: rgba(255,255,255,0.03); color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.1); padding: 12px 24px;
            border-radius: 12px; font-size: 0.85rem; font-weight: 600; cursor: pointer;
            transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-cp-secondary:hover { background: rgba(255,255,255,0.08); color: white; }
        
        .badge-cp {
            font-size: 0.6rem; letter-spacing: 1px; padding: 4px 10px;
            border-radius: 6px; font-weight: 700; text-transform: uppercase;
        }
        .badge-active { background: rgba(34,197,94,0.1); color: #4ade80; }
        .badge-pending { background: rgba(251,191,36,0.1); color: #fbbf24; }
        .badge-rejected { background: rgba(239,68,68,0.1); color: #f87171; }
        
        .alert-cp {
            border-radius: 12px; padding: 14px 18px; font-size: 0.85rem;
            display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
            border: 1px solid;
        }
        .alert-success { background: rgba(34,197,94,0.08); border-color: rgba(34,197,94,0.2); color: #4ade80; }
        .alert-error { background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.2); color: #f87171; }
        
        @media(max-width:991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar { left: 0; }
            .topbar-toggle { display: flex; }
            .page-content { padding: 16px; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="fixed inset-0 bg-navy/80 hidden" id="sidebarOverlay" style="z-index:199;" onclick="toggleSidebar()"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon-sb"><i class="fas fa-gavel"></i></div>
            <div>
                <div class="logo-text">DockIt</div>
                <div class="logo-sub">CA Panel</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">My Space</div>
            <a href="{{ route('ca.dashboard') }}" class="sidebar-link {{ request()->routeIs('ca.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('ca.profile') }}" class="sidebar-link {{ request()->routeIs('ca.profile*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> My Profile
            </a>

            <div class="nav-section-label">Network</div>
            <a href="{{ route('ca.search.advocates') }}" class="sidebar-link {{ request()->routeIs('ca.search*') ? 'active' : '' }}">
                <i class="fas fa-search"></i> Search Advocates
            </a>
            <a href="{{ route('feedback') }}" class="sidebar-link {{ request()->routeIs('ca.feedback*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Feedback
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-card-sb">
                <div class="user-avatar-sb">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div style="overflow:hidden">
                    <div class="user-name-sb">{{ auth()->user()->name }}</div>
                    <div class="user-role-sb">CA</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i></button></form>
            </div>
        </div>
    </aside>
    <header class="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <a href="{{ route('ca.profile') }}" class="topbar-btn"><i class="fas fa-user"></i></a>
        </div>
    </header>
    <main class="main-content">
        <div class="page-content">
            @if (session('success'))
                <div class="alert-cp alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert-cp alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('hidden');
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