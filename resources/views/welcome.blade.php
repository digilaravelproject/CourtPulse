@extends('layouts.main')

@section('title', 'DockIt — India\'s Legal Professional Network')

@section('content')
<!-- 1. Hero Section -->
<section class="relative min-h-[85vh] flex items-center overflow-hidden py-24">
    <!-- Grid Background -->
    <div class="absolute inset-0 opacity-40 pointer-events-none" 
         style="background-image: linear-gradient(rgba(180, 180, 254, .03) 1px, transparent 1px), linear-gradient(90deg, rgba(180, 180, 254, .03) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <!-- Glow Effects -->
    <div class="absolute -top-[100px] -left-[150px] w-[600px] h-[600px] rounded-full blur-[100px] opacity-20 pointer-events-none" 
         style="background: radial-gradient(circle, var(--blue) 0%, transparent 70%);"></div>
    <div class="absolute bottom-0 right-[20%] w-[400px] h-[400px] rounded-full blur-[80px] opacity-10 pointer-events-none" 
         style="background: radial-gradient(circle, var(--blue) 0%, transparent 70%);"></div>

    <div class="max-w-[1500px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 relative z-10 items-center">
        <div>
            <span class="hero-badge inline-block bg-[#B4B4FE20] border border-[#B4B4FE40] text-[#B4B4FE] text-[0.65rem] font-bold tracking-[0.2em] px-4 py-1.5 rounded-sm uppercase mb-8">
                Official Procedural Network
            </span>
            <h1 class="text-7xl md:text-8xl font-black text-white leading-[0.9] uppercase tracking-tighter mb-8">
                PROCEDURAL <br> <span class="text-[#B4B4FE]">EXCELLENCE</span> <br> SIMPLIFIED.
            </h1>
            <p class="text-xl text-slate-400 max-w-lg mb-12">
                The leading network for on-ground legal support. Access verified clerks, filing agents, and procedural experts across every major Indian registry.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('find') }}" class="btn-primary py-4 px-10 text-sm">Find Professional</a>
                <a href="{{ route('register') }}" class="btn-ghost py-4 px-10 text-sm border-[#B4B4FE60] text-[#B4B4FE] hover:bg-[#B4B4FE10]">Join the Network</a>
            </div>

            <div class="mt-16 pt-12 border-t border-white/5 flex gap-12">
                <div>
                    <div class="text-3xl font-black text-white">50+</div>
                    <div class="text-[0.6rem] font-bold text-slate-500 uppercase tracking-widest mt-1">Court Cities</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">12k+</div>
                    <div class="text-[0.6rem] font-bold text-slate-500 uppercase tracking-widest mt-1">Verified Agents</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">24hr</div>
                    <div class="text-[0.6rem] font-bold text-slate-500 uppercase tracking-widest mt-1">Avg Deployment</div>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex justify-center relative">
            <!-- Visual Element from old theme -->
            <div class="w-[500px] h-[600px] bg-linear-to-br from-[#0a0f20] via-[#0d1428] to-[#0a0f1e] rounded-[40px] border border-white/5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-grid opacity-20"></div>
                <!-- Abstract Stack -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative w-64 h-96">
                        @for($i=1; $i<=3; $i++)
                        <div class="absolute bg-linear-to-b from-[#1a2040] to-[#0e1628] border border-[#B4B4FE30] rounded-lg transition-all duration-700 group-hover:scale-105"
                             style="width: {{ 150 - ($i*20) }}px; height: {{ 320 - ($i*30) }}px; left: {{ 40 + ($i*25) }}px; top: {{ 30 + ($i*30) }}px; transform: perspective(1000px) rotateY(-{{ 10 - ($i*2) }}deg); opacity: {{ 1 - ($i*0.2) }};"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Workflow Section -->
<section class="py-32 bg-[#080d1a] border-y border-white/5" id="how-it-works">
    <div class="max-w-[1500px] mx-auto px-6">
        <div class="max-w-3xl mb-24">
            <span class="section-label">PROCESS FLOW</span>
            <h2 class="section-head">HOW IT <span class="text-[#B4B4FE]">WORKS.</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $steps = [
                    ['title' => 'Register Profile', 'desc' => 'Sign up as a Lawyer, Clerk, or Agency and verify your professional credentials.'],
                    ['title' => 'Find Resource', 'desc' => 'Search by court, city, or niche expertise in our deep procedural index.'],
                    ['title' => 'Initiate Request', 'desc' => 'Connect directly with on-ground experts and share task requirements securely.'],
                    ['title' => 'Secure Close', 'desc' => 'Complete the task, exchange files via DockIt, and verify results efficiently.'],
                ];
            @endphp

            @foreach($steps as $index => $step)
            <div class="bg-[#0e1526] border border-white/10 p-10 rounded-xl hover:border-[#B4B4FE40] transition-all group overflow-hidden relative">
                <div class="absolute -top-10 -right-10 text-9xl font-black text-white/5 italic group-hover:text-[#B4B4FE05] transition-colors leading-none">0{{ $index + 1 }}</div>
                <div class="w-12 h-12 bg-[#B4B4FE] text-[#050812] flex items-center justify-center rounded-lg font-black text-xl mb-8 relative z-10">{{ $index + 1 }}</div>
                <h3 class="text-2xl font-extrabold text-white uppercase tracking-tight mb-4 relative z-10">{{ $step['title'] }}</h3>
                <p class="text-slate-400 relative z-10 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 3. Insights Section -->
