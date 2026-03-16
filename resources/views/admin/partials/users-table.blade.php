@php
    $ROLE = [
        'advocate' => ['bg-blue-100', 'text-blue-700'],
        'clerk' => ['bg-purple-100', 'text-purple-700'],
        'ca' => ['bg-amber-100', 'text-amber-700'],
        'guest' => ['bg-slate-100', 'text-slate-600'],
        'admin' => ['bg-orange-100', 'text-orange-700'],
    ];
@endphp

<table class="w-full text-sm">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200">
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">#</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Name</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                Email</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden sm:table-cell">
                Phone</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Role</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Status</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden lg:table-cell">
                Joined</th>
            <th class="px-4 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Action
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $u)
            @php $rc = $ROLE[$u->role] ?? ['bg-slate-100','text-slate-600']; @endphp
            <tr class="trow" data-uid="{{ $u->id }}">
                <td class="font-mono text-[0.7rem] text-slate-400">{{ $users->firstItem() + $loop->index }}</td>
                <td>
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-9 h-9 rounded-lg {{ $rc[0] }} {{ $rc[1] }}
                      flex items-center justify-center font-bold text-[0.8rem] flex-shrink-0">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $u->name }}</div>
                            <div class="text-[0.7rem] text-slate-400 md:hidden">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="text-slate-500 hidden md:table-cell">{{ $u->email }}</td>
                <td class="text-slate-500 hidden sm:table-cell">{{ $u->phone ?? '—' }}</td>
                <td>
                    <span
                        class="font-mono text-[0.6rem] uppercase tracking-wider
                     {{ $rc[0] }} {{ $rc[1] }} px-2 py-0.5 rounded">
                        {{ $u->role }}
                    </span>
                </td>
                <td>
                    @if ($u->status === 'active')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                       bg-green-100 text-green-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold">
                            <span class="dot bg-green-500"></span> Active
                        </span>
                    @elseif($u->status === 'pending')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                       bg-amber-100 text-amber-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold">
                            <span class="dot bg-amber-400"></span> Pending
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                       bg-red-100 text-red-600 font-mono text-[0.6rem] uppercase tracking-wide font-semibold">
                            <span class="dot bg-red-500"></span> Rejected
                        </span>
                    @endif
                </td>
                <td class="text-slate-400 text-[0.75rem] hidden lg:table-cell">{{ $u->created_at->format('d M Y') }}
                </td>
                <td>
                    <div class="flex items-center gap-1.5 justify-end">
                        <a href="{{ route('admin.users.show', $u) }}"
                            class="w-8 h-8 rounded-lg border border-slate-200 bg-white
                   hover:border-gold hover:text-gold flex items-center justify-center
                   transition-all text-slate-500 text-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if ($u->status === 'pending')
                            <button
                                onclick="openVerify({{ $u->id }},'{{ addslashes($u->name) }}','{{ $u->role }}','{{ $u->email }}','{{ $u->phone ?? '' }}','{{ $u->created_at->format('d M Y') }}','{{ $u->city ?? '' }}')"
                                class="flex items-center gap-1 px-3 h-8 rounded-lg bg-green-500 hover:bg-green-600
                     text-white text-xs font-bold transition-all shadow-sm shadow-green-200/60">
                                <i class="bi bi-check-lg"></i> Verify
                            </button>
                            <button onclick="openReject({{ $u->id }},'{{ addslashes($u->name) }}')"
                                class="flex items-center gap-1 px-3 h-8 rounded-lg bg-red-500 hover:bg-red-600
                     text-white text-xs font-bold transition-all shadow-sm shadow-red-200/60">
                                <i class="bi bi-x-lg"></i> Reject
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="py-14 text-center text-slate-400 text-sm">
                    <i class="bi bi-people text-3xl block mb-2 text-slate-300"></i>
                    No users found matching your filters.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
@if ($users->hasPages())
    <div class="px-4 py-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
        <span class="text-xs text-slate-400 font-mono">
            Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}
        </span>
        {{ $users->links() }}
    </div>
@endif
