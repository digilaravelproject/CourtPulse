@if (isset($advocates) && $advocates->count())
    <div class="mb-4 text-[10px] font-black text-white/40 uppercase tracking-widest flex items-center gap-2">
        <i class="fas fa-list-ul text-blue/40"></i>
        {{ $advocates->total() }} advocate(s) found
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($advocates as $advocate)
            @php
                $status = \App\Models\ConnectionRequest::getStatus($authId, $advocate->id);
                $connected = $status === 'connected';
            @endphp
            <div
                class="bg-navy2 rounded-3xl border border-white/5 p-6 hover:border-blue/30 transition-all duration-300 group shadow-2xl relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue/5 rounded-full -mr-12 -mt-12 pointer-events-none group-hover:bg-blue/10 transition-colors"></div>

                <!-- Header -->
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-xl bg-blue/10 border border-blue/20 text-blue shadow-[0_0_20px_rgba(180,180,254,0.15)] group-hover:shadow-[0_0_30px_rgba(180,180,254,0.3)] transition-all">
                        {{ strtoupper(substr($advocate->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-black text-white uppercase tracking-widest truncate group-hover:text-blue transition-colors">
                            {{ $advocate->name }}
                        </h3>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[0.55rem] font-black uppercase tracking-widest bg-green-500/10 border border-green-500/20 text-green-400">
                                <i class="fas fa-check-circle text-[8px]"></i> Verified
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Info — encrypted unless connected -->
                @if ($advocate->advocateProfile)
                    <div class="space-y-3 mb-6 relative z-10">
                        <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                            <i class="fas fa-building-columns w-4 text-blue/40 text-center"></i>
                            <span class="truncate">{{ $connected ? $advocate->advocateProfile->high_court ?? 'N/A' : '••••• High Court' }}</span>
                        </div>
                        @if ($advocate->city)
                            <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                                <i class="fas fa-location-dot w-4 text-blue/40 text-center"></i>
                                <span>{{ $connected ? $advocate->city : '•••••, •••••' }}</span>
                            </div>
                        @endif
                        @if ($advocate->advocateProfile->experience_years)
                            <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                                <i class="fas fa-briefcase w-4 text-blue/40 text-center"></i>
                                <span>{{ $advocate->advocateProfile->experience_years }} yrs experience</span>
                            </div>
                        @endif
                        
                        <!-- Contact encrypted unless connected -->
                        @if ($hasFeedback)
                            <div class="flex items-center gap-3 text-xs font-bold text-white/60 pt-2 border-t border-white/5">
                                <i class="fas fa-envelope w-4 text-blue/40 text-center"></i>
                                <span class="truncate {{ !$connected ? 'blur-[3px] select-none opacity-50' : '' }}">
                                    {{ $connected ? $advocate->email : 'user@example.com' }}
                                </span>
                            </div>
                            @if ($advocate->phone)
                                <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                                    <i class="fas fa-phone w-4 text-blue/40 text-center"></i>
                                    <span class="{{ !$connected ? 'blur-[3px] select-none opacity-50' : '' }}">
                                        {{ $connected ? $advocate->phone : '+91 ••••• •••••' }}
                                    </span>
                                </div>
                            @endif
                        @else
                            <div class="flex items-center gap-2 text-[10px] font-black text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl px-4 py-3 mt-2">
                                <i class="fas fa-lock text-xs"></i>
                                <span class="uppercase tracking-widest">Feedback required to unlock</span>
                            </div>
                        @endif
                    </div>
                @endif

                @if (!$connected && $hasFeedback)
                    <div class="flex items-center gap-2 text-[10px] font-black text-amber-400 bg-amber-500/10 border border-amber-500/20 rounded-xl px-4 py-3 mb-6">
                        <i class="fas fa-shield-halved text-xs"></i>
                        <span class="uppercase tracking-widest">Connect to unlock all info</span>
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex gap-3 relative z-10">
                    <a href="{{ route('clerk.advocate.profile', $advocate->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/10 text-white/70 hover:text-white hover:bg-white/5 transition-all">
                        <i class="fas fa-id-card"></i> Profile
                    </a>

                    @if ($status === 'none')
                        <button onclick="sendConnect({{ $advocate->id }}, this)"
                            class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                            <i class="fas fa-user-plus"></i> Connect
                        </button>
                    @elseif($status === 'sent')
                        <button disabled
                            class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white/5 border border-white/10 text-white/40 cursor-not-allowed">
                            <i class="fas fa-clock"></i> Pending
                        </button>
                    @elseif($status === 'received')
                        @php
                            $req = \App\Models\ConnectionRequest::where('sender_id', $advocate->id)
                                ->where('receiver_id', $authId)
                                ->first();
                        @endphp
                        <button onclick="acceptConnect({{ $req?->id }}, this)"
                            class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black text-navy uppercase tracking-widest bg-green-400 hover:bg-white transition-all transform hover:scale-[1.02]">
                            <i class="fas fa-check"></i> Accept
                        </button>
                    @elseif($status === 'connected')
                        <div class="flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue/10 border border-blue/20 text-blue">
                            <i class="fas fa-handshake"></i> Connected
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($advocates->hasPages())
        <div class="mt-8">{{ $advocates->withQueryString()->links() }}</div>
    @endif
@else
    <div class="bg-navy2 rounded-3xl border border-white/5 py-20 text-center shadow-2xl relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="w-20 h-20 rounded-full bg-navy border border-white/5 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-magnifying-glass text-3xl text-white/10"></i>
            </div>
            <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-2">No advocates found</h3>
            <p class="text-xs font-bold text-white/40 uppercase tracking-widest">Try adjusting your search filters or clear all</p>
        </div>
    </div>
@endif

<script>
    if (typeof csrfToken === 'undefined') {
        var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    }

    function sendConnect(userId, btn) {
        btn.disabled = true;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-[10px]"></i> Sending...';
        
        fetch('{{ route('connections.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    receiver_id: userId
                })
            })
            .then(r => r.json())
            .then(() => {
                btn.innerHTML = '<i class="fas fa-clock"></i> Pending';
                btn.className = 'flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white/5 border border-white/10 text-white/40 cursor-not-allowed';
                btn.disabled = true;
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            });
    }

    function acceptConnect(reqId, btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-[10px]"></i> Processing...';
        
        fetch(`/connections/${reqId}/accept`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(() => {
                btn.innerHTML = '<i class="fas fa-handshake"></i> Connected';
                btn.className = 'flex-[1.5] flex items-center justify-center gap-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue/10 border border-blue/20 text-blue';
                setTimeout(() => location.reload(), 800);
            });
    }
</script>
