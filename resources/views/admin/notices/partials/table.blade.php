{{-- ═══ NOTICES TABLE PARTIAL (AJAX-reloadable) ═══ --}}
<table class="cp-table">
    <thead>
        <tr>
            <th class="text-left">Notice Title</th>
            <th class="text-left hidden md:table-cell">Target Court</th>
            <th class="text-left">New Badge</th>
            <th class="text-left hidden lg:table-cell">PDF Document</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($notices as $notice)
            <tr class="group">
                {{-- Notice Title --}}
                <td>
                    <div class="text-sm font-black text-white uppercase tracking-tight group-hover:text-blue transition-colors mb-1 line-clamp-2" title="{{ $notice->title }}">
                        {{ $notice->title }}
                    </div>
                    <div class="text-[0.65rem] text-white/40 font-bold uppercase tracking-widest font-mono">
                        Published: {{ $notice->created_at->format('M d, Y h:i A') }}
                    </div>
                </td>

                {{-- Target Court --}}
                <td class="hidden md:table-cell">
                    @if($notice->court)
                        <div class="text-xs font-bold text-white uppercase tracking-tight mb-1">
                            {{ $notice->court->name }}
                        </div>
                        <div class="text-[0.6rem] text-white/40 font-black uppercase tracking-widest">
                            <i class="fas fa-map-marker-alt text-white/30 mr-1"></i>
                            {{ $notice->court->city }}{{ $notice->court->area ? ' - ' . $notice->court->area : '' }}
                        </div>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.65rem] font-black uppercase tracking-widest bg-blue/10 text-blue border border-blue/20">
                            <i class="bi bi-globe mr-0.5"></i> General / All Courts
                        </span>
                    @endif
                </td>

                {{-- New Badge --}}
                <td>
                    @if($notice->show_new_badge)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.65rem] font-black uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></span>
                            New Badge Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.65rem] font-black uppercase tracking-widest bg-white/5 text-white/40 border border-white/5">
                            <span class="w-1.5 h-1.5 rounded-full bg-white/20"></span>
                            Inactive
                        </span>
                    @endif
                </td>

                {{-- PDF Document --}}
                <td class="hidden lg:table-cell">
                    <a href="{{ Storage::disk('public')->url($notice->pdf_path) }}" target="_blank" 
                       class="text-xs font-bold text-blue hover:text-white underline inline-flex items-center gap-1.5">
                        <i class="bi bi-file-earmark-pdf-fill text-lg"></i>
                        View PDF
                    </a>
                </td>

                {{-- Actions --}}
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        {{-- Edit --}}
                        <button @click="openEditModal({{ $notice->id }})"
                                class="w-9 h-9 rounded-xl bg-white/5 hover:bg-blue/20 flex items-center justify-center text-white/50 hover:text-blue transition-all border border-white/5 hover:border-blue/30 shadow-lg shadow-black/20"
                                title="Edit Notice">
                            <i class="fas fa-pen text-xs"></i>
                        </button>

                        {{-- Delete --}}
                        <button @click="deleteNotice({{ $notice->id }}, $el)"
                                class="w-9 h-9 rounded-xl bg-white/5 hover:bg-red-500/20 flex items-center justify-center text-white/50 hover:text-red-400 transition-all border border-white/5 hover:border-red-500/30 shadow-lg shadow-black/20"
                                title="Delete Notice">
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
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <p class="text-white font-black uppercase tracking-[0.25em] text-xs mb-1">No notices published</p>
                        <p class="text-white/40 font-bold text-[0.65rem] uppercase tracking-widest">No circulars or updates in the database yet.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
@if(isset($notices) && method_exists($notices, 'hasPages') && $notices->hasPages())
    <div class="px-8 py-6 bg-navy border-t border-white/5 flex flex-wrap items-center justify-between gap-3">
        <span class="text-[0.65rem] text-white/40 font-bold uppercase tracking-widest">
            Showing {{ $notices->firstItem() }}–{{ $notices->lastItem() }} of {{ $notices->total() }}
        </span>
        {{ $notices->links() }}
    </div>
@endif
