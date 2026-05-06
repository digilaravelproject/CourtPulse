<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — DockIt Professional</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#050812',
                        navy2: '#080d1a',
                        navy3: '#0b1120',
                        blue: '#B4B4FE',
                        blue2: '#9999f0',
                    },
                    fontFamily: {
                        display: ['Manrope', 'sans-serif'],
                        sans: ['Manrope', 'sans-serif'],
                        mono: ['Manrope', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        /* Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #050812;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(180, 180, 254, 0.2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(180, 180, 254, 0.5);
        }

        /* Active Nav Link */
        .nav-active {
            background: rgba(180, 180, 254, 0.1);
            color: #B4B4FE !important;
            border-left: 3px solid #B4B4FE;
            box-shadow: inset 10px 0 20px -10px rgba(180, 180, 254, 0.15);
        }

        /* Toast Slide Animation */
        @keyframes tIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .t-slide {
            animation: tIn .3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Mobile Scroll Lock */
        .no-scroll {
            overflow: hidden;
            height: 100vh;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-navy text-slate-300 font-sans min-h-screen selection:bg-blue selection:text-navy flex flex-col">

    {{-- ── TOAST BOX ────────────────────────────────────────── --}}
    <div id="toastBox" class="fixed top-20 right-6 z-[9999] flex flex-col gap-3 w-80 pointer-events-none"></div>

    {{-- ── SIDEBAR OVERLAY (mobile) ────────────────────────── --}}
    <div id="sbOverlay" onclick="closeSb()"
        class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-[198] transition-opacity duration-300 opacity-0">
    </div>

    {{-- ════════════════════════════════════════
    SIDEBAR
    ════════════════════════════════════════ --}}
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-64 flex flex-col z-[199] bg-navy2 border-r border-white/5 transition-transform duration-300 ease-out -translate-x-full lg:translate-x-0 shadow-2xl">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 shrink-0 border-b border-white/5">
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-blue/10 border border-blue/20 text-blue font-black shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                DI
            </div>
            <div>
                <div class="font-black text-lg text-white leading-tight uppercase tracking-tight">DockIt</div>
                <div class="font-bold text-[0.6rem] uppercase tracking-[0.2em] text-blue">Advocate Portal</div>
            </div>
        </div>

        {{-- Nav Links --}}
        <nav class="flex-1 overflow-y-auto py-4 space-y-1">
            @php
                function navLink($route, $icon, $label)
                {
                    $active =
                        request()->routeIs($route) ||
                        (str_contains($route, '*') && request()->is(str_replace('*', '', $route) . '*'));
                    $cls = $active
                        ? 'nav-active'
                        : 'text-white/50 hover:bg-white/5 hover:text-white border-l-[3px] border-transparent';
                    $href = str_contains($route, '*') ? route(str_replace('*', '', $route)) : route($route);
                    return "<a href='{$href}' class='flex items-center gap-3 px-6 py-3.5 text-[0.8rem] font-bold uppercase tracking-widest transition-all duration-300 {$cls}'>
                                <i class='fas {$icon} text-lg w-5 shrink-0'></i> {$label}
                            </a>";
                }
            @endphp

            <div class="px-6 pt-4 pb-2 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/30">My Space</div>
            {!! navLink('advocate.dashboard', 'fa-th-large', 'Dashboard') !!}
            {!! navLink('advocate.profile', 'fa-id-card', 'My Profile') !!}

            <div class="px-6 pt-6 pb-2 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/30">Network</div>
            {!! navLink('advocate.search.clerks', 'fa-users', 'Search Clerks') !!}
            {!! navLink('advocate.guests', 'fa-user-friends', 'Browse Guests') !!}

            <div class="px-6 pt-6 pb-2 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/30">Support</div>
            {!! navLink('feedback', 'fa-star', 'Feedback') !!}

        </nav>

        {{-- Footer Profile --}}
        <div class="shrink-0 px-6 py-5 border-t border-white/5 bg-navy3/50">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-lg bg-blue text-navy shrink-0 shadow-[0_0_15px_rgba(180,180,254,0.3)]">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-1 min-w-0">
                    <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[0.65rem] uppercase tracking-widest font-bold mt-0.5">
                        @if (auth()->user()->status === 'active')
                            <span class="text-green-400"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                        @else
                            <span class="text-amber-400"><i class="fas fa-hourglass-half mr-1"></i>Pending</span>
                        @endif
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" title="Logout"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-white/40 hover:bg-red-500/10 hover:text-red-400 transition-colors focus:outline-none">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ════════════════════════════════════════
    TOPBAR
    ════════════════════════════════════════ --}}
    <header
        class="fixed top-0 left-0 lg:left-64 right-0 h-[72px] bg-navy/80 backdrop-blur-md border-b border-white/5 flex items-center px-6 gap-4 z-[100] transition-all">

        <button onclick="toggleSb()"
            class="lg:hidden text-white/70 hover:text-white text-2xl transition-colors focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>

        <div class="flex flex-col">
            <span class="font-black text-lg text-white uppercase tracking-tight">@yield('page-title', 'Dashboard')</span>
        </div>

        <div class="ml-auto flex items-center gap-4">

            {{-- Find Clerk Action --}}
            <a href="{{ route('advocate.search.clerks') }}"
                class="hidden sm:flex items-center gap-2 bg-blue text-navy px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white transition-all shadow-[0_5px_15px_rgba(180,180,254,0.2)] transform hover:scale-[1.02] active:scale-[0.98]">
                <i class="fas fa-plus text-sm"></i> Find Clerk
            </a>

            {{-- Notification Bell --}}
            <div class="relative">
                <button
                    class="w-10 h-10 rounded-xl border border-white/10 bg-white/5 flex items-center justify-center text-white/70 hover:border-blue hover:text-blue hover:bg-blue/5 transition-all focus:outline-none group">
                    <i class="fas fa-bell text-lg group-hover:animate-swing"></i>
                </button>
                <span
                    class="absolute -top-1.5 -right-1.5 min-w-[20px] h-[20px] bg-red-500 rounded-full text-white text-[10px] font-black flex items-center justify-center px-1 shadow-[0_0_10px_rgba(239,68,68,0.5)]">
                    3
                </span>
            </div>

            {{-- Topbar Avatar --}}
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-lg bg-blue text-navy shrink-0 md:hidden lg:flex shadow-[0_0_15px_rgba(180,180,254,0.2)]">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

        </div>
    </header>

    {{-- ════════════════════════════════════════
    MAIN CONTENT
    ════════════════════════════════════════ --}}
    <main id="mainWrap" class="lg:ml-64 pt-[72px] min-h-screen flex flex-col transition-all duration-300">
        <div class="flex-grow p-6 lg:p-8">

            {{-- Flash Messages --}}
            @foreach (['success' => 'green', 'error' => 'red', 'info' => 'blue'] as $key => $color)
                @if (session($key))
                    <div
                        class="alert-cp flex items-center gap-3 mb-6 px-5 py-4 rounded-xl bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-400 text-xs font-bold uppercase tracking-widest shadow-lg">
                        <i
                            class="fas fa-{{ $color === 'green' ? 'check-circle' : ($color === 'red' ? 'exclamation-circle' : 'info-circle') }} text-lg"></i>
                        {{ session($key) }}
                    </div>
                @endif
            @endforeach

            @yield('content')

        </div>

        <footer
            class="mt-auto px-8 py-6 border-t border-white/5 text-center lg:text-left text-[10px] font-bold text-white/30 uppercase tracking-widest">
            &copy; {{ date('Y') }} DockIt Professional Portal. All Rights Reserved.
        </footer>
    </main>

    {{-- ── GLOBAL JS ─────────────────────────────────────────── --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* Sidebar Toggle Logic */
        const sidebar = document.getElementById('sidebar');
        const sbOverlay = document.getElementById('sbOverlay');

        function toggleSb() {
            sidebar.classList.toggle('-translate-x-full');
            sbOverlay.classList.toggle('hidden');
            document.body.classList.toggle('no-scroll');
            setTimeout(() => {
                sbOverlay.classList.toggle('opacity-0');
            }, 10);
        }

        function closeSb() {
            sidebar.classList.add('-translate-x-full');
            sbOverlay.classList.add('opacity-0');
            document.body.classList.remove('no-scroll');
            setTimeout(() => {
                sbOverlay.classList.add('hidden');
            }, 300);
        }

        /* Premium Dark Mode Toast */
        function showToast(msg, type = 'success') {
            const isOk = type === 'success';
            const box = document.getElementById('toastBox');
            const el = document.createElement('div');

            const colorClass = isOk ?
                'bg-green-500/10 border-green-500/30 text-green-400 shadow-[0_5px_20px_rgba(34,197,94,0.15)]' :
                'bg-red-500/10 border-red-500/30 text-red-400 shadow-[0_5px_20px_rgba(239,68,68,0.15)]';
            const iconClass = isOk ? 'fa-check-circle text-green-400' : 'fa-exclamation-circle text-red-400';

            el.className =
                `t-slide pointer-events-auto flex items-center gap-4 px-5 py-4 rounded-xl border backdrop-blur-md text-xs font-bold uppercase tracking-widest ${colorClass}`;
            el.innerHTML = `<i class="fas ${iconClass} text-lg"></i><span class="flex-1 leading-relaxed">${msg}</span>`;

            box.appendChild(el);
            setTimeout(() => {
                el.style.transition = 'opacity .4s ease, transform .4s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(20px)';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        }

        /* Auto-hide Flash Messages */
        setTimeout(() => {
            document.querySelectorAll('.alert-cp').forEach(a => {
                a.style.transition = 'opacity .4s ease, transform .4s ease';
                a.style.opacity = '0';
                a.style.transform = 'translateY(-10px)';
                setTimeout(() => a.remove(), 400);
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>

</html>
