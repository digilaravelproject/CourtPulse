@extends('layouts.admin')
@section('title', 'User Management')
@section('page-title', 'User Verification')

@section('content')

    <div class="mb-10 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-8">
        {{-- Header & Tabs --}}
        <div>
            <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-3">User Directory</h2>
            <p class="text-[0.7rem] font-bold text-white/50 uppercase tracking-widest">Manage and verify network participants</p>

            <div class="flex flex-wrap gap-4 mt-6">
                @php $status = request('status', 'pending'); @endphp
                <a href="?status=pending"
                    class="flex items-center gap-2 px-6 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg {{ $status === 'pending' ? 'bg-blue text-navy shadow-[0_0_20px_rgba(180,180,254,0.3)]' : 'bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white' }}">
                    <i class="fas fa-hourglass-half {{ $status === 'pending' ? 'text-navy' : '' }}"></i> Pending Review
                </a>
                <a href="?status=active"
                    class="flex items-center gap-2 px-6 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg {{ $status === 'active' ? 'bg-blue text-navy shadow-[0_0_20px_rgba(180,180,254,0.3)]' : 'bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white' }}">
                    <i class="fas fa-user-check {{ $status === 'active' ? 'text-navy' : '' }}"></i> Active Users
                </a>
            </div>
        </div>

        {{-- Search Form --}}
        <form method="GET" action="{{ url()->current() }}"
            class="bg-navy2 p-3 rounded-3xl border border-white/5 flex flex-col sm:flex-row items-center gap-3 shadow-2xl w-full xl:w-auto">
            <input type="hidden" name="status" value="{{ $status }}">

            <div class="relative w-full xl:w-80">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                    class="w-full pl-12 pr-5 py-4 bg-navy border border-white/10 rounded-2xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner">
            </div>

            <button type="submit"
                class="w-full sm:w-auto flex justify-center items-center gap-2 px-8 py-4 bg-blue hover:bg-white text-navy rounded-2xl transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)] font-black text-xs uppercase tracking-widest">
                <span>Search</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>

    {{-- Main Table Container --}}
    <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
        <div class="p-8 border-b border-white/5 bg-white/5 flex items-center justify-between">
            <h3 class="font-black text-base text-white uppercase tracking-widest">
                {{ $status === 'pending' ? 'Verification Queue' : 'Active Network Members' }}
            </h3>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white/5 border-b border-white/5">
                        <th class="px-8 py-6 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase">User Identity</th>
                        <th class="px-8 py-6 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase">Professional Role</th>
                        <th class="px-8 py-6 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase">Primary Association</th>
                        <th class="px-8 py-6 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase">Registration Date</th>
                        <th class="px-8 py-6 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase text-right">Verification</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        @php
                            $roleClass = match ($user->role) {
                                'advocate' => 'bg-blue/10 text-blue border-blue/20 shadow-[0_0_15px_rgba(180,180,254,0.15)]',
                                'court_clerk', 'ip_clerk' => 'bg-purple-500/10 text-purple-400 border-purple-500/20 shadow-[0_0_15px_rgba(168,85,247,0.15)]',
                                'ca_cs', 'agent' => 'bg-amber-500/10 text-amber-400 border-amber-500/20 shadow-[0_0_15px_rgba(245,158,11,0.15)]',
                                default => 'bg-white/5 text-white/50 border-white/10'
                            };
                            $initials = strtoupper(substr($user->name, 0, 1)) . (strtoupper(substr(strrchr($user->name, " "), 1, 1)) ?: '');
                        @endphp
                        <tr class="hover:bg-white/5 transition-colors duration-300 group" data-uid="{{ $user->id }}">

                            {{-- User Identity --}}
                            <td class="px-8 py-6 align-middle">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-xl {{ $roleClass }} border flex items-center justify-center font-black text-sm group-hover:scale-105 transition-transform">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-white uppercase tracking-tight mb-1 group-hover:text-blue transition-colors">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest font-mono">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Professional Role --}}
                            <td class="px-8 py-6 align-middle">
                                <div class="flex flex-col items-start gap-2">
                                    <span class="inline-flex text-[0.6rem] font-black uppercase tracking-widest {{ $roleClass }} border px-3 py-1.5 rounded-lg">
                                        {{ str_replace('_', ' ', $user->role) }}
                                    </span>
                                    @if($user->sub_role)
                                        <span class="text-[0.6rem] font-bold uppercase tracking-widest text-white/40 mt-1">
                                            Spec: <span class="text-white/70">{{ str_replace('_', ' ', $user->sub_role) }}</span>
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Primary Association --}}
                            <td class="px-8 py-6 align-middle">
                                <div class="text-xs font-black text-white uppercase tracking-tight mb-1.5">
                                    {{ $user->court->name ?? 'Direct Network' }}
                                </div>
                                <div class="text-[0.65rem] text-white/40 uppercase tracking-widest font-bold">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $user->court->city ?? 'All India' }}
                                </div>
                            </td>

                            {{-- Registration Date --}}
                            <td class="px-8 py-6 align-middle">
                                <div class="text-xs font-bold text-white mb-1.5">{{ $user->created_at->format('d M, Y') }}</div>
                                <div class="text-[0.65rem] text-white/40 font-black uppercase tracking-widest">
                                    <i class="far fa-clock mr-1"></i> {{ $user->created_at->diffForHumans() }}
                                </div>
                            </td>

                            {{-- Verification Actions --}}
                            <td class="px-8 py-6 align-middle text-right">
                                @if($user->status === 'active')
                                    <button onclick="openReject('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-[0.65rem] font-black uppercase tracking-widest transition-all bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white hover:shadow-[0_5px_15px_rgba(239,68,68,0.2)]">
                                        <i class="fas fa-ban text-sm"></i> Deactivate
                                    </button>
                                @else
                                    <button onclick="openVerify('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ $user->role }}', '{{ $user->email }}', '{{ $user->phone ?? '' }}', '{{ addslashes($user->court->name ?? 'Direct Network') }}', '{{ addslashes($user->court->city ?? 'All India') }}')"
                                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-[0.65rem] font-black uppercase tracking-widest transition-all bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500 hover:text-white hover:shadow-[0_5px_15px_rgba(34,197,94,0.2)]">
                                        <i class="fas fa-check-circle text-sm"></i> Review & Verify
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-3xl mb-5">
                                        <i class="fas fa-users-slash"></i>
                                    </div>
                                    <p class="text-white font-black uppercase tracking-[0.25em] text-sm mb-2">No users found</p>
                                    <p class="text-white/40 font-bold text-[0.7rem] uppercase tracking-widest">
                                        Try adjusting your search or filters.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
            <div class="px-8 py-6 bg-navy/50 border-t border-white/5">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @include('admin.partials.verification-modals')

@endsection
