@extends('layouts.admin')
@section('title', 'All Users')
@section('page-title', 'All Users')

@section('content')

    {{-- ═══════════════════════════════════════════
     ALPINE COMPONENT  x-data="usersFilter()"
═══════════════════════════════════════════ --}}
    <div x-data="usersFilter()" x-init="init()">

        {{-- Filter Bar --}}
        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-5
              flex flex-wrap items-end gap-3">

            {{-- Search --}}
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Search</label>
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Name or email…"
                        class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50
                 w-52 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                </div>
            </div>

            {{-- Role --}}
            <div class="flex flex-col gap-1">
                <label class="font-mono text-[0.56rem] tracking-[1.5px] uppercase text-slate-400">Role</label>
                <select x-model="f.role" @change="load()"
                    class="py-2 pl-3 pr-8 text-sm border border-slate-200 rounded-lg bg-slate-50
               focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                    <option value="">All Roles</option>
                    <option value="advocate">Advocate</option>
                    <option value="clerk">Clerk</option>
                    <option value="ca">CA</option>
                    <option value="guest">Guest</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            {{-- Status --}}
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

            {{-- Reset --}}
            <button @click="reset()"
                class="ml-auto flex items-center gap-1.5 px-4 py-2 text-sm font-medium
             border border-slate-200 rounded-lg hover:border-slate-400 bg-white
             text-slate-600 hover:text-slate-800 transition-all">
                <i class="bi bi-x-circle"></i> Reset
            </button>

            {{-- Loading indicator --}}
            <div x-show="loading" x-cloak class="flex items-center gap-2 text-sm text-slate-400 font-medium">
                <i class="bi bi-arrow-repeat spin text-gold"></i> Loading…
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-display font-bold text-[1.05rem] text-slate-800">All Users</h2>
            </div>
            <div id="users-tbl" class="overflow-x-auto min-h-[120px]">
                @include('admin.partials.users-table', ['users' => $users])
            </div>
        </div>

    </div>{{-- /x-data --}}

    {{-- ═══════════════════════════════════════════
     VERIFY MODAL
═══════════════════════════════════════════ --}}
    <div id="vOverlay" onclick="closeModal()"
        class="hidden fixed inset-0 bg-navy/60 backdrop-blur-sm z-1000 transition-opacity"></div>

    <div id="vModal"
        class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
         w-[min(500px,calc(100vw-2rem))] bg-white rounded-2xl shadow-2xl z-1001">

        {{-- Header --}}
        <div
            class="flex items-center gap-4 px-6 py-5 border-b border-slate-100
              rounded-t-2xl bg-linear-to-br from-green-50 to-white">
            <div
                class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center
                text-green-600 text-2xl shrink-0">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div class="flex-1">
                <div class="font-display font-bold text-[1.1rem] text-slate-800">Verify Professional</div>
                <div class="text-xs text-slate-500 mt-0.5">Review details before approving account access.</div>
            </div>
            <button onclick="closeModal()"
                class="text-slate-400 hover:text-slate-700 transition-colors text-xl leading-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 space-y-4">
            {{-- User card --}}
            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                <div id="v_avatar"
                    class="w-14 h-14 rounded-xl bg-navy flex items-center justify-center
               text-gold font-bold text-lg border-2 border-gold/30 shrink-0
               font-display">
                </div>
                <div>
                    <div id="v_name" class="font-bold text-base text-slate-800 font-display"></div>
                    <span id="v_rpill"
                        class="inline-block mt-1 text-[0.6rem] font-semibold
                                  px-2.5 py-0.5 rounded font-mono uppercase tracking-wide"></span>
                </div>
            </div>

            {{-- Detail grid --}}
            <div class="grid grid-cols-2 gap-3">
                @foreach ([['v_email', 'bi-envelope', 'Email'], ['v_phone', 'bi-phone', 'Phone'], ['v_date', 'bi-calendar3', 'Registered'], ['v_city', 'bi-geo-alt', 'City']] as [$id, $icon, $label])
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                        <div
                            class="flex items-center gap-1.5 font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5">
                            <i class="bi {{ $icon }}"></i> {{ $label }}
                        </div>
                        <div id="{{ $id }}" class="text-sm font-semibold text-slate-700 break-all"></div>
                    </div>
                @endforeach
            </div>

            {{-- Notice --}}
            <div
                class="flex items-start gap-3 px-4 py-3 bg-amber-50 border border-amber-200
                rounded-lg text-amber-700 text-xs leading-relaxed">
                <i class="bi bi-info-circle-fill shrink-0 mt-0.5"></i>
                Once verified, this user gets full dashboard access and will appear in the Professional Directory.
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100
              bg-slate-50/80 rounded-b-2xl">
            <button onclick="closeModal()"
                class="px-5 py-2.5 text-sm font-medium border border-slate-200 rounded-lg
             hover:border-slate-400 bg-white transition-all text-slate-700">
                Cancel
            </button>
            <button id="vConfirmBtn" onclick="doVerify()"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold
             bg-green-500 hover:bg-green-600 text-white rounded-lg
             transition-all shadow-md shadow-green-200">
                <i class="bi bi-check-lg"></i> Confirm Verify
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
     REJECT MODAL
