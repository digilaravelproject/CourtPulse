@extends('layouts.main')

@section('title', 'Join our Operations Team - DockIt')

@section('content')
<section class="py-24 bg-[#050812] relative">
    <div class="max-w-[1500px] mx-auto px-6">
        <div class="max-w-3xl mb-32">
            <span class="section-label">TEAM EXPANSION</span>
            <h1 class="text-7xl md:text-8xl font-black text-white leading-[0.85] uppercase tracking-tighter mb-8">
                BUILD THE <br> <span class="text-[#B4B4FE]">LEGAL RAILROAD.</span>
            </h1>
            <p class="text-xl text-slate-500 leading-relaxed">Join the team digitizing the on-ground execution layer of the Indian legal system.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-start">
            <div class="space-y-6">
                <h4 class="text-white text-xs font-black uppercase tracking-[0.2em] mb-12 flex items-center gap-4">
                    Open Positions <span class="w-12 h-px bg-white/10"></span>
                </h4>
                
                @php
                    $jobs = ['Operations Associate', 'Network Growth Manager', 'Legal Liaison Officer', 'Procurement Specialist'];
                @endphp
                @foreach($jobs as $job)
                <div class="group bg-[#0e1526] border border-white/5 p-10 rounded-2xl hover:border-[#B4B4FE] transition duration-500 cursor-pointer flex justify-between items-center overflow-hidden relative">
                    <div class="relative z-10">
                        <div class="text-[0.65rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-2">Remote / Hybrid</div>
                        <h3 class="text-3xl font-black text-white uppercase tracking-tight">{{ $job }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center text-white group-hover:bg-[#B4B4FE] group-hover:text-navy transition-all duration-500 relative z-10">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                    <!-- Hover text background -->
                    <div class="absolute right-0 bottom-0 text-9xl font-black text-white/5 italic translate-x-1/4 translate-y-1/4 group-hover:text-[#B4B4FE05] transition-all">HIRING</div>
                </div>
                @endforeach
            </div>

            <div class="bg-linear-to-br from-[#111830] to-[#050812] border border-[#B4B4FE20] p-16 rounded-[40px] sticky top-32">
                <h3 class="text-4xl font-black text-white tracking-tighter leading-none mb-8">DON'T SEE A <br> <span class="text-[#B4B4FE]">PERFECT FIT?</span></h3>
                <p class="text-slate-500 text-lg mb-12">We're always looking for ambitious individuals who understand the nuances of the Indian court system. Drop your resume for future considerations.</p>
                <a href="mailto:careers@dockit.network" class="btn-primary py-6 px-12 text-sm inline-block">GO SPONTANEOUS</a>
            </div>
        </div>
    </div>
</section>
@endsection
