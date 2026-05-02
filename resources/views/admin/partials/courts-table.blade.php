{{-- ═══ COURTS TABLE PARTIAL (AJAX-reloadable) ═══ --}}
<table class="cp-table">
    <thead>
        <tr>
            <th class="text-left">Institution Name</th>
            <th class="text-left hidden md:table-cell">Location</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($courts as $court)
            <tr class="group">

                {{-- Institution Name --}}
                <td>
                    <div class="text-sm font-black text-white uppercase tracking-tight group-hover:text-blue transition-colors mb-1">
                        {{ $court->name }}
                    </div>
                    <div class="text-[0.65rem] text-white/40 font-bold uppercase tracking-widest font-mono">
                        ID: #{{ str_pad($court->id, 5, '0', STR_PAD_LEFT) }}
                    </div>
                </td>


                {{-- Location --}}
                <td class="hidden md:table-cell">
                    <div class="text-xs font-bold text-white uppercase tracking-tight mb-1">
                        <i class="fas fa-map-marker-alt text-white/30 mr-1"></i>
                        {{ $court->area ?? '—' }}
                    </div>
                    <div class="text-[0.6rem] text-white/40 font-black uppercase tracking-widest">
                        {{ $court->city }}{{ $court->pincode ? ' - ' . $court->pincode : '' }}
                    </div>
                </td>


                {{-- Actions --}}
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        {{-- Edit --}}
                        <a href="{{ route('admin.courts.edit', $court->id) }}"
                            class="w-9 h-9 rounded-xl bg-white/5 hover:bg-blue/20 flex items-center justify-center text-white/50 hover:text-blue transition-all border border-white/5 hover:border-blue/30 shadow-lg shadow-black/20"
                            title="Edit Institution">
                            <i class="fas fa-pen text-xs"></i>
                        </a>

                        {{-- Delete --}}
                        <button onclick="deleteCourt({{ $court->id }}, this)"
                            class="w-9 h-9 rounded-xl bg-white/5 hover:bg-red-500/20 flex items-center justify-center text-white/50 hover:text-red-400 transition-all border border-white/5 hover:border-red-500/30 shadow-lg shadow-black/20"
                            title="Delete Permanently">
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

