@extends('layouts.admin')
@section('title', 'Feedback')
@section('page-title', 'Feedback Logs')

@section('content')

    {{-- Custom Table Styles for Spacing and Readability --}}
    <style>
        .cp-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cp-table thead th {
            background-color: rgba(255, 255, 255, 0.02) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.5) !important;
            font-weight: 900 !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.15em !important;
            padding: 1.25rem 1.5rem !important;
            text-transform: uppercase;
        }

        .cp-table tbody td {
            padding: 1.25rem 1.5rem !important;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .cp-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .cp-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }
    </style>

    <div x-data="filterTable('{{ route('admin.feedback') }}', 'fb-tbl', { rating: '' })" x-init="init()">

        {{-- Filter Bar --}}
        <div
            class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 mb-10 flex flex-col md:flex-row flex-wrap items-end gap-6 transition-all">

            {{-- Rating Filter --}}
            <div class="flex flex-col gap-3 w-full sm:w-64 flex-grow md:flex-grow-0">
                <label class="font-black text-xs uppercase tracking-widest text-white/50 pl-1">Filter by Rating</label>
                <div class="relative">
                    <select x-model="f.rating" @change="load()"
                        class="w-full pl-5 pr-12 py-4 text-sm border border-white/10 rounded-2xl bg-navy text-white focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors appearance-none shadow-inner cursor-pointer">
                        <option value="">All Ratings</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                    <i
                        class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-white/30 text-sm pointer-events-none"></i>
                </div>
            </div>

            {{-- Actions (Reset & Loader) --}}
            <div class="flex items-center gap-6 ml-auto w-full md:w-auto justify-between md:justify-end">
                {{-- Loading indicator --}}
                <div x-show="loading" x-cloak
                    class="flex items-center gap-3 text-sm font-black uppercase tracking-widest text-blue">
                    <i class="fas fa-spinner fa-spin text-lg"></i> Loading...
                </div>

                {{-- Reset --}}
                <button @click="reset()"
                    class="flex items-center justify-center gap-2 px-8 py-4 text-xs font-black uppercase tracking-widest border border-white/10 rounded-2xl hover:bg-white/5 text-white/70 hover:text-white transition-all shadow-lg ml-auto focus:outline-none">
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
                {{-- The partial included here should ideally use the .cp-table class structure to match the styling --}}
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