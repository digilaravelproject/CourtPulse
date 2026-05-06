@if($courts->isEmpty())
    <div class="bg-navy2 border border-white/5 rounded-2xl p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-white/10 text-2xl mx-auto mb-4">
            <i class="fas fa-gavel"></i>
        </div>
        <h4 class="text-white font-semibold mb-1">No courts found</h4>
        <p class="text-white/40 text-sm">Try adjusting your search filters.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($courts as $court)
            <div class="group bg-navy2 border border-white/5 rounded-2xl p-5 hover:border-blue/30 transition-all duration-300 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold text-white truncate uppercase tracking-tight">
                            {{ $court->name }}
                        </div>
                        <div class="text-[10px] font-bold text-blue uppercase tracking-widest opacity-80">
                            {{ $court->type ?? 'General Jurisdiction' }}
                        </div>
                    </div>
                </div>

                <div class="mb-5 flex items-start gap-2 text-xs text-white/50 leading-relaxed">
                    <i class="fas fa-map-marker-alt mt-0.5 text-white/20"></i>
                    <span>
                        {{ $court->city }}, {{ $court->state }}
                        @if($court->pincode)
                            <span class="mx-1 text-white/10">•</span> {{ $court->pincode }}
                        @endif
                    </span>
                </div>

                <div class="pt-4 border-t border-white/5">
                    <a href="{{ route('professional.search.clerks', ['court_id' => $court->id]) }}"
                       class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-blue hover:text-navy hover:border-blue transition-all duration-300">
                        <i class="fas fa-users"></i> Browse Clerks
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if($courts->hasPages())
        <div class="mt-8">
            {{-- Custom styled pagination for the dark theme --}}
            <div class="flex justify-center">
                {{ $courts->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    @endif
@endif
