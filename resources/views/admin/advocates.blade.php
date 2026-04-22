@extends('layouts.admin')
@section('title', 'Advocates')
@section('page-title', 'Advocates')

@section('content')

    <div x-data="{
        f: { search: '', status: '' },
        loading: false,
        load() {
            this.loading = true;
            const qs = new URLSearchParams(Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== ''))).toString();
            fetch('{{ route('admin.advocates') }}' + (qs ? '?' + qs : ''), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(d => {
                    document.getElementById('adv-tbl').innerHTML = d.html;
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                    showToast('Filter Failed', 'err');
                });
        },
        reset() {
            this.f = { search: '', status: '' };
            this.load();
        }
    }">

        {{-- Filter Bar --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-5 flex flex-wrap items-end gap-3">
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Search</label>
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Name or email…"
                        class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50
                 w-52 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Status</label>
                <select x-model="f.status" @change="load()"
                    class="py-2 pl-3 pr-8 text-sm border border-slate-200 rounded-lg bg-slate-50
               focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <button @click="reset()"
                class="ml-auto flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-slate-200
             rounded-lg hover:border-slate-400 bg-white text-slate-600 transition-all">
                <i class="bi bi-x-circle"></i> Reset
            </button>
            <div x-show="loading" x-cloak class="flex items-center gap-2 text-sm text-slate-400 font-medium">
                <i class="bi bi-arrow-repeat spin text-gold"></i> Loading…
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="font-display font-bold text-[1.05rem] text-slate-800">All Advocates</h2>
            </div>
            <div id="adv-tbl" class="overflow-x-auto">
                @include('admin.partials.advocates-table', ['advocates' => $advocates])
            </div>
        </div>

    </div>{{-- /x-data --}}

    @include('admin.partials.verify-reject-modals')

@endsection

@push('scripts')
    <script>
        let _uid = null,
            _uname = null;
        const RPILL = {
            advocate: 'bg-blue-100 text-blue-700',
            clerk: 'bg-purple-100 text-purple-700',
            ca: 'bg-amber-100 text-amber-700',
            guest: 'bg-slate-100 text-slate-600',
            admin: 'bg-orange-100 text-orange-700'
        };

        function openVerify(id, name, role, email, phone, date, city) {
            _uid = id;
            _uname = name;
            document.getElementById('v_avatar').textContent = name.substring(0, 2).toUpperCase();
            document.getElementById('v_name').textContent = name;
            document.getElementById('v_email').textContent = email;
            document.getElementById('v_phone').textContent = phone || '—';
            document.getElementById('v_date').textContent = date;
            document.getElementById('v_city').textContent = city || '—';
            const p = document.getElementById('v_rpill');
            p.textContent = role;
            p.className =
                `inline-block mt-1 text-[0.6rem] font-semibold px-2.5 py-0.5 rounded font-mono uppercase tracking-wide ${RPILL[role]||'bg-slate-100 text-slate-600'}`;
            const btn = document.getElementById('vConfirmBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Confirm Verify';
            document.getElementById('vOverlay').classList.remove('hidden');
            const m = document.getElementById('vModal');
            m.classList.remove('hidden');
            m.classList.add('modal-pop');
        }

        function openReject(id, name) {
            _uid = id;
            _uname = name;
            document.getElementById('r_sub').textContent = `Confirm rejection for "${name}"`;
            const btn = document.getElementById('rConfirmBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
            document.getElementById('vOverlay').classList.remove('hidden');
            const m = document.getElementById('rModal');
            m.classList.remove('hidden');
            m.classList.add('modal-pop');
        }

        function closeModal() {
            ['vModal', 'rModal'].forEach(id => {
                const m = document.getElementById(id);
                if (m) {
                    m.classList.add('hidden');
                    m.classList.remove('modal-pop');
                }
            });
            document.getElementById('vOverlay').classList.add('hidden');
            _uid = _uname = null;
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });

        function doVerify() {
            const btn = document.getElementById('vConfirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Verifying…';
            fetch(`/admin/users/${_uid}/verify`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json()).then(() => {
                    const n = _uname;
                    closeModal();
                    showToast(`${n} Verified!`, 'ok');
                    document.querySelectorAll(`[data-uid="${_uid}"]`).forEach(r => {
                        r.style.transition = 'opacity .3s';
                        r.style.opacity = '0';
                        setTimeout(() => r.remove(), 300);
                    });
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-check-lg"></i> Confirm Verify';
                    showToast('Error!', 'err');
                });
        }

        function doReject() {
            const btn = document.getElementById('rConfirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Rejecting…';
            fetch(`/admin/users/${_uid}/reject`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json()).then(() => {
                    const n = _uname;
                    closeModal();
                    showToast(`${n} Rejected.`, 'err');
                    document.querySelectorAll(`[data-uid="${_uid}"]`).forEach(r => {
                        r.style.transition = 'opacity .3s';
                        r.style.opacity = '0';
                        setTimeout(() => r.remove(), 300);
                    });
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
                    showToast('Error!', 'err');
                });
        }
    </script>
@endpush
