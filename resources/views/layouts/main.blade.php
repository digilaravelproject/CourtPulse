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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

    <!-- Styling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-navy font-sans text-text2 overflow-x-hidden">

    <!-- 1. Header (Navbar) -->
    <nav class="fixed top-0 left-0 right-0 z-[2000] py-5 border-b border-white/5 backdrop-blur-xl bg-navy/90 transition-all duration-500 ease-in-out" id="navbar">
        <div class="max-w-[1500px] mx-auto px-6 h-full flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group no-underline">
                <div class="w-9 h-9 rounded-lg bg-blue flex items-center justify-center text-[0.85rem] text-navy font-black group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-[0_0_15px_rgba(180,180,254,0.4)]">DI</div>
                <span class="text-white font-black tracking-tighter text-2xl uppercase group-hover:text-blue transition-colors duration-300">DockIt</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-10">
                <a href="{{ url('/') }}"
                    class="text-[0.7rem] font-bold text-slate-400 hover:text-white transition-all no-underline tracking-[0.2em] uppercase hover:scale-105 active:scale-95">Home</a>
                <a href="#how-it-works"
                    class="text-[0.7rem] font-bold text-slate-400 hover:text-white transition-all no-underline tracking-[0.2em] uppercase hover:scale-105 active:scale-95">How
                    it works</a>
                <a href="{{ route('find') }}"
                    class="text-[0.7rem] font-bold text-slate-400 hover:text-white transition-all no-underline tracking-[0.2em] uppercase hover:scale-105 active:scale-95">Search</a>
                <a href="{{ route('blogs') }}"
                    class="text-[0.7rem] font-bold text-slate-400 hover:text-white transition-all no-underline tracking-[0.2em] uppercase hover:scale-105 active:scale-95">Blogs</a>
                <a href="{{ route('updates') }}"
                    class="text-[0.7rem] font-bold text-slate-400 hover:text-white transition-all no-underline tracking-[0.2em] uppercase hover:scale-105 active:scale-95">Updates</a>
                <a href="#contact"
                    class="text-[0.7rem] font-bold text-slate-400 hover:text-white transition-all no-underline tracking-[0.2em] uppercase hover:scale-105 active:scale-95">Contact</a>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex items-center gap-5">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-slate-400 border border-white/10 px-6 py-2.5 rounded-lg text-[0.7rem] font-bold transition-all duration-300 hover:text-white hover:border-slate-400 no-underline uppercase tracking-widest">DASHBOARD</a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="text-slate-400 border border-white/10 px-6 py-2.5 rounded-lg text-[0.7rem] font-bold transition-all duration-300 hover:text-white hover:border-slate-400 no-underline uppercase tracking-widest">LOGOUT</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition-all no-underline uppercase text-[0.7rem] font-bold tracking-widest">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue text-navy font-black px-6 py-2.5 rounded-lg transition-all duration-300 uppercase text-[0.7rem] tracking-widest hover:bg-white hover:scale-105 hover:shadow-[0_0_20px_rgba(180,180,254,0.5)] no-underline">JOIN NOW</a>
                    @endauth
                </div>

                <!-- Hamburger -->
                <button id="mobile-toggle" type="button" class="lg:hidden text-white text-3xl p-2 hover:text-blue transition-all active:scale-90 flex items-center justify-center rounded-lg hover:bg-white/5" aria-label="Toggle Menu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Drawer Overlay -->
    <div id="menu-overlay" class="fixed inset-0 bg-black/60 z-[2500] opacity-0 pointer-events-none transition-opacity duration-500 lg:hidden"></div>

    <!-- Mobile Drawer -->
    <div id="mobile-menu" class="fixed top-0 right-0 bottom-0 w-[320px] z-[3000] translate-x-full lg:hidden bg-navy/95 backdrop-blur-2xl border-l border-white/10 transition-transform duration-500 ease-[cubic-bezier(0.2,1,0.3,1)] overflow-y-auto">
        <div class="flex flex-col h-full w-full p-8">
            <div class="flex justify-between items-center mb-12">
                <a href="{{ url('/') }}" class="flex items-center gap-2 no-underline">
                    <div class="w-8 h-8 rounded-md bg-blue flex items-center justify-center text-[0.8rem] text-navy font-black">DI</div>
                    <span class="text-white font-black tracking-tighter text-2xl uppercase">DockIt</span>
                </a>
                <button id="mobile-close" class="text-white text-3xl p-2 hover:text-blue transition-colors active:scale-90">
                    <i class="bi bi-x-lg text-2xl"></i>
                </button>
            </div>

            <div class="flex flex-col gap-1">
                <a href="{{ url('/') }}" class="mobile-nav-link group flex items-center justify-between text-[0.75rem] font-black text-slate-400 uppercase tracking-[0.2em] no-underline py-5 border-b border-white/5 hover:text-white transition-all">
                    <span>Home</span>
                    <i class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-all"></i>
                </a>
                <a href="#how-it-works" class="mobile-nav-link group flex items-center justify-between text-[0.75rem] font-black text-slate-400 uppercase tracking-[0.2em] no-underline py-5 border-b border-white/5 hover:text-white transition-all">
                    <span>How it works</span>
                    <i class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-all"></i>
                </a>
                <a href="{{ route('find') }}" class="mobile-nav-link group flex items-center justify-between text-[0.75rem] font-black text-slate-400 uppercase tracking-[0.2em] no-underline py-5 border-b border-white/5 hover:text-white transition-all">
                    <span>Search</span>
                    <i class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-all"></i>
                </a>
                <a href="{{ route('blogs') }}" class="mobile-nav-link group flex items-center justify-between text-[0.75rem] font-black text-slate-400 uppercase tracking-[0.2em] no-underline py-5 border-b border-white/5 hover:text-white transition-all">
                    <span>Legal Blogs</span>
                    <i class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-all"></i>
                </a>
                <a href="{{ route('updates') }}" class="mobile-nav-link group flex items-center justify-between text-[0.75rem] font-black text-slate-400 uppercase tracking-[0.2em] no-underline py-5 border-b border-white/5 hover:text-white transition-all">
                    <span>Latest Updates</span>
                    <i class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-all"></i>
                </a>
                <a href="#contact" class="mobile-nav-link group flex items-center justify-between text-[0.75rem] font-black text-slate-400 uppercase tracking-[0.2em] no-underline py-5 border-b border-white/5 hover:text-white transition-all">
                    <span>Contact Support</span>
                    <i class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-all"></i>
                </a>
                <a href="{{ route('careers') }}" class="mobile-nav-link group flex items-center justify-between text-[0.75rem] font-black text-slate-400 uppercase tracking-[0.2em] no-underline py-5 border-b border-white/5 hover:text-white transition-all">
                    <span>Careers</span>
                    <i class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-all"></i>
                </a>
            </div>

            <div class="mt-auto pt-10">
                @auth
                    <div class="flex flex-col gap-4">
                        <a href="{{ url('/dashboard') }}" class="text-slate-400 border border-white/10 px-5 py-4 rounded-md text-[0.75rem] font-black text-center uppercase tracking-[0.2em] no-underline hover:text-white hover:border-blue transition-all">DASHBOARD</a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="bg-blue text-navy font-black px-5 py-4 rounded-md text-[0.75rem] text-center w-full uppercase tracking-[0.2em] hover:bg-white transition-colors">LOGOUT</button>
                        </form>
                    </div>
                @else
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('login') }}" class="text-slate-400 border border-white/10 px-5 py-4 rounded-md text-[0.75rem] font-black text-center uppercase tracking-[0.2em] no-underline hover:text-white hover:border-blue transition-all">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue text-navy font-black px-5 py-4 rounded-md text-[0.75rem] text-center w-full uppercase tracking-[0.2em] no-underline shadow-[0_0_20px_rgba(180,180,254,0.3)] hover:scale-[1.02] transition-all">JOIN AS PROFESSIONAL</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>


    <div class="pt-[75px]">
        @yield('content')
    </div>

    <!-- 3. Footer (Global Bottom) -->
    <footer class="bg-navy border-t border-white/5 pt-24">
        <div class="max-w-[1500px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 mb-20 items-center">
                <div>
                    <div class="flex items-center gap-6 mb-8">
                        <span class="font-black text-5xl text-white tracking-tighter uppercase italic">DockIt</span>
                        <span class="w-px h-8 bg-white/10"></span>
                        <span class="text-xl font-bold text-slate-400 uppercase tracking-[0.3em]">Menu</span>
                    </div>
                    <p class="text-slate-500 text-lg max-w-xl leading-relaxed">
                        A platform that gives instant access to procedural support - clerks, filing agents, on-ground
                        help across courts and tribunals in India.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">
                            Sections</h4>
                        <ul class="space-y-4 list-none p-0 text-slate-500 text-sm font-bold uppercase tracking-widest">
                            <li><a href="{{ url('/') }}" class="hover:text-blue hover:pl-2 transition-all no-underline">Home</a>
                            </li>
                            <li><a href="#how-it-works" class="hover:text-blue hover:pl-2 transition-all no-underline">How it
                                    works</a></li>
                            <li><a href="{{ route('find') }}"
                                    class="hover:text-blue hover:pl-2 transition-all no-underline">Search</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">
                            Updates</h4>
                        <ul class="space-y-4 list-none p-0 text-slate-500 text-sm font-bold uppercase tracking-widest">
                            <li><a href="{{ route('updates') }}"
                                    class="hover:text-blue hover:pl-2 transition-all no-underline">Updates</a></li>
                            <li><a href="{{ route('blogs') }}"
                                    class="hover:text-blue hover:pl-2 transition-all no-underline">Blogs</a></li>
                            <li><a href="#contact" class="hover:text-blue hover:pl-2 transition-all no-underline">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Marquee -->
            <div class="border-y border-white/5 py-4 overflow-hidden bg-white/2">
                <div class="marquee-container" style="background: transparent;">
                    <div class="marquee-content animate-marquee">
                        <span
                            class="mx-12 text-[0.65rem] font-black text-blue uppercase tracking-[0.4em] italic">NEWS</span>
                        <span
                            class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court
                            / Tribunal Updates</span>
                        <span
                            class="mx-12 text-[0.65rem] font-black text-blue uppercase tracking-[0.4em] italic">NEWS</span>
                        <span
                            class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court
                            / Tribunal Updates</span>
                        <!-- Duplicate for seamless scroll -->
                        <span
                            class="mx-12 text-[0.65rem] font-black text-blue uppercase tracking-[0.4em] italic">NEWS</span>
                        <span
                            class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court
                            / Tribunal Updates</span>
                        <span
                            class="mx-12 text-[0.65rem] font-black text-blue uppercase tracking-[0.4em] italic">NEWS</span>
                        <span
                            class="mx-12 text-[0.65rem] font-black text-white px-2 py-1 border border-white/10 uppercase tracking-[0.4em]">Court
                            / Tribunal Updates</span>
                    </div>
                </div>
            </div>

            <!-- Find & Login Lists (Point 7) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 py-12 border-b border-white/5">
                <div>
                    <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">Find
                    </h4>
                    <div
                        class="flex flex-wrap gap-x-8 gap-y-4 text-slate-500 text-[0.65rem] font-black uppercase tracking-widest">
                        <a href="#" class="hover:text-blue hover:scale-110 transition-all no-underline">Court Clerks</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-blue hover:scale-110 transition-all no-underline">IP Clerks</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-blue hover:scale-110 transition-all no-underline">RoC Agents</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-blue hover:scale-110 transition-all no-underline">Advocates</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-[0.6rem] font-black uppercase tracking-[0.25em] mb-6 opacity-40">Login
                    </h4>
                    <div
                        class="flex flex-wrap gap-x-8 gap-y-4 text-slate-500 text-[0.65rem] font-black uppercase tracking-widest">
                        <a href="#" class="hover:text-blue transition no-underline">Professionals</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-blue transition no-underline">Guest</a>
                        <span class="opacity-20">|</span>
                        <a href="#" class="hover:text-blue transition no-underline">Support</a>
                    </div>
                </div>
            </div>

            <div class="py-12 flex flex-col md:flex-row justify-between items-center gap-6">
                <span class="text-slate-600 text-[0.6rem] font-bold uppercase tracking-[0.3em]">&copy; {{ date('Y') }}
                    DOCKIT NETWORK. EVERY SECOND COVERED.</span>
                <div class="flex gap-8 text-slate-500 text-sm">
                    <a href="#" class="hover:text-white transition"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DockIt Navigation Initialized');

            // 1. Navbar scroll effect
            const navbar = document.getElementById('navbar');
            const handleScroll = () => {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            };
            window.addEventListener('scroll', handleScroll);
            handleScroll(); // Initial check

            // 2. Mobile Menu Logic
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileClose = document.getElementById('mobile-close');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const body = document.body;

            if (!mobileToggle || !mobileMenu || !menuOverlay) {
                console.warn('Mobile menu elements not found:', { mobileToggle, mobileMenu, menuOverlay });
                return;
            }

            const openMenu = (e) => {
                if (e) e.preventDefault();
                console.log('Menu Opening triggered');

                // Toggle classes for animation
                mobileMenu.classList.add('active');
                mobileMenu.classList.remove('translate-x-full');
                mobileMenu.classList.add('translate-x-0');

                menuOverlay.classList.remove('pointer-events-none');
                menuOverlay.classList.add('opacity-100');

                body.classList.add('mobile-menu-open');
                body.style.overflow = 'hidden';
            };

            const closeMenu = (e) => {
                if (e) e.preventDefault();
                console.log('Menu Closing triggered');

                mobileMenu.classList.remove('active');
                mobileMenu.classList.remove('translate-x-0');
                mobileMenu.classList.add('translate-x-full');

                menuOverlay.classList.add('pointer-events-none');
                menuOverlay.classList.remove('opacity-100');

                body.classList.remove('mobile-menu-open');
                body.style.overflow = '';
            };

            // Event Listeners
            mobileToggle.addEventListener('click', openMenu);
            // Click listener for the overlay
            menuOverlay.addEventListener('click', closeMenu);
            mobileClose.addEventListener('click', closeMenu);

            // Close on link click
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.addEventListener('click', closeMenu);
            });

            // 3. Intersection Observer for Scroll Animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (entry.target.classList.contains('reveal-left')) {
                            entry.target.classList.add('reveal-left-visible');
                        } else {
                            entry.target.classList.add('reveal-visible');
                        }
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal, .reveal-left').forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>
