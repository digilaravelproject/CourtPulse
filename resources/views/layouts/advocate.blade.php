<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Court Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#060C18',
                            800: '#0F1A2E',
                            700: '#1a2744'
                        },
                        gold: {
                            DEFAULT: '#D4AF37',
                            dark: '#B5952F',
                            light: '#F2D06B'
                        },
                    },
                    fontFamily: {
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        body: ['"DM Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>
    <style>
        * {
            box-sizing: border-box
        }

        body {
            font-family: 'DM Sans', sans-serif
        }

        /* Sidebar */
        #sidebar {
            width: 256px;
            background: #060C18;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, .06) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(26, 39, 68, .8) 0%, transparent 50%);
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
        }

        /* Nav link base */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: .84rem;
            font-weight: 500;
            color: rgba(255, 255, 255, .5);
            text-decoration: none;
            transition: all .18s;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, .06);
            color: rgba(255, 255, 255, .85);
        }

        .nav-link:hover .nav-icon {
            color: rgba(255, 255, 255, .6)
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(212, 175, 55, .18), rgba(212, 175, 55, .08));
            color: #D4AF37;
            border: 1px solid rgba(212, 175, 55, .2);
        }

        .nav-link.active .nav-icon {
            color: #D4AF37
        }

        .nav-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
            color: rgba(255, 255, 255, .3);
            transition: all .18s;
        }

        .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, .06)
        }

        .nav-link.active .nav-icon {
            background: rgba(212, 175, 55, .15)
        }

        .nav-section {
            font-family: 'JetBrains Mono', monospace;
            font-size: .52rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .2);
            padding: 14px 16px 5px;
        }

        /* Topbar */
        #topbar {
            left: 256px;
            transition: left .3s
        }

        /* Alert */
        .alert-cp {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: .83rem;
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 18px;
            border: 1px solid
        }

        .alert-success {
            background: rgba(34, 197, 94, .08);
            border-color: rgba(34, 197, 94, .25);
            color: #16a34a
        }

        .alert-error {
            background: rgba(239, 68, 68, .08);
            border-color: rgba(239, 68, 68, .25);
            color: #dc2626
        }

        .alert-info {
            background: rgba(212, 175, 55, .08);
            border-color: rgba(212, 175, 55, .3);
            color: #92650a
        }

        /* Table row hover */
        .trow {
            transition: background .15s
        }

        .trow:hover {
            background: #F8FAFC
        }

        /* Status dot */
        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block
        }

        /* Spinner */
        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        .spin {
            animation: spin .7s linear infinite;
            display: inline-block
        }

        ::-webkit-scrollbar {
            width: 4px
        }

        ::-webkit-scrollbar-track {
            background: transparent
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, .2);
            border-radius: 10px
        }

        [x-cloak] {
            display: none !important
        }

        @media(max-width:1023px) {
            #sidebar {
                transform: translateX(-100%)
            }

            #sidebar.open {
                transform: translateX(0)
            }

            #mainWrap {
                margin-left: 0 !important
            }

            #topbar {
                left: 0 !important
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-100 min-h-screen">

    <!-- Overlay mobile -->
    <div id="sbOverlay" onclick="closeSb()" class="hidden fixed inset-0 bg-black/60 z-30 lg:hidden"></div>

    <!-- ═══════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════ -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen z-40 flex flex-col">

        <!-- Brand -->
        <div class="flex items-center gap-3 px-4 py-[18px]" style="border-bottom:1px solid rgba(255,255,255,.07)">
            <img src="data:image/jpeg;base64,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"
                alt="CP" class="w-9 h-9 rounded-xl object-cover flex-shrink-0"
                style="box-shadow:0 0 0 2px rgba(212,175,55,.3)">
            <div>
                <div class="font-display font-bold text-white leading-tight" style="font-size:1.02rem">Court Pulse</div>
                <div class="font-mono uppercase tracking-[2.5px]" style="font-size:.48rem;color:rgba(212,175,55,.55)">
                    Advocate Portal</div>
            </div>
        </div>

        <!-- Pending banner -->
        @if (auth()->user()->status === 'pending')
            <div class="mx-3 mt-3 rounded-xl px-3 py-2.5 flex gap-2 items-start"
                style="background:rgba(212,175,55,.08);border:1px solid rgba(212,175,55,.2)">
                <i class="bi bi-clock-history flex-shrink-0 mt-0.5" style="color:#D4AF37;font-size:.8rem"></i>
                <p class="text-[.72rem] leading-snug" style="color:#D4AF37">
                    Account pending verification. Upload required documents.
                </p>
            </div>
        @endif

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-2">

            <div class="nav-section">My Space</div>

            <a href="{{ route('advocate.dashboard') }}"
                class="nav-link {{ request()->routeIs('advocate.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('advocate.profile') }}"
                class="nav-link {{ request()->routeIs('advocate.profile*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-person-vcard"></i></span>
                <span>My Profile</span>
            </a>

            <a href="{{ route('advocate.documents') }}"
                class="nav-link {{ request()->routeIs('advocate.documents*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-folder2-open"></i></span>
                <span>My Documents</span>
                @php $pendingDocs = auth()->user()->documents()->where('status','pending')->count(); @endphp
                @if ($pendingDocs > 0)
                    <span class="ml-auto text-[.58rem] font-mono font-bold px-1.5 py-0.5 rounded-full"
                        style="background:rgba(212,175,55,.2);color:#D4AF37">{{ $pendingDocs }}</span>
                @endif
            </a>

            <div class="nav-section">Network</div>

            <a href="{{ route('advocate.search.clerks') }}"
                class="nav-link {{ request()->routeIs('advocate.search*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-people"></i></span>
                <span>Search Clerks</span>
            </a>

            <a href="{{ route('advocate.guests') }}"
                class="nav-link {{ request()->routeIs('advocate.guest*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-people-fill"></i></span>
                <span>Browse Guests</span>
            </a>

            <a href="{{ route('feedback') }}" class="nav-link {{ request()->is('feedback*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-star-half"></i></span>
                <span>Feedback</span>
            </a>

        </nav>

        <!-- User card footer -->
        <div class="px-3 py-3" style="border-top:1px solid rgba(255,255,255,.07)">
            <div class="flex items-center gap-2.5 rounded-xl px-3 py-2.5"
                style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                <div class="w-8 h-8 rounded-lg font-bold font-display text-sm flex items-center justify-center flex-shrink-0"
                    style="background:linear-gradient(135deg,#D4AF37,#B5952F);color:#060C18">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-white truncate" style="font-size:.82rem">{{ auth()->user()->name }}
                    </div>
                    <div class="font-mono uppercase tracking-wider truncate"
                        style="font-size:.52rem;color:rgba(212,175,55,.5)">
                        @if (auth()->user()->status === 'active')
                            ✓ Verified
                        @else
                            ⏳ Pending
                        @endif
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout"
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-xs transition-all"
                        style="background:none;border:none;color:rgba(255,255,255,.25);cursor:pointer"
                        onmouseover="this.style.background='rgba(239,68,68,.15)';this.style.color='#ef4444'"
                        onmouseout="this.style.background='none';this.style.color='rgba(255,255,255,.25)'">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- ═══════════════════════════════════════
     TOPBAR
