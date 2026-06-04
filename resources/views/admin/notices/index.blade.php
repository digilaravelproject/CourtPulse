@extends('layouts.admin')
@section('title', 'Notices & Circulars Management')
@section('page-title', 'Notices & Circulars')

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
        modalOpen: false,
        isEdit: false,
        noticeId: null,
        title: '',
        courtId: '',
        showNewBadge: false,
        currentPdfUrl: '',
        loading: false,
        f: { search: '' },
        tblLoading: false,

        load() {
            this.tblLoading = true;
            const qs = new URLSearchParams(
                Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== ''))
            ).toString();
            fetch('{{ route('admin.notices.index') }}' + (qs ? '?' + qs : ''), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(d => {
                    document.getElementById('notices-tbl').innerHTML = d.html;
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
        },
        openAddModal() {
            this.isEdit = false;
            this.noticeId = null;
            this.title = '';
            this.courtId = '';
            this.showNewBadge = false;
            this.currentPdfUrl = '';
            this.loading = false;
            this.modalOpen = true;
            const fileInput = document.getElementById('pdf_file');
            if (fileInput) fileInput.value = '';
        },
        openEditModal(id) {
            const app = this;
            app.loading = true;
            
            fetch('/admin/notices/' + id)
                .then(r => r.json())
                .then(d => {
                    app.loading = false;
                    if (d.success) {
                        app.isEdit = true;
                        app.noticeId = id;
                        app.title = d.notice.title;
                        app.courtId = d.notice.court_id || '';
                        app.showNewBadge = d.notice.show_new_badge;
                        app.currentPdfUrl = d.notice.pdf_url;
                        app.modalOpen = true;
                        
                        const fileInput = document.getElementById('pdf_file');
                        if (fileInput) fileInput.value = '';
                    } else {
                        showToast(d.message || 'Failed to load details.', 'err');
                    }
                })
                .catch(() => {
                    app.loading = false;
                    showToast('Network error loading notice details.', 'err');
                });
        },
        submitForm() {
            const app = this;
            
            if (!app.title.trim()) {
                showToast('Please enter a notice title.', 'err');
                return;
            }

            const fileInput = document.getElementById('pdf_file');
            if (!app.isEdit && (!fileInput || !fileInput.files.length)) {
                showToast('Please upload a PDF file for the notice.', 'err');
                return;
            }

            app.loading = true;
            const formData = new FormData();
            formData.append('title', app.title);
            formData.append('court_id', app.courtId);
            formData.append('show_new_badge', app.showNewBadge ? '1' : '0');
            
            if (fileInput && fileInput.files.length) {
                formData.append('pdf_file', fileInput.files[0]);
            }

            const url = app.isEdit ? `/admin/notices/${app.noticeId}/update` : '{{ route('admin.notices.store') }}';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(r => r.json())
            .then(d => {
                app.loading = false;
                if (d.success) {
                    showToast(d.message, 'ok');
                    app.modalOpen = false;
                    app.load();
                } else {
                    showToast(d.message || 'Saving failed.', 'err');
                }
            })
            .catch(() => {
                app.loading = false;
                showToast('An error occurred while saving the notice.', 'err');
            });
        },
        deleteNotice(id, btn) {
            if (!confirm('Are you sure you want to DELETE this notice? This action cannot be undone.')) return;

            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class=\'fas fa-spinner fa-spin text-xs\'></i>';

            fetch('/admin/notices/' + id, {
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
    }">

        {{-- ── HEADER ────────────────────────────────────────── --}}
        <div class="mb-8 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Circulars & Notices</h2>
                <p class="text-[0.65rem] text-white/40 font-bold uppercase tracking-[0.2em] mt-1">
                    Publish administrative circulars, guidelines and causelist updates
                </p>
            </div>

            <div class="flex items-center gap-3 w-full xl:w-auto">
                <button @click="openAddModal()"
                    class="flex-1 xl:flex-none flex items-center justify-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-blue text-navy rounded-xl hover:bg-white transition-all shadow-lg shadow-blue/20">
                    <i class="fas fa-plus text-sm"></i> Add New Notice
                </button>
            </div>
        </div>

        {{-- ── FILTER BAR ────────────────────────────────────────── --}}
        <div class="bg-navy2 p-4 rounded-2xl border border-white/10 flex flex-wrap items-center gap-4 mb-6 shadow-2xl">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px] relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Search by notice title or court name..."
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
            <div id="notices-tbl" class="overflow-x-auto min-h-[400px]">
                @include('admin.notices.partials.table', ['notices' => $notices])
            </div>
        </div>

        {{-- ── ADD / EDIT MODAL ───────────────────────────────────── --}}
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-navy/80 backdrop-blur-sm" @click="modalOpen = false"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-navy2 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl transition-all"
                 x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95">
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight" x-text="isEdit ? 'Edit Notice' : 'Add Notice'"></h3>
                    <button @click="modalOpen = false" class="text-white/40 hover:text-white transition-colors">
                        <i class="bi bi-x-lg text-lg"></i>
                    </button>
                </div>

                <form @submit.prevent="submitForm()">
                    {{-- Court Dropdown --}}
                    <div class="mb-6">
                        <label for="court_id" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest mb-2">Target Court (Optional)</label>
                        <select id="court_id" x-model="courtId"
                                class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none">
                            <option value="">General Notice / All Courts</option>
                            @foreach($courts as $court)
                                <option value="{{ $court->id }}">{{ $court->name }} ({{ $court->city }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Title (Max 150 Chars) --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <label for="title" class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Notice Title (Max 150 Characters)</label>
                            <span class="text-[0.6rem] font-bold tracking-widest font-mono text-white/40" 
                                  :class="{'text-red-400 font-extrabold': title.length >= 150}" 
                                  x-text="title.length + ' / 150'"></span>
                        </div>
                        <textarea id="title" x-model="title" maxlength="150" required rows="3"
                                  placeholder="Enter notice title (e.g. Circular regarding e-filing implementation...)"
                                  class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none leading-relaxed resize-none"></textarea>
                    </div>

                    {{-- PDF file upload --}}
                    <div class="mb-6">
                        <label for="pdf_file" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest mb-2" 
                               x-text="isEdit ? 'Replace PDF Document (Optional)' : 'Upload PDF Document (Required)'"></label>
                        <div class="relative">
                            <input type="file" id="pdf_file" accept=".pdf" :required="!isEdit"
                                   class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[0.65rem] file:font-black file:uppercase file:tracking-widest file:bg-blue/10 file:text-blue hover:file:bg-blue/20 file:cursor-pointer">
                        </div>

                        <!-- Current PDF preview -->
                        <div x-show="isEdit && currentPdfUrl" class="mt-3 p-3 rounded-lg bg-blue/5 border border-blue/10 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-file-earmark-pdf-fill text-blue text-base"></i>
                                <a :href="currentPdfUrl" target="_blank" class="text-xs font-bold text-blue hover:text-white underline">View Uploaded PDF</a>
                            </div>
                            <span class="text-[9px] text-white/30 font-bold uppercase tracking-wider">Kept unless replaced</span>
                        </div>
                    </div>

                    {{-- Toggle show new badge --}}
                    <div class="mb-8 p-4 bg-white/[0.02] border border-white/5 rounded-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs font-black text-white uppercase tracking-tight block">Show "New" Badge</span>
                            <span class="text-[0.6rem] text-white/40 font-bold uppercase tracking-widest mt-0.5 block">Display a prominent tag next to notice</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="showNewBadge" class="sr-only peer">
                            <div class="w-11 h-6 bg-navy rounded-full border border-white/10 peer peer-focus:ring-0 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white/40 peer-checked:after:bg-blue after:border-white/20 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue/25 peer-checked:border-blue/30"></div>
                        </label>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" @click="modalOpen = false"
                                class="px-5 py-3 rounded-xl bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white transition-all text-xs font-bold uppercase tracking-widest">
                            Cancel
                        </button>
                        <button type="submit" :disabled="loading"
                                class="px-6 py-3 bg-blue text-navy font-black rounded-xl hover:bg-white transition-all shadow-lg shadow-blue/20 text-xs uppercase tracking-widest flex items-center gap-2">
                            <span x-show="loading"><i class="bi bi-arrow-repeat spin"></i></span>
                            <span x-text="loading ? 'Saving...' : 'Save Notice'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- /x-data --}}

@endsection
