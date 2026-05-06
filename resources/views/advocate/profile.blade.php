@extends('layouts.advocate')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ── LEFT: Profile Summary Card ── --}}
        <div class="space-y-6">
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-8 text-center border-b border-white/5 bg-navy/50 relative">
                    <div class="w-24 h-24 rounded-2xl mx-auto flex items-center justify-center font-black text-4xl mb-4 bg-blue/10 text-blue border border-blue/20 shadow-[0_0_20px_rgba(180,180,254,0.2)]">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="font-black text-white text-xl uppercase tracking-tight mb-1">{{ auth()->user()->name }}</div>
                    <div class="text-[0.65rem] uppercase tracking-widest font-bold text-white/50">Advocate</div>

                    <div class="mt-5">
                        @if (auth()->user()->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-green-500/10 border border-green-500/20 text-green-400 font-black text-[0.6rem] uppercase tracking-widest">
                                <i class="fas fa-check-circle"></i> Account Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-amber-500/10 border border-amber-500/20 text-amber-400 font-black text-[0.6rem] uppercase tracking-widest">
                                <i class="fas fa-hourglass-half"></i> Pending Verification
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info List -->
                <div class="p-6 space-y-4 bg-navy/50">
                    <div class="flex items-center gap-3 text-xs font-bold text-white/80 bg-navy p-3 rounded-xl border border-white/5 shadow-inner">
                        <i class="fas fa-envelope text-white/30 w-4 text-center"></i>
                        <span class="truncate">{{ auth()->user()->email }}</span>
                    </div>
                    @if (auth()->user()->phone)
                        <div class="flex items-center gap-3 text-xs font-bold text-white/80 bg-navy p-3 rounded-xl border border-white/5 shadow-inner">
                            <i class="fas fa-phone-alt text-white/30 w-4 text-center"></i>
                            <span>{{ auth()->user()->phone }}</span>
                        </div>
                    @endif
                    @if ($profile && $profile->bar_council_number)
                        <div class="flex items-center gap-3 text-xs font-bold text-white/80 bg-navy p-3 rounded-xl border border-white/5 shadow-inner">
                            <i class="fas fa-id-card text-white/30 w-4 text-center"></i>
                            <span class="truncate">{{ $profile->bar_council_number }}</span>
                        </div>
                    @endif
                    @if ($profile && $profile->experience_years)
                        <div class="flex items-center gap-3 text-xs font-bold text-white/80 bg-navy p-3 rounded-xl border border-white/5 shadow-inner">
                            <i class="fas fa-briefcase text-white/30 w-4 text-center"></i>
                            <span>{{ $profile->experience_years }} Years Exp.</span>
                        </div>
                    @endif
                </div>
            </div>

            @if ($profile && !empty($profile->practice_areas))
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-6">
                    <h4 class="font-black text-white/50 text-[0.65rem] uppercase tracking-[0.2em] mb-4">Practice Areas</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($profile->practice_areas as $area)
                            <span class="px-3 py-1.5 rounded-lg text-[0.65rem] font-black uppercase tracking-widest bg-white/5 border border-white/10 text-white/70">
                                {{ $area }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- ── RIGHT: Edit Form ── --}}
        <div class="lg:col-span-2">
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5">
                    <h3 class="font-black text-base text-white uppercase tracking-widest">Professional Information</h3>
                    <p class="text-white/50 text-[0.7rem] font-bold uppercase tracking-wider mt-1.5">
                        Update your bar council details and professional information
                    </p>
                </div>

                <form action="{{ route('advocate.profile.update') }}" method="POST" class="flex flex-col">
                    @csrf

                    <div class="p-8 bg-navy/50 space-y-8">

                        {{-- Error Messages Block --}}
                        @if ($errors->any())
                            <div class="p-5 bg-red-500/10 border border-red-500/30 rounded-2xl shadow-inner mb-6">
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

                        {{-- Section: Bar Council --}}
                        <div>
                            <div class="font-black text-white/40 text-[0.65rem] uppercase tracking-[0.2em] mb-4 border-b border-white/5 pb-2">Bar Council Details</div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Bar Council Number <span class="text-blue">*</span></label>
                                    <div class="relative">
                                        <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="bar_council_number" required value="{{ old('bar_council_number', $profile->bar_council_number ?? '') }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('bar_council_number') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Enrollment Number <span class="text-blue">*</span></label>
                                    <div class="relative">
                                        <i class="fas fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="enrollment_number" required value="{{ old('enrollment_number', $profile->enrollment_number ?? '') }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('enrollment_number') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Enrollment Date <span class="text-blue">*</span></label>
                                    <div class="relative">
                                        <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="date" name="enrollment_date" required value="{{ old('enrollment_date', $profile->enrollment_date ?? '') }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('enrollment_date') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">High Court <span class="text-blue">*</span></label>
                                    <div class="relative">
                                        <i class="fas fa-university absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="high_court" required value="{{ old('high_court', $profile->high_court ?? '') }}" placeholder="e.g. Bombay High Court"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('high_court') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Professional --}}
                        <div>
                            <div class="font-black text-white/40 text-[0.65rem] uppercase tracking-[0.2em] mb-4 border-b border-white/5 pb-2 mt-4">Professional Details</div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Years of Experience</label>
                                    <div class="relative">
                                        <i class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="number" name="experience_years" min="0" max="60" value="{{ old('experience_years', $profile->experience_years ?? '') }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('experience_years') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Office Phone</label>
                                    <div class="relative">
                                        <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="office_phone" value="{{ old('office_phone', $profile->office_phone ?? '') }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('office_phone') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Website</label>
                                    <div class="relative">
                                        <i class="fas fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="url" name="website" value="{{ old('website', $profile->website ?? '') }}" placeholder="https://..."
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('website') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">City</label>
                                    <div class="relative">
                                        <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="city" value="{{ old('city', auth()->user()->city ?? '') }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner
                                            {{ $errors->has('city') ? 'border-red-500/50' : 'border-white/10' }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Practice Areas --}}
                            <div class="mb-8">
                                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-3">Practice Areas</label>
                                @php
                                    $allAreas = [
                                        'Criminal Law', 'Civil Law', 'Family Law', 'Corporate Law',
                                        'Constitutional Law', 'Tax Law', 'Labour Law', 'Property Law',
                                        'IP Law', 'Cyber Law',
                                    ];
                                    $selected = $profile->practice_areas ?? [];
                                @endphp
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($allAreas as $area)
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="practice_areas[]" value="{{ $area }}" {{ in_array($area, $selected) ? 'checked' : '' }} class="peer hidden">
                                            <span class="inline-block px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border transition-all duration-300
                                                border-white/10 text-white/50 bg-white/5
                                                peer-checked:border-blue/50 peer-checked:text-blue peer-checked:bg-blue/10 peer-checked:shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                                                {{ $area }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Bio --}}
                            <div class="mb-6">
                                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Professional Bio</label>
                                <div class="relative">
                                    <i class="fas fa-user-edit absolute left-4 top-4 text-white/30"></i>
                                    <textarea name="bio" rows="4" maxlength="2000" placeholder="Brief description of your practice and expertise..."
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner resize-none
                                        {{ $errors->has('bio') ? 'border-red-500/50' : 'border-white/10' }}">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Office Address --}}
                            <div>
                                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Office Address</label>
                                <div class="relative">
                                    <i class="fas fa-map-marked-alt absolute left-4 top-4 text-white/30"></i>
                                    <textarea name="office_address" rows="2" maxlength="500"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner resize-none
                                        {{ $errors->has('office_address') ? 'border-red-500/50' : 'border-white/10' }}">{{ old('office_address', $profile->office_address ?? (auth()->user()->address ?? '')) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Row --}}
                    <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 px-8 py-6 border-t border-white/5 bg-navy mt-auto">
                        <a href="{{ route('advocate.dashboard') }}"
                            class="w-full sm:w-auto text-center px-8 py-3.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-blue hover:bg-white text-navy rounded-xl transition-all shadow-[0_5px_20px_rgba(180,180,254,0.25)] transform hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fas fa-save text-sm"></i> Save Profile
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection
