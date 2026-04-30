@extends('layouts.main')

@section('title', 'DockIt — India\'s Legal Professional Network')
@section('content')
    <!-- HERO SECTION -->
    <header class="relative pt-32 pb-24 overflow-hidden bg-navy group/hero">
        <!-- Premium Hero Background -->
        <div
            class="absolute inset-0 opacity-20 pointer-events-none scale-105 group-hover/hero:scale-110 transition-transform duration-[15000ms] ease-out">
            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80&w=1500"
                class="w-full h-full object-cover grayscale brightness-[0.2]" alt="Legal Tech Background">
        </div>

        <!-- Subtle Grid Overlay -->
        <div class="absolute inset-0 opacity-15 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="8" height="8" patternUnits="userSpaceOnUse">
                        <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.05" />
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>

        <div class="max-w-[1500px] mx-auto px-4 md:px-8 text-center relative z-10">
            <!-- Main Headline -->
            <h2
                class="text-4xl sm:text-5xl md:text-6xl lg:text-[5.5rem] font-black text-white leading-[1.05] tracking-tight mb-10 max-w-5xl mx-auto uppercase reveal-left visible drop-shadow-lg">
                A Platform That Gives Instant Access To <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-white to-blue">Procedural Support</span>
            </h2>

            <!-- Sub Headline -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-20 reveal stagger-1 visible">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2.5"
                    class="animate-bounce stroke-blue hidden sm:block">
                    <path d="M7 17L17 7M7 7H17V17" />
                </svg>
                <h3 class="text-base sm:text-lg md:text-xl font-bold text-blue uppercase tracking-[0.2em]">
                    Digitising The Last Mile Of Indian Law.
                </h3>
            </div>

            {{--
            <!-- High Contrast Hero Marquee (Commented out as requested for readability) -->
            <div class="border-y border-white/15 py-10 overflow-hidden bg-navy2 relative shadow-inner">
                <div class="absolute inset-y-0 left-0 w-24 bg-linear-to-r from-navy2 to-transparent z-10"></div>
                <div class="absolute inset-y-0 right-0 w-24 bg-linear-to-l from-navy2 to-transparent z-10"></div>

                <div class="marquee-container py-10 overflow-hidden whitespace-nowrap" style="background: transparent;">
                    <div class="animate-marquee inline-block">
                        <span class="inline-block px-12 text-blue text-[1.1rem] font-black tracking-normal">Every District
                            covered. Every Court handled.</span>
                        <span class="inline-block px-12 text-white text-[1.1rem] font-black tracking-normal">Delegate court
                            appearances & routine filings to verified professionals</span>
                        <span class="inline-block px-12 text-blue text-[1.1rem] font-black tracking-normal">Connect with
                            verified filing professionals across Tribunals & ROC offices.</span>
                        <span class="inline-block px-12 text-white text-[1.1rem] font-black tracking-normal">Ideas move
                            fast. Your filings should too.</span>
                    </div>
                </div>
            </div>
            --}}

            <!-- Modern Static Feature Grid (Replaces Marquee) -->
            <div
                class="border-y border-white/10 py-12 bg-white/[0.02] backdrop-blur-sm relative shadow-2xl rounded-2xl mx-auto max-w-6xl">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 px-6 md:px-10 text-center divide-y sm:divide-y-0 sm:divide-x divide-white/10">
                    <div class="pt-4 sm:pt-0 px-4 group">
                        <p
                            class="text-white text-base md:text-lg font-bold tracking-wide leading-relaxed group-hover:text-blue transition-colors duration-300">
                            Every District Covered.<br>Every Court Handled.
                        </p>
                    </div>
                    <div class="pt-4 sm:pt-0 px-4 group">
                        <p
                            class="text-white/80 text-base md:text-lg font-medium tracking-wide leading-relaxed group-hover:text-white transition-colors duration-300">
                            Delegate Court Appearances & Routine Filings To Verified Professionals.
                        </p>
                    </div>
                    <div class="pt-4 sm:pt-0 px-4 group">
                        <p
                            class="text-white text-base md:text-lg font-bold tracking-wide leading-relaxed group-hover:text-blue transition-colors duration-300">
                            Connect With Verified Filing Professionals Across Tribunals & ROC.
                        </p>
                    </div>
                    <div class="pt-4 sm:pt-0 px-4 group">
                        <p
                            class="text-white/80 text-base md:text-lg font-medium tracking-wide leading-relaxed group-hover:text-white transition-colors duration-300">
                            Ideas Move Fast.<br>Your Filings Should Too.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <!-- How It Works Section -->
    <section class="py-24 md:py-32 bg-navy2" id="how-it-works">
        <div class="max-w-[1500px] mx-auto px-4 md:px-8">
            <div class="mb-16 md:mb-24 reveal text-center md:text-left">
                <h2 class="text-white uppercase tracking-tighter text-3xl md:text-5xl font-black mb-6 leading-none">How It
                    Works.</h2>
                <div class="w-20 h-1.5 bg-blue mx-auto md:mx-0 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Card 1 -->
                <div
                    class="bg-navy border border-white/5 p-8 md:p-10 rounded-2xl transition-all duration-500 ease-out group reveal stagger-1 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue/10 hover:border-blue/30 cursor-pointer relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-blue/5 rounded-full blur-3xl -mr-10 -mt-10 transition-all duration-500 group-hover:bg-blue/10">
                    </div>
                    <div
                        class="w-16 h-16 bg-navy3 rounded-xl flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/40 group-hover:bg-blue/5 transition-all duration-300 shadow-lg">
                        <span class="text-2xl font-black text-blue group-hover:scale-110 transition-transform">01</span>
                    </div>
                    <h3
                        class="text-xl font-black text-white uppercase mb-4 tracking-tight group-hover:text-blue transition-colors">
                        Register & Verify</h3>
                    <p class="text-white/60 text-sm md:text-base leading-relaxed font-medium">Create your profile as an
                        Advocate, IP Agent, Chartered Accountant, Company Secretary, or Clerk.</p>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-navy border border-white/5 p-8 md:p-10 rounded-2xl transition-all duration-500 ease-out group reveal stagger-2 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue/10 hover:border-blue/30 cursor-pointer relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-blue/5 rounded-full blur-3xl -mr-10 -mt-10 transition-all duration-500 group-hover:bg-blue/10">
                    </div>
                    <div
                        class="w-16 h-16 bg-navy3 rounded-xl flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/40 group-hover:bg-blue/5 transition-all duration-300 shadow-lg">
                        <span class="text-2xl font-black text-blue group-hover:scale-110 transition-transform">02</span>
                    </div>
                    <h3
                        class="text-xl font-black text-white uppercase mb-4 tracking-tight group-hover:text-blue transition-colors">
                        Filter & Connect</h3>
                    <p class="text-white/60 text-sm md:text-base leading-relaxed font-medium">Search by City, Court, Domain
                        of Practice, Years of Experience, or Task Type. View past ratings before reaching out.</p>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-navy border border-white/5 p-8 md:p-10 rounded-2xl transition-all duration-500 ease-out group reveal stagger-3 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue/10 hover:border-blue/30 cursor-pointer relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-blue/5 rounded-full blur-3xl -mr-10 -mt-10 transition-all duration-500 group-hover:bg-blue/10">
                    </div>
                    <div
                        class="w-16 h-16 bg-navy3 rounded-xl flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/40 group-hover:bg-blue/5 transition-all duration-300 shadow-lg">
                        <span class="text-2xl font-black text-blue group-hover:scale-110 transition-transform">03</span>
                    </div>
                    <h3
                        class="text-xl font-black text-white uppercase mb-4 tracking-tight group-hover:text-blue transition-colors">
                        Delegate & Track</h3>
                    <p class="text-white/60 text-sm md:text-base leading-relaxed font-medium">Assign tasks — Appearances,
                        Adjournments, or filing Vakalatnama. Track court status live and receive WhatsApp updates.</p>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-navy border border-white/5 p-8 md:p-10 rounded-2xl transition-all duration-500 ease-out group reveal stagger-4 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue/10 hover:border-blue/30 cursor-pointer relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-blue/5 rounded-full blur-3xl -mr-10 -mt-10 transition-all duration-500 group-hover:bg-blue/10">
                    </div>
                    <div
                        class="w-16 h-16 bg-navy3 rounded-xl flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/40 group-hover:bg-blue/5 transition-all duration-300 shadow-lg">
                        <span class="text-2xl font-black text-blue group-hover:scale-110 transition-transform">04</span>
                    </div>
                    <h3
                        class="text-xl font-black text-white uppercase mb-4 tracking-tight group-hover:text-blue transition-colors">
                        Provide Feedback</h3>
                    <p class="text-white/60 text-sm md:text-base leading-relaxed font-medium">Rate the professionalism and
                        quality of service provided by the network to maintain excellence.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Updates & Maps Section -->
    <section class="py-24 md:py-32 bg-navy relative" id="updates">
        <!-- Subtle Background Glow -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl h-96 bg-blue/5 blur-[120px] pointer-events-none">
        </div>

        <div class="max-w-[1500px] mx-auto px-4 md:px-8 relative z-10">
            <h2
                class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tighter max-w-4xl leading-[1.1] mb-16 md:mb-20 reveal-left">
                Latest Court Updates.
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 pt-12 border-t border-white/10">
                <!-- Left Column: Maps -->
                <div
                    class="bg-navy2 p-8 md:p-14 rounded-3xl border border-white/5 relative overflow-hidden group hover:border-white/10 transition-all duration-500 shadow-xl">
                    <div class="absolute inset-0 opacity-10 group-hover:opacity-20 transition-opacity duration-700">
                        <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&q=80&w=1000"
                            class="w-full h-full object-cover grayscale mix-blend-overlay" alt="Map Overlay">
                    </div>
                    <div class="relative z-10 space-y-8">
                        <div
                            class="inline-flex items-center gap-3 bg-white/5 px-4 py-2 rounded-full border border-white/10">
                            <span class="w-2 h-2 rounded-full bg-blue animate-pulse"></span>
                            <span class="text-blue text-xs font-black uppercase tracking-[0.2em]">Court / Tribunal
                                Maps</span>
                        </div>

                        <h3 class="text-3xl md:text-4xl font-black text-white uppercase leading-tight tracking-tight">
                            <span class="block mb-2">Locate Court Rooms.</span>
                            <span class="block mb-2">Every Court. Mapped.</span>
                            <span class="block text-blue/90">Before You Arrive.</span>
                        </h3>

                        <p
                            class="text-white/60 text-sm md:text-base uppercase tracking-[0.15em] font-bold max-w-md leading-relaxed">
                            Because you have to start before the gate, not after it.
                        </p>

                        <a href="#"
                            class="bg-blue text-navy font-black px-6 md:px-8 py-4 rounded-xl transition-all duration-300 uppercase text-xs tracking-widest hover:bg-white hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(59,130,246,0.3)] no-underline inline-flex items-center gap-4 mt-4 w-full sm:w-auto justify-center">
                            Find Court Maps
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Updates -->
                <div
                    class="bg-navy2 p-8 md:p-14 rounded-3xl border border-white/5 relative overflow-hidden group hover:border-white/10 transition-all duration-500 shadow-xl">
                    <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-blue/50 to-transparent"></div>
                    <div class="space-y-8">
                        <div
                            class="inline-flex items-center gap-3 bg-white/5 px-4 py-2 rounded-full border border-white/10">
                            <span class="text-blue text-xs font-black uppercase tracking-[0.2em]">Latest Updates &
                                News</span>
                        </div>

                        <h3 class="text-3xl md:text-4xl font-black text-white uppercase leading-tight tracking-tight">
                            <span class="block mb-2">Every Notice.</span>
                            <span class="block mb-2">Every Circular.</span>
                            <span class="block text-blue/90">One Place.</span>
                        </h3>

                        <p class="text-white/60 text-sm md:text-base leading-relaxed font-medium max-w-md">
                            Live Court Notices, Tribunal Circulars, and procedural updates — curated daily for
                            professionals.
                        </p>

                        <a href="#"
                            class="text-white border border-white/20 px-6 md:px-8 py-4 rounded-xl text-xs font-black transition-all duration-300 hover:bg-white/10 hover:border-white/40 no-underline uppercase tracking-widest inline-flex items-center gap-4 mt-4 w-full sm:w-auto justify-center">
                            Find Notices & Circulars
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Signup Banner -->
            <div
                class="mt-16 md:mt-24 flex flex-col lg:flex-row items-center justify-between gap-8 bg-gradient-to-r from-blue to-blue/90 p-8 md:p-10 rounded-3xl shadow-[0_20px_50px_rgba(59,130,246,0.2)] border border-white/20 reveal relative overflow-hidden">
                <!-- Background Decoration -->
                <svg class="absolute right-0 top-0 w-64 h-64 text-white opacity-10 -translate-y-1/2 translate-x-1/3"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
                </svg>

                <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
                    <span class="text-navy font-black text-xl md:text-2xl uppercase tracking-tighter block mb-2">Sign Up For
                        WhatsApp Updates</span>
                    <span class="text-navy/80 font-bold text-sm">Get real-time court statuses and notifications directly to
                        your phone.</span>
                </div>

                <div
                    class="flex flex-col sm:flex-row w-full lg:w-auto relative z-10 shadow-lg rounded-xl overflow-hidden border border-navy/10">
                    <input type="tel" placeholder="Enter Mobile Number"
                        class="bg-white px-6 py-4 placeholder-navy/40 text-navy focus:outline-none focus:ring-0 text-sm font-bold w-full sm:w-72 border-none">
                    <button
                        class="bg-navy text-white px-8 py-4 font-black text-xs uppercase tracking-widest hover:bg-black transition-colors w-full sm:w-auto">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="py-24 md:py-32 bg-navy2" id="contact">
        <div class="max-w-[1500px] mx-auto px-4 md:px-8">
            <div class="mb-16 md:mb-24 reveal text-center md:text-left">
                <h2 class="text-white uppercase tracking-tighter text-3xl md:text-5xl font-black mb-6 leading-none">Contact
                    Us.</h2>
                <div class="w-20 h-1.5 bg-blue mx-auto md:mx-0 rounded-full"></div>
            </div>

            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-0 bg-navy border border-white/10 rounded-3xl overflow-hidden reveal shadow-2xl">
                <!-- Left Details -->
                <div class="p-8 md:p-16 lg:p-20 space-y-12 bg-navy/50 relative">
                    <div class="relative h-64 md:h-80 mb-12 rounded-2xl overflow-hidden border border-white/5">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1000"
                            class="w-full h-full object-cover grayscale opacity-40 mix-blend-luminosity hover:opacity-60 hover:scale-105 transition-all duration-700"
                            alt="DockIt Office HQ">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy to-transparent opacity-60"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div>
                            <h3 class="text-xs font-black text-blue uppercase tracking-[0.2em] mb-3">Headquarters</h3>
                            <p class="text-xl md:text-2xl font-black text-white uppercase tracking-tight leading-tight">
                                Complete Address<br>To Be Provided Here.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-blue uppercase tracking-[0.2em] mb-3">Direct Line</h3>
                            <p class="text-xl md:text-2xl font-black text-white uppercase tracking-tight leading-tight">
                                +91 00000 00000<br>
                                <span class="text-white/50 text-sm tracking-normal font-medium mt-1 block">Mon - Fri, 9AM -
                                    6PM</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Details -->
                <div
                    class="p-8 md:p-16 lg:p-20 flex flex-col justify-center bg-navy border-t lg:border-t-0 lg:border-l border-white/10">
                    <div>
                        <h3 class="text-xs font-black text-blue uppercase tracking-[0.2em] mb-6">General Inquiries</h3>
                        <div class="space-y-6">
                            <p
                                class="text-2xl md:text-4xl font-black text-white uppercase tracking-tight leading-tight break-words">
                                support@dockit.in<br>
                                info@dockit.in
                            </p>
                            <p class="text-white/60 text-base max-w-md leading-relaxed font-medium">
                                Our support channel is monitored 24/7 for critical procedural inquiries and professional
                                onboarding assistance across India.
                            </p>
                        </div>
                    </div>

                    <div class="mt-16 md:mt-24 pt-10 border-t border-white/10 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-white/40 text-xs font-black uppercase tracking-[0.2em] leading-relaxed">
                            DockIt Operations Network<br>Grounded In Excellence
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection