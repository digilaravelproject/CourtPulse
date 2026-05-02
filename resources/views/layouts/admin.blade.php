<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css', 'resources/js/app.js')
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

    {{-- Alpine.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>

    <style>
        :root {
            --brand: #B4B4FE;
            --brand-glow: rgba(180, 180, 254, 0.3);
            --border: rgba(255, 255, 255, 0.1);
        }

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

        /* Spinner */
        .spin {
            display: inline-block;
            animation: sp .7s linear infinite;
        }

        @keyframes sp {
            to {
                transform: rotate(360deg);
            }
        }

        /* Toast Slide */
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
    </style>
    @stack('styles')
</head>

<body class="bg-navy text-slate-300 font-sans min-h-screen selection:bg-blue selection:text-navy">

    {{-- ── TOAST BOX ────────────────────────────────────────── --}}
    <div id="toastBox" class="fixed top-20 right-6 z-[9999] flex flex-col gap-3 w-80 pointer-events-none"></div>

    {{-- ── SIDEBAR OVERLAY (mobile) ────────────────────────── --}}
    <div id="sbOverlay" onclick="closeSb()"
        class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-[198] transition-opacity duration-300"></div>

    {{-- ════════════════════════════════════════
    SIDEBAR
    ════════════════════════════════════════ --}}
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-64 flex flex-col z-[199] bg-navy2 border-r border-white/5 transition-transform duration-300 ease-out -translate-x-full lg:translate-x-0 shadow-2xl">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 shrink-0 border-b border-white/5">
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-blue/10 border border-blue/20 text-blue font-black shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                CP
            </div>
            <div>
                <div class="font-black text-lg text-white leading-tight uppercase tracking-tight">CourtPulse</div>
                <div class="font-bold text-[0.6rem] uppercase tracking-[0.2em] text-blue">Admin Panel</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 space-y-1">
            @php
                function navLink($route, $icon, $label, $badge = null, $urlParams = [])
                {
                    $active = request()->routeIs($route . '*') && empty(array_diff_assoc($urlParams, request()->all()));
                    if (empty($urlParams) && !empty(request()->query('role_category'))) {
                        $active = false;
                    }
                    $cls = $active ? 'nav-active' : 'text-white/50 hover:bg-white/5 hover:text-white border-left border-transparent';
                    $b = $badge
                        ? "<span class='ml-auto text-[0.6rem] font-bold px-2 py-0.5 rounded-full bg-blue text-navy'>{$badge}</span>"
                        : '';
                    return "<a href='" . route($route, $urlParams) . "' class='flex items-center gap-3 px-6 py-3.5 text-[0.8rem] font-bold uppercase tracking-widest transition-all duration-300 {$cls}'>
                                                                                                                <i class='bi {$icon} text-lg w-5 shrink-0'></i> {$label} {$b}
                                                                                                            </a>";
                }
            @endphp

            <div class="px-6 pt-4 pb-2 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/30">Main</div>
            {!! navLink('admin.dashboard', 'bi-grid-1x2-fill', 'Dashboard') !!}

            <div class="px-6 pt-6 pb-2 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/30">Network</div>
            {!! navLink('admin.users', 'bi-shield-check', 'Support Staff', null, ['role_category' => 'support']) !!}
            {!! navLink('admin.users', 'bi-briefcase-fill', 'Professionals', null, ['role_category' => 'professional']) !!}
            {!! navLink('admin.users', 'bi-people-fill', 'Guest Users', null, ['role_category' => 'guest']) !!}

            <div class="px-6 pt-6 pb-2 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/30">System</div>
            {!! navLink('admin.courts.index', 'bi-buildings-fill', 'Courts Data') !!}
            {!! navLink('admin.feedback', 'bi-star-fill', 'Feedback') !!}

            @php
                $isSuperAdmin = DB::table('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('model_has_roles.model_id', auth()->id())
                    ->where('model_has_roles.model_type', 'App\Models\User')
                    ->where('roles.name', 'super_admin')
                    ->exists();
            @endphp
            @if ($isSuperAdmin)
                <div class="px-6 pt-6 pb-2 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/30">Security</div>
                {!! navLink('super.roles', 'bi-shield-lock-fill', 'Roles') !!}
                {!! navLink('super.activity', 'bi-clock-history', 'Activity Logs') !!}
            @endif

        </nav>

        {{-- Footer --}}
        <div class="shrink-0 px-6 py-5 border-t border-white/5 bg-navy3/50">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-lg bg-blue text-navy shrink-0 shadow-[0_0_15px_rgba(180,180,254,0.3)]">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-1 min-w-0">
                    <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[0.65rem] uppercase tracking-widest text-blue mt-0.5 font-bold">
                        {{ str_replace('_', ' ', auth()->user()->role == 'super_admin' ? 'admin' : auth()->user()->role) }}
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button title="Logout"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-white/40 hover:bg-red-500/10 hover:text-red-400 transition-colors">
                        <i class="bi bi-box-arrow-right text-lg"></i>
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
            <i class="bi bi-list"></i>
        </button>

        <div class="flex flex-col">
            <span
                class="font-black text-lg text-white uppercase tracking-tight">@yield('page-title', 'Dashboard')</span>
        </div>

        <div class="ml-auto flex items-center gap-4">
            @php $ui = (int) ($pendingCount ?? 0); @endphp

            <a href="{{ route('admin.users') }}?status=pending"
                class="relative w-10 h-10 rounded-xl border border-white/10 bg-white/5 flex items-center justify-center text-white/70 hover:border-blue hover:text-blue hover:bg-blue/5 transition-all group">
                <i class="bi bi-bell-fill text-lg group-hover:animate-swing"></i>
                @if ($ui > 0)
                    <span
                        class="absolute -top-1.5 -right-1.5 min-w-[20px] h-[20px] bg-red-500 rounded-full text-white text-[10px] font-black flex items-center justify-center px-1 shadow-[0_0_10px_rgba(239,68,68,0.5)]">
                        {{ $ui }}
                    </span>
                @endif
            </a>
        </div>
    </header>

    {{-- ════════════════════════════════════════
    MAIN CONTENT
    ════════════════════════════════════════ --}}
    <main class="lg:ml-64 pt-[72px] min-h-screen flex flex-col">
        <div class="flex-grow p-6 lg:p-8">

            {{-- Flash Messages --}}
            @foreach (['success' => 'green', 'error' => 'red', 'info' => 'blue'] as $key => $color)
                @if (session($key))
                    <div
                        class="flex items-center gap-3 mb-6 px-5 py-4 rounded-xl bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-400 text-xs font-bold uppercase tracking-widest shadow-lg">
                        <i
                            class="bi bi-{{ $color === 'green' ? 'check-circle-fill' : ($color === 'red' ? 'exclamation-circle-fill' : 'info-circle-fill') }} text-lg"></i>
                        {{ session($key) }}
                    </div>
                @endif
            @endforeach

            @yield('content')
        </div>

        <footer
            class="mt-auto px-8 py-6 border-t border-white/5 text-center lg:text-left text-[10px] font-bold text-white/30 uppercase tracking-widest">
            &copy; {{ date('Y') }} CourtPulse Admin Portal. All Rights Reserved.
        </footer>
    </main>

    {{-- ── GLOBAL JS ─────────────────────────────────────────── --}}
    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        /* Sidebar Toggle */
        function toggleSb() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sbOverlay').classList.toggle('hidden');
            setTimeout(() => {
                document.getElementById('sbOverlay').classList.toggle('opacity-0');
            }, 10);
        }

        function closeSb() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sbOverlay').classList.add('opacity-0');
            setTimeout(() => {
                document.getElementById('sbOverlay').classList.add('hidden');
            }, 300);
        }

        /* Premium Dark Mode Toast */
        function showToast(msg, type = 'ok') {
            const isOk = type === 'ok';
            const box = document.getElementById('toastBox');
            const el = document.createElement('div');

            const colorClass = isOk ? 'bg-green-500/10 border-green-500/30 text-green-400 shadow-[0_5px_20px_rgba(34,197,94,0.15)]' : 'bg-red-500/10 border-red-500/30 text-red-400 shadow-[0_5px_20px_rgba(239,68,68,0.15)]';
            const iconClass = isOk ? 'bi-check-circle-fill text-green-400' : 'bi-exclamation-circle-fill text-red-400';

            el.className = `t-slide pointer-events-auto flex items-center gap-4 px-5 py-4 rounded-xl border backdrop-blur-md text-xs font-bold uppercase tracking-widest ${colorClass}`;
            el.innerHTML = `<i class="bi ${iconClass} text-lg"></i><span class="flex-1 leading-relaxed">${msg}</span>`;

            box.appendChild(el);
            setTimeout(() => {
                el.style.transition = 'opacity .4s ease, transform .4s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(20px)';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        }

        /* AJAX Action Helper */
        function ajaxAction(url, method, btn, successMsg, type = 'ok') {
            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Processing...';
            const body = btn.dataset.body || null;

            fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: body
            })
                .then(r => r.json())
                .then(d => {
                    if (d.success !== false) {
                        showToast(successMsg, type);
                        const row = btn.closest('tr') || btn.closest('.data-card');
                        if (row) {
                            row.style.transition = 'all .4s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'scale(0.95)';
                            setTimeout(() => row.remove(), 400);
                        }
                    } else {
                        showToast(d.message || 'Error executing action', 'err');
                        btn.disabled = false;
                        btn.innerHTML = orig;
                    }
                })
                .catch(() => {
                    showToast('Network Request failed', 'err');
                    btn.disabled = false;
                    btn.innerHTML = orig;
                });
        }
    </script>
    @stack('scripts')
</body>

</html>