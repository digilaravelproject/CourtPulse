@extends('layouts.clerk')
@section('title', 'View Advocates')
@section('page-title', 'View Advocates')
@section('content')

    @php $hasFeedback = \App\Http\Controllers\User\FeedbackController::clerkHasFeedback(auth()->id()); @endphp

    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-2">View Advocates</h1>
        <p class="text-xs font-bold text-white/60 leading-relaxed uppercase tracking-widest">Search and connect with verified advocates.</p>
    </div>

    {{-- Locked Banner --}}
    @if (!$hasFeedback)
        <div class="flex items-center gap-4 p-6 mb-8 rounded-3xl border border-red-500/20 bg-red-500/10 backdrop-blur-sm shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-red-500/20 text-red-400 shrink-0 shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                <i class="fas fa-lock"></i>
            </div>
            <div class="flex-1">
                <div class="font-black text-white uppercase tracking-widest text-sm">Contact Details Locked</div>
                <div class="text-xs font-bold text-white/60 mt-1 uppercase tracking-tighter">Submit compulsory feedback to unlock advocate contacts.</div>
            </div>
            <a href="{{ route('clerk.feedback') }}"
                class="flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-red-400 hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(248,113,113,0.2)]">
                Give Feedback <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @endif

    {{-- Filters --}}
    <div x-data="{
        f: { search: '{{ request('search') }}', high_court: '{{ request('high_court') }}', city: '{{ request('city') }}' },
        loading: false,
        doSearch() {
            this.loading = true;
            const qs = new URLSearchParams(this.f).toString();
            fetch('{{ route('clerk.advocates') }}?' + qs, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(d => {
                    document.getElementById('advocateGrid').innerHTML = d.html;
                    this.loading = false;
                })
                .catch(() => this.loading = false);
        },
        reset() {
            this.f = { search: '', high_court: '', city: '' };
            this.doSearch();
        }
    }">

        <div class="bg-navy2 rounded-3xl border border-white/5 p-6 md:p-8 mb-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 relative z-10">
                <div class="relative group">
                    <label class="text-[10px] font-black text-white/40 uppercase tracking-widest block mb-2 px-1">Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-blue transition-colors"></i>
                        <input type="text" x-model="f.search" @input.debounce.400ms="doSearch()"
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                            placeholder="Advocate name...">
                    </div>
                </div>
                <div class="relative group">
                    <label class="text-[10px] font-black text-white/40 uppercase tracking-widest block mb-2 px-1">High Court</label>
                    <div class="relative">
                        <i class="fas fa-building-columns absolute left-4 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-blue transition-colors"></i>
                        <input type="text" x-model="f.high_court" @input.debounce.400ms="doSearch()"
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                            placeholder="e.g. Bombay High Court">
                    </div>
                </div>
                <div class="relative group">
                    <label class="text-[10px] font-black text-white/40 uppercase tracking-widest block mb-2 px-1">City</label>
                    <div class="relative">
                        <i class="fas fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-blue transition-colors"></i>
                        <input type="text" x-model="f.city" @input.debounce.400ms="doSearch()"
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                            placeholder="City...">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between relative z-10 border-t border-white/5 pt-6">
                <div class="flex items-center gap-4">
                    <button @click="doSearch()"
                        class="flex items-center gap-2 py-3 px-8 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                        <i class="fas fa-magnifying-glass"></i> Search
                    </button>
                    <button @click="reset()"
                        class="px-8 py-3 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">
                        <i class="fas fa-rotate-right mr-2"></i> Reset
                    </button>
                </div>
                <div x-show="loading" class="flex items-center gap-2 text-[10px] font-black text-blue uppercase tracking-widest">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Updating Results...
                </div>
            </div>
        </div>

        {{-- Results Grid --}}
        <div id="advocateGrid">
            @include('clerk.partials.advocate-list', [
                'advocates' => $advocates,
                'hasFeedback' => $hasFeedback,
                'authId' => auth()->id()
            ])
        </div>

    </div>

@endsection
