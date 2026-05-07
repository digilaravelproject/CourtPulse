@extends('layouts.admin')
@section('title', 'User Management')
@section('page-title', 'User Verification')

@section('content')

    <div class="mb-6 flex flex-col lg:flex-row items-start lg:items-end justify-between gap-4">
        {{-- Header & Tabs --}}
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight mb-1">User Directory</h2>
            <p class="text-[0.65rem] font-semibold text-white/40 uppercase tracking-wider">Manage and verify network participants</p>

            <div class="flex gap-2 mt-4">
                @php $status = request('status', 'pending'); @endphp
                <a href="?status=pending"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-[0.7rem] font-bold uppercase tracking-wider transition-all {{ $status === 'pending' ? 'bg-blue text-navy shadow-md' : 'bg-white/5 text-white/50 border border-white/10 hover:bg-white/10' }}">
                    <i class="fas fa-hourglass-half text-[0.8rem]"></i> Pending Review
                </a>
                <a href="?status=active"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-[0.7rem] font-bold uppercase tracking-wider transition-all {{ $status === 'active' ? 'bg-blue text-navy shadow-md' : 'bg-white/5 text-white/50 border border-white/10 hover:bg-white/10' }}">
                    <i class="fas fa-user-check text-[0.8rem]"></i> Active Users
                </a>
            </div>
        </div>

        {{-- Search Form --}}
        <form method="GET" action="{{ url()->current() }}"
            class="flex items-center gap-2 w-full lg:w-auto">
            <input type="hidden" name="status" value="{{ $status }}">

            <div class="relative flex-grow lg:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..."
                    class="w-full pl-9 pr-4 py-2 bg-navy2 border border-white/10 rounded-lg text-white text-sm placeholder-white/20 focus:outline-none focus:border-blue transition-colors">
            </div>

            <button type="submit"
                class="flex items-center gap-2 px-5 py-2 bg-blue hover:bg-blue/90 text-navy rounded-lg transition-all font-bold text-[0.7rem] uppercase tracking-wider">
                <span>Search</span>
            </button>
        </form>
    </div>

    {{-- Main Table Container --}}
    <div class="bg-navy2 rounded-xl border border-white/5 shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
            <h3 class="font-bold text-xs text-white/70 uppercase tracking-widest">
                {{ $status === 'pending' ? 'Verification Queue' : 'Active Network Members' }}
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white/[0.03] border-b border-white/5">
                        <th class="px-6 py-3 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">User Identity</th>
                        <th class="px-6 py-3 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">Role</th>
                        <th class="px-6 py-3 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">Association</th>
                        <th class="px-6 py-3 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase">Joined</th>
                        <th class="px-6 py-3 font-bold text-white/30 text-[0.6rem] tracking-widest uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
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
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg {{ $roleClass }} border flex items-center justify-center font-bold text-[0.7rem]">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="text-[0.8rem] font-bold text-white group-hover:text-blue transition-colors">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-[0.6rem] text-white/30 font-medium">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-3">
                                <span class="inline-block text-[0.55rem] font-bold uppercase tracking-tighter {{ $roleClass }} border px-2 py-0.5 rounded-md">
                                    {{ str_replace('_', ' ', $user->role) }}
                                </span>
                            </td>

                            <td class="px-6 py-3">
                                <div class="text-[0.7rem] font-bold text-white/80">{{ $user->court->name ?? 'Direct Network' }}</div>
                                <div class="text-[0.6rem] text-white/30 uppercase"><i class="fas fa-map-marker-alt text-[0.5rem] mr-1"></i> {{ $user->court->city ?? 'All India' }}</div>
                            </td>

                            <td class="px-6 py-3">
                                <div class="text-[0.7rem] text-white/80 font-medium">{{ $user->created_at->format('d M, Y') }}</div>
                                <div class="text-[0.55rem] text-white/30 uppercase">{{ $user->created_at->diffForHumans() }}</div>
                            </td>

                            <td class="px-6 py-3 text-right">
                                @if($user->status === 'active')
                                    <button onclick="openReject('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                        class="px-3 py-1.5 rounded-md text-[0.6rem] font-bold uppercase bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all">
                                        Deactivate
                                    </button>
                                @else
                                    <button onclick="openVerify('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ $user->role }}', '{{ $user->email }}', '{{ $user->phone ?? '' }}', '{{ addslashes($user->court->name ?? 'Direct Network') }}', '{{ addslashes($user->court->city ?? 'All India') }}')"
                                        class="px-3 py-1.5 rounded-md text-[0.6rem] font-bold uppercase bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500 hover:text-white transition-all">
                                        Review
                                    </button>
                                @endif
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

    @include('admin.partials.verification-modals')

@endsection
