@extends('professional.layouts.master')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
        <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-tight">Intelligence <span class="text-blue-500">Command</span></h2>
        <p class="text-xs font-bold text-white/30 uppercase tracking-[0.2em]">Real-time node performance & network status</p>
    </div>

    <div class="flex items-center gap-3">
        <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 flex items-center gap-3 backdrop-blur-md">
            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-[10px] font-black text-white/60 uppercase tracking-widest">System Online</span>
        </div>
        <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-white/60 uppercase tracking-widest backdrop-blur-md">
            {{ now()->format('d M Y') }}
        </div>
    </div>
</div>

{{-- Metric Hub --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    {{-- Total Connections --}}
    <div class="group relative p-8 rounded-4xl bg-white/5 border border-white/10 hover:border-blue-500/30 transition-all duration-500 overflow-hidden backdrop-blur-xl">
        <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i class="fas fa-network-wired text-7xl text-white"></i>
        </div>
        <div class="relative z-10">
            <div class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-4">Network Nodes</div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-white tracking-tighter">{{ $totalConnections ?? 0 }}</span>
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Active</span>
            </div>
        </div>
    </div>

    {{-- Pending Requests --}}
    <a href="{{ route('professional.pending.requests') }}" class="group relative p-8 rounded-4xl bg-white/5 border border-white/10 hover:border-amber-500/30 transition-all duration-500 overflow-hidden backdrop-blur-xl">
        <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i class="fas fa-clock text-7xl text-white"></i>
        </div>
        <div class="relative z-10">
            <div class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-4">Pending Handshakes</div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-white tracking-tighter">{{ $pendingRequests ?? 0 }}</span>
                <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Inbound</span>
            </div>
        </div>
    </a>

    {{-- Clerks Connected --}}
    <div class="group relative p-8 rounded-4xl bg-white/5 border border-white/10 hover:border-indigo-500/30 transition-all duration-500 overflow-hidden backdrop-blur-xl">
        <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i class="fas fa-user-shield text-7xl text-white"></i>
        </div>
        <div class="relative z-10">
            <div class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-4">Support Channels</div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-white tracking-tighter">{{ $clerksConnected ?? 0 }}</span>
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Verified</span>
            </div>
        </div>
    </div>

    {{-- Feedback Rating --}}
    <div class="group relative p-8 rounded-4xl bg-white/5 border border-white/10 hover:border-fuchsia-500/30 transition-all duration-500 overflow-hidden backdrop-blur-xl">
        <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i class="fas fa-star text-7xl text-white"></i>
        </div>
        <div class="relative z-10">
            <div class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-4">Reputation Score</div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-white tracking-tighter">{{ number_format($avgRating ?? 0, 1) }}</span>
                <span class="text-xs font-bold text-fuchsia-400 uppercase tracking-widest">{{ $feedbacksReceived ?? 0 }} Reviews</span>
            </div>
        </div>
    </div>
</div>

{{-- Strategic Modules --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    {{-- Main Command Center --}}
    <div class="lg:col-span-8 space-y-8">
        {{-- Profile Intel Card --}}
        <div class="p-10 rounded-[3rem] bg-white/5 border border-white/10 backdrop-blur-3xl relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500/10 blur-[100px] rounded-full"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                <div class="h-40 w-40 rounded-[2.5rem] bg-linear-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-5xl font-black text-white shadow-[0_30px_60px_rgba(37,99,235,0.3)] border border-white/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-4xl font-black text-white uppercase tracking-tighter mb-3">{{ Auth::user()->name }}</h3>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3 mb-6">
                        <span class="px-4 py-1.5 rounded-xl bg-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest border border-blue-500/20">
                            {{ strtoupper(str_replace('_', ' ', Auth::user()->sub_role ?? Auth::user()->role)) }}
                        </span>
                        <span class="px-4 py-1.5 rounded-xl bg-white/5 text-white/40 text-[10px] font-black uppercase tracking-widest border border-white/5">
                            Active Node Since {{ Auth::user()->created_at->format('Y') }}
                        </span>
                    </div>
                    <p class="text-base font-medium text-white/50 leading-relaxed max-w-xl italic">
                        "{{ $profile->bio ?? 'Tactical profile incomplete. Update your dossier to enhance networking visibility and reputation scores.' }}"
                    </p>
                </div>

                <div class="flex flex-col gap-4 min-w-[180px] w-full md:w-auto">
                    <a href="{{ route('professional.profile') }}" class="w-full py-5 rounded-2xl bg-blue-600 text-white text-xs font-black uppercase tracking-widest text-center hover:bg-blue-700 hover:shadow-[0_0_40px_rgba(37,99,235,0.4)] transition-all duration-300">
                        Update Dossier
                    </a>
                    <a href="{{ route('professional.settings') }}" class="w-full py-5 rounded-2xl bg-white/5 border border-white/10 text-white text-xs font-black uppercase tracking-widest text-center hover:bg-white/10 transition-all duration-300">
                        Configuration
                    </a>
                </div>
            </div>
        </div>

        {{-- Search Operations --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Search Clerks --}}
            <a href="{{ route('professional.search.clerks') }}" class="group p-8 rounded-[2.5rem] bg-white/5 border border-white/5 hover:border-blue-500/30 transition-all duration-500 backdrop-blur-xl">
                <div class="h-16 w-16 rounded-2xl bg-blue-500/10 border border-blue-500/10 flex items-center justify-center text-blue-400 mb-8 group-hover:scale-110 group-hover:bg-blue-500/20 transition-all duration-500">
                    <i class="fas fa-user-tie text-2xl"></i>
                </div>
                <h4 class="text-base font-black text-white uppercase tracking-widest mb-2">Clerk Search</h4>
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest">Deploy support nodes</p>
            </a>

            {{-- Search Advocates --}}
            <a href="{{ route('professional.search.advocates') }}" class="group p-8 rounded-[2.5rem] bg-white/5 border border-white/5 hover:border-indigo-500/30 transition-all duration-500 backdrop-blur-xl">
                <div class="h-16 w-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/10 flex items-center justify-center text-indigo-400 mb-8 group-hover:scale-110 group-hover:bg-indigo-500/20 transition-all duration-500">
                    <i class="fas fa-balance-scale text-2xl"></i>
                </div>
                <h4 class="text-base font-black text-white uppercase tracking-widest mb-2">Advocates</h4>
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest">Professional networking</p>
            </a>

            {{-- Search Courts --}}
            <a href="{{ route('professional.search.courts') }}" class="group p-8 rounded-[2.5rem] bg-white/5 border border-white/5 hover:border-fuchsia-500/30 transition-all duration-500 backdrop-blur-xl">
                <div class="h-16 w-16 rounded-2xl bg-fuchsia-500/10 border border-fuchsia-500/10 flex items-center justify-center text-fuchsia-400 mb-8 group-hover:scale-110 group-hover:bg-fuchsia-500/20 transition-all duration-500">
                    <i class="fas fa-landmark text-2xl"></i>
                </div>
                <h4 class="text-base font-black text-white uppercase tracking-widest mb-2">Institutions</h4>
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest">Locate court hubs</p>
            </a>
        </div>
    </div>

    {{-- Side Intel --}}
    <div class="lg:col-span-4 space-y-8">
        {{-- Quick Actions --}}
        <div class="p-10 rounded-[3rem] bg-white/5 border border-white/10 backdrop-blur-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-[0.4em] mb-10 opacity-40">System Actions</h3>

            <div class="space-y-5">
                <a href="{{ route('professional.connections') }}" class="flex items-center justify-between p-5 rounded-2xl bg-white/2 border border-white/5 hover:bg-white/5 hover:border-blue-500/20 transition-all group">
                    <div class="flex items-center gap-5">
                        <div class="h-12 w-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="text-xs font-black text-white/70 uppercase tracking-widest">My Network</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-white/20 group-hover:text-blue-500 group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="{{ route('professional.feedback') }}" class="flex items-center justify-between p-5 rounded-2xl bg-white/2 border border-white/5 hover:bg-white/5 hover:border-fuchsia-500/20 transition-all group">
                    <div class="flex items-center gap-5">
                        <div class="h-12 w-12 rounded-xl bg-fuchsia-500/10 flex items-center justify-center text-fuchsia-400 group-hover:scale-110 transition-transform">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <span class="text-xs font-black text-white/70 uppercase tracking-widest">Intelligence Feed</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-white/20 group-hover:text-fuchsia-500 group-hover:translate-x-1 transition-all"></i>
                </a>

                <div class="pt-8 mt-4 border-t border-white/5">
                    <div class="p-8 rounded-4xl bg-linear-to-br from-blue-600/10 to-indigo-600/10 border border-blue-500/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 blur-2xl rounded-full"></div>
                        <div class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-4">System Update</div>
                        <p class="text-[11px] font-bold text-white/60 leading-relaxed uppercase tracking-wider mb-0">
                            Sync with local court hubs to increase connection priority and networking reach.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resource Stats --}}
        <div class="p-10 rounded-[3rem] bg-white/5 border border-white/10 backdrop-blur-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-[0.4em] mb-10 opacity-40">Resource Load</h3>

            <div class="space-y-8">
                <div>
                    <div class="flex justify-between mb-3">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Profile Integrity</span>
                        <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">{{ $profile ? '100%' : '20%' }}</span>
                    </div>
                    <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden border border-white/5">
                        <div class="h-full bg-blue-500 rounded-full shadow-[0_0_15px_rgba(59,130,246,0.5)]" style="width: {{ $profile ? '100%' : '20%' }}"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-3">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Network Saturation</span>
                        <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">{{ min(($totalConnections ?? 0) * 5, 100) }}%</span>
                    </div>
                    <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden border border-white/5">
                        <div class="h-full bg-indigo-500 rounded-full shadow-[0_0_15px_rgba(99,102,241,0.5)]" style="width: {{ min(($totalConnections ?? 0) * 5, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
