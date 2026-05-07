@extends('layouts.admin')
@section('title', 'Feedback')
@section('page-title', 'Feedback Logs')

@section('content')
{{-- Main Wrapper with horizontal padding --}}
<div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-10 py-10"
     x-data="filterTable('{{ route('admin.feedback') }}', 'fb-tbl', { rating: '' })"
     x-init="init()">

    {{-- Header Section: Title and Count --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Customer Feedback</h1>
            <p class="text-white/40 text-sm font-medium mt-1 uppercase tracking-widest">Manage and review user ratings</p>
        </div>

        {{-- Quick Stats / Loading Indicator --}}
        <div x-show="loading" x-cloak x-transition.opacity
             class="flex items-center gap-3 bg-blue/10 border border-blue/20 px-6 py-3 rounded-2xl text-blue text-xs font-black uppercase tracking-widest">
            <i class="fas fa-circle-notch fa-spin"></i>
            Syncing Data...
        </div>
    </div>

    {{-- Filter Bar: Enhanced Spacing and Glassmorphism --}}
    <div class="bg-navy2 rounded-[2.5rem] border border-white/5 shadow-2xl p-8 md:p-12 mb-10 relative overflow-hidden group">
        {{-- Subtle decorative background glow --}}
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue/5 blur-[100px] rounded-full"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-10">

            {{-- Rating Filter --}}
            <div class="w-full md:max-w-md">
                <label class="block text-[11px] font-black text-white/40 uppercase tracking-[0.25em] mb-4 ml-1">
                    Sort by Star Rating
                </label>
                <div class="relative group/select">
                    <div class="absolute left-5 top-1/2 -translate-y-1/2 text-white/20 group-focus-within/select:text-blue transition-colors duration-300">
                        <i class="fas fa-star text-sm"></i>
                    </div>
                    <select x-model="f.rating" @change="load()"
                        class="w-full pl-14 pr-12 py-5 bg-navy border border-white/10 rounded-2xl text-white text-sm font-bold appearance-none focus:outline-none focus:border-blue/50 focus:ring-4 focus:ring-blue/10 transition-all cursor-pointer shadow-2xl shadow-black/20">
                        <option value="">All Feedback Scores</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }} Rating</option>
                        @endfor
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-white/20 pointer-events-none group-hover/select:translate-y-[-40%] transition-transform">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Reset Action --}}
            <div class="flex items-center justify-end w-full md:w-auto">
                <button @click="reset()"
                    class="group flex items-center justify-center gap-3 px-12 py-5 text-xs font-black uppercase tracking-[0.15em] border border-white/10 rounded-2xl hover:bg-white/[0.03] text-white/50 hover:text-white transition-all shadow-xl active:scale-95 focus:outline-none">
                    <i class="fas fa-sync-alt opacity-50 group-hover:rotate-180 transition-transform duration-500"></i>
                    Reset All Filters
                </button>
            </div>
        </div>
    </div>

    {{-- Table Container: Better Padding and Separation --}}
    <div class="bg-navy2 rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden flex flex-col">
        <div class="px-10 py-8 border-b border-white/5 bg-white/[0.01] flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue/10 flex items-center justify-center text-blue shadow-inner">
                    <i class="fas fa-list-ul text-lg"></i>
                </div>
                <h2 class="font-black text-lg text-white uppercase tracking-widest">Detailed Logs</h2>
            </div>
        </div>

        <div id="fb-tbl" class="overflow-x-auto min-h-[450px]">
            {{-- This partial should contain the <table> with px-10 on <td> for proper spacing --}}
            @include('admin.partials.feedback-table', ['feedbacks' => $feedbacks])
        </div>
    </div>
</div>

<style>
    /* Hide scrollbars for cleaner look but keep functionality */
    .overflow-x-auto::-webkit-scrollbar { height: 6px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    [x-cloak] { display: none !important; }
</style>
@endsection

@push('scripts')
<script>
    function filterTable(url, targetId, defaults) {
        return {
            f: { ...defaults },
            loading: false,
            init() {
                // Initial load logic if needed
            },
            load() {
                this.loading = true;
                const qs = new URLSearchParams(
                    Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== ''))
                ).toString();

                fetch(url + (qs ? '?' + qs : ''), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(d => {
                    const container = document.getElementById(targetId);
                    // Subtle fade out/in effect for the table content
                    container.style.opacity = '0';
                    setTimeout(() => {
                        container.innerHTML = d.html;
                        container.style.opacity = '1';
                        this.loading = false;
                    }, 150);
                })
                .catch(() => {
                    this.loading = false;
                    if (typeof showToast === 'function') {
                        showToast('Error loading data', 'err');
                    } else {
                        alert('Error updating table.');
                    }
                });
            },
            reset() {
                this.f = { ...defaults };
                this.load();
            }
        };
    }
</script>
@endpush
