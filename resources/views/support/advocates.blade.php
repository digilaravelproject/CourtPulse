@extends('layouts.clerk')
@section('title', 'View Advocates')
@section('page-title', 'View Advocates')
@section('content')

    @php $hasFeedback = \App\Http\Controllers\FeedbackController::clerkHasFeedback(auth()->id()); @endphp

    <div class="mb-6">
        <h2 class="font-display font-bold text-slate-800 text-2xl">View Advocates</h2>
        <p class="text-slate-400 text-sm mt-1">Search and connect with verified advocates.</p>
    </div>

    {{-- Locked Banner --}}
    @if (!$hasFeedback)
        <div class="flex items-center gap-4 p-4 mb-6 rounded-2xl border border-red-200 bg-red-50 flex-wrap">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-red-100 flex-shrink-0">
                <i class="bi bi-lock-fill text-red-500"></i>
            </div>
            <div class="flex-1">
                <div class="font-semibold text-red-700 text-sm">Contact Details Locked</div>
                <div class="text-slate-500 text-xs mt-0.5">Submit compulsory feedback to unlock advocate contacts.</div>
            </div>
            <a href="{{ route('feedback') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all flex-shrink-0"
                style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                onmouseout="this.style.background='#D4AF37'">
                Give Feedback →
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

        <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-5">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block font-mono text-xs tracking-widest uppercase text-slate-400 mb-1.5">Name</label>
                    <input type="text" x-model="f.search" @input.debounce.400ms="doSearch()"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700
                           focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition"
                        placeholder="Advocate name...">
                </div>
                <div>
                    <label class="block font-mono text-xs tracking-widest uppercase text-slate-400 mb-1.5">High
                        Court</label>
                    <input type="text" x-model="f.high_court" @input.debounce.400ms="doSearch()"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700
                           focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition"
                        placeholder="e.g. Bombay High Court">
                </div>
                <div>
                    <label class="block font-mono text-xs tracking-widest uppercase text-slate-400 mb-1.5">City</label>
                    <input type="text" x-model="f.city" @input.debounce.400ms="doSearch()"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700
                           focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition"
                        placeholder="City...">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button @click="doSearch()"
                    class="flex items-center gap-2 px-5 py-2 rounded-xl text-sm font-bold transition-all"
                    style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                    onmouseout="this.style.background='#D4AF37'">
                    <i class="bi bi-search"></i> Search
                </button>
                <button @click="reset()"
                    class="flex items-center gap-2 px-5 py-2 rounded-xl text-sm font-semibold border border-slate-200
                       text-slate-600 hover:border-slate-300 bg-white transition-all">
                    <i class="bi bi-x-lg"></i> Clear
                </button>
                <div x-show="loading" class="flex items-center gap-2 text-sm text-slate-400">
                    <svg class="animate-spin w-4 h-4 text-[#D4AF37]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Searching...
                </div>
            </div>
        </div>

        {{-- Results Grid --}}
        <div id="advocateGrid">
            @include('clerk.partials.advocate-list', [
                'advocates' => $advocates,
                'hasFeedback' => $hasFeedback,
            ])
        </div>

    </div>

@endsection
