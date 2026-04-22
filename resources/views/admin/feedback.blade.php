@extends('layouts.admin')
@section('title', 'Feedback')
@section('page-title', 'Feedback Logs')

@section('content')

    <div x-data="filterTable('{{ route('admin.feedback') }}', 'fb-tbl', { rating: '' })" x-init="">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-5 flex flex-wrap items-end gap-3">
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Rating</label>
                <select x-model="f.rating" @change="load()"
                    class="py-2 pl-3 pr-8 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                    <option value="">All Ratings</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
            <button @click="reset()"
                class="ml-auto flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-slate-200 rounded-lg hover:border-slate-400 bg-white text-slate-600 transition-all">
                <i class="bi bi-x-circle"></i> Reset
            </button>
            <div x-show="loading" x-cloak class="flex items-center gap-2 text-sm text-slate-400">
                <i class="bi bi-arrow-repeat spin text-gold"></i> Loading…
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-display font-bold text-[1.05rem] text-slate-800">All Feedback</h2>
            </div>
            <div id="fb-tbl" class="overflow-x-auto min-h-[100px]">
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
                            showToast('Filter Failed', 'err');
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
