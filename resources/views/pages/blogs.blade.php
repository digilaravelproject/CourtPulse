@extends('layouts.main')

@section('title', 'Legal & Procedural Insights - DockIt')

@section('content')
<section class="py-24 bg-[#050812]">
    <div class="max-w-[1500px] mx-auto px-6">
        <div class="max-w-3xl mb-24">
            <span class="section-label">EDITORIAL BITS</span>
            <h1 class="text-7xl font-black text-white leading-[0.9] uppercase tracking-tighter mb-8">
                THE DOCKIT <br> <span class="text-[#B4B4FE]">JOURNAL.</span>
            </h1>
            <p class="text-xl text-slate-500 leading-relaxed">Deep dives into Indian procedural law, registry updates, and the evolving landscape of legal tech.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
            @for($i=1; $i<=6; $i++)
            <article class="group">
                <div class="aspect-16/10 bg-[#0e1526] border border-white/5 mb-10 overflow-hidden rounded-2xl relative">
                    <img src="https://images.unsplash.com/photo-1505664194779-8beaceb93744?auto=format&fit=crop&w=800&q=80" alt="Blog Thumb" 
                         class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                    <div class="absolute top-6 left-6 bg-[#B4B4FE] text-[#050812] text-[0.6rem] font-black px-4 py-1.5 uppercase tracking-widest rounded-sm">
                        CATEGORY {{ $i }}
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-3 text-[0.65rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-4">
                        <i class="bi bi-clock"></i> 5 MINS READ • MARCH {{ 10 + $i }}, 2024
                    </div>
                    <h3 class="text-3xl font-black text-white leading-tight uppercase tracking-tight group-hover:text-[#B4B4FE] transition-colors mb-4">
                        THE FUTURE OF E-FILING IN DISTRICT COURTS.
                    </h3>
                    <p class="text-slate-500 line-clamp-2 leading-relaxed mb-8">Exploring how the latest directives from the E-Committee are reshaping the daily workflows of clerks and advocates on ground.</p>
                    <a href="#" class="inline-flex items-center gap-2 text-xs font-black text-white uppercase tracking-widest group-hover:gap-4 transition-all">
                        READ ARTICLE <i class="bi bi-arrow-right text-[#B4B4FE]"></i>
                    </a>
                </div>
            </article>
            @endfor
        </div>
    </div>
</section>
@endsection
