<table class="w-full text-sm">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200">
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">User</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden sm:table-cell">
                Role</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Document
                Type</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                File</th>
            <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Status</th>
            <th
                class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden lg:table-cell">
                Uploaded</th>
            <th class="px-4 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Action
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($documents as $doc)
            <tr class="trow" data-docid="{{ $doc->id }}">
                <td>
                    <div class="font-semibold text-slate-800">{{ $doc->user->name }}</div>
                    <div class="text-[0.72rem] text-slate-400">{{ $doc->user->email }}</div>
                </td>
                <td class="hidden sm:table-cell">
                    <span
                        class="font-mono text-[0.6rem] uppercase tracking-wider text-slate-500">{{ $doc->user->role }}</span>
                </td>
                <td class="font-medium text-slate-700">
                    {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}
                </td>
                <td class="hidden md:table-cell">
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                        class="inline-flex items-center gap-1.5 text-gold hover:text-gold-h text-[0.82rem] font-medium transition-colors">
                        <i class="bi bi-file-earmark-arrow-down"></i> View
                    </a>
                </td>
                <td>
                    @if ($doc->status === 'approved')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-green-100 text-green-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="dot bg-green-500"></span>Approved</span>
                    @elseif($doc->status === 'pending')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-100 text-amber-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="dot bg-amber-400"></span>Pending</span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-red-100 text-red-600 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="dot bg-red-500"></span>Rejected</span>
                    @endif
                </td>
                <td class="text-slate-400 text-[0.75rem] hidden lg:table-cell">{{ $doc->created_at->format('d M Y') }}
                </td>
                <td>
                    <div class="flex items-center gap-1.5 justify-end">
                        @if ($doc->status === 'pending')
                            <button
                                onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Document Approved!','ok')"
                                data-body='{"status":"approved"}'
                                class="flex items-center gap-1 px-3 h-8 rounded-lg bg-green-500 hover:bg-green-600 text-white text-xs font-bold transition-all">
                                <i class="bi bi-check-lg"></i>
                            </button>
                            <button
                                onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Document Rejected.','err')"
                                data-body='{"status":"rejected","rejection_reason":"Invalid document"}'
                                class="flex items-center gap-1 px-3 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-bold transition-all">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        @elseif($doc->status === 'rejected')
                            <span
                                class="text-[0.72rem] text-red-500 max-w-[120px] block">{{ $doc->rejection_reason }}</span>
                        @else
                            <span class="text-[0.72rem] text-green-600 font-medium">✓ Verified</span>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="py-14 text-center text-slate-400 text-sm">
                    <i class="bi bi-file-earmark-check text-3xl block mb-2 text-slate-300"></i>
                    No documents found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@if ($documents->hasPages())
    <div class="px-4 py-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
        <span class="text-xs text-slate-400 font-mono">Showing
            {{ $documents->firstItem() }}–{{ $documents->lastItem() }} of {{ $documents->total() }}</span>
        {{ $documents->links() }}
    </div>
@endif
