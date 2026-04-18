@extends('layouts.super-admin')
@section('title', 'User Management')
@section('page-title', 'Manage All Users')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        {{-- Filters Bar --}}
        <div class="p-6 border-b border-slate-50">
            <form action="{{ route('super.users') }}" method="GET" class="flex flex-wrap items-end gap-4">
                {{-- Search --}}
                <div class="flex-1 min-w-[240px]">
                    <label class="block text-[0.6rem] uppercase tracking-widest font-bold text-slate-400 mb-2">Search Personnel</label>
                    <div class="relative">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Email, Phone..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition">
                    </div>
                </div>

                {{-- Role --}}
                <div class="w-40">
                    <label class="block text-[0.6rem] uppercase tracking-widest font-bold text-slate-400 mb-2">Role Type</label>
                    <select name="role" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:border-gold transition appearance-none cursor-pointer">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="w-40">
                    <label class="block text-[0.6rem] uppercase tracking-widest font-bold text-slate-400 mb-2">Account Status</label>
                    <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:border-gold transition appearance-none cursor-pointer">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-navy text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-navy/20 hover:bg-slate-800 transition-all">
                        Filter
                    </button>
                    <a href="{{ route('super.users') }}" class="bg-white border border-slate-200 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-all flex items-center justify-center">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[0.6rem] uppercase tracking-widest font-bold">
                        <th class="px-6 py-4 text-left">UID / Name</th>
                        <th class="px-6 py-4 text-left">Role & Permissions</th>
                        <th class="px-6 py-4 text-left">Contact Info</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-sm">
                                        {{ $user->id }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-extrabold text-slate-800 leading-none">{{ $user->name }}</p>
                                        <p class="text-[0.65rem] text-slate-400 mt-1.5 font-mono">Joined {{ $user->created_at->format('d M, Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5">
                                    <span class="inline-flex w-fit px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[0.6rem] font-bold uppercase tracking-wider">
                                        {{ $user->role }}
                                    </span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $perm)
                                            <span class="text-[0.55rem] text-slate-400 bg-slate-100 px-1.5 py-0.25 rounded border border-slate-200">
                                                {{ $perm->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-[0.7rem] font-medium text-slate-700"><i class="bi bi-envelope mr-1.5 text-slate-300"></i>{{ $user->email }}</p>
                                <p class="text-[0.7rem] text-slate-500 mt-1"><i class="bi bi-phone mr-1.5 text-slate-300"></i>{{ $user->phone ?? 'Not provided' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->status === 'active')
                                    <span class="px-2.5 py-1 rounded-full bg-green-50 text-green-600 text-[0.65rem] font-bold uppercase tracking-widest border border-green-100 shadow-sm shadow-green-50">Active</span>
                                @elseif($user->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-500 text-[0.65rem] font-bold uppercase tracking-widest border border-amber-100 shadow-sm shadow-amber-50">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-red-50 text-red-500 text-[0.65rem] font-bold uppercase tracking-widest border border-red-100 shadow-sm shadow-red-50">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('super.users.permissions', $user->id) }}" 
                                            class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-gold/10 hover:text-gold transition-all" title="Manage Permissions & Roles">
                                        <i class="bi bi-person-gear"></i>
                                    </a>
                                    @if($user->id !== auth()->id() && !$user->hasRole('super_admin'))
                                    <button onclick="confirmDestroy({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                            class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-red-50 hover:text-red-500 transition-all" title="Delete Account">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <i class="bi bi-search text-3xl mb-3 block opacity-20"></i>
                                No users found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                {{ $users->links() }}
            </div>
        @endif

    </div>

    {{-- Role Modal (Reusing logic if needed or direct from SuperAdminController) --}}
    {{-- Assuming modals are defined in layout or partials --}}
    
@endsection

@push('scripts')
<script>
    function confirmDestroy(id, name) {
        if(confirm(`Are you absolutely sure you want to PERMANENTLY delete user "${name}"?\nThis action cannot be undone.`)) {
            fetch(`/super-admin/users/${id}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(d => {
                if(d.success) {
                    showToast(d.message || 'User deleted', 'ok');
                    setTimeout(() => location.reload(), 800);
                } else {
                    showToast(d.message || 'Deletion failed', 'err');
                }
            })
            .catch(() => showToast('Failed to connect to server', 'err'));
        }
    }

    // Role modal placeholder logic - matches activity logs script
    function openAssignRoleModal(id, name, role) {
        if(typeof window.openAssignRoleModal === 'function') {
            window.openAssignRoleModal(id, name, role);
        } else {
            console.warn('Role assignment modal function not found');
        }
    }
</script>
@endpush
