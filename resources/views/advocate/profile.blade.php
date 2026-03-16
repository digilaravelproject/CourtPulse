@extends('layouts.advocate')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── LEFT: Profile Summary Card ── --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-8 text-center" style="background:linear-gradient(135deg,#060C18 0%,#1a2744 100%)">
                    <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center font-bold font-display text-2xl mb-3"
                        style="background:linear-gradient(135deg,#D4AF37,#B5952F);color:#060C18">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="font-display font-bold text-white text-lg">{{ auth()->user()->name }}</div>
                    <div class="font-mono text-[.6rem] uppercase tracking-widest mt-1" style="color:rgba(212,175,55,.6)">
                        Advocate</div>
                    <div class="mt-3">
                        @if (auth()->user()->status === 'active')
                            <span class="px-3 py-1 rounded-full text-[.62rem] font-mono font-bold"
                                style="background:rgba(34,197,94,.15);color:#16a34a;border:1px solid rgba(34,197,94,.25)">
                                ✓ Account Verified
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[.62rem] font-mono font-bold"
                                style="background:rgba(212,175,55,.12);color:#D4AF37;border:1px solid rgba(212,175,55,.25)">
                                ⏳ Pending Verification
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-4 space-y-3 text-sm">
                    <div class="flex items-center gap-2.5 text-slate-600">
                        <i class="bi bi-envelope w-4 text-slate-400"></i> {{ auth()->user()->email }}
                    </div>
                    @if (auth()->user()->phone)
                        <div class="flex items-center gap-2.5 text-slate-600">
                            <i class="bi bi-telephone w-4 text-slate-400"></i> {{ auth()->user()->phone }}
                        </div>
                    @endif
                    @if ($profile && $profile->bar_council_number)
                        <div class="flex items-center gap-2.5 text-slate-600">
                            <i class="bi bi-patch-check w-4 text-slate-400"></i> {{ $profile->bar_council_number }}
                        </div>
                    @endif
                    @if ($profile && $profile->experience_years)
                        <div class="flex items-center gap-2.5 text-slate-600">
                            <i class="bi bi-briefcase w-4 text-slate-400"></i> {{ $profile->experience_years }} Years Exp.
                        </div>
                    @endif
                </div>
            </div>

            @if ($profile && !empty($profile->practice_areas))
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <h4 class="font-display font-bold text-slate-800 mb-3">Practice Areas</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($profile->practice_areas as $area)
                            <span class="px-3 py-1 rounded-full text-xs font-mono font-semibold"
                                style="background:rgba(212,175,55,.1);color:#92650a;border:1px solid rgba(212,175,55,.2)">
                                {{ $area }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- ── RIGHT: Edit Form ── --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-display font-bold text-slate-800 text-[1.05rem]">Professional Information</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Update your bar council details and professional information
                    </p>
                </div>

                <form action="{{ route('advocate.profile.update') }}" method="POST" class="p-6">
                    @csrf

                    {{-- Section: Bar Council --}}
                    <div class="font-mono text-[.58rem] tracking-[2px] uppercase text-slate-400 mb-3">BAR COUNCIL DETAILS
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Bar
                                Council Number *</label>
                            <input type="text" name="bar_council_number" required
                                value="{{ old('bar_council_number', $profile->bar_council_number ?? '') }}"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                            @error('bar_council_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Enrollment
                                Number *</label>
                            <input type="text" name="enrollment_number" required
                                value="{{ old('enrollment_number', $profile->enrollment_number ?? '') }}"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                            @error('enrollment_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Enrollment
                                Date *</label>
                            <input type="date" name="enrollment_date" required
                                value="{{ old('enrollment_date', $profile->enrollment_date ?? '') }}"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                            @error('enrollment_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">High
                                Court *</label>
                            <input type="text" name="high_court" required
                                value="{{ old('high_court', $profile->high_court ?? '') }}"
                                placeholder="e.g. Allahabad High Court"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                            @error('high_court')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Section: Professional --}}
                    <div class="font-mono text-[.58rem] tracking-[2px] uppercase text-slate-400 mb-3">PROFESSIONAL DETAILS
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label
                                class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Years
                                of Experience</label>
                            <input type="number" name="experience_years" min="0" max="60"
                                value="{{ old('experience_years', $profile->experience_years ?? '') }}"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                        </div>
                        <div>
                            <label
                                class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Office
                                Phone</label>
                            <input type="text" name="office_phone"
                                value="{{ old('office_phone', $profile->office_phone ?? '') }}"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                        </div>
                        <div>
                            <label
                                class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Website</label>
                            <input type="url" name="website" value="{{ old('website', $profile->website ?? '') }}"
                                placeholder="https://..."
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                        </div>
                        <div>
                            <label
                                class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">City</label>
                            <input type="text" name="city" value="{{ old('city', auth()->user()->city ?? '') }}"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm
                     focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                        </div>
                    </div>

                    {{-- Practice Areas --}}
                    <div class="mb-5">
                        <label class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Practice
                            Areas</label>
                        @php
                            $allAreas = [
                                'Criminal Law',
                                'Civil Law',
                                'Family Law',
                                'Corporate Law',
                                'Constitutional Law',
                                'Tax Law',
                                'Labour Law',
                                'Property Law',
                                'IP Law',
                                'Cyber Law',
                            ];
                            $selected = $profile->practice_areas ?? [];
                        @endphp
                        <div class="flex flex-wrap gap-2">
                            @foreach ($allAreas as $area)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="practice_areas[]" value="{{ $area }}"
                                        {{ in_array($area, $selected) ? 'checked' : '' }} class="peer hidden">
                                    <span
                                        class="inline-block px-3 py-1.5 rounded-full text-xs font-mono font-semibold border transition-all
                           border-slate-200 text-slate-500 bg-white
                           peer-checked:border-yellow-400 peer-checked:text-[#92650a]"
                                        style="peer-checked:background:rgba(212,175,55,.1)">
                                        {{ $area }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Bio --}}
                    <div class="mb-5">
                        <label
                            class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Professional
                            Bio</label>
                        <textarea name="bio" rows="4" maxlength="2000"
                            placeholder="Brief description of your practice and expertise..."
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm resize-none
                   focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">{{ old('bio', $profile->bio ?? '') }}</textarea>
                    </div>

                    {{-- Office Address --}}
                    <div class="mb-6">
                        <label class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Office
                            Address</label>
                        <textarea name="office_address" rows="2" maxlength="500"
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm resize-none
                   focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">{{ old('office_address', $profile->office_address ?? (auth()->user()->address ?? '')) }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold transition-all"
                            style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                            onmouseout="this.style.background='#D4AF37'">
                            <i class="bi bi-check-lg"></i> Save Profile
                        </button>
                        <a href="{{ route('advocate.dashboard') }}"
                            class="px-5 py-2.5 rounded-xl text-sm font-medium border border-slate-200 text-slate-500 hover:border-slate-400 transition-all">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            input[type="checkbox"]:checked+span {
                background: rgba(212, 175, 55, .1) !important;
                border-color: #D4AF37 !important;
                color: #92650a !important;
            }
        </style>
    @endpush

@endsection
