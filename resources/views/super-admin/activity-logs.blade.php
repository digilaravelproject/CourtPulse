@extends('layouts.admin')
@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')

    {{-- ── Page Header ───────────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display text-2xl font-bold text-slate-800">Activity Logs</h1>
            <p class="text-sm text-slate-500 mt-0.5">Recent user registrations and system events.</p>
        </div>
        <button onclick="location.reload()"
            class="flex items-center gap-2 bg-white border border-slate-200 hover:border-gold/50 px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-gold transition-all shadow-sm w-fit">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>
    </div>

    {{-- ── AJAX Filter ────────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6" x-data="activityFilter()"
        x-init="fetchLogs()">

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-4">

            {{-- Search --}}
            <div class="sm:col-span-2 relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" x-model="filters.search" @input.debounce.400ms="fetchLogs()"
                    placeholder="Search by name or email..."
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm
                    focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition">
            </div>

            {{-- Role filter --}}
            <select x-model="filters.role" @change="fetchLogs()"
                class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white
                   focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition cursor-pointer">
                <option value="">All Roles</option>
                <option value="super_admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="advocate">Advocate</option>
                <option value="clerk">Clerk</option>
                <option value="ca">CA</option>
                <option value="guest">Guest</option>
            </select>

            {{-- Status filter --}}
            <select x-model="filters.status" @change="fetchLogs()"
                class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white
                   focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition cursor-pointer">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        {{-- Active filters + count --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 flex-wrap">
                <template x-if="filters.search">
                    <span
                        class="flex items-center gap-1.5 bg-gold/10 text-yellow-800 font-mono text-xs px-2.5 py-1 rounded-full">
                        Search: <span x-text="filters.search" class="font-bold"></span>
                        <button @click="filters.search=''; fetchLogs()" class="hover:text-red-500 ml-1">×</button>
                    </span>
                </template>
                <template x-if="filters.role">
                    <span
                        class="flex items-center gap-1.5 bg-blue-50 text-blue-700 font-mono text-xs px-2.5 py-1 rounded-full">
                        Role: <span x-text="filters.role" class="font-bold capitalize"></span>
                        <button @click="filters.role=''; fetchLogs()" class="hover:text-red-500 ml-1">×</button>
                    </span>
                </template>
                <template x-if="filters.status">
                    <span
                        class="flex items-center gap-1.5 bg-green-50 text-green-700 font-mono text-xs px-2.5 py-1 rounded-full">
                        Status: <span x-text="filters.status" class="font-bold capitalize"></span>
                        <button @click="filters.status=''; fetchLogs()" class="hover:text-red-500 ml-1">×</button>
                    </span>
                </template>
            </div>
            <div class="flex items-center gap-3">
                <span class="font-mono text-xs text-slate-400" x-text="total > 0 ? total + ' results' : ''"></span>
                <button @click="filters={search:'',role:'',status:''}; fetchLogs()"
                    x-show="filters.search || filters.role || filters.status" x-cloak
                    class="font-mono text-xs text-slate-400 hover:text-red-500 transition-colors underline">
                    Clear all
                </button>
            </div>
        </div>
    </div>

    {{-- ── Results Table (AJAX target) ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" x-data="activityFilter()"
        x-init="fetchLogs()">

        {{-- Loading overlay --}}
        <div x-show="loading" x-cloak class="flex items-center justify-center py-20 border-b border-slate-100">
            <div class="flex flex-col items-center gap-3">
                <i class="bi bi-arrow-repeat spin text-2xl text-gold"></i>
                <span class="text-sm text-slate-500 font-medium">Loading...</span>
            </div>
        </div>

        {{-- Table --}}
        <div x-show="!loading" x-cloak>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="text-left px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                User</th>
                            <th class="text-left px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                Role</th>
                            <th
                                class="text-left px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider hidden md:table-cell">
                                Email</th>
                            <th class="text-left px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="text-left px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider hidden lg:table-cell">
                                Joined</th>
                            <th class="text-left px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="activityTableBody">
                        {{-- Filled by PHP on first load, then replaced by AJAX --}}
                        @include('super-admin.partials.activity-rows', ['recentUsers' => $recentUsers])
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div id="activityPagination" class="px-5 py-4 border-t border-slate-100">
                {{ $recentUsers->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- ── Assign Role Modal ────────────────────────────────────────────────────── --}}
    <div id="assignRoleModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-navy/60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 modal-pop">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-gold/10 flex items-center justify-center">
                    <i class="bi bi-person-gear text-gold"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800">Assign Role</p>
                    <p id="assignRoleUserName" class="text-xs text-slate-500"></p>
                </div>
            </div>
            <form id="assignRoleForm">
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Select
                        Role</label>
                    <select name="role" id="assignRoleSelect"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition">
                        <option value="advocate">Advocate</option>
                        <option value="clerk">Clerk</option>
                        <option value="ca">CA</option>
                        <option value="admin">Admin</option>
                        <option value="guest">Guest</option>
                        @if (auth()->user()->hasRole('super_admin'))
                            <option value="super_admin">Super Admin</option>
                        @endif
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="submitAssignRole()"
                        class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-navy transition-all"
                        style="background:#D4AF37" onmouseover="this.style.background='#B5952F'"
                        onmouseout="this.style.background='#D4AF37'">
                        <i class="bi bi-check2"></i> Assign
                    </button>
                    <button type="button" onclick="closeAssignRoleModal()"
                        class="flex-1 py-2.5 rounded-xl text-sm font-medium border border-slate-200 text-slate-600 hover:border-slate-300 bg-white">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // ── Activity Filter / AJAX Table ────────────────────────────────────────────
            function activityFilter() {
                return {
                    filters: {
                        search: '',
                        role: '',
                        status: ''
                    },
                    loading: false,
                    total: 0,

                    fetchLogs() {
                        this.loading = true;
                        const qs = new URLSearchParams(this.filters).toString();

                        fetch(`{{ route('super.activity') }}?${qs}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': CSRF,
                                },
                            })
                            .then(r => r.json())
                            .then(d => {
                                if (d.html !== undefined) {
                                    document.getElementById('activityTableBody').innerHTML = d.html;
                                    document.getElementById('activityPagination').innerHTML = d.pagination ?? '';
                                    this.total = d.total ?? 0;
                                }
                                this.loading = false;
                            })
                            .catch(() => {
                                showToast('Failed to fetch logs', 'err');
                                this.loading = false;
                            });
                    },
                };
            }

            // ── Assign Role Modal ────────────────────────────────────────────────────────
            let _assignUserId = null;

            function openAssignRoleModal(userId, userName, currentRole) {
                _assignUserId = userId;
                document.getElementById('assignRoleUserName').textContent = userName;
                document.getElementById('assignRoleSelect').value = currentRole;
                document.getElementById('assignRoleModal').classList.remove('hidden');
            }

            function closeAssignRoleModal() {
                document.getElementById('assignRoleModal').classList.add('hidden');
                _assignUserId = null;
            }

            function submitAssignRole() {
                const role = document.getElementById('assignRoleSelect').value;
                const btn = document.querySelector('#assignRoleModal button[onclick="submitAssignRole()"]');
                btn.disabled = true;
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Assigning...';

                fetch(`/super-admin/assign-role/${_assignUserId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            role
                        }),
                    })
                    .then(r => r.json())
                    .then(d => {
                        if (d.success !== false) {
                            showToast(d.message || 'Role assigned!', 'ok');
                            closeAssignRoleModal();
                            // Update role badge in table without full reload
                            const roleBadge = document.querySelector(`[data-user-id="${_assignUserId}"] .role-badge`);
                            if (roleBadge) roleBadge.textContent = role.replace('_', ' ');
                            setTimeout(() => location.reload(), 800);
                        } else {
                            showToast(d.message || 'Failed', 'err');
                        }
                        btn.disabled = false;
                        btn.innerHTML = orig;
                    })
                    .catch(() => {
                        showToast('Network error', 'err');
                        btn.disabled = false;
                        btn.innerHTML = orig;
                    });
            }
        </script>
    @endpush

@endsection
