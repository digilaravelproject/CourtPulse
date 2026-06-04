@extends('layouts.admin')
@section('title', 'Blogs Management')
@section('page-title', 'Blogs')

@section('content')

    {{-- Custom Table Styles --}}
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

        .cp-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .cp-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }
    </style>

    <div x-data="{
        f: { search: '' },
        tblLoading: false,

        load() {
            this.tblLoading = true;
            const qs = new URLSearchParams(
                Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== ''))
            ).toString();
            fetch('{{ route('admin.blogs.index') }}' + (qs ? '?' + qs : ''), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(d => {
                    document.getElementById('blogs-tbl').innerHTML = d.html;
                    this.tblLoading = false;
                })
                .catch(() => {
                    this.tblLoading = false;
                    showToast('Filter failed', 'err');
                });
        },
        reset() {
            this.f = { search: '' };
            this.load();
        }
    }">

        {{-- ── HEADER ────────────────────────────────────────── --}}
        <div class="mb-8 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Blog Articles</h2>
                <p class="text-[0.65rem] text-white/40 font-bold uppercase tracking-[0.2em] mt-1">
                    Manage DockIt Journal editorial content and legal articles
                </p>
            </div>

            <div class="flex items-center gap-3 w-full xl:w-auto">
                <a href="{{ route('admin.blogs.create') }}"
                    class="flex-1 xl:flex-none flex items-center justify-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-blue text-navy rounded-xl hover:bg-white transition-all shadow-lg shadow-blue/20">
                    <i class="fas fa-plus text-sm"></i> Write Article
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-blue/10 border border-blue/20 rounded-xl text-blue text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── FILTER BAR ────────────────────────────────────────── --}}
        <div class="bg-navy2 p-4 rounded-2xl border border-white/10 flex flex-wrap items-center gap-4 mb-6 shadow-2xl">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px] relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Search by title or category..."
                    class="w-full bg-navy border-white/5 pl-11 pr-4 py-2.5 rounded-xl text-xs font-bold text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none">
            </div>

            {{-- Reset --}}
            <button @click="reset()"
                class="px-5 py-2.5 rounded-xl bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white transition-all text-[0.6rem] font-black uppercase tracking-widest">
                <i class="fas fa-sync-alt mr-1.5"></i> Reset
            </button>

            {{-- Loading Indicator --}}
            <div x-show="tblLoading" x-cloak class="ml-2">
                <i class="fas fa-spinner fa-spin text-blue text-sm"></i>
            </div>
        </div>

        {{-- ── TABLE CONTAINER ────────────────────────────────────── --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div id="blogs-tbl" class="overflow-x-auto min-h-[400px]">
                @include('admin.blogs.partials.table', ['blogs' => $blogs])
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    function deleteBlog(id, btn) {
        if (!confirm('Are you sure you want to permanently DELETE this blog post? This action cannot be undone.')) return;

        btn.disabled = true;
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';

        fetch('/admin/blogs/' + id, {
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
            showToast('Network error occurred during delete.', 'err');
        });
    }
</script>
@endpush
