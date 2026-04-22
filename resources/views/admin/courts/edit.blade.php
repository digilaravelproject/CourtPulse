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
                {{-- Current status badge --}}
                @if ($court->is_active)
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-green-100 text-green-700
                     font-mono text-[0.62rem] uppercase tracking-wide font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 text-slate-500
                     font-mono text-[0.62rem] uppercase tracking-wide font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                    </span>
                @endif
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

                    {{-- Court Type --}}
                    <div>
                        <label class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">
                            Court Type <span class="text-red-400">*</span>
                        </label>
                        <select name="type" required
                            class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold
                   {{ $errors->has('type') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}">
                            <option value="supreme" {{ old('type', $court->type) === 'supreme' ? 'selected' : '' }}>Supreme
                                Court</option>
                            <option value="high" {{ old('type', $court->type) === 'high' ? 'selected' : '' }}>High
                                Court</option>
                            <option value="district" {{ old('type', $court->type) === 'district' ? 'selected' : '' }}>
                                District Court</option>
                            <option value="session" {{ old('type', $court->type) === 'session' ? 'selected' : '' }}>
                                Sessions Court</option>
                            <option value="civil" {{ old('type', $court->type) === 'civil' ? 'selected' : '' }}>Civil
                                Court</option>
                            <option value="criminal" {{ old('type', $court->type) === 'criminal' ? 'selected' : '' }}>
                                Criminal Court</option>
                            <option value="family" {{ old('type', $court->type) === 'family' ? 'selected' : '' }}>Family
                                Court</option>
                            <option value="consumer" {{ old('type', $court->type) === 'consumer' ? 'selected' : '' }}>
                                Consumer Court</option>
                            <option value="tribunal" {{ old('type', $court->type) === 'tribunal' ? 'selected' : '' }}>
                                Tribunal</option>
                        </select>
                        @error('type')
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

                    {{-- City --}}
                    <div>
                        <label class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">
                            City <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="city" value="{{ old('city', $court->city) }}" required
                            class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold
                   {{ $errors->has('city') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}">
                        @error('city')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- State --}}
                    <div>
                        <label class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">
                            State <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="state" value="{{ old('state', $court->state) }}" required
                            class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold
                   {{ $errors->has('state') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}">
                        @error('state')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="md:col-span-2">
                        <label
                            class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg bg-white resize-none
                   focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">{{ old('address', $court->address) }}</textarea>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label
                            class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">Phone</label>
                        <div class="relative">
                            <i class="bi bi-telephone absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" name="phone" value="{{ old('phone', $court->phone) }}"
                                class="w-full pl-8 pr-3.5 py-2.5 text-sm border border-slate-200 rounded-lg bg-white
                     focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label
                            class="block font-mono text-[0.6rem] tracking-[1.5px] uppercase text-slate-500 mb-1.5">Email</label>
                        <div class="relative">
                            <i class="bi bi-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="email" name="email" value="{{ old('email', $court->email) }}"
                                class="w-full pl-8 pr-3.5 py-2.5 text-sm border rounded-lg bg-white transition
                     focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold
                     {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }}">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Active Toggle --}}
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 cursor-pointer group w-fit">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $court->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-slate-300 text-gold focus:ring-gold cursor-pointer">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900 transition-colors">
                                Court is active
                            </span>
                        </label>
                        <p class="mt-1 text-xs text-slate-400 ml-7">Inactive Courts won't appear in professional searches.
                        </p>
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
