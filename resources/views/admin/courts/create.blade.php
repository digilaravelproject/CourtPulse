@extends('layouts.admin')
@section('title', 'Add Court')
@section('page-title', 'Add New Court')

@section('content')

    {{-- ── BACK BUTTON ─────────────────────────────── --}}
    <div class="mb-8">
        <a href="{{ route('admin.courts.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 text-white/70 hover:text-white transition-all text-xs font-black uppercase tracking-widest shadow-lg">
            <i class="fas fa-arrow-left"></i> Back to Courts
        </a>
    </div>

    <div class="max-w-4xl mx-auto md:mx-0">
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col transform transition-all duration-300">

            {{-- Card Header --}}
            <div class="flex items-center gap-5 px-8 py-6 border-b border-white/5 bg-white/5">
                <div class="w-14 h-14 rounded-2xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-2xl shrink-0 shadow-[0_0_20px_rgba(180,180,254,0.15)]">
                    <i class="fas fa-building-circle-check"></i>
                </div>
                <div class="flex-1">
                    <h2 class="font-black text-base text-white uppercase tracking-widest">Add New Court</h2>
                    <p class="text-[0.7rem] text-white/50 uppercase tracking-wider font-bold mt-1.5">Register a new court or tribunal to the system.</p>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.courts.store') }}" method="POST" class="flex flex-col">
                @csrf

                <div class="p-8 bg-navy/50 space-y-8">

                    {{-- Error Messages Block --}}
                    @if ($errors->any())
                        <div class="p-5 bg-red-500/10 border border-red-500/30 rounded-2xl shadow-inner mb-2">
                            <div class="flex items-center gap-2 text-red-400 font-black text-xs uppercase tracking-widest mb-3">
                                <i class="fas fa-exclamation-triangle text-lg"></i> Please fix the following errors:
                            </div>
                            <ul class="list-disc list-inside text-xs font-bold text-red-400/80 space-y-1.5 ml-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Court Name --}}
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">
                                Court Name <span class="text-blue">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-university absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    placeholder="e.g. Bombay High Court"
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                    {{ $errors->has('name') ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-white/10' }}">
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-[10px] font-bold text-red-400 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Area --}}
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">
                                Area
                            </label>
                            <div class="relative">
                                <i class="fas fa-map-marked-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="text" name="area" value="{{ old('area') }}"
                                    placeholder="e.g. Bandra East"
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                    {{ $errors->has('area') ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-white/10' }}">
                            </div>
                            @error('area')
                                <p class="mt-1.5 text-[10px] font-bold text-red-400 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- City --}}
                        <div>
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">
                                City
                            </label>
                            <div class="relative">
                                <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="text" name="city" value="{{ old('city') }}" placeholder="e.g. Mumbai"
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                    {{ $errors->has('city') ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-white/10' }}">
                            </div>
                            @error('city')
                                <p class="mt-1.5 text-[10px] font-bold text-red-400 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Pincode --}}
                        <div>
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">
                                PIN Code
                            </label>
                            <div class="relative">
                                <i class="fas fa-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="text" name="pincode" value="{{ old('pincode') }}" placeholder="400001"
                                    maxlength="6" inputmode="numeric"
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                    {{ $errors->has('pincode') ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-white/10' }}">
                            </div>
                            @error('pincode')
                                <p class="mt-1.5 text-[10px] font-bold text-red-400 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Submit Row --}}
                <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 px-8 py-6 border-t border-white/5 bg-navy mt-auto">
                    <a href="{{ route('admin.courts.index') }}"
                        class="w-full sm:w-auto text-center px-8 py-3.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">
                        Cancel
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-blue hover:bg-white text-navy rounded-xl transition-all shadow-[0_5px_20px_rgba(180,180,254,0.25)] transform hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fas fa-plus text-sm"></i> Add Court
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