═══════════════════════════════════════ -->
    <header id="topbar"
        class="fixed top-0 right-0 h-14 bg-white border-b border-slate-200 z-20
              flex items-center px-5 gap-3 shadow-sm">

        <button onclick="toggleSb()"
            class="lg:hidden w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center
           text-slate-500 hover:text-slate-800 text-lg bg-white">
            <i class="bi bi-list"></i>
        </button>

        <div class="font-display font-bold text-slate-800" style="font-size:1rem">
            @yield('page-title', 'Dashboard')
        </div>

        <div class="ml-auto flex items-center gap-2">

            <a href="{{ route('advocate.search.clerks') }}"
                class="hidden sm:flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-bold transition-all"
                style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                onmouseout="this.style.background='#D4AF37'">
                <i class="bi bi-plus-lg"></i> Find Clerk
            </a>

            <div class="relative">
                <button
                    class="w-9 h-9 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-500 hover:border-yellow-400 transition-all text-sm">
                    <i class="bi bi-bell"></i>
                </button>
                <span
                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center font-bold"
                    style="font-size:.5rem">3</span>
            </div>

            <div class="w-9 h-9 rounded-xl font-bold font-display text-sm flex items-center justify-center"
                style="background:linear-gradient(135deg,#D4AF37,#B5952F);color:#060C18">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </header>

    <!-- ═══════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════ -->
    <main id="mainWrap" class="pt-14 min-h-screen" style="margin-left:256px">
        <div class="p-5 lg:p-6">

            @if (session('success'))
                <div class="alert-cp alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-cp alert-error"><i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}</div>
            @endif
            @if (session('info'))
                <div class="alert-cp alert-info"><i class="bi bi-info-circle-fill"></i> {{ session('info') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function toggleSb() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sbOverlay').classList.toggle('hidden');
        }

        function closeSb() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sbOverlay').classList.add('hidden');
        }

        function showToast(msg, type = 'success') {
            const t = document.createElement('div');
            t.className =
                'fixed bottom-5 right-5 z-50 flex items-center gap-2.5 px-4 py-3 rounded-xl shadow-xl text-sm font-semibold';
            t.style.cssText = type === 'success' ? 'background:#D4AF37;color:#060C18' : 'background:#ef4444;color:white';
            t.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i>' +
            msg;
            document.body.appendChild(t);
            setTimeout(() => {
                t.style.opacity = '0';
                t.style.transition = 'opacity .3s';
                setTimeout(() => t.remove(), 300)
            }, 3200);
        }
        setTimeout(() => {
            document.querySelectorAll('.alert-cp').forEach(a => {
                a.style.transition = 'opacity .4s';
                a.style.opacity = '0';
                setTimeout(() => a.remove(), 400);
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>

</html>
