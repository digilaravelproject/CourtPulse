@extends('layouts.main')

@section('title', 'Procedural Updates & Circulars - DockIt')

@section('content')
<section class="py-24 bg-[#050812]">
    <div class="max-w-[1500px] mx-auto px-6">
        <div class="max-w-3xl mb-24">
            <span class="section-label">LIVE FEED</span>
            <h1 class="text-7xl font-black text-white leading-[0.9] uppercase tracking-tighter mb-8">
                COURT <br> <span class="text-[#B4B4FE]">INTELLIGENCE.</span>
            </h1>
            <p class="text-xl text-slate-500 leading-relaxed">Daily feed of registry circulars, causelists, and administrative notices from across Indian courts.</p>
        </div>

        <div class="space-y-4 max-w-5xl">
            @for($i=1; $i<=10; $i++)
            <div class="bg-[#0e1526] border border-white/5 p-8 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-8 hover:bg-[#111830] transition border-l-4 border-l-[#B4B4FE60]">
                <div class="max-w-2xl">
                    <div class="flex items-center gap-4 text-[0.6rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-3">
                        <span class="bg-[#B4B4FE20] px-3 py-1 rounded-sm">High Court of Bombay</span>
                        <span class="text-slate-600">Issued: March {{ 25 - $i }}, 2024</span>
                    </div>
                    <h3 class="text-2xl font-black text-white leading-tight uppercase tracking-tight">Standard Operating Procedure for E-Mentioning in Commercial Suits.</h3>
                </div>
                <div>
                    <a href="#" class="btn-ghost flex items-center gap-2 border-[#B4B4FE40] text-[#B4B4FE] hover:bg-[#B4B4FE10] px-8 py-4">
                        <i class="bi bi-download"></i> VIEW CIRCULAR
                    </a>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>
@endsection
