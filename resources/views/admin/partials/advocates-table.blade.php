<table class="w-full text-sm">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200">
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">#</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Name</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                Email / Phone</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden lg:table-cell">
                Bar Council No.</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden lg:table-cell">
                High Court</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden sm:table-cell">
                City</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Status</th>
            <th class="px-4 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Action
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($advocates as $u)
            <tr class="trow" data-uid="{{ $u->id }}">
                <td class="font-mono text-[0.7rem] text-slate-400">{{ $advocates->firstItem() + $loop->index }}</td>
                <td>
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-9 h-9 rounded-lg bg-blue-100 text-blue-700
                      flex items-center justify-center font-bold text-[0.8rem] flex-shrink-0">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $u->name }}</div>
                            <div class="text-[0.7rem] text-slate-400">{{ $u->advocateProfile->experience_years ?? 0 }}
                                yrs
                                exp</div>
                        </div>
                    </div>
                </td>
                <td class="hidden md:table-cell">
                    <div class="text-slate-700">{{ $u->email }}</div>
                    <div class="text-[0.72rem] text-slate-400">{{ $u->phone ?? '—' }}</div>
                </td>
                <td class="font-mono text-[0.75rem] text-slate-500 hidden lg:table-cell">
                    {{ $u->advocateProfile->bar_council_number ?? '—' }}
                </td>
                <td class="text-slate-600 hidden lg:table-cell">{{ $u->advocateProfile->high_court ?? '—' }}</td>
                <td class="text-slate-600 hidden sm:table-cell">{{ $u->city ?? '—' }}</td>
                <td>
                    @if ($u->status === 'active')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-green-100 text-green-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="dot bg-green-500"></span>Active</span>
                    @elseif($u->status === 'pending')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-100 text-amber-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="dot bg-amber-400"></span>Pending</span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-red-100 text-red-600 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="dot bg-red-500"></span>Rejected</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-1.5 justify-end">
                        <a href="{{ route('admin.users.show', $u) }}"
                            class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:border-gold hover:text-gold flex items-center justify-center transition-all text-slate-500 text-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if ($u->status === 'pending')
                            <a href="{{ route('admin.users.show', $u) }}"
                                class="flex items-center gap-1.5 px-3 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition-all shadow-sm shadow-amber-200/60">
                                <i class="bi bi-shield-check"></i> Review
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="py-14 text-center text-slate-400 text-sm">
                    <i class="bi bi-person-badge text-3xl block mb-2 text-slate-300"></i>
                    No advocates found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@if ($advocates->hasPages())
    <div class="px-4 py-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
        <span class="text-xs text-slate-400 font-mono">Showing
            {{ $advocates->firstItem() }}–{{ $advocates->lastItem() }} of {{ $advocates->total() }}</span>
        {{ $advocates->links() }}
    </div>
@endif
