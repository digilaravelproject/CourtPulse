<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Court Pulse</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4AF37',
                        'gold-h': '#B5952F',
                        navy: '#0A1120',
                        'ncard': '#1E293B',
                        'nbg': '#0F172A',
                    },
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    {{-- Alpine.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>

    <style>
        :root {
            --sw: 256px;
        }

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px
        }

        ::-webkit-scrollbar-track {
            background: transparent
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px
        }

        /* gold pattern */
        .gpat {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23D4AF37' fill-opacity='0.045'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E")
        }

        /* active link bar */
        .nav-active {
            position: relative;
            background: rgba(212, 175, 55, .10);
            color: #D4AF37 !important
        }

        .nav-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #D4AF37;
            border-radius: 0 2px 2px 0
        }

        /* table row hover */
        .trow:hover td {
            background: #f8fafc
        }

        .trow td {
            border-bottom: 1px solid #f1f5f9;
            padding: 12px 16px;
            vertical-align: middle
        }

        .trow:last-child td {
            border-bottom: none
        }

        /* spin */
        .spin {
            display: inline-block;
            animation: sp .7s linear infinite
        }

        @keyframes sp {
            to {
                transform: rotate(360deg)
            }
        }

        /* modal pop */
        @keyframes popIn {
            from {
                opacity: 0;
                transform: translate(-50%, -46%) scale(.95)
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1)
            }
        }

        .modal-pop {
            animation: popIn .25s cubic-bezier(.34, 1.56, .64, 1) forwards
        }

        /* toast slide */
        @keyframes tIn {
            from {
                opacity: 0;
                transform: translateX(12px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        .t-slide {
            animation: tIn .25s ease forwards
        }

        /* status dots */
        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block
        }

        /* Alpine.js — hide elements until Alpine initialises */
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-100 font-sans min-h-screen">

    {{-- ── TOAST BOX ────────────────────────────────────────── --}}
    <div id="toastBox" class="fixed top-16 right-4 z-[9999] flex flex-col gap-2 w-72 pointer-events-none"></div>

    {{-- ── SIDEBAR OVERLAY (mobile) ────────────────────────── --}}
    <div id="sbOverlay" onclick="closeSb()" class="hidden fixed inset-0 bg-navy/60 backdrop-blur-sm z-[198]"></div>

    {{-- ════════════════════════════════════════
     SIDEBAR
════════════════════════════════════════ --}}
    <aside id="sidebar"
        class="gpat fixed inset-y-0 left-0 w-64 bg-navy flex flex-col z-[199]
         border-r border-white/[0.06] transition-transform duration-300
         -translate-x-full lg:translate-x-0">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-[21px] border-b border-white/[0.06] flex-shrink-0">
            <div
                class="w-9 h-9 rounded-[9px] border border-gold/40 bg-gold/10 overflow-hidden flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo" class="w-full h-full object-cover">
            </div>
            <div>
                <div class="font-display text-[1.1rem] font-bold text-white leading-tight">Court Pulse</div>
                <div class="font-mono text-[0.52rem] text-gold/80 tracking-[2.5px] uppercase">Admin Panel</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-3 space-y-0.5">

            @php
                function navLink($route, $icon, $label, $badge = null)
                {
                    $active = request()->routeIs($route . '*');
                    $cls = $active ? 'nav-active' : 'text-white/55 hover:bg-white/[0.04] hover:text-white/80';
                    $b = $badge
                        ? "<span class='ml-auto bg-gold text-navy text-[0.54rem] font-bold px-1.5 py-0.5 rounded-full font-mono'>{$badge}</span>"
                        : '';
                    return "<a href='" .
                        route($route) .
                        "' class='flex items-center gap-3 px-5 py-2.5 text-[0.84rem] font-medium transition-all {$cls}'>
                  <i class='bi {$icon} w-[18px] flex-shrink-0'></i> {$label} {$b}
                </a>";
                }
            @endphp

            <div class="px-5 pt-3 pb-1 font-mono text-[0.5rem] tracking-[2.5px] uppercase text-white/20">Main</div>
            {!! navLink('admin.dashboard', 'bi-grid-3x3-gap', 'Dashboard') !!}

            <div class="px-5 pt-4 pb-1 font-mono text-[0.5rem] tracking-[2.5px] uppercase text-white/20">User Management
            </div>
            {!! navLink('admin.advocates', 'bi-person-badge', 'Advocates') !!}
            {!! navLink('admin.clerks', 'bi-folder2-open', 'Clerks') !!}
            {!! navLink('admin.users', 'bi-people', 'All Users', $pendingCount ?? 0 > 0 ? $pendingCount ?? 0 : null) !!}

            <div class="px-5 pt-4 pb-1 font-mono text-[0.5rem] tracking-[2.5px] uppercase text-white/20">Content</div>
            {!! navLink('admin.documents', 'bi-file-earmark-check', 'Documents') !!}
            {!! navLink('admin.courts.index', 'bi-building', 'Courts') !!}
            {!! navLink('admin.feedback', 'bi-star', 'Feedback') !!}

            @php
                $isSuperAdmin = DB::table('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('model_has_roles.model_id', auth()->id())
                    ->where('model_has_roles.model_type', 'App\Models\User')
                    ->where('roles.name', 'super_admin')
                    ->exists();
            @endphp
            @if ($isSuperAdmin)
                <div class="px-5 pt-4 pb-1 font-mono text-[0.5rem] tracking-[2.5px] uppercase text-white/20">Super Admin
                </div>
                {!! navLink('super.roles', 'bi-shield-lock', 'Roles') !!}
                {!! navLink('super.permissions', 'bi-key', 'Permissions') !!}
                {!! navLink('super.activity', 'bi-clock-history', 'Activity Logs') !!}
            @endif

        </nav>

        {{-- Footer --}}
        <div class="flex-shrink-0 px-5 py-4 border-t border-white/[0.06]">
            <div class="flex items-center gap-3">
                <div
                    class="w-[34px] h-[34px] rounded-[8px] bg-ncard border border-gold/25
                  flex items-center justify-center text-gold font-bold text-[0.82rem] flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-1 min-w-0">
                    <div class="text-[0.82rem] font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="font-mono text-[0.55rem] text-gold/80 uppercase tracking-wide">
                        {{ auth()->user()->role }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button title="Logout" class="text-white/25 hover:text-red-400 transition-colors text-[1rem]">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ════════════════════════════════════════
     TOPBAR
════════════════════════════════════════ --}}
    <header
        class="fixed top-0 left-0 lg:left-64 right-0 h-[58px] bg-white
               border-b border-slate-200 flex items-center px-5 gap-4 z-[100]">

        <button onclick="toggleSb()" class="lg:hidden text-slate-500 text-xl mr-1">
            <i class="bi bi-list"></i>
        </button>

        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                class="w-7 h-7 rounded-full object-cover border border-gold/40">
            <span class="font-display font-bold text-[1.1rem] text-slate-800 truncate">@yield('page-title', 'Dashboard')</span>
        </div>

        <div class="ml-auto flex items-center gap-2">
            @php
                $di = (int) ($pendingDocsCount ?? 0);
                $ui = (int) ($pendingCount ?? 0);
            @endphp

            <a href="{{ route('admin.documents') }}"
                class="relative w-9 h-9 rounded-lg border border-slate-200 bg-white
              flex items-center justify-center text-slate-500
              hover:border-gold hover:text-gold transition-all">
                <i class="bi bi-file-earmark-check text-[1rem]"></i>
                @if ($di > 0)
                    <span
                        class="absolute -top-1.5 -right-1.5 min-w-[17px] h-[17px] bg-gold rounded-full text-navy text-[0.5rem] font-bold flex items-center justify-center font-mono border-2 border-white px-0.5">{{ $di }}</span>
                @endif
            </a>

            <a href="{{ route('admin.users') }}?status=pending"
                class="relative w-9 h-9 rounded-lg border border-slate-200 bg-white
              flex items-center justify-center text-slate-500
              hover:border-red-400 hover:text-red-500 transition-all">
                <i class="bi bi-bell text-[1rem]"></i>
                @if ($ui > 0)
                    <span
                        class="absolute -top-1.5 -right-1.5 min-w-[17px] h-[17px] bg-red-500 rounded-full text-white text-[0.5rem] font-bold flex items-center justify-center border-2 border-white px-0.5">{{ $ui }}</span>
                @endif
            </a>

            <div
                class="w-9 h-9 rounded-lg bg-ncard border border-gold/25
                flex items-center justify-center text-gold font-bold text-[0.82rem]">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </header>

    {{-- ════════════════════════════════════════
     MAIN
════════════════════════════════════════ --}}
    <main class="lg:ml-64 pt-[58px] min-h-screen">
        <div class="p-5 lg:p-6">

            {{-- Flash --}}
            @foreach (['success' => 'green', 'error' => 'red', 'info' => 'amber'] as $key => $color)
                @if (session($key))
                    <div
                        class="flex items-center gap-3 mb-4 px-4 py-3 rounded-xl
                bg-{{ $color }}-50 border border-{{ $color }}-200
                text-{{ $color }}-700 text-sm font-medium">
                        <i
                            class="bi bi-{{ $color === 'green' ? 'check-circle-fill' : ($color === 'red' ? 'exclamation-circle-fill' : 'info-circle-fill') }}"></i>
                        {{ session($key) }}
                    </div>
                @endif
            @endforeach

            @yield('content')
        </div>
    </main>

    {{-- ── GLOBAL JS ─────────────────────────────────────────── --}}
    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        /* Sidebar toggle */
        function toggleSb() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sbOverlay').classList.toggle('hidden');
        }

        function closeSb() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sbOverlay').classList.add('hidden');
        }

        /* Toast */
        function showToast(msg, type = 'ok') {
            const isOk = type === 'ok';
            const box = document.getElementById('toastBox');
            const el = document.createElement('div');
            el.className = `t-slide pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl
                  border shadow-lg text-sm font-medium
                  ${isOk ? 'bg-white border-green-200 text-green-700' : 'bg-white border-red-200 text-red-600'}`;
            el.innerHTML = `<i class="bi ${isOk?'bi-check-circle-fill text-green-500':'bi-exclamation-circle-fill text-red-500'}"></i>
                  <span class="flex-1">${msg}</span>`;
            box.appendChild(el);
            setTimeout(() => {
                el.style.transition = 'opacity .3s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            }, 3500);
        }

        /* AJAX action helper (approve/reject inline) */
        function ajaxAction(url, method, btn, successMsg, type = 'ok') {
            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
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
                        const row = btn.closest('tr');
                        if (row) {
                            row.style.transition = 'opacity .3s';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                    } else {
                        showToast(d.message || 'Error', 'err');
                        btn.disabled = false;
                        btn.innerHTML = orig;
                    }
                })
                .catch(() => {
                    showToast('Request failed', 'err');
                    btn.disabled = false;
                    btn.innerHTML = orig;
                });
        }
    </script>
    @stack('scripts')
</body>

</html>
