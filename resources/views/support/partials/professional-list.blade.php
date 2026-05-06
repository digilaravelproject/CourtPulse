@if (isset($professionals) && $professionals->count())
    <div class="mb-4 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] font-mono">
        {{ $professionals->total() }} professionals found
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($professionals as $professional)
            @php
                $status = \App\Models\ConnectionRequest::getStatus($authId, $professional->id);
                $connected = $status === 'connected';
                $roleLabel = match($professional->role) {
                    'advocate' => 'Advocate',
                    'ca_cs' => 'CA/CS',
                    'agent' => 'IP Agent',
                    default => 'Professional'
                };
            @endphp
            <div class="group relative bg-navy2 rounded-3xl border border-white/5 p-6 hover:border-blue-500/30 hover:shadow-[0_20px_40px_rgba(0,0,0,0.4)] transition-all duration-500 overflow-hidden">
                <div class="absolute -top-12 -right-12 w-24 h-24 bg-blue-500/5 blur-2xl rounded-full group-hover:bg-blue-500/10 transition-all duration-500"></div>

                {{-- Professional Info --}}
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-xl font-black text-white shadow-lg border border-white/10 group-hover:scale-110 transition-transform duration-500">
                        {{ strtoupper(substr($professional->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-black text-white uppercase tracking-tighter truncate group-hover:text-blue-400 transition-colors">{{ $professional->name }}</div>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="text-[9px] font-black text-blue uppercase tracking-widest">{{ $roleLabel }}</span>
                        </div>
                    </div>
                </div>

                {{-- Details --}}
                <div class="space-y-3 mb-8 relative z-10">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/2 border border-white/5">
                        <i class="fas fa-university text-[10px] text-blue-400 w-4"></i>
                        <span class="text-[10px] font-bold text-white/50 uppercase tracking-wider truncate">
                            {{ $connected ? ($professional->advocateProfile->high_court ?? $professional->clerkProfile->court_name ?? 'Court') : 'Hidden' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/2 border border-white/5">
                        <i class="fas fa-user-clock text-[10px] text-indigo-400 w-4"></i>
                        <span class="text-[10px] font-bold text-white/50 uppercase tracking-wider">
                            {{ $professional->advocateProfile->experience_years ?? $professional->clerkProfile->experience_years ?? '0' }} Years Experience
                        </span>
                    </div>

                    @if ($connected && $hasFeedback)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white/2 border border-white/5">
                            <i class="fas fa-map-marker-alt text-[10px] text-blue-400 w-4"></i>
                            <span class="text-[10px] font-bold text-white/50 uppercase tracking-wider">
                                {{ $professional->city ?? 'Location not set' }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 relative z-10">
                    <a href="{{ route('support.professional.profile', $professional->id) }}"
                       class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-white/10 hover:border-white/20 transition-all">
                        View Profile
                    </a>

                    @if ($status === 'none')
                        <button data-user-id="{{ $professional->id }}"
                                class="send-connection-btn flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 hover:shadow-[0_10px_20px_rgba(37,99,235,0.3)] transition-all">
                            Send Request
                        </button>
                    @elseif($status === 'sent')
                        <button disabled
                                class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black text-white/30 uppercase tracking-widest cursor-not-allowed">
                            Request Sent
                        </button>
                    @elseif($status === 'received')
                        <a href="{{ route('support.pending.requests') }}"
                           class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-amber-500 text-navy text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all">
                            Accept Request
                        </a>
                    @elseif($status === 'connected')
                        <button disabled
                                class="flex-1 flex items-center justify-center py-3.5 rounded-2xl bg-green-500/10 border border-green-500/20 text-[10px] font-black text-green-400 uppercase tracking-widest">
                            Connected
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($professionals->hasPages())
        <div class="mt-10">
            {{ $professionals->withQueryString()->links('vendor.pagination.tailwind-dark') }}
        </div>
    @endif
@else
    <div class="bg-navy2 border border-white/5 rounded-4xl p-20 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-b from-blue-500/5 to-transparent"></div>
        <div class="relative z-10">
            <div class="w-24 h-24 rounded-3xl bg-white/5 flex items-center justify-center text-white/10 text-4xl mx-auto mb-8 border border-white/5">
                <i class="fas fa-search"></i>
            </div>
            <h4 class="text-xl font-black text-white uppercase tracking-tighter mb-2">No Professionals Found</h4>
            <p class="text-white/40 text-sm uppercase tracking-[0.2em] max-w-xs mx-auto">Try using different search keywords or filters.</p>
        </div>
    </div>
@endif
