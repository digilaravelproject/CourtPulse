<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Browse') — Court Pulse</title>

    {{-- Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap"
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
                        cream: '#faf8f4',
                        ink: '#0e0e0f',
                        border: '#e5e0d8',
                        muted: '#7a7068',
                    },
                    fontFamily: {
                        display: ['Cormorant Garamond', 'serif'],
                        sans: ['DM Sans', 'sans-serif'],
                        mono: ['DM Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    {{-- Alpine --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            background: #faf8f4;
        }

        .gold-ring:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.25);
            border-color: #D4AF37 !important;
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans text-ink min-h-screen" x-data="guestLayout()">

    {{-- Toast --}}
    <div class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 w-72 pointer-events-none">
        <template x-for="t in toasts" :key="t.id">
            <div x-show="t.show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                :class="t.type === 'ok' ? 'bg-white border-green-200 text-green-700' :
                    'bg-white border-red-200 text-red-600'"
                class="pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl border shadow-lg text-sm font-medium">
                <i :class="t.type === 'ok' ? 'bi-check-circle-fill text-green-500' :
                    'bi-exclamation-circle-fill text-red-500'"
                    class="bi flex-shrink-0"></i>
                <span x-text="t.msg" class="flex-1"></span>
            </div>
        </template>
    </div>

    {{-- ══ TOPNAV ══ --}}
    <nav class="sticky top-0 z-[100] bg-white border-b border-border">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center gap-2">

            {{-- Logo --}}
            <a href="{{ route('guest.dashboard') }}"
                class="flex items-center gap-2 flex-shrink-0 font-display font-bold text-xl text-ink no-underline">
                <span class="w-8 h-8 bg-gold rounded-lg flex items-center justify-center text-ink text-sm">⚖</span>
                <span class="hidden sm:block">Court Pulse</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-1 ml-auto">
                @foreach ([['guest.dashboard', 'bi-grid-3x3-gap-fill', 'Home'], ['guest.advocates', 'bi-person-badge', 'Advocates'], ['guest.clerks', 'bi-folder2-open', 'Clerks']] as [$r, $ic, $lb])
                    <a href="{{ route($r) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all
                          {{ request()->routeIs($r . '*') ? 'bg-gold/10 text-gold font-semibold' : 'text-muted hover:bg-gold/10 hover:text-gold-h' }}">
                        <i class="bi {{ $ic }} text-[0.85rem]"></i> {{ $lb }}
                    </a>
                @endforeach
                <a href="{{ route('feedback') }}"
                    class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all
                          {{ request()->routeIs('feedback*') || request()->routeIs('user.detail*') ? 'bg-gold/10 text-gold font-semibold' : 'text-muted hover:bg-gold/10 hover:text-gold-h' }}">
                    <i class="bi bi-star-fill text-[0.85rem]"></i> Feedback
                </a>
                <form action="{{ route('logout') }}" method="POST" class="ml-2">
                    @csrf
                    <button
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium border border-border text-muted hover:border-gold hover:text-gold-h transition-all">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>

            {{-- Mobile right --}}
            <div class="flex items-center gap-2 ml-auto md:hidden">
                <div
                    class="w-8 h-8 rounded-lg bg-gold/10 border border-gold/25 flex items-center justify-center font-display font-bold text-sm text-gold-h">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <button @click="drawerOpen=true"
                    class="w-9 h-9 border border-border rounded-lg flex items-center justify-center text-muted hover:border-gold hover:text-gold transition-all">
                    <i class="bi bi-list text-lg"></i>
                </button>
            </div>
        </div>
    </nav>

    {{-- ══ MOBILE DRAWER ══ --}}
    {{-- Overlay --}}
    <div x-cloak x-show="drawerOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="drawerOpen=false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[200] md:hidden"></div>

    {{-- Drawer panel --}}
    <div x-cloak x-show="drawerOpen" x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 bottom-0 w-72 bg-white z-[201] flex flex-col shadow-2xl md:hidden">

        {{-- Drawer head --}}
        <div class="flex items-center justify-between p-4 border-b border-border">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-gold/10 border border-gold/25 flex items-center justify-center font-display font-bold text-base text-gold-h">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-ink leading-tight">{{ auth()->user()->name }}</div>
                    <div class="font-mono text-[0.55rem] tracking-widest uppercase text-gold-h">
                        {{ auth()->user()->role }}</div>
                </div>
            </div>
            <button @click="drawerOpen=false"
                class="w-8 h-8 border border-border rounded-lg flex items-center justify-center text-muted hover:text-ink">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        {{-- Drawer nav --}}
        <nav class="flex-1 overflow-y-auto p-3 space-y-1">
            <p class="font-mono text-[0.52rem] tracking-[2px] uppercase text-muted/70 px-3 py-2">Navigation</p>
            @foreach ([['guest.dashboard', 'bi-grid-3x3-gap-fill', 'Home'], ['guest.advocates', 'bi-person-badge', 'Advocates'], ['guest.clerks', 'bi-folder2-open', 'Clerks']] as [$r, $ic, $lb])
                <a href="{{ route($r) }}" @click="drawerOpen=false"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
                      {{ request()->routeIs($r . '*') ? 'bg-gold/10 text-gold font-semibold' : 'text-muted hover:bg-gold/10 hover:text-gold-h' }}">
                    <i class="bi {{ $ic }} w-5 text-center text-base"></i> {{ $lb }}
                </a>
            @endforeach
            <a href="{{ route('feedback') }}" @click="drawerOpen=false"
                class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
                      {{ request()->routeIs('feedback*') || request()->routeIs('user.detail*') ? 'bg-gold/10 text-gold font-semibold' : 'text-muted hover:bg-gold/10 hover:text-gold-h' }}">
                <i class="bi bi-star-fill w-5 text-center text-base"></i> Feedback &amp; Connect
            </a>
        </nav>

        {{-- Drawer footer --}}
        <div class="p-4 border-t border-border">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border border-border text-sm font-semibold text-muted hover:border-red-300 hover:text-red-500 hover:bg-red-50 transition-all">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- ══ MAIN ══ --}}
    <main class="max-w-6xl mx-auto px-4 py-5 pb-24 md:pb-8">

        {{-- Flash messages --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm font-medium">
                <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- ══ FOOTER ══ --}}
    <footer class="border-t border-border bg-white mt-10 py-5 hidden md:block">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between flex-wrap gap-2">
            <div class="font-display font-bold text-base flex items-center gap-2">
                <span class="w-6 h-6 bg-gold rounded flex items-center justify-center text-[0.65rem]">⚖</span>
                Court Pulse
            </div>
            <div class="text-xs text-muted">© {{ date('Y') }} Court Pulse. All rights reserved.</div>
        </div>
    </footer>

    {{-- ══ BOTTOM NAV (mobile only) ══ --}}
    <nav
        class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-border z-[100] flex md:hidden shadow-[0_-2px_12px_rgba(0,0,0,0.06)]">
        @foreach ([['guest.dashboard', 'bi-grid-3x3-gap-fill', 'Home'], ['guest.advocates', 'bi-person-badge', 'Advocates'], ['guest.clerks', 'bi-folder2-open', 'Clerks'], ['feedback', 'bi-star-fill', 'Feedback']] as [$r, $ic, $lb])
            <a href="{{ route($r) }}"
                class="flex-1 flex flex-col items-center justify-center gap-1 text-[0.57rem] font-mono tracking-wide uppercase transition-all
                  {{ request()->routeIs($r . '*') || ($r === 'feedback' && (request()->routeIs('feedback*') || request()->routeIs('user.detail*'))) ? 'text-gold' : 'text-muted hover:text-gold-h' }}">
                <i class="bi {{ $ic }} text-xl leading-none"></i>
                {{ $lb }}
            </a>
        @endforeach
    </nav>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        function guestLayout() {
            return {
                drawerOpen: false,
                toasts: [],
                showToast(msg, type = 'ok') {
                    const id = Date.now();
                    this.toasts.push({
                        id,
                        msg,
                        type,
                        show: true
                    });
                    setTimeout(() => {
                        const t = this.toasts.find(t => t.id === id);
                        if (t) t.show = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 300);
                    }, 3500);
                }
            }
        }
    </script>
    @stack('scripts')
</body>

</html>
