<table class="w-full text-sm">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200">
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 w-10">#</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Court Name
            </th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden sm:table-cell">
                Type</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                Location</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden lg:table-cell">
                Contact</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Status</th>
            <th class="px-4 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Action
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($courts as $court)
            <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition-colors">

                {{-- # --}}
                <td class="px-4 py-3.5 font-mono text-[0.7rem] text-slate-400">
                    {{ $courts->firstItem() + $loop->index }}
                </td>

                {{-- Court Name --}}
                <td class="px-4 py-3.5">
                    <div class="font-semibold text-slate-800 text-[0.85rem]">{{ $court->name }}</div>
                    @if ($court->address)
                        <div class="text-[0.7rem] text-slate-400 truncate max-w-[220px] mt-0.5">{{ $court->address }}
                        </div>
                    @endif
                </td>

                {{-- Type badge --}}
                <td class="px-4 py-3.5 hidden sm:table-cell">
                    <span
                        class="inline-flex items-center text-[0.62rem] font-semibold px-2.5 py-1
                     rounded-md font-mono uppercase tracking-wide
          @if ($court->type === 'supreme') bg-red-100 text-red-700
          @elseif($court->type === 'high')     bg-purple-100 text-purple-700
          @elseif($court->type === 'district') bg-blue-100 text-blue-700
          @elseif($court->type === 'session')  bg-indigo-100 text-indigo-700
          @elseif($court->type === 'civil')    bg-sky-100 text-sky-700
          @elseif($court->type === 'criminal') bg-orange-100 text-orange-700
          @elseif($court->type === 'family')   bg-pink-100 text-pink-700
          @elseif($court->type === 'consumer') bg-teal-100 text-teal-700
          @else bg-amber-100 text-amber-700 @endif">
                        {{ $court->type_label }}
                    </span>
                </td>

                {{-- Location --}}
                <td class="px-4 py-3.5 hidden md:table-cell">
                    <div class="text-slate-700 text-[0.83rem] font-medium">{{ $court->city }}</div>
                    <div class="text-[0.72rem] text-slate-400 mt-0.5">
                        {{ $court->state }}@if ($court->pincode)
                            &mdash; {{ $court->pincode }}
                        @endif
                    </div>
                </td>

                {{-- Contact --}}
                <td class="px-4 py-3.5 hidden lg:table-cell">
                    @if ($court->phone)
                        <div class="flex items-center gap-1.5 text-[0.8rem] text-slate-600">
                            <i class="bi bi-telephone text-slate-400 text-[0.7rem]"></i> {{ $court->phone }}
                        </div>
                    @endif
                    @if ($court->email)
                        <div class="flex items-center gap-1.5 text-[0.72rem] text-slate-400 mt-0.5">
                            <i class="bi bi-envelope text-[0.7rem]"></i> {{ $court->email }}
                        </div>
                    @endif
                    @if (!$court->phone && !$court->email)
                        <span class="text-slate-300 text-xs">—</span>
                    @endif
                </td>

                {{-- Status --}}
                <td class="px-4 py-3.5">
                    @if ($court->is_active)
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                       bg-green-100 text-green-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Active
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                       bg-slate-100 text-slate-500 font-mono text-[0.6rem] uppercase tracking-wide font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400 inline-block"></span> Inactive
                        </span>
                    @endif
                </td>

                {{-- Actions --}}
                <td class="px-4 py-3.5">
                    <div class="flex items-center gap-1.5 justify-end">
                        <a href="{{ route('admin.courts.edit', $court) }}"
                            class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:border-gold hover:text-gold
                   flex items-center justify-center transition-all text-slate-500 text-sm"
                            title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button onclick="deactivateCourt({{ $court->id }}, this)"
                            class="w-8 h-8 rounded-lg border border-red-200 bg-red-50 hover:bg-red-500 hover:text-white
                   flex items-center justify-center transition-all text-red-500 text-sm"
                            title="Deactivate">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </td>

            </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-16 text-center text-slate-400 text-sm">
                        <i class="bi bi-building text-4xl block mb-3 text-slate-300"></i>
                        No courts found.
                        <a href="{{ route('admin.courts.create') }}" class="text-gold hover:underline ml-1 font-medium">
                            Add one &rarr;
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($courts->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
            <span class="text-xs text-slate-400 font-mono">
                Showing {{ $courts->firstItem() }}&ndash;{{ $courts->lastItem() }} of {{ $courts->total() }} courts
            </span>
            {{ $courts->links() }}
        </div>
    @endif
