<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — CourtPulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #050812; }
        ::-webkit-scrollbar-thumb { background: #0b1120; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #B4B4FE; }
        body { background: #050812; font-family: 'Manrope', sans-serif; }

        /* Sidebar */
        .sidebar {
            width: 260px; background: #080d1a; border-right: 1px solid rgba(255,255,255,0.05);
            display: flex; flex-direction: column; height: 100vh; position: fixed; left: 0; top: 0;
        }
        .sidebar-brand {
            padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; gap: 12px;
        }
        .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, #B4B4FE, #9999f0);
            display: flex; align-items: center; justify-content: center; color: #050812;
            font-size: 1rem;
        }
        .brand-name { font-size: 1.2rem; font-weight: 800; color: white; }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 16px 0; }
        .nav-label {
            font-size: 0.55rem; letter-spacing: 2px; text-transform: uppercase;
            color: rgba(255,255,255,0.25); padding: 8px 20px 8px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 10px; padding: 10px 20px;
            color: rgba(255,255,255,0.45); text-decoration: none;
            font-size: 0.85rem; font-weight: 600; transition: all 0.3s; margin: 2px 8px;
            border-radius: 10px;
        }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: white; }
        .nav-link.active { background: rgba(180,180,254,0.1); color: #B4B4FE; }
        .nav-link i { width: 18px; }

        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        .user-card {
            display: flex; align-items: center; gap: 12px; padding: 12px;
            background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);
        }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, #B4B4FE, #9999f0);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; color: #050812;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 0.85rem; font-weight: 600; color: white; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.55rem; color: #B4B4FE; letter-spacing: 1px; text-transform: uppercase; }

        .btn-logout {
            display: flex; align-items: center; gap: 8px; padding: 10px 16px;
            border-radius: 10px; color: rgba(255,255,255,0.5); font-size: 0.85rem;
            transition: all 0.3s; width: 100%; justify-content: center;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.1); color: #f87171; }

        /* Main content */
        .main-wrapper { margin-left: 260px; min-height: 100vh; background: #050812; }
        .main-content { padding: 32px; max-width: 1500px; margin: 0 auto; }

        /* Cards */
        .card-main {
            background: #080d1a; border: 1px solid rgba(255,255,255,0.05);
            border-radius: 24px; overflow: hidden;
        }
        .card-header {
            padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 1rem; font-weight: 700; color: white; }
        .card-body { padding: 24px; }

        /* Form elements */
        .form-label {
            font-size: 0.65rem; letter-spacing: 1px; text-transform: uppercase;
            color: rgba(255,255,255,0.4); margin-bottom: 8px; font-weight: 600;
        }
        .form-input {
            border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
            padding: 12px 16px; font-size: 0.87rem; width: 100%;
            background: #050812; color: white; transition: all 0.3s;
        }
        .form-input:focus { border-color: #B4B4FE; box-shadow: 0 0 0 3px rgba(180,180,254,0.1); }
        .form-input::placeholder { color: rgba(255,255,255,0.2); }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #B4B4FE, #9999f0); color: #050812;
            border: none; padding: 12px 24px; border-radius: 12px;
            font-size: 0.85rem; font-weight: 700; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;
        }
        .btn-primary:hover { background: white; transform: scale(1.02); }

        .btn-secondary {
            background: rgba(255,255,255,0.03); color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.1); padding: 12px 24px;
            border-radius: 12px; font-size: 0.85rem; font-weight: 600;
            transition: all 0.3s;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.08); color: white; }

        /* Alerts */
        .alert-flash {
            padding: 14px 18px; border-radius: 12px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px; font-size: 0.85rem;
            border: 1px solid;
        }
        .alert-success { background: rgba(34,197,94,0.08); border-color: rgba(34,197,94,0.2); color: #4ade80; }
        .alert-error { background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.2); color: #f87171; }

        /* Mobile */
        .mobile-header { display: none; }
        @media(max-width:991px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-header {
                display: flex; align-items: center; justify-content: space-between;
                padding: 16px 20px; background: #080d1a;
                border-bottom: 1px solid rgba(255,255,255,0.05); position: sticky; top: 0; z-index: 30;
            }
            .mobile-toggle { background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; }
            .main-content { padding: 20px; }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-navy text-white" style="font-family: 'Manrope', sans-serif;">
    <!-- Mobile overlay -->
    <div id="sbOverlay" onclick="closeSb()" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside id="sidebar" class="sidebar shrink-0">
            <div class="sidebar-brand">
                <div class="brand-icon"><i class="fas fa-gavel"></i></div>
                <div>
                    <div class="brand-name">DockIt</div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <p class="nav-label">Menu</p>
                <a href="{{ route('clerk.dashboard') }}" class="nav-link {{ request()->routeIs('clerk.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="{{ route('clerk.advocates') }}" class="nav-link {{ request()->routeIs('clerk.advocates*') ? 'active' : '' }}">
                    <i class="fas fa-search"></i> Advocate Search
                </a>
                <a href="{{ route('clerk.profile') }}" class="nav-link {{ request()->routeIs('clerk.profile*') ? 'active' : '' }}">
                    <i class="fas fa-user-edit"></i> Edit Portfolio
                </a>
                <a href="{{ route('clerk.guests') }}" class="nav-link {{ request()->routeIs('clerk.guest*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Browse Guests
                </a>
                <a href="{{ route('feedback') }}" class="nav-link {{ request()->is('feedback*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Feedback
                </a>

                <p class="nav-label pt-4 mt-4">Account</p>
                <a href="{{ route('clerk.profile') }}" class="nav-link">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <form action="{{ route('logout') }}" method="POST" class="px-2">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>

            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ auth()->user()->clerkProfile->designation ?? 'Court Clerk' }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="main-wrapper flex-1 flex flex-col relative overflow-y-auto">
            <!-- Mobile header -->
            <header class="mobile-header">
                <div class="flex items-center gap-2">
                    <div class="brand-icon"><i class="fas fa-gavel"></i></div>
                    <span class="font-bold text-lg">DockIt</span>
                </div>
                <button onclick="toggleSb()" class="mobile-toggle"><i class="fas fa-bars"></i></button>
            </header>

            <div class="main-content">
                @if(session('success'))
                    <div class="alert-flash alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert-flash alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        function toggleSb() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sbOverlay').classList.toggle('hidden');
        }
        function closeSb() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sbOverlay').classList.add('hidden');
        }
        setTimeout(() => {
            document.querySelectorAll('.alert-flash').forEach(a => {
                a.style.transition = 'opacity .4s'; a.style.opacity = '0';
                setTimeout(() => a.remove(), 400);
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>

</html>
