<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DockIt') — India's Legal Professional Network</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

    <!-- Styling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy: #050812;
            --navy2: #080d1a;
            --navy3: #0b1120;
            --card: #0e1526;
            --card2: #111830;
            --card3: #141c35;
            --blue: #B4B4FE;
            --blue2: #9999f0;
            --blue-glow: rgba(180, 180, 254, 0.3);
            --blue-light: #d0d0ff;
            --accent: #B4B4FE;
            --border: rgba(255, 255, 255, 0.06);
            --border2: rgba(180, 180, 254, 0.35);
            --text: #CBD5E1;
            --text2: #94A3B8;
            --muted: #4A5568;
            --white: #F8FAFC;
        }

        body {
            background: var(--navy);
            color: var(--text);
            font-family: 'Manrope', sans-serif;
            overflow-x: hidden;
            line-height: 1.6;
            font-weight: 400;
        }

        /* Nav */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 18px 0;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px);
            background: rgba(5, 8, 18, 0.92);
            transition: all 0.3s ease;
        }
        
        .nav.scrolled {
            padding: 12px 0;
            background: rgba(5, 8, 18, 0.98);
        }

        .logo-box {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: var(--navy);
            font-weight: 900;
        }

        .btn-primary {
            background: var(--blue);
            color: var(--navy);
            font-weight: 700;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.2s;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .btn-primary:hover {
            background: var(--blue2);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px var(--blue-glow);
        }

        .btn-ghost {
            color: var(--text2);
            border: 1px solid var(--border);
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-ghost:hover {
            color: var(--white);
            border-color: var(--text2);
        }

        /* Sections */
        .section-head {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .section-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        /* Marquee */
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            background: var(--blue);
            padding: 10px 0;
        }

        .marquee-content {
            display: inline-block;
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-item {
            display: inline-block;
            padding: 0 30px;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--navy);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
    </style>
</head>
<body class="antialiased">
    <!-- 1. Header -->
    <nav class="nav" id="navbar">
        <div class="max-w-[1500px] mx-auto px-6 h-full flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-white no-underline">
                <div class="logo-box">D</div>
                <span class="font-extrabold tracking-tight text-lg">DockIt</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-[0.82rem] font-medium text-slate-400 hover:text-white transition no-underline">HOME</a>
                <a href="{{ route('find') }}" class="text-[0.82rem] font-medium text-slate-400 hover:text-white transition no-underline">BEGIN / FIND</a>
                <a href="{{ route('blogs') }}" class="text-[0.82rem] font-medium text-slate-400 hover:text-white transition no-underline">BLOGS</a>
                <a href="{{ route('updates') }}" class="text-[0.82rem] font-medium text-slate-400 hover:text-white transition no-underline">UPDATES</a>
                <a href="{{ route('careers') }}" class="text-[0.82rem] font-medium text-slate-400 hover:text-white transition no-underline">CAREERS</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-ghost">DASHBOARD</a>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn-primary">JOIN NETWORK</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="pt-[75px]">
        @yield('content')
    </div>

    <!-- 3. Footer -->
    <footer class="bg-[#050812] border-t border-white/5 pt-24 pb-12">
        <div class="max-w-[1500px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-2">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 text-white no-underline mb-6">
                        <div class="logo-box">D</div>
                        <span class="font-extrabold tracking-tight text-2xl">DockIt</span>
                    </a>
                    <p class="text-slate-500 text-lg max-w-md">The unified platform for procedural legal support across all Indian courts and tribunals.</p>
                </div>
                <div>
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.2em] mb-6">Platform</h4>
                    <ul class="space-y-4 list-none p-0 text-slate-500 text-sm">
                        <li><a href="{{ route('find') }}" class="hover:text-white transition no-underline">Find Professional</a></li>
                        <li><a href="{{ route('blogs') }}" class="hover:text-white transition no-underline">Legal Blogs</a></li>
                        <li><a href="{{ route('updates') }}" class="hover:text-white transition no-underline">Court Updates</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.2em] mb-6">Company</h4>
                    <ul class="space-y-4 list-none p-0 text-slate-500 text-sm">
                        <li><a href="{{ route('careers') }}" class="hover:text-white transition no-underline">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition no-underline">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition no-underline">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <span class="text-slate-600 text-[0.7rem] uppercase tracking-widest">&copy; {{ date('Y') }} DOCKIT NETWORK. ALL RIGHTS RESERVED.</span>
                <div class="flex gap-6 text-slate-500 text-lg">
                    <a href="#" class="hover:text-white transition"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
