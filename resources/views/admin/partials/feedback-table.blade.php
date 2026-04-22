<table class="w-full text-sm">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200">
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">From</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">To</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Rating</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                Comment</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden lg:table-cell">
                Date</th>
            <th class="px-4 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Action
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($feedbacks as $fb)
            <tr class="trow" data-fbid="{{ $fb->id }}">
                <td>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-[0.75rem] shrink-0">
                            {{ strtoupper(substr($fb->giver->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-slate-700 text-[0.83rem]">{{ $fb->giver->name ?? 'Unknown' }}
                            </div>
                            <div class="font-mono text-[0.58rem] uppercase text-slate-400">{{ $fb->giver->role ?? '' }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-[0.75rem] shrink-0">
                            {{ strtoupper(substr($fb->receiver->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-slate-700 text-[0.83rem]">
                                {{ $fb->receiver->name ?? 'Unknown' }}</div>
                            <div class="font-mono text-[0.58rem] uppercase text-slate-400">
                                {{ $fb->receiver->role ?? '' }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex items-center gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }} text-gold text-[0.85rem]"></i>
                        @endfor
                        <span class="ml-1.5 font-mono text-[0.7rem] text-slate-500">{{ $fb->rating }}/5</span>
                    </div>
                </td>
                <td class="text-slate-600 hidden md:table-cell max-w-[200px]">
                    <div class="truncate text-[0.82rem]">{{ $fb->comment ?? '—' }}</div>
                </td>
                <td class="text-slate-400 text-[0.75rem] hidden lg:table-cell">{{ $fb->created_at->format('d M Y') }}
                </td>
                <td>
                    <div class="flex justify-end">
                        <button
                            onclick="ajaxAction('{{ route('admin.feedback.destroy', $fb) }}','DELETE',this,'Feedback Deleted.','err')"
                            class="w-8 h-8 rounded-lg border border-red-200 bg-red-50 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all text-red-500 text-sm">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="py-14 text-center text-slate-400 text-sm">
                    <i class="bi bi-star text-3xl block mb-2 text-slate-300"></i>
                    No feedback found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@if ($feedbacks->hasPages())
    <div class="px-4 py-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
        <span class="text-xs text-slate-400 font-mono">Showing
            {{ $feedbacks->firstItem() }}–{{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }}</span>
        {{ $feedbacks->links() }}
    </div>
@endif
