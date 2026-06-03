@extends('layouts.admin')
@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')

    <div class="mb-6 flex flex-col lg:flex-row items-start lg:items-end justify-between gap-4">
        {{-- Header & Tabs --}}
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight mb-1">User Directory</h2>
            <p class="text-[0.65rem] font-semibold text-white/40 uppercase tracking-wider">Manage system users, roles, and permissions</p>

            <div class="flex flex-wrap gap-2 mt-4">
                @php 
                    $status = request('status'); 
                    $roleCategory = request('role_category');
                    $search = request('search');
                    $queryStr = ($roleCategory ? '&role_category='.$roleCategory : '') . ($search ? '&search='.$search : '');
                @endphp
                <a href="?{{ $roleCategory ? 'role_category='.$roleCategory : '' }}{{ $search ? '&search='.$search : '' }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-[0.7rem] font-bold uppercase tracking-wider transition-all {{ is_null($status) ? 'bg-blue text-navy shadow-md' : 'bg-white/5 text-white/50 border border-white/10 hover:bg-white/10' }}">
                    <i class="fas fa-users text-[0.8rem]"></i> All Status
                </a>
                <a href="?status=pending{{ $queryStr }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-[0.7rem] font-bold uppercase tracking-wider transition-all {{ $status === 'pending' ? 'bg-blue text-navy shadow-md' : 'bg-white/5 text-white/50 border border-white/10 hover:bg-white/10' }}">
                    <i class="fas fa-hourglass-half text-[0.8rem]"></i> Pending Review
                </a>
                <a href="?status=active{{ $queryStr }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-[0.7rem] font-bold uppercase tracking-wider transition-all {{ $status === 'active' ? 'bg-blue text-navy shadow-md' : 'bg-white/5 text-white/50 border border-white/10 hover:bg-white/10' }}">
                    <i class="fas fa-user-check text-[0.8rem]"></i> Active Users
                </a>
                <a href="?status=rejected{{ $queryStr }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-[0.7rem] font-bold uppercase tracking-wider transition-all {{ $status === 'rejected' ? 'bg-blue text-navy shadow-md' : 'bg-white/5 text-white/50 border border-white/10 hover:bg-white/10' }}">
                    <i class="fas fa-user-times text-[0.8rem]"></i> Inactive / Rejected
                </a>
            </div>
        </div>

        {{-- Add User & Search Form --}}
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <button onclick="openAddUserModal()"
                class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-green-500 hover:bg-green-400 text-navy rounded-lg transition-all font-black text-[0.7rem] uppercase tracking-wider shadow-lg shadow-green-500/10 shrink-0">
                <i class="fas fa-user-plus text-[0.85rem]"></i>
                <span>Add User</span>
            </button>

            <form method="GET" action="{{ url()->current() }}"
                class="flex items-center gap-2 w-full sm:w-auto">
                <input type="hidden" name="status" value="{{ $status }}">
                @if($roleCategory)
                    <input type="hidden" name="role_category" value="{{ $roleCategory }}">
                @endif

                <div class="relative flex-grow sm:w-60">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search name, email, phone..."
                        class="w-full pl-9 pr-4 py-2.5 bg-navy2 border border-white/10 rounded-lg text-white text-sm placeholder-white/20 focus:outline-none focus:border-blue transition-colors">
                </div>

                <button type="submit"
                    class="flex items-center gap-2 px-5 py-2.5 bg-blue hover:bg-blue/90 text-navy rounded-lg transition-all font-bold text-[0.7rem] uppercase tracking-wider">
                    <span>Search</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Main Table Container --}}
    <div class="bg-navy2 rounded-xl border border-white/5 shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <h3 class="font-bold text-xs text-white/70 uppercase tracking-widest">
                @if($roleCategory)
                    {{ ucfirst($roleCategory) }} Directory - 
                @endif
                @if(is_null($status))
                    All Members
                @elseif($status === 'pending')
                    Verification Queue
                @elseif($status === 'active')
                    Active Members
                @else
                    Inactive / Suspended Members
                @endif
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white/[0.03] border-b border-white/5">
                        <th class="px-6 py-4 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">User Identity</th>
                        <th class="px-6 py-4 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">Role / Contact</th>
                        <th class="px-6 py-4 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">Association</th>
                        <th class="px-6 py-4 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">Joined</th>
                        <th class="px-6 py-4 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        @php
                            $roleClass = match ($user->role) {
                                'super_admin', 'admin' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                'advocate' => 'bg-blue/10 text-blue border-blue/20',
                                'court_clerk', 'ip_clerk' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                'ca_cs' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                'agent' => 'bg-teal-500/10 text-teal-400 border-teal-500/20',
                                default => 'bg-white/5 text-white/50 border-white/10'
                            };
                            $initials = strtoupper(substr($user->name, 0, 1)) . (strtoupper(substr(strrchr($user->name, " "), 1, 1)) ?: '');
                        @endphp
                        <tr class="hover:bg-white/[0.02] transition-colors group" data-uid="{{ $user->id }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl {{ $roleClass }} border flex items-center justify-center font-bold text-[0.75rem] shadow-md shadow-navy/80">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="text-[0.8rem] font-bold text-white group-hover:text-blue transition-colors flex items-center gap-1.5">
                                            <span>{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="text-[0.55rem] font-bold uppercase px-1.5 py-0.5 rounded bg-blue/10 text-blue border border-blue/20">You</span>
                                            @endif
                                        </div>
                                        <div class="text-[0.6rem] text-white/30 font-medium mt-0.5">
                                            ID: #{{ $user->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-block text-[0.55rem] font-bold uppercase tracking-wider {{ $roleClass }} border px-2 py-0.5 rounded mb-1">
                                    {{ str_replace('_', ' ', $user->role) }}
                                </span>
                                <div class="text-[0.65rem] font-medium text-white/60 font-mono">{{ $user->email }}</div>
                                @if($user->phone)
                                    <div class="text-[0.6rem] text-white/30 font-mono">{{ $user->phone }}</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($user->court)
                                    <div class="text-[0.7rem] font-bold text-white/80">{{ $user->court->name }}</div>
                                    <div class="text-[0.6rem] text-white/30 uppercase mt-0.5"><i class="fas fa-map-marker-alt text-[0.5rem] mr-1"></i> {{ $user->court->city }}</div>
                                @elseif(!empty($user->court_ids))
                                    @php
                                        $primaryCourt = \App\Models\Court::find($user->court_ids[0] ?? null);
                                        $cnt = count($user->court_ids);
                                    @endphp
                                    @if($primaryCourt)
                                        <div class="text-[0.7rem] font-bold text-white/80">{{ $primaryCourt->name }}</div>
                                        <div class="text-[0.6rem] text-white/30 uppercase mt-0.5">
                                            <i class="fas fa-map-marker-alt text-[0.5rem] mr-1"></i> {{ $primaryCourt->city }}
                                            @if($cnt > 1)
                                                <span class="ml-1 bg-white/5 border border-white/10 px-1 rounded text-white/50 text-[0.5rem] font-black">+{{ $cnt - 1 }} More</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-[0.7rem] font-bold text-white/40">Direct Network</div>
                                    @endif
                                @else
                                    <div class="text-[0.7rem] font-bold text-white/40">Direct Network</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-[0.7rem] text-white/80 font-medium">{{ $user->created_at->format('d M, Y') }}</div>
                                <div class="text-[0.55rem] text-white/30 uppercase mt-0.5">{{ $user->created_at->diffForHumans() }}</div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="openManageUser('{{ $user->id }}')"
                                        class="px-3 py-1.5 rounded-lg text-[0.6rem] font-bold uppercase bg-blue/10 hover:bg-blue text-blue hover:text-navy border border-blue/20 hover:border-transparent transition-all">
                                        <i class="fas fa-cog mr-1"></i> Manage
                                    </button>

                                    @if($user->id !== auth()->id())
                                        @if($user->status === 'active')
                                            <button onclick="toggleStatus('{{ $user->id }}')"
                                                class="px-3 py-1.5 rounded-lg text-[0.6rem] font-bold uppercase bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white border border-red-500/20 hover:border-transparent transition-all">
                                                Deactivate
                                            </button>
                                        @else
                                            <button onclick="toggleStatus('{{ $user->id }}')"
                                                class="px-3 py-1.5 rounded-lg text-[0.6rem] font-bold uppercase bg-green-500/10 hover:bg-green-500 text-green-400 hover:text-white border border-green-500/20 hover:border-transparent transition-all">
                                                Activate
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <i class="fas fa-users-slash text-white/10 text-2xl mb-3 block"></i>
                                <p class="text-white/40 font-bold uppercase tracking-widest text-[0.65rem]">No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
            <div class="px-6 py-3 bg-white/[0.01] border-t border-white/5 text-xs">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @include('admin.partials.user-management-modals')

@endsection
