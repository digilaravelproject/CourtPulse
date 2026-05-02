@extends('layouts.admin')
@section('title', 'Edit Court')
@section('page-title', 'Edit Court')

@section('content')

    <div class="mb-4">
        <a href="{{ route('admin.courts.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border border-slate-200
           rounded-lg hover:border-slate-400 bg-white text-slate-600 transition-all">
            <i class="bi bi-arrow-left"></i> Back to Courts
        </a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- Card Header --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-gold text-lg shrink-0">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="flex-1">
                    <h2 class="font-display font-bold text-[1.1rem] text-slate-800">Edit Court</h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $court->name }}</p>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.courts.update', $court) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 text-red-700 font-semibold text-sm mb-2">
                            <i class="bi bi-exclamation-circle"></i> Please fix the following errors:
                        </div>
                        <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Court Name --}}
                    <div class="md:col-span-2">
                        <label class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">
                            Court Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $court->name) }}" required
                            class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold
                   {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Area --}}
                    <div class="md:col-span-2">
                        <label class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">
                            Area
                        </label>
                        <input type="text" name="area" value="{{ old('area', $court->area) }}"
                            placeholder="e.g. Bandra East"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold
                   {{ $errors->has('area') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}">
                        @error('area')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">
                            City
                        </label>
                        <input type="text" name="city" value="{{ old('city', $court->city) }}"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold
                   {{ $errors->has('city') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}">
                        @error('city')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pincode --}}
                    <div>
                        <label
                            class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">PIN Code</label>
                        <input type="text" name="pincode" value="{{ old('pincode', $court->pincode) }}" maxlength="6"
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg bg-white
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                        @error('pincode')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Row --}}
                    <div class="md:col-span-2 flex items-center gap-3 pt-4 border-t border-slate-100 mt-2">
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold
                   bg-gold hover:bg-gold-h text-navy rounded-lg transition-all shadow-sm shadow-gold/30">
                            <i class="bi bi-floppy"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.courts.index') }}"
                            class="px-5 py-2.5 text-sm font-medium border border-slate-200 rounded-lg
                   hover:border-slate-400 bg-white text-slate-600 transition-all">
                            Cancel
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection
