@extends('layouts.admin')
@section('title', 'Court Maps Management')
@section('page-title', 'Court Maps')

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
        courtId: null,
        courtName: '',
        mapUrl: '',
        loading: false,
        f: { search: '' },
        tblLoading: false,

        load() {
            this.tblLoading = true;
            const qs = new URLSearchParams(
                Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== ''))
            ).toString();
            fetch('{{ route('admin.court-maps.index') }}' + (qs ? '?' + qs : ''), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(d => {
                    document.getElementById('courts-tbl').innerHTML = d.html;
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
        openUploadModal(id, name, currentMap) {
            this.courtId = id;
            this.courtName = name;
            this.mapUrl = currentMap;
            this.modalOpen = true;
            this.loading = false;
            const fileInput = document.getElementById('map_file');
            if (fileInput) fileInput.value = '';
        },
        submitUpload() {
            const app = this;
            const fileInput = document.getElementById('map_file');
            if (!fileInput || !fileInput.files.length) {
                showToast('Please select a PDF file first.', 'err');
                return;
            }

            app.loading = true;
            const formData = new FormData();
            formData.append('map_file', fileInput.files[0]);

            fetch(`/admin/court-maps/${app.courtId}/upload`, {
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
                    showToast(d.message || 'Upload failed.', 'err');
                }
            })
            .catch(() => {
                app.loading = false;
                showToast('An error occurred during file upload.', 'err');
            });
        }
    }">

        {{-- ── HEADER ────────────────────────────────────────── --}}
        <div class="mb-8 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Court Maps Directory</h2>
                <p class="text-[0.65rem] text-white/40 font-bold uppercase tracking-[0.2em] mt-1">
                    Upload and manage PDF layout maps for registered judicial institutions
                </p>
            </div>
        </div>

        {{-- ── FILTER BAR ────────────────────────────────────────── --}}
        <div class="bg-navy2 p-4 rounded-2xl border border-white/10 flex flex-wrap items-center gap-4 mb-6 shadow-2xl">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px] relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Search by name, city or area..."
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
            <div id="courts-tbl" class="overflow-x-auto min-h-[400px]">
                @include('admin.court-maps.partials.table', ['courts' => $courts])
            </div>
        </div>

        {{-- ── UPLOAD MODAL ───────────────────────────────────────── --}}
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-navy/80 backdrop-blur-sm" @click="modalOpen = false"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-navy2 border border-white/10 rounded-3xl w-full max-w-md p-8 shadow-2xl transition-all"
                 x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95">
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Upload Court Map</h3>
                    <button @click="modalOpen = false" class="text-white/40 hover:text-white transition-colors">
                        <i class="bi bi-x-lg text-lg"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    <span class="text-[0.65rem] text-blue font-bold uppercase tracking-widest block mb-1">Institution</span>
                    <div class="text-sm font-black text-white uppercase tracking-tight" x-text="courtName"></div>
                </div>

                <form @submit.prevent="submitUpload()">
                    <!-- Current Map info -->
                    <div x-show="mapUrl" class="mb-6 p-4 rounded-xl bg-blue/5 border border-blue/10 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue/10 flex items-center justify-center text-blue">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </div>
                            <div>
                                <div class="text-[0.6rem] text-white/40 font-bold uppercase tracking-widest">Current Map</div>
                                <a :href="mapUrl" target="_blank" class="text-xs font-bold text-blue hover:text-white underline">View Uploaded PDF</a>
                            </div>
                        </div>
                        <div class="text-[10px] text-red-400 font-bold uppercase tracking-widest bg-red-500/10 px-2.5 py-1 rounded border border-red-500/20">
                            Replaced
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <label for="map_file" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest mb-3">Select Map File (PDF Only, Max 10MB)</label>
                        <div class="relative">
                            <input type="file" id="map_file" name="map_file" accept=".pdf" required
                                   class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[0.65rem] file:font-black file:uppercase file:tracking-widest file:bg-blue/10 file:text-blue hover:file:bg-blue/20 file:cursor-pointer">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" @click="modalOpen = false"
                                class="px-5 py-3 rounded-xl bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white transition-all text-xs font-bold uppercase tracking-widest">
                            Cancel
                        </button>
                        <button type="submit" :disabled="loading"
                                class="px-6 py-3 bg-blue text-navy font-black rounded-xl hover:bg-white transition-all shadow-lg shadow-blue/20 text-xs uppercase tracking-widest flex items-center gap-2">
                            <span x-show="loading"><i class="bi bi-arrow-repeat spin"></i></span>
                            <span x-text="loading ? 'Uploading...' : 'Save Map'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- /x-data --}}

@endsection
