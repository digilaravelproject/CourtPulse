@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

    {{-- ══ STAT CARDS ══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        {{-- Total Advocates --}}
        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-start justify-between gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div>
                <div class="font-mono text-[0.58rem] tracking-[1.5px] uppercase text-slate-400 mb-1">Total Advocates</div>
                <div class="font-display font-bold text-[1.8rem] text-slate-800 leading-tight">
                    {{ number_format($stats['total_advocates']) }}</div>
                <div class="flex items-center gap-1.5 mt-1.5 text-green-600 text-xs font-medium">
                    <i class="bi bi-graph-up-arrow"></i> +12% this month
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <i class="bi bi-person-badge text-blue-500 text-lg"></i>
            </div>
        </div>

        {{-- Total Clerks --}}
        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-start justify-between gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div>
                <div class="font-mono text-[0.58rem] tracking-[1.5px] uppercase text-slate-400 mb-1">Total Clerks</div>
                <div class="font-display font-bold text-[1.8rem] text-slate-800 leading-tight">
                    {{ number_format($stats['total_clerks']) }}</div>
                <div class="flex items-center gap-1.5 mt-1.5 text-green-600 text-xs font-medium">
                    <i class="bi bi-graph-up-arrow"></i> +5% this month
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                <i class="bi bi-folder2-open text-purple-500 text-lg"></i>
            </div>
        </div>

        {{-- Pending Approval --}}
        <div class="bg-white rounded-xl border-y border-r border-slate-200 shadow-sm p-5 flex items-start justify-between gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all"
            style="border-left: 4px solid #B4B4FE;">
            <div>
                <div class="font-mono text-[0.58rem] tracking-[1.5px] uppercase text-slate-400 mb-1">Pending Approval</div>
                <div class="font-display font-bold text-[1.8rem] leading-tight" style="color: #B4B4FE;">
                    {{ $stats['pending_verifications'] }}</div>
                <div class="flex items-center gap-1.5 mt-1.5 text-amber-500 text-xs font-medium">
                    <i class="bi bi-exclamation-circle"></i> Action Required
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background: rgba(180,180,254,0.15);">
                <i class="bi bi-hourglass-split text-lg" style="color: #B4B4FE;"></i>
            </div>
        </div>

        {{-- Pending Docs --}}
        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-start justify-between gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div>
                <div class="font-mono text-[0.58rem] tracking-[1.5px] uppercase text-slate-400 mb-1">Pending Docs</div>
                <div class="font-display font-bold text-[1.8rem] text-red-500 leading-tight">
                    {{ $stats['pending_documents'] }}</div>
                <div class="flex items-center gap-1.5 mt-1.5 text-slate-400 text-xs font-medium">
                    <i class="bi bi-file-earmark-check"></i> Awaiting review
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <i class="bi bi-file-earmark-text text-red-500 text-lg"></i>
            </div>
        </div>
    </div>

    {{-- ══ CHART + ACTIVITY ════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

        {{-- Bar Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="font-display font-bold text-[1.05rem] text-slate-800">User Growth Analytics</h2>
                <select
                    class="py-1.5 pl-3 pr-7 text-xs border border-slate-200 rounded-lg bg-slate-50 font-mono focus:outline-none"
                    style="focus:ring: 2px; focus:ring-color: rgba(180,180,254,0.30); focus:border-color: #B4B4FE;">
                    <option>Last 30 Days</option>
                    <option>Last Quarter</option>
                    <option>This Year</option>
                </select>
            </div>
            <div class="p-5">
                <div class="flex items-end gap-2.5 h-[180px] px-1" id="chartBars"></div>
                <div class="flex gap-2.5 px-1 mt-2" id="chartLabels"></div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-display font-bold text-[1.05rem] text-slate-800">Recent Activities</h2>
            </div>
            <div>
                @forelse($recentUsers->take(6) as $u)
                    @php
                        $ac =
                            $u->role === 'advocate'
                                ? ['bg-blue-100', 'text-blue-700']
                                : ($u->role === 'clerk'
                                    ? ['bg-purple-100', 'text-purple-700']
                                    : ['bg-amber-100', 'text-amber-700']);
                    @endphp
                    <div class="flex items-start gap-3 px-5 py-3.5 border-b border-slate-50 last:border-0">
                        <div
                            class="w-9 h-9 rounded-xl {{ $ac[0] }} {{ $ac[1] }} flex items-center justify-center font-bold text-[0.72rem] flex-shrink-0">
                            {{ strtoupper(substr($u->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[0.83rem] font-semibold text-slate-800">
                                @if ($u->role === 'advocate')
                                    New Advocate Registration
                                @elseif($u->role === 'clerk')
                                    New Clerk Registration
                                @else
                                    New {{ ucfirst($u->role) }} Joined
                                @endif
                            </div>
                            <div class="text-[0.72rem] text-slate-400 truncate mt-0.5">{{ $u->name }}</div>
                            <div class="text-[0.67rem] text-slate-300 mt-0.5">{{ $u->created_at->diffForHumans() }}</div>
                        </div>
                        @if ($u->status === 'active')
                            <span
                                class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded bg-green-100 text-green-700 font-mono text-[0.55rem] uppercase tracking-wide font-semibold">Active</span>
                        @else
                            <span
                                class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded bg-amber-100 text-amber-700 font-mono text-[0.55rem] uppercase tracking-wide font-semibold">Pending</span>
                        @endif
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-sm">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ══ VERIFICATION QUEUE ══════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div>
                <h2 class="font-display font-bold text-[1.05rem] text-slate-800">Verification Queue</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">Review pending profiles and certificates.</p>
            </div>
            <a href="{{ route('admin.users') }}"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-slate-200 rounded-lg bg-white transition-all text-slate-600"
                style="--hover-border: #B4B4FE; --hover-color: #B4B4FE;"
                onmouseover="this.style.borderColor='#B4B4FE';this.style.color='#B4B4FE';"
                onmouseout="this.style.borderColor='';this.style.color='';">
                <i class="bi bi-funnel"></i> View All
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                            Name / Role</th>
                        <th
                            class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                            Date Applied</th>
                        <th
                            class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden lg:table-cell">
                            Documents</th>
                        <th
                            class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden sm:table-cell">
                            Email / Phone</th>
                        <th class="px-5 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $pendingUsers = $recentUsers->where('status','pending'); @endphp
                    @forelse($pendingUsers as $u)
                        @php
                            $rc =
                                $u->role === 'advocate'
                                    ? ['bg-blue-100', 'text-blue-700']
                                    : ($u->role === 'clerk'
                                        ? ['bg-purple-100', 'text-purple-700']
                                        : ['bg-green-100', 'text-green-700']);
                            $rolePill =
                                $u->role === 'advocate'
                                    ? 'bg-blue-100 text-blue-700'
                                    : ($u->role === 'clerk'
                                        ? 'bg-purple-100 text-purple-700'
                                        : 'bg-amber-100 text-amber-700');
                        @endphp
                        <tr class="trow" data-uid="{{ $u->id }}">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-10 h-10 rounded-full {{ $rc[0] }} {{ $rc[1] }} flex items-center justify-center font-bold text-[0.78rem] flex-shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ $u->name }}</div>
                                        <span
                                            class="inline-block mt-0.5 text-[0.6rem] font-semibold px-2 py-0.5 rounded {{ $rolePill }} font-mono uppercase tracking-wide">{{ $u->role }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-400 text-[0.8rem] hidden md:table-cell">
                                {{ $u->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3.5 hidden lg:table-cell">
                                @if ($u->documents->count())
                                    @foreach ($u->documents->take(1) as $doc)
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 text-slate-500 text-[0.8rem] transition-colors"
                                            onmouseover="this.style.color='#B4B4FE';" onmouseout="this.style.color='';">
                                            <i class="bi bi-file-earmark-text"></i>
                                            {{ Str::limit(basename($doc->file_path), 22) }}
                                        </a>
                                    @endforeach
                                    @if ($u->documents->count() > 1)
                                        <span class="text-[0.68rem] text-slate-400 ml-1">+{{ $u->documents->count() - 1 }}
                                            more</span>
                                    @endif
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <div class="text-[0.82rem] text-slate-700">{{ $u->email }}</div>
                                <div class="text-[0.72rem] text-slate-400">{{ $u->phone ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2 justify-end">
                                    <button
                                        onclick="openVerify({{ $u->id }},'{{ addslashes($u->name) }}','{{ $u->role }}','{{ $u->email }}','{{ $u->phone ?? '' }}','{{ $u->created_at->format('d M Y') }}','{{ $u->city ?? '' }}')"
                                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-green-500 hover:bg-green-600
                       text-white text-xs font-bold transition-all shadow-sm shadow-green-200/60">
                                        <i class="bi bi-check-lg"></i> Verify
                                    </button>
                                    <button onclick="openReject({{ $u->id }},'{{ addslashes($u->name) }}')"
                                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-red-500 hover:bg-red-600
                       text-white text-xs font-bold transition-all shadow-sm shadow-red-200/60">
                                        <i class="bi bi-x-lg"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                <i class="bi bi-check-circle text-green-400 text-2xl block mb-2"></i>
                                All verifications are up to date!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pendingUsers->count() > 0)
            <div class="px-5 py-3.5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-mono">{{ $pendingUsers->count() }} pending requests</span>
                <a href="{{ route('admin.users') }}?status=pending" class="text-xs font-medium transition-colors"
                    style="color: #B4B4FE;" onmouseover="this.style.color='#9898e0';"
                    onmouseout="this.style.color='#B4B4FE';">
                    View All Pending →
                </a>
            </div>
        @endif
    </div>

    {{-- ══ PENDING DOCUMENTS ═══════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="font-display font-bold text-[1.05rem] text-slate-800">Pending Documents</h2>
            <a href="{{ route('admin.documents') }}"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-slate-200 rounded-lg bg-white transition-all text-slate-600"
                onmouseover="this.style.borderColor='#B4B4FE';this.style.color='#B4B4FE';"
                onmouseout="this.style.borderColor='';this.style.color='';">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                            User</th>
                        <th
                            class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden sm:table-cell">
                            Role</th>
                        <th class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                            Document</th>
                        <th
                            class="px-5 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                            Uploaded</th>
                        <th class="px-5 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingDocs as $doc)
                        <tr class="trow">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-ncard flex items-center justify-center font-bold text-[0.8rem] flex-shrink-0"
                                        style="color: #B4B4FE;">
                                        {{ strtoupper(substr($doc->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800 text-[0.84rem]">{{ $doc->user->name }}
                                        </div>
                                        <div class="text-[0.7rem] text-slate-400">{{ $doc->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                @php $rp = ['advocate'=>'bg-blue-100 text-blue-700','clerk'=>'bg-purple-100 text-purple-700','ca'=>'bg-amber-100 text-amber-700','guest'=>'bg-slate-100 text-slate-600']; @endphp
                                <span
                                    class="text-[0.6rem] font-semibold px-2 py-0.5 rounded {{ $rp[$doc->user->role] ?? 'bg-slate-100 text-slate-600' }} font-mono uppercase tracking-wide">{{ $doc->user->role }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 text-slate-500 text-[0.82rem] transition-colors"
                                    onmouseover="this.style.color='#B4B4FE';" onmouseout="this.style.color='';">
                                    <i class="bi bi-file-earmark-text"></i>
                                    {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 text-slate-400 text-[0.75rem] hidden md:table-cell">
                                {{ $doc->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-1.5 justify-end">
                                    <button
                                        onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Document approved!','ok')"
                                        data-body='{"status":"approved"}'
                                        class="w-8 h-8 rounded-lg bg-green-500 hover:bg-green-600 text-white flex items-center justify-center transition-all text-sm"
                                        title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button
                                        onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Document rejected.','err')"
                                        data-body='{"status":"rejected","rejection_reason":"Documents not valid"}'
                                        class="w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition-all text-sm"
                                        title="Reject">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400 text-sm">
                                <i class="bi bi-check-circle text-green-400 text-xl block mb-1"></i> No pending documents!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══ MODALS ═══════════════════════════════════════════════════ --}}
    <div id="vOverlay" onclick="closeModal()" class="hidden fixed inset-0 bg-navy/60 backdrop-blur-sm z-[1000]"></div>

    {{-- Verify Modal --}}
    <div id="vModal"
        class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
         w-[min(500px,calc(100vw-2rem))] bg-white rounded-2xl shadow-2xl z-[1001]">
        <div
            class="flex items-center gap-4 px-6 py-5 border-b border-slate-100 rounded-t-2xl bg-gradient-to-br from-green-50 to-white">
            <div
                class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600 text-2xl flex-shrink-0">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div class="flex-1">
                <div class="font-display font-bold text-[1.1rem] text-slate-800">Verify Professional</div>
                <div class="text-xs text-slate-500 mt-0.5">Review details before approving account access.</div>
            </div>
            <button onclick="closeModal()"
                class="text-slate-400 hover:text-slate-700 transition-colors text-xl leading-none"><i
                    class="bi bi-x-lg"></i></button>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                <div id="v_avatar"
                    class="w-14 h-14 rounded-xl bg-navy flex items-center justify-center font-bold text-xl font-display flex-shrink-0"
                    style="color: #B4B4FE; border: 2px solid rgba(180,180,254,0.30);">
                </div>
                <div>
                    <div id="v_name" class="font-bold text-base text-slate-800 font-display"></div>
                    <span id="v_rpill"
                        class="inline-block mt-1 text-[0.6rem] font-semibold px-2.5 py-0.5 rounded font-mono uppercase tracking-wide"></span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                    <div
                        class="flex items-center gap-1.5 font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5">
                        <i class="bi bi-envelope"></i> Email
                    </div>
                    <div id="v_email" class="text-sm font-semibold text-slate-700 break-all"></div>
                </div>
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                    <div
                        class="flex items-center gap-1.5 font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5">
                        <i class="bi bi-phone"></i> Phone
                    </div>
                    <div id="v_phone" class="text-sm font-semibold text-slate-700"></div>
                </div>
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                    <div
                        class="flex items-center gap-1.5 font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5">
                        <i class="bi bi-calendar3"></i> Registered
                    </div>
                    <div id="v_date" class="text-sm font-semibold text-slate-700"></div>
                </div>
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                    <div
                        class="flex items-center gap-1.5 font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5">
                        <i class="bi bi-shield-check"></i> After Verify
                    </div>
                    <div class="text-sm font-semibold text-green-600">Status → <strong>Active</strong></div>
                </div>
            </div>
            <div
                class="flex items-start gap-3 px-4 py-3 bg-amber-50 border border-amber-200 rounded-lg text-amber-700 text-xs leading-relaxed">
                <i class="bi bi-info-circle-fill flex-shrink-0 mt-0.5"></i>
                Once verified, this user gets full dashboard access and will appear in the professional directory.
            </div>
        </div>
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100 bg-slate-50/80 rounded-b-2xl">
            <button onclick="closeModal()"
                class="px-5 py-2.5 text-sm font-medium border border-slate-200 rounded-lg hover:border-slate-400 bg-white transition-all">Cancel</button>
            <button id="vConfirmBtn" onclick="doVerify()"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all shadow-md shadow-green-200">
                <i class="bi bi-check-lg"></i> Confirm Verify
            </button>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rModal"
        class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
         w-[min(440px,calc(100vw-2rem))] bg-white rounded-2xl shadow-2xl z-[1001]">
        <div
            class="flex items-center gap-4 px-6 py-5 border-b border-slate-100 rounded-t-2xl bg-gradient-to-br from-red-50 to-white">
            <div
                class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-500 text-2xl flex-shrink-0">
                <i class="bi bi-person-x-fill"></i>
            </div>
            <div class="flex-1">
                <div class="font-display font-bold text-[1.1rem] text-slate-800">Reject Registration</div>
                <div id="r_sub" class="text-xs text-slate-500 mt-0.5"></div>
            </div>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-700 text-xl leading-none"><i
                    class="bi bi-x-lg"></i></button>
        </div>
        <div class="p-6">
            <div
                class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-xs leading-relaxed">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-0.5"></i>
                This marks the user as <strong>Rejected</strong>. They won't be able to access role features.
            </div>
        </div>
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100 bg-slate-50/80 rounded-b-2xl">
            <button onclick="closeModal()"
                class="px-5 py-2.5 text-sm font-medium border border-slate-200 rounded-lg hover:border-slate-400 bg-white transition-all">Cancel</button>
            <button id="rConfirmBtn" onclick="doReject()"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all shadow-md shadow-red-200">
                <i class="bi bi-x-lg"></i> Confirm Reject
            </button>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        /* ── CHART ────────────────────────────────────── */
        (function() {
            const data = [{
                    l: 'Feb 1',
                    v: 20
                }, {
                    l: 'Feb 5',
                    v: 35
                }, {
                    l: 'Feb 10',
                    v: 28
                }, {
                    l: 'Feb 15',
                    v: 50
                },
                {
                    l: 'Feb 20',
                    v: 44
                }, {
                    l: 'Feb 25',
                    v: 65
                }, {
                    l: 'Mar 1',
                    v: 80
                }, {
                    l: 'Mar 5',
                    v: 72
                }, {
                    l: 'Mar 10',
                    v: 90
                }
            ];
            const max = Math.max(...data.map(d => d.v));
            const bE = document.getElementById('chartBars'),
                lE = document.getElementById('chartLabels');
            data.forEach(d => {
                const h = Math.round((d.v / max) * 165);
                bE.innerHTML += `<div class="flex-1 min-w-[28px] rounded-t-md cursor-pointer relative group transition-opacity hover:opacity-70"
                        style="height:${h}px;background:linear-gradient(to top,#B4B4FE,#d4d4ff);">
                     <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-navy text-white text-[0.65rem] px-2 py-1 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">${d.l}: ${d.v}</div>
                   </div>`;
                lE.innerHTML +=
                    `<div class="flex-1 text-center font-mono text-[0.6rem] text-slate-400">${d.l.split(' ')[0]}</div>`;
            });
        })();

        /* ── MODAL ────────────────────────────────────── */
        let _uid = null,
            _uname = null;
        const RPILL = {
            advocate: 'bg-blue-100 text-blue-700',
            clerk: 'bg-purple-100 text-purple-700',
            ca: 'bg-amber-100 text-amber-700',
            guest: 'bg-slate-100 text-slate-600'
        };

        function openVerify(id, name, role, email, phone, date, city) {
            _uid = id;
            _uname = name;
            document.getElementById('v_avatar').textContent = name.substring(0, 2).toUpperCase();
            document.getElementById('v_name').textContent = name;
            document.getElementById('v_email').textContent = email;
            document.getElementById('v_phone').textContent = phone || '—';
            document.getElementById('v_date').textContent = date;
            const p = document.getElementById('v_rpill');
            p.textContent = role;
            p.className =
                `inline-block mt-1 text-[0.6rem] font-semibold px-2.5 py-0.5 rounded font-mono uppercase tracking-wide ${RPILL[role]||'bg-slate-100 text-slate-600'}`;
            const btn = document.getElementById('vConfirmBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Confirm Verify';
            document.getElementById('vOverlay').classList.remove('hidden');
            const m = document.getElementById('vModal');
            m.classList.remove('hidden');
            m.classList.add('modal-pop');
        }

        function openReject(id, name) {
            _uid = id;
            _uname = name;
            document.getElementById('r_sub').textContent = `Confirm rejection for "${name}"`;
            const btn = document.getElementById('rConfirmBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
            document.getElementById('vOverlay').classList.remove('hidden');
            const m = document.getElementById('rModal');
            m.classList.remove('hidden');
            m.classList.add('modal-pop');
        }

        function closeModal() {
            ['vModal', 'rModal'].forEach(id => {
                const m = document.getElementById(id);
                if (m) {
                    m.classList.add('hidden');
                    m.classList.remove('modal-pop');
                }
            });
            document.getElementById('vOverlay').classList.add('hidden');
            _uid = _uname = null;
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });

        function doVerify() {
            const btn = document.getElementById('vConfirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Verifying…';
            fetch(`/admin/users/${_uid}/verify`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json()).then(() => {
                    const n = _uname;
                    closeModal();
                    showToast(`${n} verified successfully!`, 'ok');
                    document.querySelectorAll(`[data-uid="${_uid}"]`).forEach(r => {
                        r.style.transition = 'opacity .3s';
                        r.style.opacity = '0';
                        setTimeout(() => r.remove(), 300);
                    });
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-check-lg"></i> Confirm Verify';
                    showToast('Error!', 'err');
                });
        }

        function doReject() {
            const btn = document.getElementById('rConfirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Rejecting…';
            fetch(`/admin/users/${_uid}/reject`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json()).then(() => {
                    const n = _uname;
                    closeModal();
                    showToast(`${n} rejected.`, 'err');
                    document.querySelectorAll(`[data-uid="${_uid}"]`).forEach(r => {
                        r.style.transition = 'opacity .3s';
                        r.style.opacity = '0';
                        setTimeout(() => r.remove(), 300);
                    });
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
                    showToast('Error!', 'err');
                });
        }
    </script>
@endpush
