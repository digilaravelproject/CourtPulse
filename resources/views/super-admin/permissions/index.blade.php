@extends('layouts.admin')
@section('title', 'Permissions')
@section('page-title', 'Permissions')

@section('content')

    {{-- ── Page Header ───────────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display text-2xl font-bold text-slate-800">Permissions</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                All Spatie permissions grouped by resource. Assign them to roles.
            </p>
        </div>
        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2 shadow-sm w-fit">
            <i class="bi bi-key-fill text-gold text-sm"></i>
            <span class="font-mono text-xs text-slate-500">{{ $permissions->flatten()->count() }} total permissions</span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6" x-data="permissionsManager()">

        {{-- ══════════════════════════════════════════════════════════
       LEFT — Filter + Grouped Permissions
  ══════════════════════════════════════════════════════════ --}}
        <div class="xl:col-span-2 space-y-4">

            {{-- Search / Filter bar --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" x-model="search" placeholder="Filter permissions..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm
                        focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition">
                    </div>
                    <select x-model="activeGroup"
                        class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white
                       focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition cursor-pointer">
                        <option value="">All Groups</option>
                        @foreach ($permissions as $group => $perms)
                            <option value="{{ $group }}">{{ ucfirst($group) }} ({{ $perms->count() }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Grouped Permission Cards --}}
            @foreach ($permissions as $group => $perms)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    x-show="(activeGroup === '' || activeGroup === '{{ $group }}')" x-cloak>

                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <span
                                class="font-mono text-[0.65rem] tracking-[2px] uppercase font-bold text-slate-500">{{ $group }}</span>
                            <span
                                class="font-mono text-[0.6rem] bg-gold/10 text-yellow-700 px-2 py-0.5 rounded-full">{{ $perms->count() }}</span>
                        </div>
                        <button @click="toggleGroup('{{ $group }}')"
                            class="font-mono text-[0.65rem] text-slate-400 hover:text-gold transition-colors underline">
                            <span x-text="collapsed.includes('{{ $group }}') ? 'Expand' : 'Collapse'"></span>
                        </button>
                    </div>

                    <div x-show="!collapsed.includes('{{ $group }}')" x-transition:enter="transition duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($perms as $perm)
                                <div class="flex items-center gap-2 group"
                                    x-show="search === '' || '{{ strtolower($perm->name) }}'.includes(search.toLowerCase())"
                                    x-cloak>
                                    <div
                                        class="flex items-center gap-1.5 bg-slate-50 hover:bg-white border border-slate-200 hover:border-slate-300
                        rounded-lg px-3 py-1.5 transition-all shadow-sm">
                                        <i
                                            class="bi bi-key text-slate-300 text-xs group-hover:text-gold transition-colors"></i>
                                        <span class="text-xs font-medium text-slate-700">{{ $perm->name }}</span>
                                        <button @click="deletePermission({{ $perm->id }}, '{{ $perm->name }}')"
                                            class="ml-1 w-4 h-4 rounded flex items-center justify-center text-slate-300
                       hover:text-red-500 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100"
                                            title="Delete">
                                            <i class="bi bi-x text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Empty state when search has no results --}}
                            <template x-if="search !== ''">
                                <p x-show="@json($perms->pluck('name')->toArray()).every(n => !n.includes(search.toLowerCase()))"
                                    class="text-xs text-slate-400 py-1">
                                    No matches in this group.
                                </p>
                            </template>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Delete confirmation modal --}}
            <div x-show="deleteModal.open" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-navy/60 backdrop-blur-sm"
                @keydown.escape.window="deleteModal.open = false">
                <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 modal-pop">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-500">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">Delete Permission</p>
                            <p class="text-xs text-slate-500">This will also remove it from all roles.</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 bg-slate-50 rounded-lg px-3 py-2 font-mono mb-5"
                        x-text="deleteModal.name"></p>
                    <div class="flex gap-3">
                        <button @click="confirmDeletePermission()" :disabled="deleteModal.loading"
                            class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold bg-red-500 text-white hover:bg-red-600 disabled:opacity-60 transition-all">
                            <i class="bi bi-arrow-repeat spin" x-show="deleteModal.loading" x-cloak></i>
                            <span x-text="deleteModal.loading ? 'Deleting...' : 'Delete'"></span>
                        </button>
                        <button @click="deleteModal.open = false"
                            class="flex-1 py-2.5 rounded-xl text-sm font-medium border border-slate-200 text-slate-600 hover:border-slate-300 bg-white transition-all">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

        </div>{{-- end xl:col-span-2 --}}

        {{-- ══════════════════════════════════════════════════════════
       RIGHT — Create Permission + Stats
  ══════════════════════════════════════════════════════════ --}}
        <div class="space-y-4">

            {{-- Create Permission --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center">
                        <i class="bi bi-plus-circle text-gold text-sm"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm">Create Permission</h3>
                </div>

                <div class="p-5">
                    <form @submit.prevent="createPermission($event)" x-data="{ creating: false }">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Permission Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="name" id="permName" placeholder="e.g. export reports" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-mono
                          focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition
                          placeholder:text-slate-300">
                            <p class="text-xs text-slate-400 mt-1">Format: <code class="text-gold">action resource</code>
                                (lowercase)</p>
                        </div>

                        {{-- Examples --}}
                        <div class="bg-slate-50 rounded-xl p-3 mb-4">
                            <p class="font-mono text-[0.6rem] tracking-widest uppercase text-slate-400 mb-2">Examples</p>
                            <div class="space-y-1">
                                @foreach (['view reports', 'export data', 'manage billing', 'delete comments'] as $ex)
                                    <button type="button"
                                        @click="document.getElementById('permName').value = '{{ $ex }}'"
                                        class="block w-full text-left font-mono text-xs text-slate-500 hover:text-gold transition-colors py-0.5">
                                        → {{ $ex }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" :disabled="creating"
                            class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-navy transition-all disabled:opacity-60"
                            style="background:#D4AF37" onmouseover="if(!this.disabled)this.style.background='#B5952F'"
                            onmouseout="if(!this.disabled)this.style.background='#D4AF37'">
                            <i class="bi bi-plus-lg" :class="creating ? 'hidden' : ''"></i>
                            <i class="bi bi-arrow-repeat spin" x-show="creating" x-cloak></i>
                            <span x-text="creating ? 'Creating...' : 'Create Permission'"></span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Stats by group --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800 text-sm">By Resource Group</h3>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach ($permissions as $group => $perms)
                        <div class="flex items-center justify-between px-5 py-3 hover:bg-slate-50 transition-colors cursor-pointer"
                            @click="activeGroup = (activeGroup === '{{ $group }}' ? '' : '{{ $group }}')">
                            <span class="text-sm font-medium text-slate-700 capitalize">{{ $group }}</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs bg-gold/10 text-yellow-700 px-2 py-0.5 rounded-full">
                                    {{ $perms->count() }}
                                </span>
                                <i class="bi bi-chevron-right text-xs text-slate-300"
                                    :class="activeGroup === '{{ $group }}' ? 'rotate-90' : ''"
                                    style="transition:transform .2s"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>{{-- end right col --}}

    </div>

    @push('scripts')
        <script>
            function permissionsManager() {
                return {
                    search: '',
                    activeGroup: '',
                    collapsed: [],
                    deleteModal: {
                        open: false,
                        id: null,
                        name: '',
                        loading: false
                    },

                    toggleGroup(group) {
                        const idx = this.collapsed.indexOf(group);
                        idx === -1 ? this.collapsed.push(group) : this.collapsed.splice(idx, 1);
                    },

                    // ── Create permission via AJAX ─────────────────────────────────────────
                    createPermission(event) {
                        const form = event.target;
                        const scope = Alpine.$data(event.target.querySelector('button[type=submit]')).__x ?? null;
                        const name = form.querySelector('input[name=name]').value.trim();
                        if (!name) return;

                        // Get the x-data scope
                        const btnScope = form.closest('[x-data]');
                        const btnData = btnScope ? Alpine.$data(btnScope) : null;
                        if (btnData) btnData.creating = true;

                        fetch('/super-admin/permissions', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': CSRF,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({
                                    name
                                }),
                            })
                            .then(r => r.json())
                            .then(d => {
                                if (d.success !== false) {
                                    showToast(d.message || 'Permission created!', 'ok');
                                    form.querySelector('input[name=name]').value = '';
                                    // Reload to show new permission in list
                                    setTimeout(() => location.reload(), 800);
                                } else {
                                    showToast(d.message || 'Create failed', 'err');
                                }
                                if (btnData) btnData.creating = false;
                            })
                            .catch(() => {
                                showToast('Network error', 'err');
                                if (btnData) btnData.creating = false;
                            });
                    },

                    // ── Delete permission ──────────────────────────────────────────────────
                    deletePermission(id, name) {
                        this.deleteModal = {
                            open: true,
                            id,
                            name,
                            loading: false
                        };
                    },

                    confirmDeletePermission() {
                        this.deleteModal.loading = true;
                        fetch(`/super-admin/permissions/${this.deleteModal.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                            })
                            .then(r => r.json())
                            .then(d => {
                                if (d.success !== false) {
                                    showToast(d.message || 'Permission deleted', 'ok');
                                    this.deleteModal.open = false;
                                    setTimeout(() => location.reload(), 600);
                                } else {
                                    showToast(d.message || 'Cannot delete', 'err');
                                    this.deleteModal.loading = false;
                                }
                            })
                            .catch(() => {
                                showToast('Network error', 'err');
                                this.deleteModal.loading = false;
                            });
                    },
                };
            }
        </script>
    @endpush

@endsection
