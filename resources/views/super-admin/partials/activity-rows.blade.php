@foreach ($recentUsers as $user)
    <tr class="hover:bg-slate-50/50 transition-colors border-b border-slate-100 last:border-0" data-user-id="{{ $user->id }}">
        <td class="px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800 leading-none">{{ $user->name }}</p>
                    <p class="text-[0.65rem] text-slate-400 mt-1">ID: #{{ $user->id }}</p>
                </div>
            </div>
        </td>
        <td class="px-5 py-4">
            <span class="role-badge bg-blue-50 text-blue-700 text-[0.6rem] px-2.5 py-1 rounded-full uppercase font-bold tracking-wider">
                {{ str_replace('_', ' ', $user->role) }}
            </span>
        </td>
        <td class="px-5 py-4 hidden md:table-cell">
            <p class="text-xs text-slate-600 font-medium">{{ $user->email }}</p>
            @if($user->phone)
                <p class="text-[0.65rem] text-slate-400 mt-0.5">{{ $user->phone }}</p>
            @endif
        </td>
        <td class="px-5 py-4">
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
        <td class="px-5 py-4 hidden lg:table-cell">
            <p class="text-[0.65rem] text-slate-500">{{ $user->created_at->format('M d, Y') }}</p>
            <p class="text-[0.6rem] text-slate-300 mt-0.5">{{ $user->created_at->format('H:i A') }}</p>
        </td>
        <td class="px-5 py-4">
            <div class="flex items-center gap-2">
                <button onclick="openAssignRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->role }}')"
                        class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-gold/10 hover:text-gold transition-all" title="Assign Role">
                    <i class="bi bi-person-gear"></i>
                </button>
                @if($user->id !== auth()->id() && !$user->hasRole('super_admin'))
                <button onclick="confirmDestroy({{ $user->id }}, '{{ addslashes($user->name) }}')"
                        class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-red-50 hover:text-red-500 transition-all" title="Delete User">
                    <i class="bi bi-trash3"></i>
                </button>
                @endif
            </div>
        </td>
    </tr>
@endforeach
