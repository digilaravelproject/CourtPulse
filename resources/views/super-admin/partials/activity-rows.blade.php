@forelse($recentUsers as $user)
    <tr class="trow border-b border-slate-50 hover:bg-slate-50/50 transition-colors" data-user-id="{{ $user->id }}">

        {{-- User --}}
        <td class="px-5 py-3.5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg font-display font-bold text-xs flex items-center justify-center flex-shrink-0 text-white"
                    style="background:linear-gradient(135deg,#D4AF37,#B5952F)">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="font-semibold text-sm text-slate-800 truncate max-w-[140px]">{{ $user->name }}</div>
                    <div class="font-mono text-xs text-slate-400 md:hidden truncate">{{ $user->email }}</div>
                </div>
            </div>
        </td>

        {{-- Role --}}
        <td class="px-5 py-3.5">
            @php
                $roleStyles = [
                    'super_admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                    'admin' => 'bg-amber-50  text-amber-700  border-amber-200',
                    'advocate' => 'bg-blue-50   text-blue-700   border-blue-200',
                    'clerk' => 'bg-green-50  text-green-700  border-green-200',
                    'ca' => 'bg-orange-50 text-orange-700 border-orange-200',
                    'guest' => 'bg-slate-50  text-slate-600  border-slate-200',
                ];
                $spatieRole = $user->roles->first()?->name ?? ($user->role ?? 'guest');
                $rs = $roleStyles[$spatieRole] ?? 'bg-slate-50 text-slate-600 border-slate-200';
            @endphp
            <span
                class="role-badge font-mono text-[0.65rem] px-2.5 py-1 rounded-full border font-semibold capitalize {{ $rs }}">
                {{ str_replace('_', ' ', $spatieRole) }}
            </span>
        </td>

        {{-- Email --}}
        <td class="px-5 py-3.5 hidden md:table-cell">
            <span class="font-mono text-xs text-slate-500">{{ $user->email }}</span>
        </td>

        {{-- Status --}}
        <td class="px-5 py-3.5">
            @if ($user->status === 'active')
                <span
                    class="inline-flex items-center gap-1.5 font-mono text-[0.65rem] bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full font-semibold">
                    <span class="dot bg-green-500"></span> Active
                </span>
            @elseif($user->status === 'pending')
                <span
                    class="inline-flex items-center gap-1.5 font-mono text-[0.65rem] bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full font-semibold">
                    <span class="dot bg-amber-500"></span> Pending
                </span>
            @else
                <span
                    class="inline-flex items-center gap-1.5 font-mono text-[0.65rem] bg-red-50 text-red-700 border border-red-200 px-2.5 py-1 rounded-full font-semibold">
                    <span class="dot bg-red-500"></span> Rejected
                </span>
            @endif
        </td>

        {{-- Joined --}}
        <td class="px-5 py-3.5 hidden lg:table-cell">
            <div class="text-xs text-slate-500">{{ $user->created_at->format('d M Y') }}</div>
            <div class="font-mono text-[0.6rem] text-slate-400">{{ $user->created_at->diffForHumans() }}</div>
        </td>

        {{-- Actions --}}
        <td class="px-5 py-3.5">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.show', $user) }}"
                    class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:border-gold/50 hover:text-gold
                flex items-center justify-center text-slate-400 transition-all text-sm"
                    title="View User">
                    <i class="bi bi-eye"></i>
                </a>
                <button
                    onclick="openAssignRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $spatieRole }}')"
                    class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:border-blue-300 hover:text-blue-500
                     flex items-center justify-center text-slate-400 transition-all text-sm"
                    title="Assign Role">
                    <i class="bi bi-person-gear"></i>
                </button>
                @if ($user->status === 'pending')
                    <button
                        onclick="ajaxAction('{{ route('admin.users.verify', $user) }}', 'PATCH', this, '{{ $user->name }} verified!')"
                        class="w-8 h-8 rounded-lg border border-green-200 bg-white hover:bg-green-50 hover:text-green-600
                     flex items-center justify-center text-green-400 transition-all text-sm"
                        title="Verify">
                        <i class="bi bi-check2"></i>
                    </button>
                @endif
            </div>
        </td>

    </tr>
@empty
    <tr>
        <td colspan="6" class="px-5 py-16 text-center">
            <div class="flex flex-col items-center gap-3">
                <i class="bi bi-inbox text-4xl text-slate-200"></i>
                <p class="text-sm font-medium text-slate-400">No users found</p>
                <p class="text-xs text-slate-300">Try adjusting your filters</p>
            </div>
        </td>
    </tr>
@endforelse
