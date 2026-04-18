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

        /* Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 1s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        .hover-lift {
            transition: transform 0.4s cubic-bezier(0.2, 1, 0.3, 1), box-shadow 0.4s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>
<body class="antialiased">
    <!-- 1. Header (Navbar) -->
    <nav class="nav" id="navbar">
        <div class="max-w-[1500px] mx-auto px-6 h-full flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group no-underline">
                <div class="logo-box">DI</div>
                <span class="text-white font-black tracking-tighter text-2xl uppercase">DockIt</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-[0.65rem] font-black text-slate-400 hover:text-white transition no-underline tracking-[0.2em] uppercase">Home</a>
                <a href="#how-it-works" class="text-[0.65rem] font-black text-slate-400 hover:text-white transition no-underline tracking-[0.2em] uppercase">How it works</a>
                <a href="{{ route('find') }}" class="text-[0.65rem] font-black text-slate-400 hover:text-white transition no-underline tracking-[0.2em] uppercase">begin</a>
                <a href="{{ route('blogs') }}" class="text-[0.65rem] font-black text-slate-400 hover:text-white transition no-underline tracking-[0.2em] uppercase">Blogs</a>
                <a href="{{ route('updates') }}" class="text-[0.65rem] font-black text-slate-400 hover:text-white transition no-underline tracking-[0.2em] uppercase">latest Update</a>
                <a href="#contact" class="text-[0.65rem] font-black text-slate-400 hover:text-white transition no-underline tracking-[0.2em] uppercase">contact us</a>
                <a href="{{ route('careers') }}" class="text-[0.65rem] font-black text-slate-400 hover:text-white transition no-underline tracking-[0.2em] uppercase">careers</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-ghost">DASHBOARD</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn-ghost">LOGOUT</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost uppercase">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary" style="background: var(--blue); color: var(--navy); border-radius: 4px; padding: 10px 18px; font-size: 0.65rem;">JOIN AS PROFESSIONAL</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="pt-[75px]">
        @yield('content')
    </div>

    <!-- 3. Footer (Global Bottom) -->
    <footer class="bg-[#050812] border-t border-white/5 pt-24">
        <div class="max-w-[1500px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 mb-20 items-center">
                <div>
                    <div class="flex items-center gap-6 mb-8">
                        <span class="font-black text-5xl text-white tracking-tighter uppercase italic">DockIt</span>
                        <span class="w-px h-8 bg-white/10"></span>
                        <span class="text-xl font-bold text-slate-400 uppercase tracking-[0.3em]">Menu</span>
                    </div>
                    <p class="text-slate-500 text-lg max-w-xl leading-relaxed">
                        A platform that gives instant access to procedural support - clerks, filling agents, on-ground help accross courts and tribunals in India.
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">Sections</h4>
                        <ul class="space-y-4 list-none p-0 text-slate-500 text-sm font-bold uppercase tracking-widest">
                            <li><a href="{{ url('/') }}" class="hover:text-[#B4B4FE] transition no-underline">Home</a></li>
                            <li><a href="#how-it-works" class="hover:text-[#B4B4FE] transition no-underline">How it works</a></li>
                            <li><a href="{{ route('find') }}" class="hover:text-[#B4B4FE] transition no-underline">Begin</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">Updates</h4>
                        <ul class="space-y-4 list-none p-0 text-slate-500 text-sm font-bold uppercase tracking-widest">
                            <li><a href="{{ route('updates') }}" class="hover:text-[#B4B4FE] transition no-underline">Updates</a></li>
                            <li><a href="{{ route('blogs') }}" class="hover:text-[#B4B4FE] transition no-underline">Blogs</a></li>
                            <li><a href="#contact" class="hover:text-[#B4B4FE] transition no-underline">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Marquee -->
            <div class="border-y border-white/5 py-4 overflow-hidden bg-white/2">
                <div class="marquee-container" style="background: transparent;">
                    <div class="marquee-content" style="animation: marquee 20s linear infinite;">
                        <span class="mx-12 text-[0.65rem] font-black text-[#B4B4FE] uppercase tracking-[0.4em] italic">NEWS</span>
                        <span class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court / Tribunal Updates</span>
                        <span class="mx-12 text-[0.65rem] font-black text-[#B4B4FE] uppercase tracking-[0.4em] italic">NEWS</span>
                        <span class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court / Tribunal Updates</span>
                        <!-- Duplicate for seamless scroll -->
                        <span class="mx-12 text-[0.65rem] font-black text-[#B4B4FE] uppercase tracking-[0.4em] italic">NEWS</span>
                        <span class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court / Tribunal Updates</span>
                        <span class="mx-12 text-[0.65rem] font-black text-[#B4B4FE] uppercase tracking-[0.4em] italic">NEWS</span>
                        <span class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court / Tribunal Updates</span>
                    </div>
                </div>
            </div>

            <!-- Find & Login Lists (Point 7) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 py-12 border-b border-white/5">
                <div>
                    <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">Find</h4>
                    <div class="flex flex-wrap gap-x-8 gap-y-4 text-slate-500 text-[0.65rem] font-black uppercase tracking-widest">
                        <a href="#" class="hover:text-[#B4B4FE] transition no-underline">Court Clerks</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-[#B4B4FE] transition no-underline">IP Clerks</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-[#B4B4FE] transition no-underline">RoC Agents</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-[#B4B4FE] transition no-underline">Advocates</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">Login</h4>
                    <div class="flex flex-wrap gap-x-8 gap-y-4 text-slate-500 text-[0.65rem] font-black uppercase tracking-widest">
                        <a href="#" class="hover:text-[#B4B4FE] transition no-underline">Proffessionals</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-[#B4B4FE] transition no-underline">Guest</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-[#B4B4FE] transition no-underline">Support</a>
                    </div>
                </div>
            </div>

            <div class="py-12 flex flex-col md:flex-row justify-between items-center gap-6">
                <span class="text-slate-600 text-[0.6rem] font-bold uppercase tracking-[0.3em]">&copy; {{ date('Y') }} DOCKIT NETWORK. EVERY SECOND COVERED.</span>
                <div class="flex gap-8 text-slate-500 text-sm">
                    <a href="#" class="hover:text-white transition"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Intersection Observer for Scroll Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    // Once visible, we can stop observing to save resources
                    // observer.unobserve(entry.target); 
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal, .reveal-left').forEach(el => observer.observe(el));
    </script>
</body>
</html>
