@extends('layouts.admin')
@section('title', 'Courts')
@section('page-title', 'Courts')

@section('content')

    <div x-data="{
        f: { search: '', type: '', state: '' },
        loading: false,
        load() {
            this.loading = true;
            const qs = new URLSearchParams(
                Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== ''))
            ).toString();
            fetch('{{ route('admin.courts.index') }}' + (qs ? '?' + qs : ''), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(d => {
                    document.getElementById('courts-tbl').innerHTML = d.html;
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                    showToast('Filter failed', 'err');
                });
        },
        reset() {
            this.f = { search: '', type: '', state: '' };
            this.load();
        }
    }">

        {{-- ── FILTER BAR ────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-5 flex flex-wrap items-end gap-3">

            {{-- Search --}}
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Search</label>
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Court name…"
                        class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 w-48
                 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                </div>
            </div>

            {{-- Type --}}
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Type</label>
                <select x-model="f.type" @change="load()"
                    class="py-2 pl-3 pr-8 text-sm border border-slate-200 rounded-lg bg-slate-50
               focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                    <option value="">All Types</option>
                    <option value="supreme">Supreme Court</option>
                    <option value="high">High Court</option>
                    <option value="district">District Court</option>
                    <option value="session">Sessions Court</option>
                    <option value="civil">Civil Court</option>
                    <option value="criminal">Criminal Court</option>
                    <option value="family">Family Court</option>
                    <option value="consumer">Consumer Court</option>
                    <option value="tribunal">Tribunal</option>
                </select>
            </div>

            {{-- State --}}
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">State</label>
                <div class="relative">
                    <i class="bi bi-geo-alt absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="f.state" @input.debounce.400ms="load()" placeholder="State…"
                        class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 w-36
                 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                </div>
            </div>

            {{-- Reset --}}
            <button @click="reset()"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-slate-200
             rounded-lg hover:border-slate-400 bg-white text-slate-600 transition-all">
                <i class="bi bi-x-circle"></i> Reset
            </button>

            {{-- Spinner --}}
            <div x-show="loading" x-cloak class="flex items-center gap-2 text-sm text-slate-400 font-medium">
                <i class="bi bi-arrow-repeat spin text-gold"></i> Loading…
            </div>

            {{-- Add Court --}}
            <a href="{{ route('admin.courts.create') }}"
                class="ml-auto flex items-center gap-2 px-5 py-2.5 text-sm font-bold
             bg-gold hover:bg-gold-h text-navy rounded-lg transition-all shadow-sm shadow-gold/30">
                <i class="bi bi-plus-lg"></i> Add Court
            </a>
        </div>

        {{-- ── TABLE CARD ────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <div>
                    <h2 class="font-display font-bold text-[1.05rem] text-slate-800">All Courts</h2>
                    <p class="text-[0.76rem] text-slate-400 mt-0.5">Manage registered courts and tribunals.</p>
                </div>
            </div>
            <div id="courts-tbl" class="overflow-x-auto">
                @include('admin.partials.courts-table', ['courts' => $courts])
            </div>
        </div>

    </div>{{-- /x-data --}}

@endsection

@push('scripts')
    <script>
        function deactivateCourt(id, btn) {
            if (!confirm('Deactivate this court?')) return;
            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
            fetch('/admin/courts/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(d => {
                    showToast(d.message, 'err');
                    const row = btn.closest('tr');
                    if (row) {
                        row.style.transition = 'opacity .3s';
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 300);
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = orig;
                    showToast('Something went wrong!', 'err');
                });
        }
    </script>
@endpush
