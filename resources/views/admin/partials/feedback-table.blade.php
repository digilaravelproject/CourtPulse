<table class="w-full text-left border-collapse whitespace-nowrap">
    <thead>
        <tr class="bg-white/5 border-b border-white/5">
            <th class="px-6 py-5 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase">From</th>
            <th class="px-6 py-5 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase">To</th>
            <th class="px-6 py-5 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase">Rating</th>
            <th class="px-6 py-5 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase hidden md:table-cell">Comment</th>
            <th class="px-6 py-5 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase hidden lg:table-cell">Date</th>
            <th class="px-6 py-5 font-black text-white/50 text-[0.65rem] tracking-[0.2em] uppercase text-right">Action</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-white/5">
        @forelse($feedbacks as $fb)
            <tr class="hover:bg-white/5 transition-colors duration-300 group" data-fbid="{{ $fb->id }}">

                {{-- From --}}
                <td class="px-6 py-5 align-middle">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center font-black text-sm text-blue shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                            {{ strtoupper(substr($fb->giver->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-white text-xs uppercase tracking-wider mb-0.5">{{ $fb->giver->name ?? 'Unknown' }}</div>
                            <div class="text-[0.55rem] font-black text-white/40 uppercase tracking-widest">{{ str_replace('_', ' ', $fb->giver->role ?? '') }}</div>
                        </div>
                    </div>
                </td>

                {{-- To --}}
                <td class="px-6 py-5 align-middle">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center font-black text-sm text-purple-400 shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                            {{ strtoupper(substr($fb->receiver->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-white text-xs uppercase tracking-wider mb-0.5">{{ $fb->receiver->name ?? 'Unknown' }}</div>
                            <div class="text-[0.55rem] font-black text-white/40 uppercase tracking-widest">{{ str_replace('_', ' ', $fb->receiver->role ?? '') }}</div>
                        </div>
                    </div>
                </td>

                {{-- Rating --}}
                <td class="px-6 py-5 align-middle">
                    <div class="flex items-center gap-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-[0.7rem]" style="color: {{ $i <= $fb->rating ? '#B4B4FE' : 'rgba(255,255,255,0.1)' }}"></i>
                        @endfor
                        <span class="ml-2 font-black text-[0.65rem] text-white/50">{{ $fb->rating }}/5</span>
                    </div>
                </td>

                {{-- Comment --}}
                <td class="px-6 py-5 align-middle hidden md:table-cell max-w-[200px]">
                    <div class="truncate text-white/70 text-xs font-medium">{{ $fb->comment ?? '—' }}</div>
                </td>

                {{-- Date --}}
                <td class="px-6 py-5 align-middle hidden lg:table-cell">
                    <div class="text-white/40 text-[0.65rem] font-bold uppercase tracking-widest">{{ $fb->created_at->format('d M Y') }}</div>
                </td>

                {{-- Action --}}
                <td class="px-6 py-5 align-middle">
                    <div class="flex justify-end opacity-50 group-hover:opacity-100 transition-opacity">
                        <button
                            onclick="ajaxAction('{{ route('admin.feedback.destroy', $fb) }}','DELETE',this,'Feedback Deleted.','error')"
                            class="w-8 h-8 rounded-lg border border-red-500/30 bg-red-500/10 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all text-red-400 text-xs focus:outline-none shadow-inner">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-20 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-2xl mx-auto mb-4">
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-white font-black uppercase tracking-[0.2em] text-xs mb-1">No feedback found</p>
                    <p class="text-white/40 font-bold text-[0.65rem] uppercase tracking-widest">Adjust your filters to see more results.</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if ($feedbacks->hasPages())
    <div class="px-8 py-5 border-t border-white/5 bg-navy/50 flex flex-wrap items-center justify-between gap-4">
        <span class="text-[0.65rem] text-white/40 font-black uppercase tracking-widest">
            Showing {{ $feedbacks->firstItem() }}–{{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }}
        </span>
        {{ $feedbacks->links() }}
    </div>
@endif
