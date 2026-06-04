@if($blogs->count() > 0)
    <table class="cp-table">
        <thead>
            <tr>
                <th class="w-20">Thumbnail</th>
                <th>Blog Details</th>
                <th>Category</th>
                <th>Read Time</th>
                <th>Date Published</th>
                <th class="w-32 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
                <tr class="align-middle border-b border-white/5">
                    <td>
                        <div class="w-12 h-12 rounded-lg bg-navy overflow-hidden border border-white/10 flex items-center justify-center">
                            @if($blog->image_path)
                                <img src="{{ $blog->image_url }}" alt="thumb" class="w-full h-full object-cover">
                            @else
                                <i class="bi bi-image text-white/20"></i>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-white uppercase text-xs tracking-wide">{{ $blog->title }}</div>
                        <div class="text-[10px] text-white/30 font-semibold truncate max-w-sm mt-0.5">
                            {{ strip_tags($blog->content) }}
                        </div>
                    </td>
                    <td>
                        <span class="text-[10px] font-black uppercase tracking-widest text-blue bg-blue/10 border border-blue/20 px-2.5 py-1 rounded">
                            {{ $blog->category }}
                        </span>
                    </td>
                    <td class="text-xs text-white/50 font-bold uppercase tracking-wider font-mono">
                        {{ $blog->read_time }}
                    </td>
                    <td class="text-xs text-white/40 font-bold">
                        {{ $blog->created_at->format('M d, Y') }}
                    </td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                               class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-white/60 hover:text-blue hover:border-blue transition-colors">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button onclick="deleteBlog({{ $blog->id }}, this)" 
                                    class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-white/60 hover:text-red-400 hover:border-red-500/30 transition-colors">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="p-6 border-t border-white/5">
        {{ $blogs->links() }}
    </div>
@else
    <div class="py-24 text-center">
        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/20 text-2xl mx-auto mb-4">
            <i class="bi bi-journal-text"></i>
        </div>
        <h4 class="text-white font-black uppercase tracking-widest text-sm mb-1">No blogs found</h4>
        <p class="text-white/30 text-xs font-bold uppercase tracking-widest">No articles published yet.</p>
    </div>
@endif
