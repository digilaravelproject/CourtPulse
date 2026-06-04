@extends('layouts.admin')
@section('title', 'Edit Blog Article')
@section('page-title', 'Edit Article')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <style>
        .ql-toolbar.ql-snow {
            background-color: #080d1a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 10px 15px;
        }
        .ql-container.ql-snow {
            background-color: #050812 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            min-height: 300px;
            font-size: 0.85rem;
            color: #F8FAFC !important;
        }
        .ql-editor {
            min-height: 300px;
            line-height: 1.7;
        }
        .ql-editor.ql-blank::before {
            color: rgba(255, 255, 255, 0.2) !important;
            font-style: normal;
        }
        .ql-snow .ql-stroke {
            stroke: rgba(255, 255, 255, 0.6) !important;
        }
        .ql-snow .ql-fill {
            fill: rgba(255, 255, 255, 0.6) !important;
        }
        .ql-snow .ql-picker {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        .ql-snow .ql-picker-options {
            background-color: #080d1a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-3xl">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.blogs.index') }}" class="text-xs font-bold text-[#B4B4FE] uppercase tracking-widest flex items-center gap-1 mb-2 hover:underline">
                    <i class="bi bi-arrow-left"></i> Back to articles
                </a>
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Edit Blog Article</h2>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-xs font-bold uppercase tracking-wider space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Form --}}
        <form id="blog-form" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Title --}}
            <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-2">
                <label for="title" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Article Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}" required
                       placeholder="Enter blog title (e.g. Navigating Digital Filing Directives...)"
                       class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none">
            </div>

            {{-- Category & Image Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Category --}}
                <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-2">
                    <label for="category" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Category</label>
                    <input type="text" id="category" name="category" value="{{ old('category', $blog->category) }}" required
                           placeholder="e.g. Legal Tech, Causelists, Registry Rules"
                           class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none">
                </div>

                {{-- Thumbnail --}}
                <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-2">
                    <label for="image" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Replace Cover Image (Optional)</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full bg-navy border border-white/5 rounded-xl px-4 py-2 text-xs text-white focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[0.65rem] file:font-black file:uppercase file:tracking-widest file:bg-blue/10 file:text-blue hover:file:bg-blue/20 file:cursor-pointer">
                    
                    {{-- Existing Image Preview --}}
                    @if($blog->image_path)
                        <div class="mt-3 p-3 rounded-lg bg-blue/5 border border-blue/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded bg-navy border border-white/10 overflow-hidden shrink-0">
                                    <img src="{{ $blog->image_url }}" alt="cover" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="text-[0.55rem] text-white/40 font-bold uppercase tracking-widest">Current Image</div>
                                    <a href="{{ $blog->image_url }}" target="_blank" class="text-[10px] font-bold text-blue hover:text-white underline">View Full Image</a>
                                </div>
                            </div>
                            <span class="text-[9px] text-white/30 font-bold uppercase tracking-wider">Kept unless replaced</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Rich Text Editor --}}
            <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-3">
                <label class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Article Body</label>
                
                <div id="editor-container">
                    <div id="editor">{!! old('content', $blog->content) !!}</div>
                </div>

                <input type="hidden" name="content" id="content-input">
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.blogs.index') }}"
                   class="px-6 py-3 rounded-xl bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white transition-all text-xs font-bold uppercase tracking-widest">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue text-navy font-black rounded-xl hover:bg-white transition-all shadow-lg shadow-blue/20 text-xs uppercase tracking-widest">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Write the blog post contents here...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'clean']
                    ]
                }
            });

            const contentInput = document.getElementById('content-input');

            // Sync editor text to hidden input on change
            quill.on('text-change', () => {
                contentInput.value = quill.root.innerHTML;
            });

            // Set up form submission handler
            const form = document.getElementById('blog-form');
            form.addEventListener('submit', (e) => {
                const html = quill.root.innerHTML;
                contentInput.value = html;

                // Validate content presence (Quill blank state usually is '<p><br></p>')
                const plainText = quill.getText().trim();
                if (plainText.length === 0) {
                    e.preventDefault();
                    showToast('Blog content is required and cannot be empty.', 'err');
                }
            });
        });
    </script>
@endpush
