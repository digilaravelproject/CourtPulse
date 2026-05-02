@php
    // Refined premium role pills mapping
    $ROLE = [
        'advocate' => ['bg-blue/10', 'text-blue', 'border-blue/20'],
        'court_clerk' => ['bg-purple-500/10', 'text-purple-400', 'border-purple-500/20'],
        'ip_clerk' => ['bg-purple-500/10', 'text-purple-400', 'border-purple-500/20'],
        'ca_cs' => ['bg-amber-500/10', 'text-amber-400', 'border-amber-500/20'],
        'agent' => ['bg-amber-500/10', 'text-amber-400', 'border-amber-500/20'],
        'guest' => ['bg-white/5', 'text-white/50', 'border-white/10'],
        'admin' => ['bg-green-500/10', 'text-green-400', 'border-green-500/20'],
        'super_admin' => ['bg-green-500/10', 'text-green-400', 'border-green-500/20'],
    ];
@endphp

<table class="w-full text-left border-collapse">
    <thead>
        <tr class="border-b border-white/5">
            <th class="p-5 font-black text-[0.65rem] text-white/50 uppercase tracking-[0.2em]">#</th>
            <th class="p-5 font-black text-[0.65rem] text-white/50 uppercase tracking-[0.2em]">User</th>
            <th class="p-5 font-black text-[0.65rem] text-white/50 uppercase tracking-[0.2em] hidden md:table-cell">Contact</th>
            <th class="p-5 font-black text-[0.65rem] text-white/50 uppercase tracking-[0.2em]">Role</th>
            <th class="p-5 font-black text-[0.65rem] text-white/50 uppercase tracking-[0.2em]">Status</th>
            <th class="p-5 font-black text-[0.65rem] text-white/50 uppercase tracking-[0.2em] hidden lg:table-cell">Joined</th>
            <th class="p-5 font-black text-[0.65rem] text-white/50 uppercase tracking-[0.2em] text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $u)
            @php 
                $rc = $ROLE[$u->role] ?? ['bg-white/5', 'text-white/50', 'border-white/10']; 
                $roleName = str_replace('_', ' ', $u->role);
            @endphp
            <tr class="border-b border-white/5 hover:bg-white/2 transition-colors" data-uid="{{ $u->id }}">
                <td class="p-5 align-middle text-white/40 font-black text-xs">{{ $users->firstItem() + $loop->index }}</td>
                <td class="p-5 align-middle">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl {{ $rc[0] }} {{ $rc[1] }} border {{ $rc[2] }} flex items-center justify-center font-black text-sm shrink-0 shadow-inner">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-white">{{ $u->name }}</div>
                            <div class="text-[0.65rem] font-bold text-white/40 uppercase tracking-widest mt-0.5 md:hidden">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="p-5 align-middle hidden md:table-cell">
                    <div class="text-sm text-white/70">{{ $u->email }}</div>
                    @if($u->phone)
                        <div class="text-[0.7rem] text-white/40 mt-1"><i class="fas fa-phone-alt text-[0.6rem] mr-1"></i> {{ $u->phone }}</div>
                    @else
                        <div class="text-[0.7rem] text-white/30 mt-1 italic">No phone</div>
                    @endif
                </td>
                <td class="p-5 align-middle">
                    <span class="inline-block text-[0.6rem] font-black uppercase tracking-widest px-3 py-1 rounded-md border {{ $rc[0] }} {{ $rc[1] }} {{ $rc[2] }}">
                        {{ $roleName }}
                    </span>
                </td>
                <td class="p-5 align-middle">
                    @if ($u->status === 'active')
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 text-[0.65rem] font-black uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 shadow-[0_0_10px_rgba(74,222,128,0.8)]"></span> Active
                        </div>
                    @elseif($u->status === 'pending')
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[0.65rem] font-black uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.8)]"></span> Pending
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-[0.65rem] font-black uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 shadow-[0_0_10px_rgba(248,113,113,0.8)]"></span> Rejected
                        </div>
                    @endif
                </td>
                <td class="p-5 align-middle hidden lg:table-cell">
                    <div class="text-sm text-white/60 font-bold">{{ $u->created_at->format('M d, Y') }}</div>
                    <div class="text-[0.65rem] text-white/30 uppercase tracking-widest">{{ $u->created_at->format('h:i A') }}</div>
                </td>
                <td class="p-5 align-middle text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.users.show', ['user' => $u->id]) }}"
                            class="w-9 h-9 rounded-xl border border-white/10 bg-white/5 hover:border-blue hover:text-blue hover:bg-blue/5 flex items-center justify-center transition-all text-white/50" title="View Profile">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                        @if ($u->status === 'pending')
                            <button type="button" onclick="openVerify({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->role }}', '{{ addslashes($u->email) }}', '{{ addslashes($u->phone ?? '') }}', '{{ $u->created_at->format('M d, Y') }}', '{{ addslashes($u->city ?? '') }}')"
                                class="w-9 h-9 rounded-xl border border-green-500/20 bg-green-500/10 hover:bg-green-500 hover:text-navy hover:border-green-500 flex items-center justify-center transition-all text-green-400 shadow-[0_0_10px_rgba(34,197,94,0.1)]" title="Verify User">
                                <i class="fas fa-check text-sm"></i>
                            </button>
                            <button type="button" onclick="openReject({{ $u->id }}, '{{ addslashes($u->name) }}')"
                                class="w-9 h-9 rounded-xl border border-red-500/20 bg-red-500/10 hover:bg-red-500 hover:text-white hover:border-red-500 flex items-center justify-center transition-all text-red-400 shadow-[0_0_10px_rgba(239,68,68,0.1)]" title="Reject User">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="p-16 text-center">
                    <div class="w-20 h-20 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center text-white/20 text-3xl mx-auto mb-4">
                        <i class="fas fa-users-slash"></i>
                    </div>
                    <div class="font-black text-white/60 uppercase tracking-widest text-sm mb-1">No Users Found</div>
                    <div class="text-white/30 text-xs font-bold">Adjust your filters to see more results.</div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
@if ($users->hasPages())
    <div class="p-6 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4 bg-white/1">
        <div class="text-xs text-white/40 font-black uppercase tracking-widest">
            Showing <span class="text-white">{{ $users->firstItem() }}</span> - <span class="text-white">{{ $users->lastItem() }}</span> of <span class="text-white">{{ $users->total() }}</span>
        </div>
        <div class="cp-pagination">
            {{ $users->links() }}
        </div>
    </div>
@endif
