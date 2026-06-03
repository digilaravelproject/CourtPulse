@extends('layouts.main')

@section('title', 'Court Maps Directory - DockIt')

@section('content')
<section class="py-24 bg-[#050812] relative min-h-[70vh] overflow-hidden">
    <!-- Subtle Background Glow -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl h-[500px] bg-blue/5 blur-[150px] pointer-events-none"></div>

    <div class="max-w-[1500px] mx-auto px-6 relative z-10">
        {{-- ── HERO / TITLE SECTION ────────────────────────────────── --}}
        <div class="max-w-3xl mb-20">
            <span class="section-label text-blue text-xs font-black uppercase tracking-[0.2em] mb-4 block">NAVIGATION SUPPORT</span>
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-white leading-[0.95] uppercase tracking-tighter mb-8">
                COURT ROOM <br> <span class="text-[#B4B4FE]">LAYOUT MAPS.</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-400 leading-relaxed font-medium">
                Locate court rooms, registries, and department halls across major judicial centers before you arrive on site.
            </p>
        </div>

        {{-- ── SEARCH BAR ────────────────────────────────────────── --}}
        <div class="mb-12 max-w-2xl">
            <form action="{{ route('court-maps.index') }}" method="GET" class="relative flex items-center gap-3">
                <div class="relative flex-1">
                    <i class="bi bi-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 text-base"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search courts by name, city or state..." 
                           class="w-full bg-[#0e1526]/80 border border-white/10 pl-14 pr-6 py-4 rounded-2xl text-sm font-bold text-white placeholder-slate-500 focus:outline-none focus:border-blue/50 focus:ring-1 focus:ring-blue/50 transition-all">
                </div>
                <button type="submit" 
                        class="bg-blue hover:bg-white text-navy font-black px-8 py-4 rounded-2xl text-xs uppercase tracking-widest transition-all duration-300 shadow-[0_10px_20px_rgba(180,180,254,0.15)] hover:shadow-[0_10px_35px_rgba(255,255,255,0.3)]">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('court-maps.index') }}" 
                       class="bg-white/5 border border-white/10 hover:border-white/20 text-slate-300 hover:text-white px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- ── CARDS GRID ────────────────────────────────────────── --}}
        @if($courts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($courts as $court)
                    <div class="bg-[#0e1526] border border-white/5 p-8 rounded-3xl transition-all duration-500 ease-out hover:-translate-y-2 hover:shadow-[0_15px_40px_rgba(180,180,254,0.08)] hover:border-white/10 flex flex-col justify-between group relative overflow-hidden min-h-[300px]">
                        <!-- Subtle card internal background glow on hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                        <div>
                            {{-- Card Header / Status Badge --}}
                            <div class="flex items-center justify-between mb-8 relative z-10">
                                <div class="w-12 h-12 rounded-2xl bg-[#050812] border border-white/10 flex items-center justify-center text-blue group-hover:border-blue/40 transition-colors shadow-lg">
                                    <i class="bi bi-buildings text-xl"></i>
                                </div>
                                @if($court->map_path)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.6rem] font-black uppercase tracking-widest bg-green-500/10 text-green-400 border border-green-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                                        Map Available
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.6rem] font-black uppercase tracking-widest bg-white/5 text-white/40 border border-white/5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white/20"></span>
                                        Pending
                                    </span>
                                @endif
                            </div>

                            {{-- Court Details --}}
                            <div class="space-y-4 mb-10 relative z-10">
                                <h3 class="text-2xl font-black text-white leading-tight uppercase tracking-tight group-hover:text-blue transition-colors duration-300">
                                    {{ $court->name }}
                                </h3>
                                
                                <div class="space-y-2 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                    <div class="flex items-start gap-2">
                                        <i class="bi bi-geo-alt text-[#B4B4FE]/60 mt-0.5"></i>
                                        <span>{{ $court->area ?? 'Area Not Provided' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="bi bi-building-geo text-[#B4B4FE]/60"></i>
                                        <span>{{ $court->city }}{{ $court->pincode ? ' - ' . $court->pincode : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <div class="relative z-10">
                            @if($court->map_path)
                                <a href="{{ Storage::disk('public')->url($court->map_path) }}" 
                                   target="_blank" 
                                   class="w-full bg-[#B4B4FE] hover:bg-white text-navy font-black py-4 rounded-2xl text-xs uppercase tracking-widest transition-all duration-300 shadow-[0_5px_15px_rgba(180,180,254,0.2)] hover:shadow-[0_8px_25px_rgba(255,255,255,0.4)] no-underline flex items-center justify-center gap-2">
                                    View Map <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            @else
                                <button disabled 
                                        class="w-full bg-white/5 text-white/30 border border-white/5 font-black py-4 rounded-2xl text-xs uppercase tracking-widest cursor-not-allowed flex items-center justify-center gap-2">
                                    Map Pending <i class="bi bi-lock-fill"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($courts, 'hasPages') && $courts->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $courts->links() }}
                </div>
            @endif
        @else
            {{-- ── EMPTY STATE ────────────────────────────────────────── --}}
            <div class="py-24 border border-white/5 bg-[#0e1526] rounded-3xl text-center flex flex-col items-center justify-center max-w-2xl mx-auto">
                <div class="w-20 h-20 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-3xl mb-6">
                    <i class="bi bi-map"></i>
                </div>
                <h3 class="text-white font-black uppercase tracking-[0.2em] text-lg mb-2">No Courts Found</h3>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest max-w-md px-6">
                    We couldn't find any courts matching your query. Try resetting filters or using alternate search keywords.
                </p>
                @if(request('search'))
                    <a href="{{ route('court-maps.index') }}" 
                       class="mt-8 bg-blue hover:bg-white text-navy font-black px-6 py-3.5 rounded-xl text-xs uppercase tracking-widest transition-all">
                        View All Maps
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
