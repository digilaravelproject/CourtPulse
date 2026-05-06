@extends('support.layouts.master')
@section('title', 'My Connections')
@section('page-title', 'My Connections')

@section('content')

<div class="mb-8 space-y-1">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">My <span class="text-blue">Network</span></h2>
    <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.2em]">Manage your professional connections</p>
</div>

<div class="rounded-2xl bg-navy2 border border-white/5 overflow-hidden shadow-sm">
    <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/2">
        <h3 class="text-xs font-bold text-white uppercase tracking-[0.3em]">Connected Professionals</h3>
        <span class="px-3 py-1 rounded-lg bg-blue/10 text-blue text-[10px] font-black uppercase tracking-widest border border-blue/20">
            {{ $connected->count() }} Total
        </span>
    </div>

    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($connected as $connection)
                <div class="group relative rounded-2xl bg-navy border border-white/5 p-6 hover:border-blue/30 hover:bg-white/3 transition-all duration-500">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-blue/10 text-blue text-xl font-black border border-blue/10 group-hover:scale-105 transition-transform duration-500">
                            {{ strtoupper(substr($connection->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-black text-white truncate group-hover:text-blue transition-colors">{{ $connection->name }}</div>
                            <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest truncate">
                                {{ $connection->sub_role ?? $connection->role }}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-7 w-7 flex items-center justify-center rounded-lg bg-black/20 text-white/30 text-[10px]">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span class="text-[11px] font-bold text-white/60 truncate">{{ $connection->email }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="h-7 w-7 flex items-center justify-center rounded-lg bg-black/20 text-white/30 text-[10px]">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span class="text-[11px] font-bold text-white/60">{{ $connection->phone ?? 'Private' }}</span>
                        </div>
                        @if($connection->advocateProfile)
                            <div class="flex items-center gap-3">
                                <div class="h-7 w-7 flex items-center justify-center rounded-lg bg-black/20 text-white/30 text-[10px]">
                                    <i class="fas fa-landmark"></i>
                                </div>
                                <span class="text-[11px] font-bold text-blue truncate">{{ $connection->advocateProfile->court_name }}</span>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('support.professional.profile', $connection->id) }}" class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-blue hover:text-navy hover:border-blue transition-all duration-300">
                        <i class="fas fa-eye text-blue group-hover:text-navy"></i> View Full Profile
                    </a>
                </div>
            @empty
                <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                    <div class="h-20 w-20 flex items-center justify-center rounded-3xl bg-white/5 border border-white/10 text-white/20 mb-6 group hover:border-blue/30 transition-all duration-500">
                        <i class="fas fa-users text-3xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h4 class="text-xl font-black text-white uppercase tracking-tighter mb-2">No Connections Found</h4>
                    <p class="text-sm font-bold text-white/40 uppercase tracking-widest max-w-xs leading-relaxed">
                        Start by searching for advocates and sending connection requests to grow your network.
                    </p>
                    <a href="{{ route('support.search.professionals') }}" class="mt-8 px-8 py-4 rounded-xl bg-blue text-navy text-xs font-black uppercase tracking-[0.2em] hover:bg-blue2 hover:shadow-[0_0_30px_rgba(0,210,255,0.2)] transition-all duration-300">
                        <i class="fas fa-search mr-2"></i> Search Professionals
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
