<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Browse') — DockIt</title>
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
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        body { background: #050812; font-family: 'Manrope', sans-serif; }
        .gold-ring:focus { outline: none; box-shadow: 0 0 0 3px rgba(180,180,254,0.2); border-color: #B4B4FE !important; }
    </style>
    @stack('styles')
</head>

<body class="font-sans text-white min-h-screen" style="font-weight: 400;" x-data="guestLayout()">
    <div class="fixed top-4 right-4 z-50 flex flex-col gap-2 w-72 pointer-events-none">
        <template x-for="t in toasts" :key="t.id">
            <div x-show="t.show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                :class="t.type === 'ok' ? 'bg-navy2 border-green-500/20 text-green-400' : 'bg-navy2 border-red-500/20 text-red-400'"
                class="pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl border shadow-lg text-sm font-semibold">
                <i :class="t.type === 'ok' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'" class="shrink-0"></i>
                <span x-text="t.msg" class="flex-1"></span>
            </div>
        </template>
    </div>

    <nav class="sticky top-0 z-40 bg-navy2 border-b border-white/5">
        <div class="max-w-[1500px] mx-auto px-4 h-14 flex items-center gap-2">
            <a href="{{ route('guest.dashboard') }}" class="flex items-center gap-2 shrink-0 font-bold text-xl text-white no-underline">
                <span class="w-8 h-8 bg-blue rounded-lg flex items-center justify-center text-navy text-sm"><i class="fas fa-gavel"></i></span>
                <span class="hidden sm:block">DockIt</span>
            </a>

            <div class="hidden md:flex items-center gap-1 ml-auto">
                @foreach ([['guest.dashboard', 'fa-home', 'Home'], ['guest.advocates', 'fa-user-tie', 'Advocates'], ['guest.clerks', 'fa-folder', 'Clerks']] as [$r, $ic, $lb])
                    <a href="{{ route($r) }}" class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold transition-all
                          {{ request()->routeIs($r . '*') ? 'bg-blue/10 text-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas {{ $ic }} text-[0.85rem]"></i> {{ $lb }}
                    </a>
                @endforeach
                <a href="{{ route('feedback') }}" class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold transition-all
                      {{ request()->routeIs('feedback*') || request()->routeIs('user.detail*') ? 'bg-blue/10 text-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-star text-[0.85rem]"></i> Feedback
                </a>
                <form action="{{ route('logout') }}" method="POST" class="ml-2">
                    @csrf
                    <button class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold border border-white/10 text-white/50 hover:border-blue hover:text-blue transition-all">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-2 ml-auto md:hidden">
                <div class="w-8 h-8 rounded-lg bg-blue/10 border border-blue/20 flex items-center justify-center font-bold text-sm text-blue">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <button @click="drawerOpen=true" class="w-9 h-9 border border-white/10 rounded-lg flex items-center justify-center text-white/50 hover:border-blue hover:text-blue transition-all">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </nav>

    <div x-cloak x-show="drawerOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="drawerOpen=false"
        class="fixed inset-0 bg-navy/80 backdrop-blur-sm z-50 md:hidden"></div>

    <div x-cloak x-show="drawerOpen" x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 bottom-0 w-72 bg-navy2 border-l border-white/5 z-51 flex flex-col shadow-2xl md:hidden">

        <div class="flex items-center justify-between p-4 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center font-bold text-base text-blue">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-white leading-tight">{{ auth()->user()->name }}</div>
                    <div class="font-mono text-[0.55rem] tracking-widest uppercase text-blue">{{ auth()->user()->role }}</div>
                </div>
            </div>
            <button @click="drawerOpen=false" class="w-8 h-8 border border-white/10 rounded-lg flex items-center justify-center text-white/50 hover:text-white">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-3 space-y-1">
            <p class="font-mono text-[0.52rem] tracking-[2px] uppercase text-white/30 px-3 py-2">Navigation</p>
            @foreach ([['guest.dashboard', 'fa-home', 'Home'], ['guest.advocates', 'fa-user-tie', 'Advocates'], ['guest.clerks', 'fa-folder', 'Clerks']] as [$r, $ic, $lb])
                <a href="{{ route($r) }}" @click="drawerOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-all
                      {{ request()->routeIs($r . '*') ? 'bg-blue/10 text-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas {{ $ic }} w-5 text-center text-base"></i> {{ $lb }}
                </a>
            @endforeach
            <a href="{{ route('feedback') }}" @click="drawerOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('feedback*') || request()->routeIs('user.detail*') ? 'bg-blue/10 text-blue' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-star w-5 text-center text-base"></i> Feedback
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border border-white/10 text-sm font-semibold text-white/50 hover:border-red-500 hover:text-red-400 hover:bg-red-500/5 transition-all">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <main class="max-w-[1500px] mx-auto px-4 py-5 pb-24 md:pb-8">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 mb-4 px-4 py-3 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm font-semibold">
                <i class="fas fa-check-circle shrink-0"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 mb-4 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-semibold">
                <i class="fas fa-exclamation-circle shrink-0"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-white/5 bg-navy2 mt-10 py-5 hidden md:block">
        <div class="max-w-[1500px] mx-auto px-4 flex items-center justify-between flex-wrap gap-2">
            <div class="font-bold text-base flex items-center gap-2">
                <span class="w-6 h-6 bg-blue rounded flex items-center justify-center text-[0.65rem] text-navy"><i class="fas fa-gavel"></i></span>
                DockIt
            </div>
            <div class="text-xs text-white/40">&copy; {{ date('Y') }} DockIt. All rights reserved.</div>
        </div>
    </footer>

    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-navy2 border-t border-white/5 z-40 flex md:hidden shadow-[0_-2px_12px_rgba(0,0,0,0.3)]">
        @foreach ([['guest.dashboard', 'fa-home', 'Home'], ['guest.advocates', 'fa-user-tie', 'Advocates'], ['guest.clerks', 'fa-folder', 'Clerks'], ['feedback', 'fa-star', 'Feedback']] as [$r, $ic, $lb])
            <a href="{{ route($r) }}" class="flex-1 flex flex-col items-center justify-center gap-1 text-[0.57rem] font-mono tracking-wide uppercase transition-all
                  {{ request()->routeIs($r . '*') || ($r === 'feedback' && (request()->routeIs('feedback*') || request()->routeIs('user.detail*'))) ? 'text-blue' : 'text-white/40 hover:text-blue' }}">
                <i class="fas {{ $ic }} text-xl leading-none"></i>
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
                    this.toasts.push({ id, msg, type, show: true });
                    setTimeout(() => {
                        const t = this.toasts.find(t => t.id === id);
                        if (t) t.show = false;
                        setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
                    }, 3500);
                }
            }
        }
    </script>
    @stack('scripts')
</body>

</html>