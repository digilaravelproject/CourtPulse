@extends('layouts.super-admin')
@section('title', 'Super Admin Dashboard')
@section('page-title', 'Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        {{-- Total Users --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-500 font-medium text-sm">Total Registerations</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-2">
                <div class="flex items-center justify-between text-[0.7rem]">
                    <span class="text-slate-400">Active</span>
                    <span class="font-bold text-green-600">{{ $stats['active_users'] }}</span>
                </div>
                <div class="flex items-center justify-between text-[0.7rem]">
                    <span class="text-slate-400">Pending</span>
                    <span class="font-bold text-amber-600">{{ $stats['pending_users'] }}</span>
                </div>
            </div>
        </div>

        {{-- Verification --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-500 font-medium text-sm">Pending Verifications</h3>
                    <p class="text-3xl font-bold text-amber-600 mt-1">{{ number_format($stats['pending_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-400">
                <i class="bi bi-info-circle mr-1"></i>
                <span>Action required for access</span>
            </div>
        </div>

        {{-- Docs --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-500 font-medium text-sm">Pending Documents</h3>
                    <p class="text-3xl font-bold text-indigo-600 mt-1">{{ number_format($stats['pending_docs']) }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="bi bi-file-earmark-check"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-indigo-600 font-medium">
                <i class="bi bi-eye-fill mr-1"></i>
                <span>Review documents</span>
            </div>
        </div>

        {{-- Feedback --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-500 font-medium text-sm">Total Feedback</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_feedbacks']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="bi bi-star"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-purple-600 font-medium">
                <i class="bi bi-chat-left-dots mr-1"></i>
                <span>User experiences</span>
            </div>
        </div>
    </div>

    {{-- System Status & Recent Users --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        {{-- Role Distribution --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i class="bi bi-pie-chart text-gold"></i> Role Distribution
            </h3>
            <div class="space-y-4">
                @foreach($roleDistribution as $role)
                    @php
                        $perc = $stats['total_users'] > 0 ? ($role['count'] / $stats['total_users']) * 100 : 0;
                        $color = match($role['role']) {
                            'Advocate' => 'bg-blue-500',
                            'Clerk' => 'bg-purple-500',
                            'Ca' => 'bg-amber-500',
                            'Guest' => 'bg-slate-500',
                            'Admin' => 'bg-orange-500',
                            default => 'bg-indigo-500'
                        };
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1.5 text-slate-600">
                            <span>{{ $role['role'] }}</span>
                            <span class="text-slate-400 font-mono">{{ $role['count'] }} users</span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                            <div class="h-full {{ $color }} rounded-full" style="width: {{ $perc }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8 pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                <div class="text-center">
                    <p class="text-[0.6rem] uppercase tracking-wider text-slate-400 font-bold mb-1">Roles</p>
                    <p class="text-lg font-bold text-slate-800">{{ $stats['total_roles'] }}</p>
                </div>
                <div class="text-center">
                    <p class="text-[0.6rem] uppercase tracking-wider text-slate-400 font-bold mb-1">Permissions</p>
                    <p class="text-lg font-bold text-slate-800">{{ $stats['total_permissions'] }}</p>
                </div>
            </div>
        </div>

        {{-- Recent Users List --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-clock-history text-gold"></i> Latest Registrations
                </h3>
                <a href="{{ route('super.users') }}" class="text-blue-600 text-[0.7rem] font-bold uppercase tracking-wider hover:underline">Manage All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[0.6rem] uppercase tracking-widest font-bold">
                            <th class="px-6 py-3 text-left">Professional</th>
                            <th class="px-6 py-3 text-left">Role</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentUsers as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-600 text-xs">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">{{ $user->name }}</p>
                                        <p class="text-[0.65rem] text-slate-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-indigo-50 text-indigo-600 text-[0.6rem] px-2 py-0.5 rounded uppercase font-bold tracking-wider">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->status === 'active')
                                    <div class="flex items-center gap-1.5 text-green-600 font-bold text-[0.65rem] uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </div>
                                @elseif($user->status === 'pending')
                                    <div class="flex items-center gap-1.5 text-amber-500 font-bold text-[0.65rem] uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Pending
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 text-red-500 font-bold text-[0.65rem] uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400 font-mono">
                                {{ $user->created_at->format('d M') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
