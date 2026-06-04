@extends('layouts.main')

@section('title', $blog->title . ' — DockIt Journal')

@section('content')
<style>
    .blog-content-rich p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.75);
        font-size: 1.05rem;
    }
    .blog-content-rich h1, 
    .blog-content-rich h2, 
    .blog-content-rich h3, 
    .blog-content-rich h4 {
        color: #fff;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        line-height: 1.2;
    }
    .blog-content-rich h1 { font-size: 2.25rem; }
    .blog-content-rich h2 { font-size: 1.75rem; border-b: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.5rem; }
    .blog-content-rich h3 { font-size: 1.4rem; }
    .blog-content-rich h4 { font-size: 1.2rem; }
    
    .blog-content-rich ul, 
    .blog-content-rich ol {
        margin-bottom: 1.75rem;
        padding-left: 1.5rem;
    }
    .blog-content-rich ul { list-style-type: disc; }
    .blog-content-rich ol { list-style-type: decimal; }
    
    .blog-content-rich li {
        margin-bottom: 0.6rem;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.75);
    }
    .blog-content-rich blockquote {
        border-left: 4px solid #B4B4FE;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #B4B4FE;
        background-color: rgba(180, 180, 254, 0.03);
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-radius: 0 8px 8px 0;
    }
    .blog-content-rich pre {
        background-color: rgba(5, 8, 18, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 1.25rem;
        overflow-x: auto;
        margin-bottom: 1.75rem;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        color: #B4B4FE;
        font-size: 0.9rem;
    }
    .blog-content-rich a {
        color: #B4B4FE;
        text-decoration: underline;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .blog-content-rich a:hover {
        color: #fff;
    }
</style>

<section class="py-16 md:py-24 bg-[#050812] relative overflow-hidden">
    <!-- Subtle Background Glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl h-[600px] bg-blue/5 blur-[180px] pointer-events-none"></div>

    <div class="max-w-[1500px] mx-auto px-6 relative z-10">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2.5 text-[0.65rem] font-black uppercase tracking-widest text-slate-500 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('blogs') }}" class="hover:text-white transition-colors no-underline">Journal</a>
            <i class="bi bi-chevron-right text-[8px] text-[#B4B4FE]"></i>
            <span class="text-slate-400">{{ $blog->category }}</span>
            <i class="bi bi-chevron-right text-[8px] text-[#B4B4FE] hidden sm:inline-block"></i>
            <span class="text-white truncate max-w-xs hidden sm:inline-block">{{ $blog->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            {{-- Main Column --}}
            <article class="lg:col-span-8 space-y-10">
                <div>
                    {{-- Category & Date Meta --}}
                    <div class="flex flex-wrap items-center gap-4 text-[0.65rem] font-bold text-[#B4B4FE] uppercase tracking-widest mb-6">
                        <span class="bg-[#B4B4FE20] px-3.5 py-1.5 rounded text-[#B4B4FE]">{{ $blog->category }}</span>
                        <span>{{ $blog->read_time }}</span>
                        <span class="text-slate-500">•</span>
                        <span class="text-slate-500">Published: {{ $blog->created_at->format('F d, Y') }}</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white leading-[1.05] uppercase tracking-tighter mb-8 break-words">
                        {{ $blog->title }}
                    </h1>
                </div>

                {{-- Featured Cover Image --}}
                @if($blog->image_path)
                    <div class="aspect-21/9 w-full bg-[#0e1526] border border-white/5 overflow-hidden rounded-3xl relative">
                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                {{-- Rich Text Body Content --}}
                <div class="blog-content-rich prose prose-invert max-w-none pt-4 break-words">
                    {!! $blog->content !!}
                </div>
            </article>

            {{-- Sidebar Column --}}
            <aside class="lg:col-span-4 space-y-12">
                @if($recentBlogs->count() > 0)
                    <div class="bg-[#0e1526] border border-white/5 rounded-3xl p-8 shadow-2xl">
                        <h4 class="text-white font-black uppercase tracking-[0.15em] text-sm mb-6 border-b border-white/5 pb-4">
                            Recent Articles
                        </h4>
                        
                        <div class="space-y-6">
                            @foreach($recentBlogs as $recent)
                                <div class="group flex gap-4 items-start">
                                    @if($recent->image_path)
                                        <div class="w-16 h-16 rounded-xl bg-navy overflow-hidden shrink-0 border border-white/5 relative">
                                            <img src="{{ $recent->image_url }}" alt="thumb" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-[#B4B4FE] block mb-1">
                                            {{ $recent->category }}
                                        </span>
                                        <h5 class="text-xs font-black uppercase tracking-tight text-white line-clamp-2 leading-snug group-hover:text-[#B4B4FE] transition-colors">
                                            <a href="{{ route('blogs.show', $recent->slug) }}" class="no-underline">
                                                {{ $recent->title }}
                                            </a>
                                        </h5>
                                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1 block">
                                            {{ $recent->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Legal Notice Box --}}
                <div class="bg-navy2 border border-white/5 rounded-3xl p-8 relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-blue/5 blur-2xl rounded-full"></div>
                    <span class="text-blue text-[10px] font-black uppercase tracking-widest block mb-2">Registry & Filings</span>
                    <h4 class="text-white font-black uppercase tracking-tight text-sm mb-3">Looking for causelists or circulars?</h4>
                    <p class="text-slate-400 text-xs leading-relaxed font-medium mb-6">
                        Stay informed on recent administrative updates and notifications issued directly from courts registry.
                    </p>
                    <a href="{{ route('updates') }}" class="inline-flex items-center gap-2 bg-blue hover:bg-white text-navy text-[0.65rem] font-black uppercase tracking-widest px-5 py-3 rounded-xl transition duration-300 no-underline shadow-lg shadow-blue/10">
                        View Updates <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
