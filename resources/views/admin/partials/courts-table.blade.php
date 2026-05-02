{{-- ═══ COURTS TABLE PARTIAL (AJAX-reloadable) ═══ --}}
<table class="w-full whitespace-nowrap">
    <thead>
        <tr>
            <th class="text-left px-6 py-4 text-[0.6rem] font-black text-white/40 uppercase tracking-[0.2em] bg-white/2 border-b border-white/5">Institution Name</th>
            <th class="text-left px-6 py-4 text-[0.6rem] font-black text-white/40 uppercase tracking-[0.2em] bg-white/2 border-b border-white/5">Type</th>
            <th class="text-left px-6 py-4 text-[0.6rem] font-black text-white/40 uppercase tracking-[0.2em] bg-white/2 border-b border-white/5 hidden md:table-cell">Location</th>
            <th class="text-center px-6 py-4 text-[0.6rem] font-black text-white/40 uppercase tracking-[0.2em] bg-white/2 border-b border-white/5">Status</th>
            <th class="text-right px-6 py-4 text-[0.6rem] font-black text-white/40 uppercase tracking-[0.2em] bg-white/2 border-b border-white/5">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-white/5">
        @forelse($courts as $court)
            <tr class="group hover:bg-white/2 transition-colors">

                {{-- Institution Name --}}
                <td class="px-6 py-5">
                    <div class="text-sm font-black text-white uppercase tracking-tight group-hover:text-blue transition-colors mb-1">
                        {{ $court->name }}
                    </div>
                    <div class="text-[0.65rem] text-white/40 font-bold uppercase tracking-widest font-mono">
                        ID: #{{ str_pad($court->id, 5, '0', STR_PAD_LEFT) }}
                    </div>
                </td>

                {{-- Type --}}
                <td class="px-6 py-5">
                    <span class="text-[0.6rem] font-black uppercase tracking-widest text-white/70 bg-white/5 border border-white/10 px-3 py-1.5 rounded-lg inline-block">
                        {{ $court->type }}
                    </span>
                </td>

                {{-- Location --}}
                <td class="px-6 py-5 hidden md:table-cell">
                    <div class="text-xs font-bold text-white uppercase tracking-tight mb-1">
                        <i class="fas fa-map-marker-alt text-white/30 mr-1"></i>
                        {{ $court->area ?? '—' }}
                    </div>
                    <div class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">
                        {{ $court->city }}{{ $court->state ? ', ' . $court->state : '' }}
                        {{ $court->pincode ? ' — ' . $court->pincode : '' }}
                    </div>
                </td>

                {{-- Status Toggle --}}
                <td class="px-6 py-5 text-center">
                    @if($court->is_active)
                        <button onclick="toggleCourt({{ $court->id }}, this)" title="Click to disable"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 font-black text-[0.6rem] uppercase tracking-widest hover:bg-green-500/20 transition-all cursor-pointer">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> Live
                        </button>
                    @else
                        <button onclick="toggleCourt({{ $court->id }}, this)" title="Click to enable"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 font-black text-[0.6rem] uppercase tracking-widest hover:bg-red-500/20 transition-all cursor-pointer">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Disabled
                        </button>
                    @endif
                </td>

                {{-- Actions --}}
                <td class="px-6 py-5 text-right">
                    <div class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-opacity">
                        {{-- Edit --}}
                        @php
                            $courtJson = htmlspecialchars(json_encode([
                                'id'      => $court->id,
                                'name'    => $court->name,
                                'type'    => $court->type,
                                'area'    => $court->area,
                                'city'    => $court->city,
                                'state'   => $court->state,
                                'pincode' => $court->pincode,
                            ]), ENT_QUOTES, 'UTF-8');
                        @endphp
                        <button onclick="openModal('edit', JSON.parse(this.dataset.court))" data-court="{{ $courtJson }}"
                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-blue/20 flex items-center justify-center text-white/50 hover:text-blue transition-colors border border-transparent hover:border-blue/30 focus:outline-none"
                            title="Edit">
                            <i class="fas fa-pen text-xs"></i>
                        </button>

                        {{-- Delete --}}
                        <button onclick="openDeleteModal({{ $court->id }}, '{{ addslashes($court->name) }}')"
                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-red-500/20 flex items-center justify-center text-white/50 hover:text-red-400 transition-colors border border-transparent hover:border-red-500/30 focus:outline-none"
                            title="Delete">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-24 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-2xl mb-4">
                            <i class="fas fa-building"></i>
                        </div>
                        <p class="text-white font-black uppercase tracking-[0.25em] text-xs mb-1">Registry is empty</p>
                        <p class="text-white/40 font-bold text-[0.65rem] uppercase tracking-widest">No courts registered in the database yet.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
@if(isset($courts) && method_exists($courts, 'hasPages') && $courts->hasPages())
    <div class="px-8 py-6 bg-navy border-t border-white/5 flex flex-wrap items-center justify-between gap-3">
        <span class="text-[0.65rem] text-white/40 font-bold uppercase tracking-widest">
            Showing {{ $courts->firstItem() }}–{{ $courts->lastItem() }} of {{ $courts->total() }}
        </span>
        {{ $courts->links() }}
    </div>
@endif
