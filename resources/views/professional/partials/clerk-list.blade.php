@if($clerks->isEmpty())
    <div class="bg-navy2 border border-white/5 rounded-2xl p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-white/10 text-2xl mx-auto mb-4">
            <i class="fas fa-search"></i>
        </div>
        <h4 class="text-white font-semibold mb-1">No clerks found</h4>
        <p class="text-white/40 text-sm">Try adjusting your search filters.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($clerks as $clerk)
            <div class="group bg-navy2 border border-white/5 rounded-2xl p-6 hover:border-blue/30 hover:bg-white/2 transition-all duration-300">
                <!-- Header: Avatar & Name -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-blue/10 text-blue text-xl font-black border border-blue/10 group-hover:scale-105 transition-transform duration-500">
                        {{ strtoupper(substr($clerk->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-black text-white truncate group-hover:text-blue transition-colors">
                            {{ $clerk->name }}
                        </div>
                        <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest truncate">
                            {{ $clerk->sub_role ?? $clerk->role }}
                        </div>
                    </div>
                </div>

                <!-- Body: Location & Court Info -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="h-7 w-7 flex items-center justify-center rounded-lg bg-black/20 text-white/30 text-[10px]">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="text-[11px] font-bold text-white/60 truncate">
                            {{ $clerk->city ?? 'Location not set' }}
                        </span>
                    </div>

                    @if($clerk->court)
                        <div class="flex items-center gap-3">
                            <div class="h-7 w-7 flex items-center justify-center rounded-lg bg-black/20 text-white/30 text-[10px]">
                                <i class="fas fa-landmark"></i>
                            </div>
                            <span class="text-[11px] font-bold text-blue truncate">
                                {{ $clerk->court?->name }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Footer: Actions -->
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('professional.user.profile.view', $clerk->id) }}"
                       class="flex items-center justify-center gap-2 py-3 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-white hover:text-navy transition-all duration-300">
                        <i class="fas fa-eye text-blue group-hover:text-navy"></i> View
                    </a>

                    <button class="btn-cp-primary send-connection-btn flex items-center justify-center gap-2 py-3 rounded-xl bg-blue text-navy text-[10px] font-black uppercase tracking-widest hover:bg-blue2 transition-all duration-300 shadow-lg shadow-blue/5"
                            data-user-id="{{ $clerk->id }}">
                        <i class="fas fa-user-plus"></i> Connect
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