═══════════════════════════════════════════ --}}
    <div id="rModal"
        class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
         w-[min(440px,calc(100vw-2rem))] bg-white rounded-2xl shadow-2xl z-1001">

        <div
            class="flex items-center gap-4 px-6 py-5 border-b border-slate-100
              rounded-t-2xl bg-linear-to-br from-red-50 to-white">
            <div
                class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center
                text-red-500 text-2xl shrink-0">
                <i class="bi bi-person-x-fill"></i>
            </div>
            <div class="flex-1">
                <div class="font-display font-bold text-[1.1rem] text-slate-800">Reject Registration</div>
                <div id="r_sub" class="text-xs text-slate-500 mt-0.5"></div>
            </div>
            <button onclick="closeModal()"
                class="text-slate-400 hover:text-slate-700 transition-colors text-xl leading-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="p-6">
            <div
                class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200
                rounded-lg text-red-700 text-xs leading-relaxed">
                <i class="bi bi-exclamation-triangle-fill shrink-0 mt-0.5"></i>
                This marks the user as <strong>Rejected</strong>. They won't be able to access role-specific features until
                re-verified.
            </div>
        </div>

        <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100
              bg-slate-50/80 rounded-b-2xl">
            <button onclick="closeModal()"
                class="px-5 py-2.5 text-sm font-medium border border-slate-200 rounded-lg
             hover:border-slate-400 bg-white transition-all text-slate-700">
                Cancel
            </button>
            <button id="rConfirmBtn" onclick="doReject()"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold
             bg-red-500 hover:bg-red-600 text-white rounded-lg
             transition-all shadow-md shadow-red-200">
                <i class="bi bi-x-lg"></i> Confirm Reject
            </button>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        /* ── ALPINE: filter ──────────────────────────────────── */
        function usersFilter() {
            return {
                f: {
                    search: '',
                    role: '',
                    status: ''
                },
                loading: false,
                init() {
                    /* nothing needed */ },
                load() {
                    this.loading = true;
                    const qs = new URLSearchParams(
                        Object.fromEntries(Object.entries(this.f).filter(([, v]) => v !== ''))
                    ).toString();
                    fetch('{{ route('admin.users') }}' + (qs ? '?' + qs : ''), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(r => r.json())
                        .then(d => {
                            document.getElementById('users-tbl').innerHTML = d.html;
                            this.loading = false;
                        })
                        .catch(() => {
                            this.loading = false;
                            showToast('Filter Failed', 'err');
                        });
                },
                reset() {
                    this.f = {
                        search: '',
                        role: '',
                        status: ''
                    };
                    this.load();
                }
            };
        }

        /* ── MODAL LOGIC ─────────────────────────────────────── */
        let _uid = null,
            _uname = null;

        const RPILL = {
            advocate: 'bg-blue-100 text-blue-700',
            clerk: 'bg-purple-100 text-purple-700',
            ca: 'bg-amber-100 text-amber-700',
            guest: 'bg-slate-100 text-slate-600',
            admin: 'bg-orange-100 text-orange-700',
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
            _showOverlay();
            _showEl('vModal');
        }

        function openReject(id, name) {
            _uid = id;
            _uname = name;
            document.getElementById('r_sub').textContent = `Rejecting "${name}" — action cannot be undone easily.`;
            const btn = document.getElementById('rConfirmBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
            _showOverlay();
            _showEl('rModal');
        }

        function _showOverlay() {
            document.getElementById('vOverlay').classList.remove('hidden');
        }

        function _showEl(id) {
            const m = document.getElementById(id);
            m.classList.remove('hidden');
            m.classList.add('modal-pop');
        }

        function closeModal() {
            ['vModal', 'rModal'].forEach(id => {
                const m = document.getElementById(id);
                m.classList.add('hidden');
                m.classList.remove('modal-pop');
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
                .then(r => r.json())
                .then(() => {
                    const name = _uname;
                    closeModal();
                    showToast(`${name} Verified Successfully!`, 'ok');
                    document.querySelectorAll(`tr[data-uid="${_uid||0}"]`).forEach(r => r.remove());
                    // fallback: remove by scanning text
                    document.querySelectorAll('#users-tbl tbody tr').forEach(r => {
                        if (r.dataset && r.dataset.uid == (_uid || 0)) r.remove();
                    });
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-check-lg"></i> Confirm Verify';
                    showToast('Verification Failed', 'err');
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
                .then(r => r.json())
                .then(() => {
                    const name = _uname;
                    closeModal();
                    showToast(`${name} Rejected.`, 'err');
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
                    showToast('Rejection Failed', 'err');
                });
        }
    </script>
@endpush
