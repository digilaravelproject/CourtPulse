@extends('layouts.admin')
@section('title', 'Feedback')
@section('page-title', 'Feedback Logs')

@section('content')

    <div x-data="filterTable('{{ route('admin.feedback') }}', 'fb-tbl', { rating: '' })" x-init="init()">

        {{-- Filter Bar --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 mb-8 flex flex-col md:flex-row flex-wrap items-end gap-6 transition-all">

            {{-- Rating Filter --}}
            <div class="flex flex-col w-full md:w-72 flex-grow md:flex-grow-0">
                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2 pl-1">Filter by Rating</label>
                <div class="relative">
                    <i class="fas fa-star absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                    <select x-model="f.rating" @change="load()"
                        class="w-full pl-11 pr-10 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold appearance-none focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner relative z-0 cursor-pointer">
                        <option value="">All Ratings</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none z-10"></i>
                </div>
            </div>

            {{-- Actions (Reset & Loader) --}}
            <div class="flex items-center gap-6 ml-auto w-full md:w-auto justify-between md:justify-end mt-4 md:mt-0">
                {{-- Loading indicator --}}
                <div x-show="loading" x-cloak
                    class="flex items-center gap-3 text-xs font-black uppercase tracking-widest text-blue">
                    <i class="fas fa-spinner fa-spin text-lg"></i> Loading...
                </div>

                {{-- Reset --}}
                <button @click="reset()"
                    class="flex items-center justify-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all shadow-lg ml-auto focus:outline-none">
                    <i class="fas fa-undo text-sm"></i> Reset Filters
                </button>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div class="p-8 border-b border-white/5 bg-white/5 flex items-center justify-between">
                <h2 class="font-black text-base text-white uppercase tracking-widest">All Feedback</h2>
            </div>

            <div id="fb-tbl" class="overflow-x-auto min-h-[400px]">
                {{-- The partial included here should use Tailwind utility classes directly on table elements --}}
                @include('admin.partials.feedback-table', ['feedbacks' => $feedbacks])
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function filterTable(url, targetId, defaults) {
            return {
                f: {
                    ...defaults
                },
                loading: false,
                init() {
                    // Initialization logic if any
                },
                load() {
                    this.loading = true;
                    const qs = new URLSearchParams(Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== '')))
                        .toString();
                    fetch(url + (qs ? '?' + qs : ''), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(r => r.json())
                        .then(d => {
                            document.getElementById(targetId).innerHTML = d.html;
                            this.loading = false;
                        })
                        .catch(() => {
                            this.loading = false;
                            if (typeof showToast === 'function') {
                                showToast('Filter Failed', 'err');
                            } else {
                                alert('Failed to filter data.');
                            }
                        });
                },
                reset() {
                    this.f = {
                        ...defaults
                    };
                    this.load();
                }
            };
        }
    </script>
@endpush
