@extends('layouts.admin')
@section('title', 'User Management')
@section('page-title', 'User Verification')

@section('content')

    {{-- Custom Table Styles for Spacing and Readability --}}
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

    <div class="mb-8 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
        {{-- Header & Tabs --}}
        <div>
            <h2 class="text-3xl font-black text-white uppercase tracking-tighter">User Directory</h2>
            <div class="flex flex-wrap gap-4 mt-4">
                @php $status = request('status', 'pending'); @endphp
                <a href="?status=pending"
                    class="px-6 py-2.5 rounded-xl text-[0.65rem] font-black uppercase tracking-widest transition-all shadow-lg {{ $status === 'pending' ? 'bg-blue text-navy shadow-[0_0_20px_rgba(180,180,254,0.3)]' : 'bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white' }}">
                    <i class="fas fa-hourglass-half mr-1.5 {{ $status === 'pending' ? 'text-navy' : '' }}"></i> Pending
                    Review
                </a>
                <a href="?status=active"
                    class="px-6 py-2.5 rounded-xl text-[0.65rem] font-black uppercase tracking-widest transition-all shadow-lg {{ $status === 'active' ? 'bg-blue text-navy shadow-[0_0_20px_rgba(180,180,254,0.3)]' : 'bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white' }}">
                    <i class="fas fa-user-check mr-1.5 {{ $status === 'active' ? 'text-navy' : '' }}"></i> Active Users
                </a>
            </div>
        </div>

        {{-- Search Form --}}
        <form method="GET" action="{{ url()->current() }}"
            class="bg-navy2 p-2 rounded-2xl border border-white/10 flex items-center shadow-inner w-full xl:w-auto">
            <input type="hidden" name="status" value="{{ $status }}">
            <i class="fas fa-search text-white/30 ml-4 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                class="bg-transparent border-none px-4 py-2 text-sm font-bold text-white placeholder-white/30 outline-none w-full xl:w-72 focus:ring-0">
            <button type="submit"
                class="bg-blue text-navy px-4 py-2.5 rounded-xl hover:bg-white transition-colors shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                <i class="fas fa-arrow-right text-sm"></i>
            </button>
        </form>
    </div>

    {{-- Main Table Container --}}
    <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
        <div class="overflow-x-auto min-h-[400px]">
            <table class="cp-table">
                <thead>
                    <tr>
                        <th class="text-left">User Identity</th>
                        <th class="text-left">Professional Role</th>
                        <th class="text-left">Primary Association</th>
                        <th class="text-left">Registration Date</th>
                        <th class="text-right">Verification</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        @php
                            $roleClass = match ($user->role) {
                                'advocate' => 'bg-blue/10 text-blue border-blue/20',
                                'court_clerk', 'ip_clerk' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                'ca_cs', 'agent' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                default => 'bg-white/5 text-white/50 border-white/10'
                            };
                            $initials = strtoupper(substr($user->name, 0, 1)) . (strtoupper(substr(strrchr($user->name, " "), 1, 1)) ?: '');
                        @endphp
                        <tr class="group">
                            {{-- User Identity --}}
                            <td>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-xl {{ $roleClass }} border flex items-center justify-center font-black text-sm group-hover:scale-105 transition-transform shadow-lg">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-white uppercase tracking-tight mb-1">
                                            {{ $user->name }}</div>
                                        <div class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest font-mono">
                                            {{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Professional Role --}}
                            <td>
                                <div class="flex flex-col items-start gap-1.5">
                                    <span
                                        class="text-[0.55rem] font-black uppercase tracking-widest {{ $roleClass }} border px-2.5 py-1 rounded-md">
                                        {{ str_replace('_', ' ', $user->role) }}
                                    </span>
                                    @if($user->sub_role)
                                        <span class="text-[0.6rem] font-bold uppercase tracking-widest text-white/40">
                                            Spec: <span class="text-white/70">{{ str_replace('_', ' ', $user->sub_role) }}</span>
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Primary Association --}}
                            <td>
                                <div class="text-xs font-black text-white uppercase tracking-tight mb-1">
                                    {{ $user->court->name ?? 'Direct Network' }}
                                </div>
                                <div class="text-[0.6rem] text-white/40 uppercase tracking-widest font-bold">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $user->court->city ?? 'All India' }}
                                </div>
                            </td>

                            {{-- Registration Date --}}
                            <td>
                                <div class="text-xs font-bold text-white mb-1">{{ $user->created_at->format('d M, Y') }}</div>
                                <div class="text-[0.6rem] text-white/40 font-black uppercase tracking-widest">
                                    <i class="far fa-clock mr-1"></i> {{ $user->created_at->diffForHumans() }}
                                </div>
                            </td>

                            {{-- Verification Actions --}}
                            <td class="text-right">
                                @if($user->status === 'active')
                                    <button onclick="toggleVerify('{{ $user->id }}', this)"
                                        class="px-5 py-2.5 rounded-xl text-[0.6rem] font-black uppercase tracking-widest transition-all bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white hover:shadow-[0_5px_15px_rgba(239,68,68,0.2)]">
                                        <i class="fas fa-ban mr-1"></i> Deactivate
                                    </button>
                                @else
                                    <button onclick="toggleVerify('{{ $user->id }}', this)"
                                        class="px-5 py-2.5 rounded-xl text-[0.6rem] font-black uppercase tracking-widest transition-all bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500 hover:text-white hover:shadow-[0_5px_15px_rgba(34,197,94,0.2)]">
                                        <i class="fas fa-check-circle mr-1"></i> Verify & Activate
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-2xl mb-4">
                                        <i class="fas fa-users-slash"></i>
                                    </div>
                                    <p class="text-white font-black uppercase tracking-[0.25em] text-xs mb-1">No users found</p>
                                    <p class="text-white/40 font-bold text-[0.65rem] uppercase tracking-widest">Try adjusting
                                        your search or filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
            <div class="px-8 py-6 bg-navy border-t border-white/5">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        async function toggleVerify(userId, btnElement) {
            const isDeactivating = btnElement.innerText.toLowerCase().includes('deactivate');
            const actionText = isDeactivating ? 'deactivate this user' : 'verify and activate this user';

            if (!confirm(`Are you sure you want to ${actionText}?`)) return;

            // Save original state for fallback
            const originalHtml = btnElement.innerHTML;

            // Set loading state
            btnElement.disabled = true;
            btnElement.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Processing...';

            try {
                const response = await fetch(`/admin/manage/users/${userId}/verify`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    // If backend needs action type, we can pass it, otherwise the controller usually handles toggle.
                    body: JSON.stringify({ action: isDeactivating ? 'reject' : 'verify' })
                });

                const data = await response.json();

                if (data.success) {
                    // Optional: Use existing toast if available
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'User status updated successfully.', 'ok');
                    }

                    // Reload page smoothly to reflect changes in tabs
                    setTimeout(() => {
                        window.location.reload();
                    }, 600);

                } else {
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Failed to update user status', 'err');
                    } else {
                        alert(data.message || 'Failed to update user status');
                    }
                    btnElement.disabled = false;
                    btnElement.innerHTML = originalHtml;
                }
            } catch (e) {
                console.error(e);
                if (typeof showToast === 'function') {
                    showToast('A network error occurred. Please try again.', 'err');
                } else {
                    alert('A network error occurred. Please try again.');
                }
                btnElement.disabled = false;
                btnElement.innerHTML = originalHtml;
            }
        }
    </script>
@endpush