@extends('layouts.main')

@section('title', 'DockIt — India\'s Legal Professional Network')
@section('content')
    <!-- HERO SECTION -->
    <header class="relative pt-32 pb-20 overflow-hidden bg-navy group/hero">
        <!-- Premium Hero Background -->
        <div class="absolute inset-0 opacity-20 pointer-events-none scale-105 group-hover/hero:scale-110 transition-transform duration-[10000ms] ease-linear">
            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80&w=1500"
                class="w-full h-full object-cover grayscale brightness-[0.3]" alt="Legal Tech Background">
        </div>

        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.1" />
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>

        <div class="max-w-[1500px] mx-auto px-6 text-center relative z-10">
            <h2
                class="text-5xl md:text-[5.5rem] font-black text-white leading-[0.95] tracking-tighter mb-8 max-w-5xl mx-auto uppercase reveal-left visible">
                A PLATFORM THAT GIVES INSTANT ACCESS TO PROCEDURAL SUPPORT
            </h2>

            <div class="flex items-center justify-center gap-4 mb-16 reveal stagger-1 visible">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5" class="float">
                    <path d="M7 17L17 7M7 7H17V17" />
                </svg>
                <h3 class="text-lg md:text-xl font-bold text-[#B4B4FE] uppercase tracking-[0.25em]">
                    Digitising the last mile of Indian law.
                </h3>
            </div>

            <!-- High Contrast Hero Marquee -->
            <div class="border-y border-white/15 py-10 overflow-hidden bg-[#0a0f1d] relative shadow-inner">
                <div class="absolute inset-y-0 left-0 w-24 bg-linear-to-r from-[#0a0f1d] to-transparent z-10"></div>
                <div class="absolute inset-y-0 right-0 w-24 bg-linear-to-l from-[#0a0f1d] to-transparent z-10"></div>

                <div class="marquee-container" style="background: transparent;">
                    <div class="marquee-content" style="animation: marquee 40s linear infinite;">
                        <span class="marquee-item text-[#B4B4FE]! text-[1.1rem]! font-black! tracking-normal!">Every Dt.
                            covered. Every court handled.</span>
                        <span class="marquee-item text-white! text-[1.1rem]! font-black! tracking-normal!">Delegate court
                            Appearances & routine filings to verified professionals</span>
                        <span class="marquee-item text-[#B4B4FE]! text-[1.1rem]! font-black! tracking-normal!">Connect with
                            verified filing professionals accross Tribunals & ROC offices.</span>
                        <span class="marquee-item text-white! text-[1.1rem]! font-black! tracking-normal!">Ideas move fast.
                            Your filings should too.</span>
                        <!-- Duplicate for seamless scroll -->
                        <span class="marquee-item text-[#B4B4FE]! text-[1.1rem]! font-black! tracking-normal!">Every Dt.
                            covered. Every court handled.</span>
                        <span class="marquee-item text-white! text-[1.1rem]! font-black! tracking-normal!">Delegate court
                            Appearances & routine filings to verified professionals</span>
                        <span class="marquee-item text-[#B4B4FE]! text-[1.1rem]! font-black! tracking-normal!">Connect with
                            verified filing professionals accross Tribunals & ROC offices.</span>
                        <span class="marquee-item text-white! text-[1.1rem]! font-black! tracking-normal!">Ideas move fast.
                            Your filings should too.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- How it works Section -->
    <section class="py-32 bg-navy2" id="how-it-works">
        <div class="max-w-[1500px] mx-auto px-6">
            <div class="mb-16 reveal">
                <h2 class="section-head text-white uppercase tracking-tighter text-4xl mb-4">How it works.</h2>
                <div class="head-line"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div
                    class="bg-card border border-white/5 p-10 rounded-xl hover:border-blue-glow transition-all duration-500 group reveal stagger-1 hover-lift">
                    <div
                        class="w-14 h-14 bg-navy3 rounded-lg flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/30">
                        <svg class="w-8 h-8 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase mb-4 tracking-tight">Register & verify</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Create your profile as an Adv, IP Agent, CA, or CS or
                        clerk</p>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-card border border-white/5 p-10 rounded-xl hover:border-blue-glow transition-all duration-500 group reveal stagger-2 hover-lift">
                    <div
                        class="w-14 h-14 bg-navy3 rounded-lg flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/30">
                        <svg class="w-8 h-8 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase mb-4 tracking-tight">Filter & Connect</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Search by City, court, Domain of Practice, Years of
                        Experience, or Task Type. See Past feedback before you reach out.</p>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-card border border-white/5 p-10 rounded-xl hover:border-blue-glow transition-all duration-500 group reveal stagger-3 hover-lift">
                    <div
                        class="w-14 h-14 bg-navy3 rounded-lg flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/30">
                        <svg class="w-8 h-8 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase mb-4 tracking-tight">Delegate & Track</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Assign Tasks - Appearance, Adjournments, filing VP,
                        Track a court live and Get WA updates when job is done.</p>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-card border border-white/5 p-10 rounded-xl hover:border-blue-glow transition-all duration-500 group reveal stagger-4 hover-lift">
                    <div
                        class="w-14 h-14 bg-navy3 rounded-lg flex items-center justify-center mb-8 border border-white/10 group-hover:border-blue/30">
                        <svg class="w-8 h-8 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase mb-4 tracking-tight">Feedback.</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Updates & Maps Section -->
    <section class="py-32 bg-navy" id="updates">
        <div class="max-w-[1500px] mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter max-w-4xl leading-[1.1] mb-20 reveal-left">
                Court Latest Updates. Know the update before you arrive. <span class="text-blue">/ walk in Ready</span>
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 pt-16 border-t border-white/5">
                <!-- Left Column: Maps -->
                <div class="bg-card p-12 rounded-2xl border border-white/5 relative overflow-hidden group">
                    <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity">
                        <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&q=80&w=1000"
                            class="w-full h-full object-cover grayscale" alt="Map Overlay">
                    </div>
                    <div class="relative z-10 space-y-6">
                        <span class="text-blue text-xs font-black uppercase tracking-[0.3em]">COURT / TRIBUNAL MAPS</span>
                        <h3 class="text-3xl font-black text-white uppercase leading-tight">Locate Court Rooms. Every Court.
                            Mapped. Before you arrive.</h3>
                        <p class="text-slate-400 text-sm uppercase tracking-widest font-bold">Because you have to start
                            before the gate, not after it.</p>
                        <a href="#" class="btn-primary inline-flex items-center gap-4 mt-8">
                            Find Court Maps & Complex Layouts
                            <span class="text-[0.6rem] opacity-60 font-medium">Link to collection with Filter</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Updates -->
                <div class="bg-card2 p-12 rounded-2xl border border-white/5 relative overflow-hidden group">
                    <div class="absolute inset-x-0 top-0 h-1 bg-blue/20"></div>
                    <div class="space-y-6">
                        <span class="text-blue text-xs font-black uppercase tracking-[0.3em]">latest Updates / News</span>
                        <h3 class="text-3xl font-black text-white uppercase leading-tight">Every Notice. Every circular.
                            One place.</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">Live Court Notice Tribunal Circulars and
                            Procedural updates - Curated daily</p>
                        <a href="#"
                            class="btn-ghost inline-flex items-center gap-4 mt-8 border-white/10 uppercase tracking-widest">
                            Find Notices & Circulars
                        </a>
                    </div>
                </div>
            </div>

            <!-- WA Signup -->
            <div
                class="mt-16 flex flex-col md:flex-row items-center justify-between gap-8 bg-blue p-8 rounded-lg shadow-2xl shadow-blue-glow reveal">
                <span class="text-navy font-black text-lg md:text-xl uppercase tracking-tighter">-> Sing up for WA
                    updates.</span>
                <div class="flex w-full md:w-auto">
                    <input type="text" placeholder="Enter Mobile Number"
                        class="bg-white/20 border-none px-6 py-4 placeholder-navy/40 text-navy focus:ring-navy/30 text-sm font-bold w-full md:w-64 rounded-l-md">
                    <button
                        class="bg-navy text-white px-8 py-4 font-black text-xs uppercase tracking-widest rounded-r-md hover:bg-black transition-colors">Subscribe</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="py-32 bg-navy2" id="contact">
        <div class="max-w-[1500px] mx-auto px-6">
            <div class="mb-16 reveal">
                <h2 class="section-head text-white uppercase tracking-tighter text-4xl mb-4">Contact us</h2>
                <div class="head-line"></div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-px bg-white/10 border border-white/10 rounded-2xl overflow-hidden reveal">
                <!-- Left Details -->
                <div class="bg-card p-16 space-y-12">
                    <div class="relative h-64 mb-12 rounded-xl overflow-hidden border border-white/5">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1000"
                            class="w-full h-full object-cover grayscale opacity-50" alt="Office Desk">
                    </div>
                    <div class="grid grid-cols-1 gap-12">
                        <div>
                            <h3 class="text-xs font-black text-blue uppercase tracking-[0.3em] mb-4">Our Archive HQ</h3>
                            <p class="text-2xl font-black text-white uppercase italic tracking-tighter">Change No Address.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-blue uppercase tracking-[0.3em] mb-4">Direct Line</h3>
                            <p class="text-2xl font-black text-white uppercase tracking-tighter">To be provided</p>
                        </div>
                    </div>
                </div>

                <!-- Right Details -->
                <div class="bg-card2 p-16 flex flex-col justify-center">
                    <div>
                        <h3 class="text-xs font-black text-blue uppercase tracking-[0.3em] mb-4">Inquiries</h3>
                        <div class="space-y-6">
                            <p class="text-3xl font-black text-white uppercase tracking-tighter leading-tight">Inquiries :
                                2 Mail IDs to be Made.</p>
                            <p class="text-slate-500 text-sm max-w-md leading-relaxed">Our support channel is monitored
                                24/7 for critical procedural inquiries and professional onboarding assistance.</p>
                        </div>
                    </div>

                    <div class="mt-24 pt-12 border-t border-white/5">
                        <span class="text-slate-600 text-[0.6rem] font-bold uppercase tracking-[0.5em]">DockIt Operations
                            Network — Grounded in Excellence</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
