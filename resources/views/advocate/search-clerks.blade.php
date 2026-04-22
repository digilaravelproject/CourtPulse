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
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(d => {
                    if (d.html) {
                        document.getElementById('clerksGrid').innerHTML = d.html;
                    }
                    this.loading = false;
                })
                .catch(() => { this.loading = false; });
        },
        reset() {
            this.f = { search: '', city: '', court: '' };
            this.doSearch();
        }
    }">

        {{-- Search Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">

                <div>
                    <label class="block font-mono text-[.62rem] tracking-wider uppercase text-slate-400 mb-1.5">Clerk
                        Name</label>
                    <div class="relative">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" x-model="f.search" @keydown.enter.prevent="doSearch()"
                            placeholder="Search by name..."
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 text-sm
                                   focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                    </div>
                </div>

                <div>
                    <label class="block font-mono text-[.62rem] tracking-wider uppercase text-slate-400 mb-1.5">Court
                        City</label>
                    <div class="relative">
                        <i class="bi bi-geo-alt absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" x-model="f.city" @keydown.enter.prevent="doSearch()"
                            placeholder="e.g. Mumbai, Delhi..."
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 text-sm
                                   focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                    </div>
                </div>

                <div>
                    <label class="block font-mono text-[.62rem] tracking-wider uppercase text-slate-400 mb-1.5">Court
                        Name</label>
                    <div class="relative">
                        <i class="bi bi-building absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" x-model="f.court" @keydown.enter.prevent="doSearch()"
                            placeholder="e.g. High Court..."
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 text-sm
                                   focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" @click="doSearch()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                    style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                    onmouseout="this.style.background='#D4AF37'">
                    <span x-show="!loading"><i class="bi bi-search mr-1"></i> Search</span>
                    <span x-show="loading" x-cloak><i class="bi bi-arrow-repeat spin"></i> Searching…</span>
                </button>
                <button type="button" @click="reset()"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border border-slate-200 text-slate-500 hover:border-slate-400 hover:text-slate-700 transition-all bg-white">
                    <i class="bi bi-x-lg"></i> Clear
                </button>
            </div>
        </div>

        {{-- Results Area --}}
        <div id="clerksGrid">
            {{-- This partial file is used for both initial load and AJAX requests --}}
            @include('advocate.partials.clerk-list', ['clerks' => $clerks])
        </div>

    </div>

@endsection
