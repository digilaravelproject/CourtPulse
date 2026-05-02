<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="India's Premier Legal Professional Network. Connect with Court Clerks, IP Agents, and Advocates instantly.">
    <meta name="theme-color" content="#050812">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CourtPulse') — India's Legal Professional Network</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        .nav-scrolled {
            background-color: rgba(5, 8, 18, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }

        /* Mobile Menu Prevent Scroll Class */
        .no-scroll {
            overflow: hidden;
            height: 100vh;
        }
    </style>
</head>

<body
    class="antialiased bg-navy text-slate-300 overflow-x-hidden min-h-screen flex flex-col selection:bg-blue selection:text-navy">

    <!-- 1. HEADER & NAVIGATION -->
    <header id="navbar"
        class="fixed top-0 left-0 right-0 z-[2000] py-4 border-b border-transparent transition-all duration-300 ease-in-out">
        <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group no-underline" aria-label="Homepage">
                <div
                    class="w-10 h-10 rounded-xl bg-blue flex items-center justify-center text-sm text-navy font-black transition-transform duration-300 group-hover:scale-105 shadow-[0_0_15px_rgba(180,180,254,0.3)] group-hover:shadow-[0_0_25px_rgba(180,180,254,0.5)]">
                    CP
                </div>
                <span
                    class="text-white font-black tracking-tight text-xl sm:text-2xl uppercase transition-colors duration-300 group-hover:text-blue">
                    CourtPulse
                </span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-8" aria-label="Main Navigation">
                <a href="{{ url('/') }}"
                    class="text-xs font-bold text-slate-400 hover:text-white transition-colors no-underline tracking-[0.15em] uppercase hover:shadow-[0_2px_0_0_#B4B4FE] pb-1">Home</a>
                <a href="{{ url('/#how-it-works') }}"
                    class="text-xs font-bold text-slate-400 hover:text-white transition-colors no-underline tracking-[0.15em] uppercase hover:shadow-[0_2px_0_0_#B4B4FE] pb-1">How
                    it works</a>
                <a href="{{ route('find') }}"
                    class="text-xs font-bold text-slate-400 hover:text-white transition-colors no-underline tracking-[0.15em] uppercase hover:shadow-[0_2px_0_0_#B4B4FE] pb-1">Search</a>
                <a href="{{ route('blogs') }}"
                    class="text-xs font-bold text-slate-400 hover:text-white transition-colors no-underline tracking-[0.15em] uppercase hover:shadow-[0_2px_0_0_#B4B4FE] pb-1">Blogs</a>
                <a href="{{ route('updates') }}"
                    class="text-xs font-bold text-slate-400 hover:text-white transition-colors no-underline tracking-[0.15em] uppercase hover:shadow-[0_2px_0_0_#B4B4FE] pb-1">Updates</a>
            </nav>

            <!-- Auth Buttons & Mobile Toggle -->
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-white border border-white/20 bg-white/5 px-5 py-2.5 rounded-lg text-xs font-black transition-all duration-300 hover:bg-white/10 hover:border-white/40 no-underline uppercase tracking-widest">
                            <i class="bi bi-grid-1x2-fill mr-2"></i> Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="text-slate-400 hover:text-white px-3 py-2.5 text-xs font-bold transition-colors uppercase tracking-widest flex items-center gap-2">
                                Logout <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-slate-300 hover:text-white transition-colors no-underline uppercase text-xs font-bold tracking-widest px-2">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue text-navy font-black px-6 py-3 rounded-xl transition-all duration-300 uppercase text-xs tracking-widest hover:bg-white hover:-translate-y-0.5 hover:shadow-[0_10px_20px_rgba(180,180,254,0.3)] no-underline flex items-center gap-2">
                            Join Network <i class="bi bi-arrow-right"></i>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button id="mobile-toggle" type="button"
                    class="lg:hidden text-slate-300 hover:text-white text-2xl p-2 transition-colors flex items-center justify-center rounded-lg hover:bg-white/5 focus:outline-none"
                    aria-label="Toggle Mobile Menu" aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- 2. MOBILE NAVIGATION DRAWER -->
    <div id="menu-overlay"
        class="fixed inset-0 bg-navy/80 backdrop-blur-sm z-[2500] opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
        aria-hidden="true"></div>

    <aside id="mobile-menu"
        class="fixed top-0 right-0 bottom-0 w-full sm:w-[350px] z-[3000] translate-x-full lg:hidden bg-navy2 border-l border-white/5 transition-transform duration-300 ease-out overflow-y-auto flex flex-col shadow-2xl">
        <div class="flex-1 px-6 py-8 flex flex-col">
            <!-- Mobile Header -->
            <div class="flex justify-between items-center mb-10">
                <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                    <div
                        class="w-8 h-8 rounded-lg bg-blue flex items-center justify-center text-xs text-navy font-black">
                        CP</div>
                    <span class="text-white font-black tracking-tight text-xl uppercase">CourtPulse</span>
                </a>
                <button id="mobile-close"
                    class="text-slate-400 hover:text-white text-2xl p-2 transition-colors focus:outline-none"
                    aria-label="Close Menu">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Mobile Links -->
            <nav class="flex flex-col gap-2" aria-label="Mobile Navigation">
                <a href="{{ url('/') }}"
                    class="mobile-nav-link group flex items-center justify-between text-sm font-bold text-slate-300 uppercase tracking-widest no-underline p-4 rounded-xl hover:bg-white/5 hover:text-white transition-all">
                    <span><i class="bi bi-house mr-3 opacity-50"></i> Home</span>
                    <i
                        class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-opacity text-blue"></i>
                </a>
                <a href="{{ url('/#how-it-works') }}"
                    class="mobile-nav-link group flex items-center justify-between text-sm font-bold text-slate-300 uppercase tracking-widest no-underline p-4 rounded-xl hover:bg-white/5 hover:text-white transition-all">
                    <span><i class="bi bi-info-circle mr-3 opacity-50"></i> How it works</span>
                    <i
                        class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-opacity text-blue"></i>
                </a>
                <a href="{{ route('find') }}"
                    class="mobile-nav-link group flex items-center justify-between text-sm font-bold text-slate-300 uppercase tracking-widest no-underline p-4 rounded-xl hover:bg-white/5 hover:text-white transition-all">
                    <span><i class="bi bi-search mr-3 opacity-50"></i> Search</span>
                    <i
                        class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-opacity text-blue"></i>
                </a>
                <a href="{{ route('blogs') }}"
                    class="mobile-nav-link group flex items-center justify-between text-sm font-bold text-slate-300 uppercase tracking-widest no-underline p-4 rounded-xl hover:bg-white/5 hover:text-white transition-all">
                    <span><i class="bi bi-journal-text mr-3 opacity-50"></i> Legal Blogs</span>
                    <i
                        class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-opacity text-blue"></i>
                </a>
                <a href="{{ route('updates') }}"
                    class="mobile-nav-link group flex items-center justify-between text-sm font-bold text-slate-300 uppercase tracking-widest no-underline p-4 rounded-xl hover:bg-white/5 hover:text-white transition-all">
                    <span><i class="bi bi-bell mr-3 opacity-50"></i> Latest Updates</span>
                    <i
                        class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-opacity text-blue"></i>
                </a>
                <a href="{{ url('/contact-us') }}"
                    class="mobile-nav-link group flex items-center justify-between text-sm font-bold text-slate-300 uppercase tracking-widest no-underline p-4 rounded-xl hover:bg-white/5 hover:text-white transition-all">
                    <span><i class="bi bi-envelope mr-3 opacity-50"></i> Contact Us</span>
                    <i
                        class="bi bi-chevron-right text-[0.6rem] opacity-0 group-hover:opacity-100 transition-opacity text-blue"></i>
                </a>
            </nav>

            <!-- Mobile Auth Footer -->
            <div class="mt-auto pt-8 border-t border-white/5">
                @auth
                    <div class="flex flex-col gap-3">
                        <a href="{{ url('/dashboard') }}"
                            class="text-white bg-white/5 border border-white/10 px-5 py-4 rounded-xl text-xs font-black text-center uppercase tracking-widest no-underline hover:bg-white/10 transition-colors">
                            <i class="bi bi-grid-1x2-fill mr-2"></i> Go To Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="w-full text-slate-400 bg-transparent border border-transparent px-5 py-4 rounded-xl text-xs font-bold text-center uppercase tracking-widest hover:text-white hover:bg-white/5 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('login') }}"
                            class="text-white border border-white/20 bg-transparent px-5 py-4 rounded-xl text-xs font-black text-center uppercase tracking-widest no-underline hover:bg-white/5 transition-colors">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-blue text-navy font-black px-5 py-4 rounded-xl text-xs text-center uppercase tracking-widest no-underline shadow-[0_5px_15px_rgba(180,180,254,0.2)] hover:bg-white transition-colors">
                            Join Network
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </aside>

    <!-- 3. MAIN CONTENT -->
    <main class="flex-grow pt-[72px]">
        @yield('content')
    </main>

    <!-- 4. FOOTER -->
    <footer class="bg-navy border-t border-white/5 pt-16 mt-auto">
        <!-- Trust & Highlights Bar (Replaces Marquee) -->
        <div class="max-w-[1500px] mx-auto px-6 mb-16">
            <div
                class="bg-navy2 border border-white/5 rounded-2xl p-6 md:p-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-6 shadow-lg">
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-10 h-10 rounded-full bg-blue/10 flex items-center justify-center text-blue"><i
                            class="bi bi-shield-check text-xl"></i></div>
                    <div>
                        <span class="block text-xs font-black uppercase tracking-widest text-white">Verified
                            Users</span>
                        <span class="text-[10px] uppercase tracking-wider opacity-60">100% Authentic Network</span>
                    </div>
                </div>
                <div class="hidden md:block w-px h-10 bg-white/10"></div>
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-10 h-10 rounded-full bg-blue/10 flex items-center justify-center text-blue"><i
                            class="bi bi-globe-central-south-asia text-xl"></i></div>
                    <div>
                        <span class="block text-xs font-black uppercase tracking-widest text-white">All India
                            Coverage</span>
                        <span class="text-[10px] uppercase tracking-wider opacity-60">Every District Handled</span>
                    </div>
                </div>
                <div class="hidden md:block w-px h-10 bg-white/10"></div>
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-10 h-10 rounded-full bg-blue/10 flex items-center justify-center text-blue"><i
                            class="bi bi-lightning-charge text-xl"></i></div>
                    <div>
                        <span class="block text-xs font-black uppercase tracking-widest text-white">Real-time
                            Updates</span>
                        <span class="text-[10px] uppercase tracking-wider opacity-60">Instant Court Status</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Main Content -->
        <div class="max-w-[1500px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-8 mb-16">

                <!-- Brand Col -->
                <div class="md:col-span-12 lg:col-span-5 pr-0 lg:pr-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue flex items-center justify-center text-xs text-navy font-black">
                            CP</div>
                        <span class="font-black text-2xl text-white tracking-tight uppercase">CourtPulse</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8 max-w-md font-medium">
                        India's premier digital platform connecting legal professionals. Gain instant access to
                        procedural support, verified court clerks, filing agents, and on-ground help across all courts
                        and tribunals.
                    </p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-blue hover:text-navy hover:border-transparent transition-all"><i
                                class="bi bi-linkedin"></i></a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-blue hover:text-navy hover:border-transparent transition-all"><i
                                class="bi bi-twitter-x"></i></a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-blue hover:text-navy hover:border-transparent transition-all"><i
                                class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <!-- Links Col 1 -->
                <div class="md:col-span-4 lg:col-span-2">
                    <h4
                        class="text-white text-xs font-black uppercase tracking-widest mb-6 border-b border-white/10 pb-4 inline-block pr-8">
                        Platform</h4>
                    <ul class="space-y-4 list-none p-0 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <li><a href="{{ url('/') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">Home</a>
                        </li>
                        <li><a href="{{ url('/#how-it-works') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">How
                                it works</a></li>
                        <li><a href="{{ route('find') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">Search
                                Support</a></li>
                        <li><a href="{{ route('register') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">Join
                                Network</a></li>
                    </ul>
                </div>

                <!-- Links Col 2 -->
                <div class="md:col-span-4 lg:col-span-2">
                    <h4
                        class="text-white text-xs font-black uppercase tracking-widest mb-6 border-b border-white/10 pb-4 inline-block pr-8">
                        Resources</h4>
                    <ul class="space-y-4 list-none p-0 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <li><a href="{{ route('updates') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">Court
                                Updates</a></li>
                        <li><a href="{{ route('blogs') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">Legal
                                Blogs</a></li>
                        <li><a href="{{ url('/contact-us') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">Contact
                                Us</a></li>
                        <li><a href="{{ route('careers') }}"
                                class="hover:text-white hover:translate-x-1 inline-block transition-transform no-underline">Careers</a>
                        </li>
                    </ul>
                </div>

                <!-- Links Col 3 -->
                <div class="md:col-span-4 lg:col-span-3">
                    <h4
                        class="text-white text-xs font-black uppercase tracking-widest mb-6 border-b border-white/10 pb-4 inline-block pr-8">
                        Network</h4>
                    <div class="flex flex-col gap-3 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <a href="{{ route('find') }}"
                            class="hover:text-blue transition-colors no-underline py-1">Verified Court Clerks</a>
                        <a href="{{ route('find') }}" class="hover:text-blue transition-colors no-underline py-1">IP
                            Agents & Clerks</a>
                        <a href="{{ route('find') }}" class="hover:text-blue transition-colors no-underline py-1">RoC
                            Filing Agents</a>
                        <a href="{{ route('find') }}" class="hover:text-blue transition-colors no-underline py-1">
                            Advocates</a>
                    </div>
                </div>

            </div>

            <!-- Copyright Bar -->
            <div
                class="py-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                <span class="text-slate-500 text-[10px] sm:text-xs font-black uppercase tracking-widest">
                    &copy; {{ date('Y') }} CourtPulse Network. All Rights Reserved.
                </span>
                <div
                    class="flex items-center gap-6 text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest">
                    <a href="#" class="hover:text-white transition-colors no-underline">Privacy Policy</a>
                    <span class="w-1 h-1 bg-white/20 rounded-full"></span>
                    <a href="#" class="hover:text-white transition-colors no-underline">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 5. SCRIPTS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // --- 1. Navbar Scroll Effect ---
            const navbar = document.getElementById('navbar');
            const handleScroll = () => {
                if (window.scrollY > 20) {
                    navbar.classList.add('nav-scrolled');
                } else {
                    navbar.classList.remove('nav-scrolled');
                }
            };
            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();

            // --- 2. Mobile Menu Logic (Robust & No Race Conditions) ---
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileClose = document.getElementById('mobile-close');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const mobileLinks = document.querySelectorAll('.mobile-nav-link');

            let isMenuOpen = false;

            const toggleMenu = (forceState = null) => {
                const newState = forceState !== null ? forceState : !isMenuOpen;
                if (isMenuOpen === newState) return; // Prevent redundant calls

                isMenuOpen = newState;
                mobileToggle.setAttribute('aria-expanded', String(isMenuOpen));

                if (isMenuOpen) {
                    // Open Menu
                    mobileMenu.classList.remove('translate-x-full');
                    mobileMenu.classList.add('translate-x-0');
                    menuOverlay.classList.remove('pointer-events-none', 'opacity-0');
                    menuOverlay.classList.add('opacity-100');
                    document.body.classList.add('no-scroll');
                } else {
                    // Close Menu
                    mobileMenu.classList.remove('translate-x-0');
                    mobileMenu.classList.add('translate-x-full');
                    menuOverlay.classList.remove('opacity-100');
                    menuOverlay.classList.add('pointer-events-none', 'opacity-0');
                    document.body.classList.remove('no-scroll');
                }
            };

            // Event Listeners for Mobile Menu
            if (mobileToggle) mobileToggle.addEventListener('click', () => toggleMenu(true));
            if (mobileClose) mobileClose.addEventListener('click', () => toggleMenu(false));
            if (menuOverlay) menuOverlay.addEventListener('click', () => toggleMenu(false));

            // Close menu when a link is clicked
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => toggleMenu(false));
            });

            // Fail-safe: Close menu if window is resized to desktop width
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024 && isMenuOpen) {
                    toggleMenu(false);
                }
            }, { passive: true });

            // --- 3. Intersection Observer for Scroll Animations ---
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
                        observer.unobserve(entry.target); // Only animate once
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal, .reveal-left').forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>