<section class="py-32">
    <div class="max-w-[1500px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-24">
        <div>
            <span class="section-label">LIVE INTELLIGENCE</span>
            <h2 class="section-head mb-12">LATEST <span class="text-[#B4B4FE]">UPDATES.</span></h2>
            
            <div class="space-y-4">
                @for($i=1; $i<=3; $i++)
                <div class="group bg-[#0e1526] border border-white/5 p-6 rounded-xl hover:bg-[#111830] transition flex gap-6 items-center">
                    <div class="w-16 h-16 bg-white/5 rounded-lg flex items-center justify-center text-[#B4B4FE] text-2xl shrink-0">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div>
                        <div class="text-[0.6rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-1">Del High Court</div>
                        <h4 class="text-lg font-bold text-white leading-snug">New Protocol for IP Matter Mentionings 2024.</h4>
                        <div class="text-xs text-slate-500 mt-2">MARCH {{ 20 + $i }} • 2 MIN READ</div>
                    </div>
                </div>
                @endfor
            </div>

            <a href="{{ route('updates') }}" class="inline-flex items-center gap-2 mt-12 text-[#B4B4FE] text-xs font-black uppercase tracking-widest hover:gap-4 transition-all">
                View All Procedural Updates <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="bg-linear-to-br from-[#111830] to-[#050812] border border-[#B4B4FE20] p-16 rounded-[40px] relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-4xl font-black text-white leading-none mb-8 uppercase tracking-tighter">NEVER MISS A <br> <span class="text-[#B4B4FE]">PROCEDURAL CHANGE.</span></h3>
                <p class="text-slate-400 text-xl mb-12 max-w-sm">Join our real-time notification network for legal pros.</p>
                
                <form class="space-y-4 max-w-md">
                    <div class="relative">
                        <input type="email" placeholder="Email address" class="w-full bg-white/5 border border-white/10 px-8 py-5 rounded-xl text-white focus:outline-none focus:border-[#B4B4FE] transition uppercase text-xs font-bold tracking-widest">
                    </div>
                    <button class="w-full btn-primary py-5 rounded-xl hover:scale-105 active:scale-95">SUBSCRIBE NOW</button>
                </form>
            </div>
            <!-- Abstract background shape -->
            <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-[#B4B4FE] rounded-full blur-[100px] opacity-10"></div>
        </div>
    </div>
</section>

<!-- 4. Support Section -->
<section class="py-32 bg-[#080d1a]" id="contact">
    <div class="max-w-[1500px] mx-auto px-6 text-center">
        <span class="section-label">GET ASSISTANCE</span>
        <h2 class="text-6xl md:text-8xl font-black text-white leading-[0.9] uppercase tracking-tighter mb-12">
            READY TO <span class="text-[#B4B4FE]">UPGRADE?</span>
        </h2>
        <p class="text-xl text-slate-400 max-w-2xl mx-auto mb-16">
            Have questions about integrating your agency or firm into the DockIt network? Our operations team is available 24/7.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-12 bg-[#0e1526] border border-white/5 rounded-2xl hover:border-[#B4B4FE40] transition">
                <i class="bi bi-envelope text-4xl text-[#B4B4FE] block mb-6"></i>
                <h4 class="text-white font-black uppercase tracking-widest mb-2">EMAIL</h4>
                <p class="text-slate-400">ops@dockit.network</p>
            </div>
            <div class="p-12 bg-[#0e1526] border border-white/5 rounded-2xl hover:border-[#B4B4FE40] transition">
                <i class="bi bi-telephone text-4xl text-[#B4B4FE] block mb-6"></i>
                <h4 class="text-white font-black uppercase tracking-widest mb-2">PHONE</h4>
                <p class="text-slate-400">+91 000 000 0000</p>
            </div>
            <div class="p-12 bg-[#0e1526] border border-white/5 rounded-2xl hover:border-[#B4B4FE40] transition">
                <i class="bi bi-geo-alt text-4xl text-[#B4B4FE] block mb-6"></i>
                <h4 class="text-white font-black uppercase tracking-widest mb-2">HEADQUARTERS</h4>
                <p class="text-slate-400">Delhi & Mumbai</p>
            </div>
        </div>
    </div>
</section>
@endsection
