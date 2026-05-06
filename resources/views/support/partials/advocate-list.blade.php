@if (isset($advocates) && $advocates->count())
    <div class="mb-4 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] font-mono">
        {{ $advocates->total() }} vectors detected in network
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($advocates as $advocate)
            @php
                $status = \App\Models\ConnectionRequest::getStatus($authId, $advocate->id);
                $connected = $status === 'connected';
            @endphp
            <div class="group relative bg-navy2 rounded-3xl border border-white/5 p-6 hover:border-blue-500/30 hover:shadow-[0_20px_40px_rgba(0,0,0,0.4)] transition-all duration-500 overflow-hidden">
                <div class="absolute -top-12 -right-12 w-24 h-24 bg-blue-500/5 blur-2xl rounded-full group-hover:bg-blue-500/10 transition-all duration-500"></div>

                <!-- Header -->
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-xl font-black text-white shadow-lg border border-white/10 group-hover:scale-110 transition-transform duration-500">
                        {{ strtoupper(substr($advocate->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-black text-white uppercase tracking-tighter truncate group-hover:text-blue-400 transition-colors">{{ $advocate->name }}</div>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Verified Node</span>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="space-y-3 mb-8 relative z-10">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/2 border border-white/5">
                        <i class="fas fa-landmark text-[10px] text-blue-400 w-4"></i>
                        <span class="text-[10px] font-bold text-white/50 uppercase tracking-wider truncate">
                            {{ $connected ? ($advocate->advocateProfile->high_court ?? 'General Jurisdiction') : '••••••••••••••••' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/2 border border-white/5">
                        <i class="fas fa-briefcase text-[10px] text-indigo-400 w-4"></i>
                        <span class="text-[10px] font-bold text-white/50 uppercase tracking-wider">
                            {{ $advocate->advocateProfile->experience_years ?? '0' }} Years Experience
                        </span>
                    </div>

                    @if ($hasFeedback)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white/2 border border-white/5 {{ !$connected ? 'opacity-50' : '' }}">
                            <i class="fas fa-envelope text-[10px] text-blue-400 w-4"></i>
                            <span class="text-[10px] font-bold text-white/50 uppercase tracking-wider truncate {{ !$connected ? 'blur-[2px] select-none' : '' }}">
                                {{ $connected ? $advocate->email : '••••••••••••••••' }}
                            </span>
                        </div>
                    @else
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10">
                            <i class="fas fa-lock text-[10px] text-red-400 w-4"></i>
                            <span class="text-[9px] font-black text-red-400/60 uppercase tracking-widest italic">Contact Vectors Encrypted</span>
                        </div>
                    @endif
                </div>

                <!-- Action Vector -->
                <div class="flex gap-3 relative z-10">
                    <a href="{{ route('support.advocate.profile', $advocate->id) }}" 
                       class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-white/10 hover:border-white/20 transition-all">
                        View Dossier
                    </a>

                    @if ($status === 'none')
                        <button data-user-id="{{ $advocate->id }}" 
                                class="send-connection-btn flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 hover:shadow-[0_10px_20px_rgba(37,99,235,0.3)] transition-all">
                            Connect
                        </button>
                    @elseif($status === 'sent')
                        <button disabled 
                                class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black text-white/30 uppercase tracking-widest cursor-not-allowed">
                            Pending
                        </button>
                    @elseif($status === 'received')
                        @php
                            $req = \App\Models\ConnectionRequest::where('sender_id', $advocate->id)
                                ->where('receiver_id', $authId)
                                ->first();
                        @endphp
                        <a href="{{ route('support.pending.requests') }}" 
                           class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-amber-500 text-navy text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all">
                            Inbound
                        </a>
                    @elseif($status === 'connected')
                        <button disabled 
                                class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-black text-emerald-400 uppercase tracking-widest">
                            Connected
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($advocates->hasPages())
        <div class="mt-10">
            {{ $advocates->withQueryString()->links('vendor.pagination.tailwind-dark') }}
        </div>
    @endif
@else
    <div class="bg-navy2 border border-white/5 rounded-4xl p-20 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-b from-blue-500/5 to-transparent"></div>
        <div class="relative z-10">
            <div class="w-24 h-24 rounded-3xl bg-white/5 flex items-center justify-center text-white/10 text-4xl mx-auto mb-8 border border-white/5">
                <i class="fas fa-radar"></i>
            </div>
            <h4 class="text-xl font-black text-white uppercase tracking-tighter mb-2">Zero Network Matches</h4>
            <p class="text-white/40 text-sm uppercase tracking-[0.2em] max-w-xs mx-auto leading-relaxed">No advocates detected with the specified protocol parameters.</p>
        </div>
    </div>
@endif
