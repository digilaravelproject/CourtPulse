@extends('layouts.advocate')
@section('title', 'Search Clerks')
@section('page-title', 'Search Clerks')

@section('content')

<div x-data="{
    f: {
        search: '{{ request('search', '') }}',
        city: '{{ request('city', '') }}',
        court: '{{ request('court', '') }}'
    },
    loading: false,
    doSearch() {
        this.loading = true;
        const qs = new URLSearchParams(this.f).toString();
        fetch('{{ route('advocate.search.clerks') }}?' + qs, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(d => {
                if (d.html) { 
                    document.getElementById('clerksGrid').innerHTML = d.html;
                    // Re-run any needed scripts if necessary
                }
                this.loading = false;
            })
            .catch(() => { this.loading = false; });
    },
    reset() {
        this.f = { search: '', city: '', court: '' };
        this.doSearch();
    }
}" class="max-w-7xl mx-auto">

    <!-- Search Header Card -->
    <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden mb-8">
        <div class="p-6 md:p-8 bg-white/5 border-b border-white/5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-white uppercase tracking-[0.2em]">Find Skilled Clerks</h2>
                    <p class="text-white/40 text-xs font-bold mt-1 uppercase tracking-wider">Connect with verified legal support professionals</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue shadow-inner">
                        <i class="fas fa-users-viewfinder"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Name Search -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest block pl-1">Clerk Name</label>
                    <div class="relative group">
                        <i class="fas fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue transition-colors text-sm"></i>
                        <input type="text" x-model="f.search" @keydown.enter.prevent="doSearch()"
                            placeholder="Enter name..."
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/10 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                    </div>
                </div>

                <!-- City Search -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest block pl-1">Court City</label>
                    <div class="relative group">
                        <i class="fas fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue transition-colors text-sm"></i>
                        <input type="text" x-model="f.city" @keydown.enter.prevent="doSearch()"
                            placeholder="e.g. Mumbai..."
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/10 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                    </div>
                </div>

                <!-- Court Search -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest block pl-1">Specific Court</label>
                    <div class="relative group">
                        <i class="fas fa-landmark absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue transition-colors text-sm"></i>
                        <input type="text" x-model="f.court" @keydown.enter.prevent="doSearch()"
                            placeholder="e.g. High Court..."
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/10 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <button type="button" @click="doSearch()" 
                    class="w-full sm:w-auto flex items-center justify-center gap-3 px-10 py-4 rounded-xl text-xs font-black text-navy uppercase tracking-[0.2em] bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_10px_25px_rgba(180,180,254,0.3)]">
                    <span x-show="!loading" class="flex items-center gap-2">
                        <i class="fas fa-bolt-lightning text-xs"></i> Search Clerks
                    </span>
                    <span x-show="loading" x-cloak class="flex items-center gap-2">
                        <i class="fas fa-circle-notch fa-spin text-xs"></i> Processing...
                    </span>
                </button>

                <button type="button" @click="reset()" 
                    class="w-full sm:w-auto px-8 py-4 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/50 hover:text-white transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-trash-can text-[10px]"></i> Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div id="clerksGrid" class="transition-all duration-500" :class="{ 'opacity-50 pointer-events-none': loading }">
        @include('advocate.partials.clerk-list', ['clerks' => $clerks])
    </div>

</div>

@endsection