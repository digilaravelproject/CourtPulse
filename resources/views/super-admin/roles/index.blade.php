@extends('layouts.admin')
@section('title', 'Roles & Permissions')
@section('page-title', 'Roles & Permissions')

@push('styles')
    <style>
        /* Required for Alpine.js x-cloak to work */
        [x-cloak] {
            display: none !important;
        }

        .perm-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            color: #475569;
            transition: all 0.15s;
            user-select: none;
        }

        .perm-label:hover {
            background: #fffbeb;
            border-color: rgba(212, 175, 55, 0.5);
        }

        .perm-label input[type=checkbox] {
            accent-color: #D4AF37;
            cursor: pointer;
        }

        .role-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
        }

        .role-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            cursor: pointer;
            transition: background .15s;
        }

        .role-header:hover {
            background: #f8fafc;
        }

        .role-body {
            border-top: 1px solid #f1f5f9;
            padding: 20px;
        }

        .group-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 8px;
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-display text-2xl font-bold text-slate-800">Roles & Permissions</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage Spatie roles and assign permissions to each role.</p>
        </div>
        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2 shadow-sm">
            <i class="bi bi-shield-lock text-yellow-500 text-sm"></i>
            <span class="font-mono text-xs text-slate-500">
                {{ $roles->count() }} roles &nbsp;·&nbsp; {{ $permissions->count() }} permissions
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ══ LEFT: Roles List ══ --}}
        <div class="xl:col-span-2">

            @foreach ($roles as $role)
                @php
                    $icons = [
                        'super_admin' => ['bi-crown-fill', 'text-purple-500', 'bg-purple-50 border-purple-200'],
                        'admin' => ['bi-shield-fill', 'text-yellow-600', 'bg-yellow-50 border-yellow-200'],
                        'advocate' => ['bi-person-badge-fill', 'text-blue-500', 'bg-blue-50 border-blue-200'],
                        'clerk' => ['bi-folder2-open', 'text-green-600', 'bg-green-50 border-green-200'],
                        'ca' => ['bi-calculator-fill', 'text-orange-500', 'bg-orange-50 border-orange-200'],
                        'guest' => ['bi-person', 'text-slate-400', 'bg-slate-50 border-slate-200'],
                    ];
                    [$ico, $icColor, $icBg] = $icons[$role->name] ?? [
                        'bi-circle',
                        'text-slate-400',
                        'bg-slate-50 border-slate-200',
                    ];
                    $isProtected = in_array($role->name, ['super_admin', 'admin', 'advocate', 'clerk', 'ca', 'guest']);
                    $grouped = $permissions->groupBy(fn($p) => explode(' ', $p->name)[1] ?? 'general');
                @endphp

                {{-- Each role is a standalone Alpine component — no nesting issues --}}
                <div class="role-card" x-data="{ open: false, saving: false }">

                    {{-- Role Header (click to toggle) --}}
                    <div class="role-header" @click="open = !open">

                        {{-- Icon --}}
                        <div
                            class="w-10 h-10 rounded-xl border flex items-center justify-center flex-shrink-0 {{ $icBg }}">
                            <i class="bi {{ $ico }} {{ $icColor }}"></i>
                        </div>

                        {{-- Name + count --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span
                                    class="font-semibold text-slate-800 capitalize">{{ str_replace('_', ' ', $role->name) }}</span>
                                @if ($isProtected)
                                    <span
                                        class="font-mono text-[0.55rem] bg-slate-100 text-slate-400 px-2 py-0.5 rounded-full">System</span>
                                @endif
                            </div>
                            <div class="font-mono text-xs text-slate-400 mt-0.5">
                                <span id="perm-count-{{ $role->id }}">{{ $role->permissions->count() }}</span>
                                permission(s) assigned
                            </div>
                        </div>

                        {{-- Permission preview pills --}}
                        <div class="hidden lg:flex items-center gap-1 flex-wrap max-w-xs">
                            @foreach ($role->permissions->take(3) as $p)
                                <span
                                    class="font-mono text-[0.6rem] bg-yellow-50 text-yellow-700 border border-yellow-200 px-2 py-0.5 rounded-md">
                                    {{ $p->name }}
                                </span>
                            @endforeach
                            @if ($role->permissions->count() > 3)
                                <span
                                    class="font-mono text-[0.6rem] text-slate-400">+{{ $role->permissions->count() - 3 }}</span>
                            @endif
                        </div>

                        {{-- Delete button (non-system roles only) --}}
                        @if (!$isProtected)
                            <button
                                @click.stop="
          if(confirm('Delete role {{ $role->name }}? This cannot be undone.')) {
            fetch('/super-admin/roles/{{ $role->id }}', {
              method:'DELETE',
              headers:{'X-CSRF-TOKEN':document.querySelector(\'meta[name=csrf-token]\').content,'X-Requested-With':'XMLHttpRequest'}
            }).then(r=>r.json()).then(d=>{
              if(d.success!==false){ showToast(d.message||\'Role deleted\',\'ok\'); $el.closest(\'.role-card\').remove(); }
              else showToast(d.message||\'Cannot delete\',\'err\');
            })
          }"
                                class="w-8 h-8 rounded-lg border border-red-200 text-red-400 hover:bg-red-50 hover:text-red-600
                 flex items-center justify-center text-sm transition-all flex-shrink-0">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif

                        {{-- Chevron --}}
                        <div class="w-7 h-7 flex items-center justify-center text-slate-300 transition-transform duration-200 flex-shrink-0"
                            :class="open ? 'rotate-180' : ''">
                            <i class="bi bi-chevron-down text-xs"></i>
                        </div>
                    </div>

                    {{-- Permission editor (shown when open=true) --}}
                    <div class="role-body" x-show="open" x-cloak>

                        <form id="roleForm-{{ $role->id }}"
                            onsubmit="saveRolePermissions(event, {{ $role->id }}); return false;">
                            @csrf

                            {{-- Permissions grouped by resource --}}
                            @foreach ($grouped as $group => $perms)
                                <div class="mb-4">
                                    <div class="group-label">{{ $group }}</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($perms as $perm)
                                            <label class="perm-label">
                                                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                                    {{ $role->permissions->contains('id', $perm->id) ? 'checked' : '' }}>
                                                {{ $perm->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            {{-- Save/Cancel buttons --}}
                            <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-2">
                                <button type="submit" :disabled="saving"
                                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-[#1a1a1a] transition-all disabled:opacity-60"
                                    style="background:#D4AF37"
                                    onmouseover="if(!this.disabled)this.style.background='#B5952F'"
                                    onmouseout="if(!this.disabled)this.style.background='#D4AF37'">
                                    <i class="bi bi-save" x-show="!saving"></i>
                                    <i class="bi bi-arrow-repeat spin" x-show="saving" x-cloak></i>
                                    <span x-text="saving ? 'Saving...' : 'Save Permissions'"></span>
                                </button>
                                <button type="button" @click="open = false"
                                    class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-600
                           border border-slate-200 hover:border-slate-300 bg-white transition-all">
                                    Cancel
                                </button>
                                <span class="ml-auto font-mono text-xs text-slate-400">
                                    Role ID: {{ $role->id }}
                                </span>
                            </div>
                        </form>
                    </div>

                </div>{{-- end role-card --}}
            @endforeach

        </div>{{-- end xl:col-span-2 --}}

        {{-- ══ RIGHT: Create New Role ══ --}}
        <div class="space-y-4">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                        style="background:rgba(212,175,55,.12)">
                        <i class="bi bi-shield-plus" style="color:#D4AF37"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm">Create New Role</h3>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('super.roles.create') }}" x-data="{ loading: false }">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Role Name *
                            </label>
                            <input type="text" name="name" required placeholder="e.g. moderator"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-mono
                          focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 transition">
                            <p class="text-xs text-slate-400 mt-1">Lowercase + underscore only</p>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <label
                                    class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Permissions</label>
                                <button type="button"
                                    onclick="this.closest('form').querySelectorAll('input[type=checkbox]').forEach(c=>c.checked=!c.checked)"
                                    class="font-mono text-[0.65rem] underline" style="color:#D4AF37">
                                    Toggle All
                                </button>
                            </div>
                            <div
                                class="border border-slate-200 rounded-xl max-h-72 overflow-y-auto divide-y divide-slate-50">
                                @foreach ($permissions->groupBy(fn($p) => explode(' ', $p->name)[1] ?? 'general') as $group => $perms)
                                    <div class="px-3 py-2">
                                        <div class="group-label">{{ $group }}</div>
                                        @foreach ($perms as $perm)
                                            <label
                                                class="flex items-center gap-2 py-1 cursor-pointer text-xs text-slate-600 hover:text-slate-800">
                                                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                                    class="rounded border-slate-300 accent-[#D4AF37]">
                                                {{ $perm->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" :disabled="loading" @click="loading=true"
                            class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-[#1a1a1a] transition-all disabled:opacity-60"
                            style="background:#D4AF37" onmouseover="if(!this.disabled)this.style.background='#B5952F'"
                            onmouseout="if(!this.disabled)this.style.background='#D4AF37'">
                            <i class="bi bi-plus-lg" x-show="!loading"></i>
                            <i class="bi bi-arrow-repeat spin" x-show="loading" x-cloak></i>
                            <span x-text="loading ? 'Creating...' : 'Create Role'"></span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Roles Summary --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800 text-sm">Summary</h3>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach ($roles as $role)
                        <div class="flex items-center justify-between px-5 py-3">
                            <span
                                class="text-sm font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $role->name) }}</span>
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-xs text-slate-400">{{ $role->users()->count() }} users</span>
                                <span class="font-mono text-xs font-bold"
                                    style="color:#D4AF37">{{ $role->permissions->count() }} perms</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>{{-- end right col --}}

    </div>

    @push('scripts')
        <script>
            /**
             * Save role permissions via AJAX
             * Called from form onsubmit — plain JS, no Alpine dependency
             */
            function saveRolePermissions(event, roleId) {
                const form = event.target ?? event;
                const btn = form.querySelector('button[type=submit]');
                const checked = form.querySelectorAll('input[name="permissions[]"]:checked');
                const csrf = document.querySelector('meta[name="csrf-token"]').content;

                // Set loading state via Alpine on the parent card
                try {
                    Alpine.$data(form.closest('[x-data]')).saving = true;
                } catch (e) {}

                // Build FormData — POST + _method=PUT for Laravel method spoofing
                const fd = new FormData();
                fd.append('_token', csrf);
                fd.append('_method', 'PUT');
                checked.forEach(cb => fd.append('permissions[]', cb.value));

                fetch('/super-admin/roles/' + roleId, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest',
                            // No Content-Type — let browser set multipart/form-data boundary
                        },
                        body: fd,
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            return response.json().then(function(e) {
                                throw e;
                            });
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        showToast(data.message || 'Permissions saved!', 'ok');

                        // Update the counter badge on this role card
                        const counter = document.getElementById('perm-count-' + roleId);
                        if (counter) counter.textContent = checked.length;
                    })
                    .catch(function(err) {
                        const msg = (err && err.message) ? err.message : 'Save failed. Check console.';
                        showToast(msg, 'err');
                        console.error('saveRolePermissions error:', err);
                    })
                    .finally(function() {
                        try {
                            Alpine.$data(form.closest('[x-data]')).saving = false;
                        } catch (e) {}
                    });
            }
        </script>
    @endpush

@endsection
