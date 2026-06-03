@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')

    {{-- ══ STAT CARDS ══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        {{-- Total Professionals --}}
        <div class="bg-navy2 rounded-2xl border border-white/5 shadow-2xl p-6 flex items-start justify-between gap-4 hover:-translate-y-1 hover:border-blue/30 transition-all duration-300 group">
            <div>
                <div class="text-[0.65rem] font-black tracking-[0.2em] uppercase text-white/50 mb-2 group-hover:text-blue transition-colors">Professionals</div>
                <div class="font-black text-4xl text-white leading-none mb-3">
                    {{ number_format($stats['professionals']['total'] ?? 0) }}
                </div>
                <div class="flex flex-wrap items-center gap-2 text-[0.6rem] font-black uppercase tracking-widest">
                    <span class="bg-blue/10 text-blue px-2 py-1 rounded-md border border-blue/20">{{ number_format($stats['professionals']['advocates'] ?? 0) }} Adv</span>
                    <span class="bg-white/5 text-white/80 px-2 py-1 rounded-md border border-white/10">{{ number_format($stats['professionals']['ca_cs'] ?? 0) }} CA/CS</span>
                    <span class="bg-white/5 text-white/80 px-2 py-1 rounded-md border border-white/10">{{ number_format($stats['professionals']['ip_agents'] ?? 0) }} IP</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <i class="fas fa-user-tie text-blue text-xl"></i>
            </div>
        </div>

        {{-- Total Support (Clerks) --}}
        <div class="bg-navy2 rounded-2xl border border-white/5 shadow-2xl p-6 flex items-start justify-between gap-4 hover:-translate-y-1 hover:border-blue/30 transition-all duration-300 group">
            <div>
                <div class="text-[0.65rem] font-black tracking-[0.2em] uppercase text-white/50 mb-2 group-hover:text-blue transition-colors">Support Staff</div>
                <div class="font-black text-4xl text-white leading-none mb-3">
                    {{ number_format($stats['support']['total'] ?? 0) }}
                </div>
                <div class="flex flex-wrap items-center gap-2 text-[0.6rem] font-black uppercase tracking-widest">
                    <span class="bg-blue/10 text-blue px-2 py-1 rounded-md border border-blue/20">{{ number_format($stats['support']['court_clerks'] ?? 0) }} Court</span>
                    <span class="bg-white/5 text-white/80 px-2 py-1 rounded-md border border-white/10">{{ number_format($stats['support']['ip_clerks'] ?? 0) }} IP</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <i class="fas fa-users-cog text-blue text-xl"></i>
            </div>
        </div>

        {{-- Pending Approval --}}
        <div class="bg-navy2 rounded-2xl border-y border-r border-white/5 border-l-4 border-l-blue shadow-2xl p-6 flex items-start justify-between gap-4 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(180,180,254,0.15)] transition-all duration-300 group">
            <div>
                <div class="text-[0.65rem] font-black tracking-[0.2em] uppercase text-white/50 mb-2 group-hover:text-blue transition-colors">Pending Approvals</div>
                <div class="font-black text-4xl text-blue leading-none mb-3">
                    {{ number_format($stats['total_pending'] ?? 0) }}
                </div>
                <div class="flex items-center gap-1.5 mt-2 text-[0.6rem] font-black uppercase tracking-widest text-red-400 bg-red-500/10 px-2 py-1 rounded-md border border-red-500/20">
                    <i class="fas fa-exclamation-triangle"></i> Action Required
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center shrink-0 group-hover:rotate-12 transition-transform">
                <i class="fas fa-hourglass-half text-blue text-xl"></i>
            </div>
        </div>

        {{-- Total Courts --}}
        <div class="bg-navy2 rounded-2xl border border-white/5 shadow-2xl p-6 flex items-start justify-between gap-4 hover:-translate-y-1 hover:border-gold/30 transition-all duration-300 group">
            <div>
                <div class="text-[0.65rem] font-black tracking-[0.2em] uppercase text-white/50 mb-2 group-hover:text-gold transition-colors">Registered Courts</div>
                <div class="font-black text-4xl text-white leading-none mb-3">
                    {{ number_format($courtCount ?? 0) }}
                </div>
                <div class="flex items-center gap-1.5 mt-2 text-[0.6rem] font-black uppercase tracking-widest text-gold/70 bg-gold/5 px-2 py-1 rounded-md border border-gold/10">
                    <i class="fas fa-gavel"></i> Judicial Network
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gold/10 border border-gold/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <i class="fas fa-university text-gold text-xl"></i>
            </div>
        </div>
    </div>

    {{-- ══ CHART + ACTIVITY ════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Bar Chart --}}
        <div class="lg:col-span-2 bg-navy2 rounded-2xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 border-b border-white/5 bg-white/5 gap-4">
                <h2 class="font-black text-sm text-white uppercase tracking-widest">User Growth Analytics</h2>
                <div class="relative">
                    <select class="pl-4 pr-8 py-2 text-[0.65rem] font-black uppercase tracking-widest border border-white/10 rounded-lg bg-navy text-blue focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue appearance-none shadow-inner">
                        <option>Last 30 Days</option>
                        <option>Last Quarter</option>
                        <option>This Year</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none"></i>
                </div>
            </div>
            <div class="p-6 grow min-h-[300px] w-full">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-navy2 rounded-2xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-white/5 bg-white/5">
                <h2 class="font-black text-sm text-white uppercase tracking-widest">Recent Signups</h2>
            </div>
            <div class="overflow-y-auto grow max-h-[350px]">
                @forelse($recentUsers->take(8) as $u)
                    <div class="flex items-start gap-4 p-5 border-b border-white/5 last:border-0 hover:bg-white/5 transition-colors group">
                        @php
                            $initials = strtoupper(substr($u->name, 0, 2));
                            $bgClass = match($u->role) {
                                'advocate' => 'bg-blue/10 text-blue border-blue/20',
                                'court_clerk', 'ip_clerk' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                'ca_cs', 'agent' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                default => 'bg-white/5 text-white/50 border-white/10'
                            };
                        @endphp
                        <div class="w-10 h-10 rounded-xl border {{ $bgClass }} flex items-center justify-center font-black text-sm shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                            {{ $initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-bold text-white truncate mb-1">
                                {{ $u->name }}
                            </div>
                            <div class="text-[0.6rem] text-white/50 uppercase tracking-widest mb-1">{{ ucwords(str_replace('_', ' ', $u->role)) }}</div>
                            <div class="text-[0.6rem] text-white/30 font-mono">{{ $u->created_at->diffForHumans() }}</div>
                        </div>
                        @if ($u->status === 'active')
                            <span class="shrink-0 inline-flex items-center px-2 py-1 rounded bg-green-500/10 border border-green-500/20 text-green-400 font-black text-[0.55rem] uppercase tracking-widest">Active</span>
                        @else
                            <span class="shrink-0 inline-flex items-center px-2 py-1 rounded bg-amber-500/10 border border-amber-500/20 text-amber-400 font-black text-[0.55rem] uppercase tracking-widest">{{ $u->status }}</span>
                        @endif
                    </div>
                @empty
                    <div class="py-12 text-center text-white/40 text-xs font-bold uppercase tracking-widest">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ══ VERIFICATION QUEUE ══════════════════════════════════════ --}}
    <div class="bg-navy2 rounded-2xl border border-white/5 shadow-2xl overflow-hidden mb-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 border-b border-white/5 bg-white/5 gap-4">
            <div>
                <h2 class="font-black text-sm text-white uppercase tracking-widest">Verification Queue</h2>
                <p class="text-[0.65rem] text-white/50 mt-1 uppercase tracking-widest font-bold">Review pending profiles and certificates.</p>
            </div>
            <a href="{{ route('admin.manage.users') }}?status=pending"
                class="flex items-center gap-2 px-5 py-2.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-lg bg-navy hover:bg-white hover:text-navy text-white transition-all">
                <i class="fas fa-filter"></i> View All
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-navy border-b border-white/10">
                        <th class="px-6 py-4 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/50">User Profile</th>
                        <th class="px-6 py-4 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/50 hidden md:table-cell">Applied On</th>
                        <th class="px-6 py-4 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/50 hidden sm:table-cell">Contact Details</th>
                        <th class="px-6 py-4 font-black text-[0.6rem] tracking-[0.2em] uppercase text-white/50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @php $pendingUsers = $recentUsers->where('status', 'pending'); @endphp
                    @forelse($pendingUsers as $u)
                        @php
                            $roleClass = match($u->role) {
                                'advocate' => 'bg-blue/10 text-blue border-blue/20',
                                'court_clerk', 'ip_clerk' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                'ca_cs', 'agent' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                default => 'bg-white/5 text-white/50 border-white/10'
                            };
                        @endphp
                        <tr class="hover:bg-white/5 transition-colors group" data-uid="{{ $u->id }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl border {{ $roleClass }} flex items-center justify-center font-black text-xs shrink-0 shadow-lg">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-xs text-white mb-1">{{ $u->name }}</div>
                                        <span class="inline-block text-[0.55rem] font-black px-2 py-0.5 rounded {{ $roleClass }} uppercase tracking-widest border">
                                            {{ str_replace('_', ' ', $u->role) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-white/60 text-[0.7rem] font-bold uppercase tracking-wider hidden md:table-cell">
                                {{ $u->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <div class="text-xs font-bold text-white mb-1">{{ $u->email }}</div>
                                <div class="text-[0.65rem] text-white/50 tracking-widest font-mono">{{ $u->phone ?? 'Not Provided' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3 justify-end">
                                    <button
                                        onclick="openVerify({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->role }}', '{{ $u->email }}', '{{ $u->phone ?? '' }}', '{{ addslashes($u->court->name ?? 'Direct Network') }}', '{{ addslashes($u->court->city ?? 'All India') }}')"
                                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500/10 border border-green-500/30 hover:bg-green-500 text-green-400 hover:text-white text-[0.65rem] font-black uppercase tracking-widest transition-all">
                                        <i class="fas fa-check-circle text-xs"></i> Review & Verify
                                    </button>
                                    <button onclick="openReject({{ $u->id }}, '{{ addslashes($u->name) }}')"
                                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-500/10 border border-red-500/30 hover:bg-red-500 text-red-400 hover:text-white text-[0.65rem] font-black uppercase tracking-widest transition-all">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center">
                                <div class="w-16 h-16 rounded-full bg-green-500/10 flex items-center justify-center text-green-400 text-2xl mx-auto mb-4 border border-green-500/20">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <p class="text-white text-sm font-black uppercase tracking-widest mb-1">All Caught Up!</p>
                                <p class="text-[0.65rem] text-white/50 uppercase tracking-widest font-bold">No pending verifications at the moment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pendingUsers->count() > 0)
            <div class="px-6 py-4 border-t border-white/5 bg-navy flex items-center justify-between">
                <span class="text-[0.65rem] text-white/50 font-black uppercase tracking-widest">{{ $pendingUsers->count() }} Profiles Waiting</span>
                <a href="{{ route('admin.manage.users') }}?status=pending" class="text-[0.65rem] font-black uppercase tracking-widest text-blue hover:text-white transition-colors flex items-center gap-1">
                    Process Queue <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>

    @include('admin.partials.user-management-modals')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        /* ── CHART IMPLEMENTATION (DARK MODE) ────────────────────────────────────── */
        (function () {
            const ctx = document.getElementById('growthChart');
            if (ctx) {
                const labels = {!! json_encode($stats['chart_labels'] ?? []) !!};
                const dataPoints = {!! json_encode($stats['chart_data'] ?? []) !!};

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'New Registrations',
                            data: dataPoints,
                            borderColor: '#B4B4FE',
                            backgroundColor: 'rgba(180, 180, 254, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#050812',
                            pointBorderColor: '#B4B4FE',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#B4B4FE',
                            pointHoverBorderColor: '#fff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(11, 17, 32, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#B4B4FE',
                                titleFont: { family: "'Manrope', sans-serif", size: 11, weight: 'bold' },
                                bodyFont: { family: "'Manrope', sans-serif", size: 14, weight: 'bold' },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    color: 'rgba(255, 255, 255, 0.4)',
                                    font: { family: "'Manrope', sans-serif", size: 10, weight: 'bold' }
                                },
                                border: { display: false },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)',
                                    drawBorder: false,
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'rgba(255, 255, 255, 0.4)',
                                    font: { family: "'Manrope', sans-serif", size: 10, weight: 'bold' }
                                },
                                border: { display: false },
                                grid: { display: false }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                    }
                });
            }
        })();

    </script>
@endpush
