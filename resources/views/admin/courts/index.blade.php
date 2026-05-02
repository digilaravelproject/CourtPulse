@extends('layouts.admin')
@section('title', 'Courts Management')

@section('content')

    {{-- Custom Table Styles --}}
    <style>
        .cp-table { width: 100%; border-collapse: collapse; }
        .cp-table thead th {
            background-color: rgba(255, 255, 255, 0.02) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.5) !important;
            font-weight: 900 !important;
            font-size: 0.65rem !important;
            letter-spacing: 0.2em !important;
            padding: 1.25rem 1.5rem !important;
            text-transform: uppercase;
        }
        .cp-table tbody td {
            padding: 1.25rem 1.5rem !important;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .cp-table tbody tr { transition: background-color 0.2s ease; }
        .cp-table tbody tr:hover { background-color: rgba(255, 255, 255, 0.03); }
    </style>

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

        {{-- ── HEADER & ACTIONS ────────────────────────────────────── --}}
        <div class="mb-8 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Court Directory</h2>
                <p class="text-[0.65rem] text-white/40 font-bold uppercase tracking-[0.2em] mt-1">
                    Database of Judicial Institutions & Jurisdictions
                </p>
            </div>

            <div class="flex items-center gap-3 w-full xl:w-auto">
                <a href="{{ route('admin.courts.create') }}"
                    class="flex-1 xl:flex-none flex items-center justify-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-blue text-navy rounded-xl hover:bg-white transition-all shadow-lg shadow-blue/20">
                    <i class="fas fa-plus text-sm"></i> Add New Institution
                </a>
            </div>
        </div>

        {{-- ── FILTER BAR ────────────────────────────────────────── --}}
        <div class="bg-navy2 p-4 rounded-2xl border border-white/10 flex flex-wrap items-center gap-4 mb-6 shadow-2xl">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px] relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Search by name..."
                    class="w-full bg-navy border-white/5 pl-11 pr-4 py-2.5 rounded-xl text-xs font-bold text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none">
            </div>

            {{-- Type Filter --}}
            <div class="w-full md:w-48 relative">
                <select x-model="f.type" @change="load()"
                    class="w-full bg-navy border-white/5 px-4 py-2.5 rounded-xl text-xs font-bold text-white appearance-none focus:ring-1 focus:ring-blue/50 outline-none cursor-pointer">
                    <option value="">All Categories</option>
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
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/20 pointer-events-none text-[0.6rem]"></i>
            </div>

            {{-- State Filter --}}
            <div class="w-full md:w-48 relative">
                <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" x-model="f.state" @input.debounce.400ms="load()" placeholder="Filter by State..."
                    class="w-full bg-navy border-white/5 pl-10 pr-4 py-2.5 rounded-xl text-xs font-bold text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 transition-all outline-none">
            </div>

            {{-- Reset --}}
            <button @click="reset()"
                class="px-5 py-2.5 rounded-xl bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white transition-all text-[0.6rem] font-black uppercase tracking-widest">
                <i class="fas fa-sync-alt mr-1.5"></i> Reset
            </button>

            {{-- Loading Indicator --}}
            <div x-show="loading" x-cloak class="ml-2">
                <i class="fas fa-spinner fa-spin text-blue text-sm"></i>
            </div>
        </div>

        {{-- ── TABLE CONTAINER ────────────────────────────────────── --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div id="courts-tbl" class="overflow-x-auto min-h-[400px]">
                @include('admin.partials.courts-table', ['courts' => $courts])
            </div>
        </div>

    </div>{{-- /x-data --}}

@endsection

@push('scripts')
    <script>
        function toggleStatus(id, btn) {
            const isLive = btn.innerText.toLowerCase().includes('live');
            if (!confirm(`Are you sure you want to ${isLive ? 'disable' : 'activate'} this institution?`)) return;
            
            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>';

            fetch(`/admin/courts/${id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        showToast(d.message, 'ok');
                        setTimeout(() => window.location.reload(), 600);
                    } else {
                        showToast(d.message || 'Error toggling status', 'err');
                        btn.disabled = false;
                        btn.innerHTML = orig;
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = orig;
                    showToast('Something went wrong!', 'err');
                });
        }

        function deleteCourt(id, btn) {
            if (!confirm('PERMANENTLY DELETE this court? This action cannot be undone.')) return;
            
            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

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
                    if (d.success) {
                        showToast(d.message, 'ok');
                        const row = btn.closest('tr');
                        if (row) {
                            row.style.transition = 'all .4s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'scale(0.95)';
                            setTimeout(() => row.remove(), 400);
                        }
                    } else {
                        showToast(d.message || 'Delete failed', 'err');
                        btn.disabled = false;
                        btn.innerHTML = orig;
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = orig;
                    showToast('Network error occurred!', 'err');
                });
        }
    </script>
@endpush

