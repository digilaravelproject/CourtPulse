@extends('layouts.admin')
@section('title', 'All Users')
@section('page-title', 'User Management')

@section('content')

    {{-- Custom table spacing overrides --}}
    <style>
        #users-tbl table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>

    {{-- ═══════════════════════════════════════════
    ALPINE COMPONENT x-data="usersFilter()"
    ═══════════════════════════════════════════ --}}
    <div x-data="usersFilter()" x-init="init()">

        {{-- Filter Bar --}}
        <div
            class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 mb-10 flex flex-col md:flex-row flex-wrap items-end gap-6 transition-all">

            {{-- Search --}}
            <div class="flex flex-col gap-3 w-full md:w-72 flex-grow md:flex-grow-0">
                <label class="font-black text-xs uppercase tracking-widest text-white/50 pl-1">Search Users</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                    <input type="text" x-model="f.search" @input.debounce.400ms="load()" placeholder="Name or email..."
                        class="w-full pl-12 pr-5 py-4 text-sm border border-white/10 rounded-2xl bg-navy text-white placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner">
                </div>
            </div>

            {{-- Role --}}
            <div class="flex flex-col gap-3 w-full sm:w-56 flex-grow sm:flex-grow-0">
                <label class="font-black text-xs uppercase tracking-widest text-white/50 pl-1">Filter by Role</label>
                <div class="relative">
                    <select x-model="f.role" @change="load()"
                        class="w-full pl-5 pr-12 py-4 text-sm border border-white/10 rounded-2xl bg-navy text-white focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors appearance-none shadow-inner cursor-pointer">
                        <option value="">All Roles</option>
                        <option value="advocate">Advocate</option>
                        <option value="court_clerk">Court Clerk</option>
                        <option value="ip_clerk">IP Clerk</option>
                        <option value="ca_cs">CA / CS</option>
                        <option value="agent">IP Agent</option>
                        <option value="guest">Guest</option>
                        <option value="admin">Admin</option>
                    </select>
                    <i
                        class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-white/30 text-sm pointer-events-none"></i>
                </div>
            </div>

            {{-- Status --}}
            <div class="flex flex-col gap-3 w-full sm:w-56 flex-grow sm:flex-grow-0">
                <label class="font-black text-xs uppercase tracking-widest text-white/50 pl-1">Account Status</label>
                <div class="relative">
                    <select x-model="f.status" @change="load()"
                        class="w-full pl-5 pr-12 py-4 text-sm border border-white/10 rounded-2xl bg-navy text-white focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors appearance-none shadow-inner cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
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
                    class="flex items-center justify-center gap-2 px-8 py-4 text-xs font-black uppercase tracking-widest border border-white/10 rounded-2xl hover:bg-white/5 text-white/70 hover:text-white transition-all shadow-lg ml-auto">
                    <i class="fas fa-undo text-sm"></i> Reset Filters
                </button>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div class="p-8 border-b border-white/5 bg-white/5 flex items-center justify-between">
                <h2 class="font-black text-base text-white uppercase tracking-widest">Network Directory</h2>
            </div>
            <div id="users-tbl" class="overflow-x-auto min-h-[400px]">
                @include('admin.partials.users-table', ['users' => $users])
            </div>
        </div>

    </div>{{-- /x-data --}}

    {{-- ═══════════════════════════════════════════
    VERIFY MODAL
    ═══════════════════════════════════════════ --}}
    <div id="vOverlay" onclick="closeModal()"
        class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-[2000] transition-opacity duration-300"></div>

    <div id="vModal"
        class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(550px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.8)] z-[2001] overflow-hidden transform scale-95 transition-transform duration-300">

        {{-- Header --}}
        <div class="flex items-center gap-5 px-8 py-6 border-b border-white/5 bg-white/5">
            <div
                class="w-14 h-14 rounded-2xl bg-green-500/10 border border-green-500/30 flex items-center justify-center text-green-400 text-2xl shrink-0 shadow-[0_0_20px_rgba(34,197,94,0.2)]">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="flex-1">
                <div class="font-black text-base text-white uppercase tracking-widest">Verify Professional</div>
                <div class="text-[0.7rem] text-white/50 uppercase tracking-wider font-bold mt-1.5">Review details before
                    approving</div>
            </div>
            <button onclick="closeModal()"
                class="text-white/40 hover:text-white transition-colors text-xl focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-8 space-y-6 bg-navy/50">
            {{-- User card --}}
            <div class="flex items-center gap-5 p-5 bg-navy rounded-2xl border border-white/5 shadow-inner">
                <div id="v_avatar"
                    class="w-14 h-14 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center font-black text-base text-blue shrink-0 shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                </div>
                <div>
                    <div id="v_name" class="font-bold text-base text-white mb-1.5"></div>
                    <span id="v_rpill"
                        class="inline-block text-[0.6rem] font-black px-3 py-1 rounded-md border uppercase tracking-widest"></span>
                </div>
            </div>

            {{-- Detail grid --}}
            <div class="grid grid-cols-2 gap-5">
                @foreach ([['v_email', 'fas fa-envelope', 'Email Address'], ['v_phone', 'fas fa-phone-alt', 'Phone Number'], ['v_date', 'fas fa-calendar-alt', 'Registered On'], ['v_city', 'fas fa-map-marker-alt', 'Primary Location']] as [$id, $icon, $label])
                    <div class="bg-navy rounded-2xl border border-white/5 p-5 shadow-inner">
                        <div
                            class="flex items-center gap-2 text-[0.65rem] font-black uppercase tracking-[0.2em] text-white/40 mb-2">
                            <i class="{{ $icon }}"></i> {{ $label }}
                        </div>
                        <div id="{{ $id }}" class="text-sm font-bold text-white break-all"></div>
                    </div>
                @endforeach
            </div>

            {{-- Notice --}}
            <div
                class="flex items-start gap-4 px-6 py-5 bg-green-500/10 border border-green-500/20 rounded-2xl text-green-400 text-sm font-bold leading-relaxed shadow-inner">
                <i class="fas fa-info-circle mt-0.5 text-xl"></i>
                <p>Once verified, this user gets full dashboard access and will appear in the Professional Directory for
                    clients to see.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-4 px-8 py-6 border-t border-white/5 bg-navy">
            <button onclick="closeModal()"
                class="px-8 py-3.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">
                Cancel
            </button>
            <button id="vConfirmBtn" onclick="doVerify()"
                class="flex items-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-green-500 hover:bg-green-400 text-navy rounded-xl transition-all shadow-[0_5px_20px_rgba(34,197,94,0.25)]">
                <i class="fas fa-check text-sm"></i> Confirm Verify
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
    REJECT MODAL
    ═══════════════════════════════════════════ --}}
    <div id="rModal"
        class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(500px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.8)] z-[2001] overflow-hidden transform scale-95 transition-transform duration-300">

        <div class="flex items-center gap-5 px-8 py-6 border-b border-white/5 bg-red-500/5">
            <div
                class="w-14 h-14 rounded-2xl bg-red-500/10 border border-red-500/30 flex items-center justify-center text-red-400 text-2xl shrink-0 shadow-[0_0_20px_rgba(239,68,68,0.2)]">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="flex-1">
                <div class="font-black text-base text-white uppercase tracking-widest">Reject Registration</div>
                <div id="r_sub" class="text-[0.7rem] text-white/50 uppercase tracking-wider font-bold mt-1.5"></div>
            </div>
            <button onclick="closeModal()"
                class="text-white/40 hover:text-white transition-colors text-xl focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-8 bg-navy/50">
            <div
                class="flex items-start gap-4 px-6 py-5 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm font-bold leading-relaxed shadow-inner">
                <i class="fas fa-exclamation-triangle mt-0.5 text-xl"></i>
                <p>Warning: This marks the user as <strong>Rejected</strong>. They won't be able to access role-specific
                    features until re-verified.</p>
            </div>
        </div>

        <div class="flex justify-end gap-4 px-8 py-6 border-t border-white/5 bg-navy">
            <button onclick="closeModal()"
                class="px-8 py-3.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">
                Cancel
            </button>
            <button id="rConfirmBtn" onclick="doReject()"
                class="flex items-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-red-500 hover:bg-red-400 text-white rounded-xl transition-all shadow-[0_5px_20px_rgba(239,68,68,0.3)]">
                <i class="fas fa-times text-sm"></i> Confirm Reject
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
                    /* nothing needed */
    },
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
                            if (typeof showToast === 'function') showToast('Filter Failed', 'err');
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
            advocate: 'bg-blue/10 text-blue border-blue/20',
            court_clerk: 'bg-purple-500/10 text-purple-400 border-purple-500/20',
            ip_clerk: 'bg-purple-500/10 text-purple-400 border-purple-500/20',
            ca_cs: 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            agent: 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            guest: 'bg-white/5 text-white/50 border-white/10',
            admin: 'bg-green-500/10 text-green-400 border-green-500/20',
        };

        function openVerify(id, name, role, email, phone, date, city) {
            _uid = id;
            _uname = name;
            document.getElementById('v_avatar').textContent = name.substring(0, 2).toUpperCase();
            document.getElementById('v_name').textContent = name;
            document.getElementById('v_email').textContent = email;
            document.getElementById('v_phone').textContent = phone || 'Not Provided';

            // Check if element exists before setting it (fallback safely)
            if (document.getElementById('v_date')) document.getElementById('v_date').textContent = date || '—';
            if (document.getElementById('v_city')) document.getElementById('v_city').textContent = city || '—';

            const p = document.getElementById('v_rpill');
            p.textContent = role.replace('_', ' ');

            const rClass = RPILL[role] || 'bg-white/5 text-white/50 border-white/10';
            p.className = `inline-block mt-1 text-[0.55rem] font-black px-3 py-1 rounded border uppercase tracking-widest ${rClass}`;

            const btn = document.getElementById('vConfirmBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Confirm Verify';

            _showOverlay();
            _showEl('vModal');
        }

        function openReject(id, name) {
            _uid = id;
            _uname = name;
            document.getElementById('r_sub').textContent = `Target: ${name}`;

            const btn = document.getElementById('rConfirmBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-times"></i> Confirm Reject';

            _showOverlay();
            _showEl('rModal');
        }

        function _showOverlay() {
            const overlay = document.getElementById('vOverlay');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('opacity-0'), 10);
        }

        function _showEl(id) {
            const m = document.getElementById(id);
            m.classList.remove('hidden');
            setTimeout(() => {
                m.classList.remove('scale-95');
                m.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            ['vModal', 'rModal'].forEach(id => {
                const m = document.getElementById(id);
                if (m) {
                    m.classList.remove('scale-100');
                    m.classList.add('scale-95');
                }
            });
            const overlay = document.getElementById('vOverlay');
            if (overlay) overlay.classList.add('opacity-0');

            setTimeout(() => {
                ['vModal', 'rModal', 'vOverlay'].forEach(id => {
                    if (document.getElementById(id)) document.getElementById(id).classList.add('hidden');
                });
                _uid = _uname = null;
            }, 300);
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });

        function doVerify() {
            const btn = document.getElementById('vConfirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Verifying...';

            fetch(`/admin/users/${_uid}/verify`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(r => r.json())
                .then(d => {
                    const name = _uname;
                    closeModal();
                    if (typeof showToast === 'function') showToast(`${name} Verified Successfully!`, 'ok');

                    // Remove Row Visually
                    document.querySelectorAll(`tr[data-uid="${_uid || 0}"]`).forEach(r => {
                        r.style.transition = 'all 0.4s ease';
                        r.style.opacity = '0';
                        r.style.transform = 'scale(0.98)';
                        setTimeout(() => r.remove(), 400);
                    });

                    // Refresh data if Alpine is loaded
                    if (typeof Alpine !== 'undefined') {
                        setTimeout(() => document.querySelector('[x-data="usersFilter()"]')._x_dataStack[0].load(), 400);
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check"></i> Confirm Verify';
                    if (typeof showToast === 'function') showToast('Verification Failed', 'err');
                });
        }

        function doReject() {
            const btn = document.getElementById('rConfirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Rejecting...';

            fetch(`/admin/users/${_uid}/reject`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(r => r.json())
                .then(d => {
                    const name = _uname;
                    closeModal();
                    if (typeof showToast === 'function') showToast(`${name} Rejected.`, 'err');

                    // Refresh data if Alpine is loaded
                    if (typeof Alpine !== 'undefined') {
                        setTimeout(() => document.querySelector('[x-data="usersFilter()"]')._x_dataStack[0].load(), 400);
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-times"></i> Confirm Reject';
                    if (typeof showToast === 'function') showToast('Rejection Failed', 'err');
                });
        }
    </script>
@endpush