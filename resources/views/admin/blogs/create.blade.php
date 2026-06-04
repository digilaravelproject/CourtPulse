@extends('layouts.admin')
@section('title', 'Write Blog Article')
@section('page-title', 'Write Article')

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
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Write New Article</h2>
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
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Title --}}
            <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-2">
                <label for="title" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Article Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       placeholder="Enter blog title (e.g. Navigating Digital Filing Directives...)"
                       class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none">
            </div>

            {{-- Category & Image Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Category --}}
                <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-2">
                    <label for="category" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Category</label>
                    <input type="text" id="category" name="category" value="{{ old('category', 'Procedural Updates') }}" required
                           placeholder="e.g. Legal Tech, Causelists, Registry Rules"
                           class="w-full bg-navy border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-white/20 focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none">
                </div>

                {{-- Thumbnail --}}
                <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-2">
                    <label for="image" class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Cover Image (Required)</label>
                    <input type="file" id="image" name="image" accept="image/*" required
                           class="w-full bg-navy border border-white/5 rounded-xl px-4 py-2 text-xs text-white focus:ring-1 focus:ring-blue/50 focus:border-blue/50 transition-all outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[0.65rem] file:font-black file:uppercase file:tracking-widest file:bg-blue/10 file:text-blue hover:file:bg-blue/20 file:cursor-pointer">
                </div>
            </div>

            {{-- Rich Text Editor --}}
            <div class="bg-navy2 p-6 rounded-2xl border border-white/5 space-y-3">
                <label class="block text-[0.65rem] text-white/50 font-bold uppercase tracking-widest">Article Body</label>
                
                <div id="editor-container">
                    <div id="editor">{!! old('content') !!}</div>
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
                    Publish Article
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
                        ['link', 'clean']
                    ]
                }
            });

            // Set up form submission handler
            const form = document.querySelector('form');
            form.addEventListener('submit', (e) => {
                const contentInput = document.getElementById('content-input');
                const html = quill.root.innerHTML;
                
                // Set the hidden input value
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
