@extends('layouts.main')

@section('title', 'Procedural Updates & Circulars - DockIt')

@section('content')
<section class="py-24 bg-[#050812] relative min-h-[70vh] overflow-hidden">
    <!-- Subtle Background Glow -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl h-[500px] bg-blue/5 blur-[150px] pointer-events-none"></div>

    <div class="max-w-[1500px] mx-auto px-6 relative z-10">
        {{-- ── HERO SECTION ────────────────────────────────────────── --}}
        <div class="max-w-3xl mb-20">
            <span class="section-label text-blue text-xs font-black uppercase tracking-[0.2em] mb-4 block">LIVE FEED</span>
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-white leading-[0.95] uppercase tracking-tighter mb-8">
                COURT <br> <span class="text-[#B4B4FE]">INTELLIGENCE.</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-400 leading-relaxed font-medium">Daily feed of registry circulars, causelists, and administrative notices from across Indian courts.</p>
        </div>

        {{-- ── SEARCH BAR ────────────────────────────────────────── --}}
        <div class="mb-12 max-w-2xl">
            <form action="{{ route('updates') }}" method="GET" class="relative flex items-center gap-3">
                <div class="relative flex-1">
                    <i class="bi bi-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 text-base"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search notices, circulars, or court names..." 
                           class="w-full bg-[#0e1526]/80 border border-white/10 pl-14 pr-6 py-4 rounded-2xl text-sm font-bold text-white placeholder-slate-500 focus:outline-none focus:border-blue/50 focus:ring-1 focus:ring-blue/50 transition-all">
                </div>
                <button type="submit" 
                        class="bg-blue hover:bg-white text-navy font-black px-8 py-4 rounded-2xl text-xs uppercase tracking-widest transition-all duration-300 shadow-[0_10px_20px_rgba(180,180,254,0.15)] hover:shadow-[0_10px_35px_rgba(255,255,255,0.3)]">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('updates') }}" 
                       class="bg-white/5 border border-white/10 hover:border-white/20 text-slate-300 hover:text-white px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- ── NOTICES CONTAINER ──────────────────────────────────── --}}
        @if($notices->count() > 0)
            <div class="space-y-4 max-w-5xl">
                @foreach($notices as $notice)
                    <div class="bg-[#0e1526] border border-white/5 p-8 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-8 hover:bg-[#111830] transition duration-300 border-l-4 border-l-[#B4B4FE60]">
                        <div class="max-w-2xl">
                            <div class="flex flex-wrap items-center gap-4 text-[0.6rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-3">
                                @if($notice->court)
                                    <span class="bg-[#B4B4FE20] px-3 py-1 rounded-sm">{{ $notice->court->name }}</span>
                                @else
                                    <span class="bg-white/5 border border-white/10 px-3 py-1 rounded-sm text-slate-400">General Notice</span>
                                @endif
                                
                                <span class="text-slate-500">Issued: {{ $notice->created_at->format('F d, Y') }}</span>
                                
                                @if($notice->show_new_badge)
                                    <span class="bg-red-500/20 text-red-400 border border-red-500/30 px-2 py-0.5 rounded text-[0.6rem] font-black tracking-widest uppercase">New</span>
                                @endif
                            </div>
                            
                            <h3 class="text-2xl font-black text-white leading-tight uppercase tracking-tight">
                                {{ $notice->title }}
                            </h3>
                        </div>
                        
                        <div class="shrink-0">
                            <a href="{{ Storage::disk('public')->url($notice->pdf_path) }}" 
                               target="_blank" 
                               class="btn-ghost flex items-center justify-center gap-2 border-[#B4B4FE40] text-[#B4B4FE] hover:bg-[#B4B4FE] hover:text-navy px-8 py-4 uppercase text-xs font-black tracking-widest transition duration-300">
                                <i class="bi bi-download"></i> VIEW CIRCULAR
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($notices, 'hasPages') && $notices->hasPages())
                <div class="mt-16 flex justify-start">
                    {{ $notices->links() }}
                </div>
            @endif
        @else
            {{-- ── EMPTY STATE ────────────────────────────────────────── --}}
            <div class="py-24 border border-white/5 bg-[#0e1526] rounded-3xl text-center flex flex-col items-center justify-center max-w-2xl mx-auto">
                <div class="w-20 h-20 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-3xl mb-6">
                    <i class="bi bi-bell-slash"></i>
                </div>
                <h3 class="text-white font-black uppercase tracking-[0.2em] text-lg mb-2">No Notices Available</h3>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest max-w-md px-6">
                    We couldn't find any circulars or administrative notices matching your query. Try resetting filters or search terms.
                </p>
                @if(request('search'))
                    <a href="{{ route('updates') }}" 
                       class="mt-8 bg-blue hover:bg-white text-navy font-black px-6 py-3.5 rounded-xl text-xs uppercase tracking-widest transition-all">
                        View All Circulars
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
