@extends('support.layouts.master')
@section('title', 'Pending Requests')
@section('page-title', 'Connection Status')

@section('content')
<div class="grid lg:grid-cols-2 gap-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Incoming Requests Section -->
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between px-4">
            <h2 class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em]">Incoming Requests</h2>
            @if($pendingReceived->count() > 0)
                <span class="px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] font-black uppercase tracking-widest animate-pulse">
                    {{ $pendingReceived->count() }} New Request{{ $pendingReceived->count() > 1 ? 's' : '' }}
                </span>
            @endif
        </div>

        <div class="bg-navy2 border border-white/5 rounded-[3rem] p-8 lg:p-10 min-h-[500px] flex flex-col relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 blur-[100px] rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-blue-500/10 transition-colors duration-700"></div>

            @if($pendingReceived->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center text-center py-20">
                    <div class="w-24 h-24 rounded-4xl bg-white/2 border border-white/5 flex items-center justify-center mb-8 relative">
                        <div class="absolute inset-0 bg-blue-500/5 blur-2xl rounded-full"></div>
                        <i class="fas fa-inbox text-white/10 text-4xl"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white/40 uppercase tracking-[0.2em] mb-2">No Incoming Requests</h3>
                    <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest leading-relaxed">You don't have any new connection requests right now</p>
                </div>
            @else
                <div class="flex-1 space-y-5 relative z-10">
                    @foreach($pendingReceived as $request)
                        <div class="group/item relative p-6 rounded-[2.5rem] bg-white/2 border border-white/5 hover:bg-white/5 hover:border-blue-500/20 transition-all duration-500 overflow-hidden">
                            <div class="absolute inset-0 bg-linear-to-br from-blue-500/5 to-transparent opacity-0 group-hover/item:opacity-100 transition-opacity"></div>

                            <div class="flex items-start gap-6 relative z-10">
                                <div class="w-16 h-16 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-700 border border-white/10 flex items-center justify-center text-white text-2xl font-black shadow-lg group-hover/item:scale-110 transition-transform duration-500">
                                    {{ strtoupper(substr($request->sender->name, 0, 1)) }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between mb-1">
                                        <h4 class="text-lg font-bold text-white tracking-tight group-hover/item:text-blue-400 transition-colors">{{ $request->sender->name }}</h4>
                                        <span class="text-[9px] font-black text-white/20 uppercase tracking-widest pt-1">{{ $request->created_at->diffForHumans() }}</span>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-3 text-[10px] font-black text-white/40 uppercase tracking-[0.15em]">
                                        <span class="px-2 py-0.5 rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/10">
                                            {{ strtoupper(str_replace('_', ' ', $request->sender->role)) }}
                                        </span>
                                        @if($request->sender->advocateProfile && $request->sender->advocateProfile->high_court)
                                            <span class="w-1 h-1 rounded-full bg-white/10"></span>
                                            <span class="truncate">{{ $request->sender->advocateProfile->high_court }}</span>
                                        @endif
                                    </div>

                                    @if($request->notes)
                                        <div class="mt-4 p-5 rounded-2xl bg-black/40 border border-white/5 relative group-hover/item:border-blue-500/10 transition-colors">
                                            <i class="fas fa-comment-alt absolute -top-2 -left-2 text-blue-500/20 text-lg"></i>
                                            <p class="text-[11px] font-bold text-white/50 leading-relaxed italic tracking-wide">
                                                {{ $request->notes }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-8 flex items-center gap-4 relative z-10">
                                <form action="{{ route('support.pending.requests.accept', $request->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full py-4 rounded-2xl bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-blue-700 hover:shadow-[0_0_30px_rgba(37,99,235,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                        Accept Request
                                    </button>
                                </form>
                                <form action="{{ route('support.pending.requests.reject', $request->id) }}" method="POST" class="shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-14 py-4 rounded-2xl bg-white/5 border border-white/10 text-white/20 hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/30 transition-all duration-300" title="Decline Request">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Sent Requests Section -->
    <div class="flex flex-col gap-6">
        <div class="px-4">
            <h2 class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em]">Sent Requests</h2>
        </div>

        <div class="bg-navy2 border border-white/5 rounded-[3rem] p-8 lg:p-10 min-h-[500px] flex flex-col relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 blur-[100px] rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-indigo-500/10 transition-colors duration-700"></div>

            @if($pendingSent->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center text-center py-20">
                    <div class="w-24 h-24 rounded-4xl bg-white/2 border border-white/5 flex items-center justify-center mb-8 relative">
                        <div class="absolute inset-0 bg-indigo-500/5 blur-2xl rounded-full"></div>
                        <i class="fas fa-paper-plane text-white/10 text-4xl"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white/40 uppercase tracking-[0.2em] mb-2">No Sent Requests</h3>
                    <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest leading-relaxed">Search for professionals to send connection requests</p>
                </div>
            @else
                <div class="flex-1 space-y-4 relative z-10">
                    @foreach($pendingSent as $request)
                        <div class="group/item relative p-6 rounded-[2.5rem] bg-white/2 border border-white/5 hover:bg-white/5 hover:border-indigo-500/20 transition-all duration-500">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/20 text-2xl font-black group-hover/item:bg-indigo-500/10 group-hover/item:text-indigo-400 group-hover/item:border-indigo-500/20 transition-all duration-500">
                                    {{ strtoupper(substr($request->receiver->name, 0, 1)) }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold text-white tracking-tight mb-1 group-hover/item:text-indigo-400 transition-colors">{{ $request->receiver->name }}</h4>
                                    <div class="flex items-center gap-3 text-[10px] font-black text-white/40 uppercase tracking-widest">
                                        <span>{{ strtoupper(str_replace('_', ' ', $request->receiver->role)) }}</span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                                        <span class="text-indigo-400/70 tracking-[0.15em]">Waiting for response</span>
                                    </div>
                                </div>

                                <form action="{{ route('support.pending.requests.reject', $request->id) }}" method="POST" class="shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/20 hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/30 transition-all duration-300" title="Cancel Request">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
