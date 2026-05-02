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
                <div class="flex items-center gap-1.5 mt-2 text-[0.6rem] font-black uppercase tracking-widest text-red-400 bg-red-500/10 px-2 py-1 rounded-md border border-red-500/20 inline-flex">
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
                <div class="flex items-center gap-1.5 mt-2 text-[0.6rem] font-black uppercase tracking-widest text-gold/70 bg-gold/5 px-2 py-1 rounded-md border border-gold/10 inline-flex">
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
            <div class="p-6 flex-grow min-h-[300px] w-full">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-navy2 rounded-2xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-white/5 bg-white/5">
                <h2 class="font-black text-sm text-white uppercase tracking-widest">Recent Signups</h2>
            </div>
            <div class="overflow-y-auto flex-grow max-h-[350px]">
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
                                        onclick="openVerify({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->role }}', '{{ $u->email }}', '{{ $u->phone ?? '' }}')"
                                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500/10 border border-green-500/30 hover:bg-green-500 text-green-400 hover:text-white text-[0.65rem] font-black uppercase tracking-widest transition-all">
                                        <i class="fas fa-check"></i> Verify
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

    {{-- ══ MODALS ═══════════════════════════════════════════════════ --}}
    <div id="vOverlay" onclick="closeModal()" class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-[2000] transition-opacity duration-300"></div>

    {{-- Verify Modal --}}
    <div id="vModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(450px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.8)] z-[2001] overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="flex items-center gap-4 px-6 py-5 border-b border-white/5 bg-white/5">
            <div class="w-12 h-12 rounded-xl bg-green-500/10 border border-green-500/30 flex items-center justify-center text-green-400 text-xl shrink-0 shadow-[0_0_15px_rgba(34,197,94,0.2)]">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="flex-1">
                <div class="font-black text-sm text-white uppercase tracking-widest">Verify Identity</div>
                <div class="text-[0.65rem] text-white/50 uppercase tracking-wider font-bold mt-1">Approve Account Access</div>
            </div>
            <button onclick="closeModal()" class="text-white/40 hover:text-white transition-colors text-lg focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 space-y-5 bg-navy/50">
            <div class="flex items-center gap-4 p-4 bg-navy rounded-xl border border-white/5 shadow-inner">
                <div id="v_avatar" class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center font-black text-sm text-blue shrink-0"></div>
                <div>
                    <div id="v_name" class="font-bold text-sm text-white mb-1"></div>
                    <span id="v_rpill" class="inline-block text-[0.55rem] font-black px-2 py-0.5 rounded border uppercase tracking-widest"></span>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-navy rounded-xl border border-white/5 p-4 shadow-inner">
                    <div class="text-[0.6rem] font-black uppercase tracking-[0.2em] text-white/40 mb-1">Email Address</div>
                    <div id="v_email" class="text-xs font-bold text-white break-all"></div>
                </div>
                <div class="bg-navy rounded-xl border border-white/5 p-4 shadow-inner">
                    <div class="text-[0.6rem] font-black uppercase tracking-[0.2em] text-white/40 mb-1">Phone Number</div>
                    <div id="v_phone" class="text-xs font-bold text-white font-mono tracking-wider"></div>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-3 px-6 py-5 border-t border-white/5 bg-navy">
            <button onclick="closeModal()" class="px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">Cancel</button>
            <button id="vConfirmBtn" onclick="doAction('verify')" class="flex items-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-green-500 hover:bg-green-400 text-navy rounded-xl transition-all shadow-[0_5px_15px_rgba(34,197,94,0.2)]">
                <i class="fas fa-check"></i> Confirm Verify
            </button>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(450px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.8)] z-[2001] overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="flex items-center gap-4 px-6 py-5 border-b border-white/5 bg-red-500/5">
            <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/30 flex items-center justify-center text-red-400 text-xl shrink-0 shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="flex-1">
                <div class="font-black text-sm text-white uppercase tracking-widest">Reject Application</div>
                <div id="r_sub" class="text-[0.65rem] text-white/50 uppercase tracking-wider font-bold mt-1"></div>
            </div>
            <button onclick="closeModal()" class="text-white/40 hover:text-white transition-colors text-lg focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 bg-navy/50">
            <div class="flex items-start gap-3 px-5 py-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-xs font-bold leading-relaxed shadow-inner">
                <i class="fas fa-exclamation-triangle mt-0.5 text-lg"></i>
                <p>Warning: This action will mark the user's profile as rejected. They will be denied access to all verified professional features.</p>
            </div>
        </div>
        <div class="flex justify-end gap-3 px-6 py-5 border-t border-white/5 bg-navy">
            <button onclick="closeModal()" class="px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">Cancel</button>
            <button id="rConfirmBtn" onclick="doAction('reject')" class="flex items-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-red-500 hover:bg-red-400 text-white rounded-xl transition-all shadow-[0_5px_15px_rgba(239,68,68,0.3)]">
                <i class="fas fa-times"></i> Confirm Reject
            </button>
        </div>
    </div>

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

        /* ── MODAL LOGIC ────────────────────────────────── */
        let _uid = null;
        let _uname = null;

        function openVerify(id, name, role, email, phone) {
            _uid = id;
            _uname = name;
            document.getElementById('v_avatar').textContent = name.substring(0, 2).toUpperCase();
            document.getElementById('v_name').textContent = name;
            document.getElementById('v_email').textContent = email;
            document.getElementById('v_phone').textContent = phone || 'Not Provided';

            const p = document.getElementById('v_rpill');
            p.textContent = role.replace('_', ' ');

            // Assign color classes based on role
            let rClass = 'bg-white/10 text-white border-white/20';
            if(role === 'advocate') rClass = 'bg-blue/10 text-blue border-blue/20';
            else if(role === 'court_clerk' || role === 'ip_clerk') rClass = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
            else if(role === 'ca_cs' || role === 'agent') rClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';

            p.className = `inline-block text-[0.55rem] font-black px-2 py-0.5 rounded border uppercase tracking-widest ${rClass}`;

            const overlay = document.getElementById('vOverlay');
            const modal = document.getElementById('vModal');

            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
            // Small delay for transition
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                modal.classList.remove('scale-95');
                modal.classList.add('scale-100');
            }, 10);
        }

        function openReject(id, name) {
            _uid = id;
            _uname = name;
            document.getElementById('r_sub').textContent = `Target: ${name}`;

            const overlay = document.getElementById('vOverlay');
            const modal = document.getElementById('rModal');

            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                modal.classList.remove('scale-95');
                modal.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            const overlay = document.getElementById('vOverlay');
            const vModal = document.getElementById('vModal');
            const rModal = document.getElementById('rModal');

            overlay.classList.add('opacity-0');
            vModal.classList.remove('scale-100');
            vModal.classList.add('scale-95');
            rModal.classList.remove('scale-100');
            rModal.classList.add('scale-95');

            setTimeout(() => {
                overlay.classList.add('hidden');
                vModal.classList.add('hidden');
                rModal.classList.add('hidden');
                _uid = _uname = null;
            }, 300);
        }

        function doAction(action) {
            const btnId = action === 'verify' ? 'vConfirmBtn' : 'rConfirmBtn';
            const btn = document.getElementById(btnId);
            const originalHtml = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

            const url = `{{ url('/admin/manage/users') }}/${_uid}/verify`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ action: action })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || "Action completed successfully!", "ok");
                    closeModal();

                    const row = document.querySelector(`tr[data-uid="${_uid}"]`);
                    if (row) {
                        row.style.transition = 'all 0.4s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'scale(0.98)';
                        setTimeout(() => row.remove(), 400);
                    }
                } else {
                    throw new Error(data.message || "Something went wrong");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || "Failed to process request", "err");
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
        }
    </script>
@endpush
