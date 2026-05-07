<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — DockIt Support</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans bg-navy text-white antialiased overflow-x-hidden">
    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-45 hidden"
         onclick="toggleSidebar()">
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
           class="fixed top-0 left-0 bottom-0 w-[280px] bg-navy2 border-r border-white/5 flex flex-col z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0">

        <!-- Logo -->
        <div class="p-6 border-b border-white/5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-linear-to-br from-blue to-blue2 flex items-center justify-center text-navy text-xl font-bold">
                <i class="fas fa-gavel text-lg"></i>
            </div>
            <div>
                <div class="text-xl font-extrabold tracking-tight">DockIt</div>
                <div class="text-[10px] text-blue font-bold tracking-[0.2em] uppercase leading-none">
                    @if(auth()->user()->role === 'court_clerk')
                        Court Clerk
                    @elseif(auth()->user()->role === 'ip_clerk')
                        IP Clerk
                    @else
                        Support
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
            <!-- Main Section -->
            <div class="space-y-1">
                <div class="px-4 text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-4">Main Menu</div>

                <a href="{{ route('support.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('support.dashboard') ? 'bg-blue/10 text-blue border-l-4 border-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-th-large w-5"></i>
                    <span class="text-sm font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('support.pending.requests') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('support.pending.requests') ? 'bg-blue/10 text-blue border-l-4 border-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-user-clock w-5"></i>
                    <span class="text-sm font-semibold">Pending Requests</span>
                    @if(isset($pendingCount) && $pendingCount > 0)
                        <span class="ml-auto bg-blue text-navy text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>

                <a href="{{ route('support.connections') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('support.connections') ? 'bg-blue/10 text-blue border-l-4 border-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="text-sm font-semibold">My Connections</span>
                </a>

                <a href="{{ route('support.search.professionals') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('support.search.professionals') ? 'bg-blue/10 text-blue border-l-4 border-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-search w-5"></i>
                    <span class="text-sm font-semibold">Find Professionals</span>
                </a>
            </div>

            <!-- Account Section -->
            <div class="space-y-1">
                <div class="px-4 text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-4">Account</div>

                <a href="{{ route('support.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('support.profile') ? 'bg-blue/10 text-blue border-l-4 border-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-user-circle w-5"></i>
                    <span class="text-sm font-semibold">My Profile</span>
                </a>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-white/5 bg-navy/20">
            <div class="flex items-center gap-3 p-2 rounded-xl bg-white/5 border border-white/5">
                <div class="w-10 h-10 rounded-lg bg-blue/10 border border-blue/20 flex items-center justify-center text-blue font-bold shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-blue font-medium uppercase tracking-wider">
                        @if(auth()->user()->role === 'court_clerk')
                            Court Clerk
                        @elseif(auth()->user()->role === 'ip_clerk')
                            IP Clerk
                        @else
                            Support
                        @endif
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="p-2 text-white/30 hover:text-red-400 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="lg:ml-[280px] min-h-screen flex flex-col transition-all duration-300">
        <!-- Topbar -->
        <header class="sticky top-0 z-40 bg-navy/80 backdrop-blur-xl border-b border-white/5 px-4 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-white/50 hover:text-white transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-lg lg:text-xl font-bold tracking-tight">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('support.profile') }}" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/50 hover:text-blue hover:border-blue/50 transition-all">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 p-4 lg:p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                <!-- Notifications/Alerts -->
                @if (session('success'))
                    <div class="alert-message bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-message bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert-message').forEach(alert => {
                alert.style.transition = 'all 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>

</html>
