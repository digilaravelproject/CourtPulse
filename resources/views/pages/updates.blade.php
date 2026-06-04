@extends('layouts.main')

@section('title', 'Procedural Updates & Circulars - DockIt')

@section('content')
<section class="py-12 md:py-16 bg-[#050812] relative min-h-[70vh] overflow-hidden">
    <!-- Subtle Background Glow -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl h-[500px] bg-blue/5 blur-[150px] pointer-events-none"></div>

    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 relative z-10">
        {{-- ── HERO SECTION ────────────────────────────────────────── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 border-b border-white/5 pb-6">
            <div class="max-w-xl">
                <span class="text-blue text-[10px] font-black uppercase tracking-[0.2em] mb-2 block">LIVE FEED</span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white uppercase tracking-tighter leading-none mb-1">
                    Circulars & <span class="text-[#B4B4FE]">Notices</span>
                </h1>
            </div>
            <p class="max-w-md text-xs sm:text-sm text-slate-400 font-medium leading-relaxed md:text-right">
                Daily feed of registry circulars, causelists, and administrative notices from across Indian courts.
            </p>
        </div>

        {{-- ── SEARCH BAR ────────────────────────────────────────── --}}
        <div class="mb-8 max-w-2xl">
            <form action="{{ route('updates') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <i class="bi bi-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search notices, circulars, or court names..." 
                           class="w-full bg-[#0e1526]/80 border border-white/10 pl-12 pr-4 py-3.5 rounded-xl text-xs font-bold text-white placeholder-slate-500 focus:outline-none focus:border-blue/50 focus:ring-1 focus:ring-blue/50 transition-all">
                </div>
                <div class="flex gap-2 shrink-0">
                    <button type="submit" 
                            class="flex-1 sm:flex-none bg-blue hover:bg-white text-navy font-black px-6 py-3.5 rounded-xl text-[0.65rem] uppercase tracking-widest transition-all duration-300 shadow-[0_10px_20px_rgba(180,180,254,0.15)]">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('updates') }}" 
                           class="flex-1 sm:flex-none flex items-center justify-center bg-white/5 border border-white/10 hover:border-white/20 text-slate-300 hover:text-white px-5 py-3.5 rounded-xl text-[0.65rem] font-black uppercase tracking-widest transition-all text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ── NOTICES CONTAINER ──────────────────────────────────── --}}
        @if($notices->count() > 0)
            <div class="space-y-4 max-w-5xl">
                @foreach($notices as $notice)
                    <div class="bg-[#0e1526] border border-white/5 p-5 sm:p-6 md:p-8 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-6 hover:bg-[#111830] transition duration-300 border-l-4 border-l-[#B4B4FE60]">
                        <div class="flex-grow min-w-0">
                            <div class="flex flex-wrap items-center gap-3 text-[0.6rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-3">
                                @if($notice->court)
                                    <span class="bg-[#B4B4FE20] px-2.5 py-1 rounded text-[#B4B4FE]">{{ $notice->court->name }}</span>
                                @else
                                    <span class="bg-white/5 border border-white/10 px-2.5 py-1 rounded text-slate-400">General Notice</span>
                                @endif
                                
                                <span class="text-slate-500">Issued: {{ $notice->created_at->format('F d, Y') }}</span>
                                
                                @if($notice->show_new_badge)
                                    <span class="bg-red-500/20 text-red-400 border border-red-500/30 px-2 py-0.5 rounded text-[0.6rem] font-black tracking-widest uppercase">New</span>
                                @endif
                            </div>
                            
                            <h3 class="text-lg sm:text-xl md:text-2xl font-black text-white leading-snug uppercase tracking-tight break-words">
                                {{ $notice->title }}
                            </h3>
                        </div>
                        
                        <div class="shrink-0 w-full md:w-auto">
                            <a href="{{ Storage::disk('public')->url($notice->pdf_path) }}" 
                               target="_blank" 
                               class="w-full md:w-auto inline-flex items-center justify-center gap-2 border border-[#B4B4FE40] hover:border-[#B4B4FE] text-[#B4B4FE] hover:bg-[#B4B4FE] hover:text-navy px-5 py-3.5 rounded-xl uppercase text-[0.65rem] font-black tracking-widest transition duration-300 whitespace-nowrap">
                                <i class="bi bi-file-earmark-pdf text-sm"></i> VIEW CIRCULAR
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($notices, 'hasPages') && $notices->hasPages())
                <div class="mt-12 flex justify-start">
                    {{ $notices->links() }}
                </div>
            @endif
        @else
            {{-- ── EMPTY STATE ────────────────────────────────────────── --}}
            <div class="py-16 border border-white/5 bg-[#0e1526] rounded-3xl text-center flex flex-col items-center justify-center max-w-2xl mx-auto px-4">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-2xl mb-6">
                    <i class="bi bi-bell-slash"></i>
                </div>
                <h3 class="text-white font-black uppercase tracking-[0.2em] text-sm mb-2">No Notices Available</h3>
                <p class="text-slate-500 font-bold text-[0.65rem] uppercase tracking-widest max-w-xs leading-relaxed">
                    We couldn't find any circulars or administrative notices matching your query. Try resetting filters or search terms.
                </p>
                @if(request('search'))
                    <a href="{{ route('updates') }}" 
                       class="mt-6 bg-blue hover:bg-white text-navy font-black px-6 py-3 rounded-xl text-[0.65rem] uppercase tracking-widest transition-all">
                        View All Circulars
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
