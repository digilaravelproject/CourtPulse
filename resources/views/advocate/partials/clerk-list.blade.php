@if (isset($clerks) && $clerks->count())
    <div class="mb-5 flex items-center gap-2">
        <div class="h-px flex-1 bg-white/5"></div>
        <div class="px-4 py-1 rounded-full bg-white/5 border border-white/5 text-[10px] font-black text-white/40 uppercase tracking-[0.2em]">
            {{ $clerks->total() }} Clerk(s) Found
        </div>
        <div class="h-px flex-1 bg-white/5"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($clerks as $clerk)
            @php
                $status = \App\Models\ConnectionRequest::getStatus($authId, $clerk->id);
                $connected = $status === 'connected';
            @endphp
            <div class="bg-navy2 border border-white/5 rounded-3xl p-6 hover:border-blue/30 transition-all duration-300 group relative overflow-hidden shadow-2xl">
                <!-- Background Glow -->
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue/5 rounded-full blur-3xl group-hover:bg-blue/10 transition-all duration-500"></div>
                
                <div class="flex items-center gap-4 mb-6 relative">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-xl shrink-0 bg-blue/10 border border-blue/20 text-blue shadow-[0_0_20px_rgba(180,180,254,0.15)] group-hover:scale-105 transition-transform duration-300">
                        {{ strtoupper(substr($clerk->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-black text-base text-white uppercase tracking-widest truncate group-hover:text-blue transition-colors">{{ $clerk->name }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-widest bg-green-500/10 text-green-400 border border-green-500/20">
                                <i class="fas fa-check-double text-[8px]"></i> Verified
                            </span>
                            @if ($connected)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-widest bg-blue/10 text-blue border border-blue/20">
                                    <i class="fas fa-link text-[8px]"></i> Connected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-3 mb-6 relative bg-navy/30 rounded-2xl p-4 border border-white/5">
                    @if ($clerk->clerkProfile)
                        @if ($clerk->clerkProfile->court_name)
                            <div class="flex items-start gap-3 text-xs font-bold text-white/60">
                                <i class="fas fa-building w-4 text-blue/40 mt-0.5 shrink-0"></i>
                                <span class="truncate leading-tight">{{ $connected ? $clerk->clerkProfile->court_name : '•••••••••• Court' }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                            <i class="fas fa-map-marker-alt w-4 text-blue/40 shrink-0"></i>
                            <span class="truncate">{{ $connected ? $clerk->clerkProfile->court_city ?? ($clerk->city ?? 'N/A') : '•••••, •••••' }}</span>
                        </div>
                        @if ($clerk->clerkProfile->department)
                            <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                                <i class="fas fa-briefcase w-4 text-blue/40 shrink-0"></i>
                                <span class="truncate">{{ $connected ? $clerk->clerkProfile->department : '•••••••••• Section' }}</span>
                            </div>
                        @endif
                    @endif
                    
                    <div class="flex items-center gap-3 text-xs font-bold text-white/60 pt-2 border-t border-white/5">
                        <i class="fas fa-envelope w-4 text-blue/40 shrink-0"></i>
                        <span class="truncate {{ !$connected ? 'blur-[3px] select-none' : '' }}">
                            {{ $connected ? $clerk->email : 'user@dockit.com' }}
                        </span>
                    </div>
                    @if ($clerk->phone)
                        <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                            <i class="fas fa-phone w-4 text-blue/40 shrink-0"></i>
                            <span class="{{ !$connected ? 'blur-[3px] select-none' : '' }}">
                                {{ $connected ? $clerk->phone : '+91 ••••• •••••' }}
                            </span>
                        </div>
                    @endif
                </div>

                @if (!$connected)
                    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-amber-400 bg-amber-500/5 border border-amber-500/10 rounded-xl px-4 py-2.5 mb-4">
                        <i class="fas fa-shield-halved text-amber-500/50"></i>
                        <span>Connect to unlock profile</span>
                    </div>
                @endif

                <div class="flex gap-2 relative">
                    <a href="{{ route('advocate.clerk.profile', $clerk->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 bg-white/5 border border-white/10 text-white/70 hover:text-white hover:bg-white/10 hover:border-white/20">
                        <i class="fas fa-id-badge text-xs"></i> Details
                    </a>

                    @if ($status === 'none')
                        <button onclick="sendConnect({{ $clerk->id }}, this)"
                            class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue text-navy hover:bg-white transition-all duration-300 shadow-[0_5px_15px_rgba(180,180,254,0.3)] transform hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fas fa-user-plus text-xs"></i> Connect
                        </button>
                    @elseif($status === 'sent')
                        <button disabled class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-amber-500/10 border border-amber-500/20 text-amber-400 cursor-not-allowed">
                            <i class="fas fa-clock-rotate-left text-xs"></i> Pending
                        </button>
                    @elseif($status === 'received')
                        @php
                            $req = \App\Models\ConnectionRequest::where('sender_id', $clerk->id)->where('receiver_id', $authId)->first();
                        @endphp
                        <button onclick="acceptConnect({{ $req?->id }}, this)"
                            class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-green-500/20 border border-green-500/30 text-green-400 hover:bg-green-500 hover:text-white transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fas fa-check-circle text-xs"></i> Accept
                        </button>
                    @elseif($status === 'connected')
                        <div class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue/10 border border-blue/20 text-blue/40 cursor-default">
                            <i class="fas fa-handshake text-xs"></i> Connected
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($clerks->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-navy2 border border-white/5 p-2 rounded-2xl inline-block shadow-xl">
                {{ $clerks->withQueryString()->links() }}
            </div>
        </div>
    @endif
@else
    <div class="bg-navy2 border border-white/5 rounded-3xl py-20 px-8 text-center relative overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-b from-blue/5 to-transparent pointer-events-none"></div>
        <div class="relative">
            <div class="w-20 h-20 bg-white/5 border border-white/10 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fas fa-user-secret text-4xl text-white/10"></i>
            </div>
            <h3 class="text-xl font-black text-white uppercase tracking-[0.2em] mb-2">No Clerks Found</h3>
            <p class="text-white/40 text-sm font-bold max-w-md mx-auto leading-relaxed">
                We couldn't find any clerks matching your current search criteria. Try adjusting your filters or searching for something else.
            </p>
            <button onclick="window.location.reload()" class="mt-8 px-8 py-3 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-white/10 transition-all">
                <i class="fas fa-rotate mr-2"></i> Reset Search
            </button>
        </div>
    </div>
@endif

<script>
    if (typeof csrfToken === 'undefined') {
        var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    }

    function sendConnect(userId, btn) {
        btn.disabled = true;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';
        
        fetch('{{ route('connections.send') }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ receiver_id: userId })
            })
            .then(r => r.json())
            .then(d => {
                btn.innerHTML = '<i class="fas fa-clock-rotate-left text-xs"></i> Pending';
                btn.className = 'flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-amber-500/10 border border-amber-500/20 text-amber-400 cursor-not-allowed';
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
    }

    function acceptConnect(reqId, btn) {
        btn.disabled = true;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';

        fetch(`/connections/${reqId}/accept`, { 
                method: 'PATCH', 
                headers: { 
                    'X-CSRF-TOKEN': csrfToken, 
                    'Accept': 'application/json' 
                } 
            })
            .then(r => r.json())
            .then(d => {
                btn.innerHTML = '<i class="fas fa-handshake text-xs"></i> Connected';
                btn.className = 'flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue/10 border border-blue/20 text-blue/40 cursor-default';
                setTimeout(() => location.reload(), 1000);
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
    }
</script>() => location.reload(), 800);
            });
    }
</script>