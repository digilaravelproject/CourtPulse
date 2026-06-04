@extends('layouts.main')

@section('title', 'Legal & Procedural Insights - DockIt')

@section('content')
<section class="py-24 bg-[#050812]">
    <div class="max-w-[1500px] mx-auto px-6">
        <div class="max-w-3xl mb-24">
            <span class="section-label">EDITORIAL BITS</span>
            <h1 class="text-7xl font-black text-white leading-[0.9] uppercase tracking-tighter mb-8">
                THE DOCKIT <br> <span class="text-[#B4B4FE]">JOURNAL.</span>
            </h1>
            <p class="text-xl text-slate-500 leading-relaxed">Deep dives into Indian procedural law, registry updates, and the evolving landscape of legal tech.</p>
        </div>

        @if($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
                @foreach($blogs as $blog)
                <article class="group">
                    <div class="aspect-16/10 bg-[#0e1526] border border-white/5 mb-10 overflow-hidden rounded-2xl relative">
                        @if($blog->image_path)
                            <img src="{{ $blog->image_url }}" alt="Blog Thumb" 
                                 class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-navy3/40">
                                <i class="bi bi-image text-white/10 text-3xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-6 left-6 bg-[#B4B4FE] text-[#050812] text-[0.6rem] font-black px-4 py-1.5 uppercase tracking-widest rounded-sm">
                            {{ $blog->category }}
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 text-[0.65rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-4">
                            <i class="bi bi-clock"></i> {{ $blog->read_time }} • {{ $blog->created_at->format('F d, Y') }}
                        </div>
                        <h3 class="text-3xl font-black text-white leading-tight uppercase tracking-tight group-hover:text-[#B4B4FE] transition-colors mb-4">
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-[#B4B4FE] transition-colors no-underline">
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p class="text-slate-500 line-clamp-2 leading-relaxed mb-8">
                            {{ Str::limit(strip_tags($blog->content), 150) }}
                        </p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="inline-flex items-center gap-2 text-xs font-black text-white uppercase tracking-widest group-hover:gap-4 transition-all no-underline">
                            READ ARTICLE <i class="bi bi-arrow-right text-[#B4B4FE]"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($blogs, 'hasPages') && $blogs->hasPages())
                <div class="mt-16 flex justify-start">
                    {{ $blogs->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="py-24 border border-white/5 bg-[#0e1526] rounded-3xl text-center flex flex-col items-center justify-center max-w-2xl mx-auto">
                <div class="w-20 h-20 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-3xl mb-6">
                    <i class="bi bi-journal-x text-slate-500"></i>
                </div>
                <h3 class="text-white font-black uppercase tracking-[0.2em] text-lg mb-2">No Articles Published</h3>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest max-w-md px-6 leading-relaxed">
                    We haven't published any journal entries or legal insights yet. Check back soon for procedural guides and updates.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
