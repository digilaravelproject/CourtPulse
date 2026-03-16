@extends('layouts.admin')
@section('title', 'Documents')
@section('page-title', 'Documents')

@section('content')

    <div x-data="filterTable('{{ route('admin.documents') }}', 'doc-tbl', { search: '', status: '', document_type: '' })" x-init="">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-5 flex flex-wrap items-end gap-3">
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Search User</label>
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="User name…"
                        class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 w-48 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Status</label>
                <select x-model="f.status" @change="load()"
                    class="py-2 pl-3 pr-8 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Type</label>
                <select x-model="f.document_type" @change="load()"
                    class="py-2 pl-3 pr-8 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                    <option value="">All Types</option>
                    <option value="bar_council_certificate">Bar Council Cert</option>
                    <option value="enrollment_certificate">Enrollment Cert</option>
                    <option value="degree_certificate">Degree Cert</option>
                    <option value="aadhar_card">Aadhar Card</option>
                    <option value="pan_card">PAN Card</option>
                    <option value="practice_certificate">Practice Cert</option>
                    <option value="court_id_card">Court ID Card</option>
                    <option value="clerk_appointment_letter">Appointment Letter</option>
                    <option value="ca_membership_certificate">CA Membership</option>
                    <option value="icai_certificate">ICAI Certificate</option>
                    <option value="profile_photo">Profile Photo</option>
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
                <h2 class="font-display font-bold text-[1.05rem] text-slate-800">All Documents</h2>
            </div>
            <div id="doc-tbl" class="overflow-x-auto min-h-[100px]">
                @include('admin.partials.documents-table', ['documents' => $documents])
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
                            showToast('Filter failed', 'err');
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
