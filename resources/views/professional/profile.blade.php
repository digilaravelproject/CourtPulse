@extends('professional.layouts.master')
@section('title', 'My Profile')
@section('page-title', 'Edit Profile')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- ── LEFT COLUMN: FORMS ── -->
        <div class="lg:col-span-8 space-y-8">

            <!-- UNIFIED PROFILE FORM -->
            <form action="{{ route('professional.profile.update') }}" method="POST" id="profileForm" class="space-y-8">
                @csrf

                <!-- Basic Information Card -->
                <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/5">
                        <h3 class="font-black text-base text-white uppercase tracking-widest">Basic Information</h3>
                        <p class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest mt-1.5">Your core personal
                            details</p>
                    </div>

                    <div class="p-8 bg-navy/50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Name
                                    <span class="text-blue">*</span></label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('name') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Email
                                    <span class="text-blue">*</span></label>
                                <div class="relative">
                                    <i
                                        class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('email') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Phone
                                    Number <span class="text-blue">*</span></label>
                                <div class="relative">
                                    <i
                                        class="fas fa-phone-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="phone_number" required
                                        value="{{ old('phone_number', $user->phone) }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('phone_number') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- City -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">City</label>
                                <div class="relative">
                                    <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                        placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('city') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- State -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">State</label>
                                <div class="relative">
                                    <i class="fas fa-map absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="state" value="{{ old('state', $user->state) }}"
                                        placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('state') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- Pincode -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Pincode</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="pincode" value="{{ old('pincode', $user->pincode) }}"
                                        placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('pincode') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Address</label>
                                <div class="relative">
                                    <i class="fas fa-map-marked-alt absolute left-4 top-4 text-white/30 z-10"></i>
                                    <textarea name="address" rows="2" placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('address') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner resize-none">{{ old('address', $user->address) }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Professional Details Card -->
                <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center justify-between">
                        <div>
                            <h3 class="font-black text-base text-white uppercase tracking-widest">Professional Details</h3>
                            <p class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest mt-1.5">Information
                                displayed on your public profile</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-md text-[0.6rem] font-black uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20">Optional</span>
                    </div>

                    <div class="p-8 bg-navy/50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Firm / Practice Name -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Firm /
                                    Practice Name</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="firm_name"
                                        value="{{ old('firm_name', $profile->firm_name ?? '') }}" placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('firm_name') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- Membership Number -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Membership
                                    Number</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="membership_number"
                                        value="{{ old('membership_number', $profile->membership_number ?? '') }}"
                                        placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('membership_number') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- ICAI Region -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">ICAI
                                    Region</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-globe-asia absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="text" name="icai_region"
                                        value="{{ old('icai_region', $profile->icai_region ?? '') }}"
                                        placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('icai_region') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- Membership Date -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Membership
                                    Date</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="date" name="membership_date"
                                        value="{{ old('membership_date', $profile->membership_date ?? '') }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('membership_date') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner color-scheme-dark">
                                </div>
                            </div>

                            <!-- Years of Experience -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Years
                                    of Experience</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <input type="number" name="experience_years"
                                        value="{{ old('experience_years', $profile->experience_years ?? '') }}"
                                        min="0" max="50" placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('experience_years') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner">
                                </div>
                            </div>

                            <!-- Office Address -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Office
                                    Address</label>
                                <div class="relative">
                                    <i class="fas fa-building absolute left-4 top-4 text-white/30 z-10"></i>
                                    <textarea name="office_address" rows="2" placeholder="Optional"
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('office_address') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner resize-none">{{ old('office_address', $profile->office_address ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Bio -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">About
                                    / Bio</label>
                                <div class="relative">
                                    <i class="fas fa-user-edit absolute left-4 top-4 text-white/30 z-10"></i>
                                    <textarea name="bio" rows="4" placeholder="Tell others about your practice..."
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border @error('bio') border-red-500/50 focus:border-red-500 focus:ring-red-500 @else border-white/10 focus:border-blue focus:ring-blue @enderror rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:ring-1 transition-colors shadow-inner resize-none">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Associated Courts Card -->
                <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center justify-between">
                        <div>
                            <h3 class="font-black text-base text-white uppercase tracking-widest">Associated Courts</h3>
                            <p class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest mt-1.5">Where do you
                                provide services?</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-md text-[0.6rem] font-black uppercase tracking-widest bg-blue/10 text-blue border border-blue/20">Multiple
                            Select</span>
                    </div>

                    <div class="p-8 bg-navy/50">
                        @if ($courts->count() > 0)
                            <div class="space-y-3 max-h-[400px] overflow-y-auto pr-4 custom-scrollbar">
                                @foreach ($courts as $court)
                                    <label
                                        class="flex items-center p-4 bg-navy border border-white/5 rounded-xl hover:bg-white/5 hover:border-blue/30 transition-all cursor-pointer group shadow-inner">
                                        <div class="relative flex items-center justify-center">
                                            <input type="checkbox" name="court_ids[]" value="{{ $court->id }}"
                                                @if (in_array($court->id, old('court_ids', $user->court_ids ?? []))) checked @endif
                                                class="peer appearance-none w-5 h-5 border-2 border-white/20 rounded bg-navy2 checked:bg-blue checked:border-blue transition-colors cursor-pointer">
                                            <i
                                                class="fas fa-check absolute text-navy text-[10px] opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></i>
                                        </div>

                                        <div class="ml-4 flex-1">
                                            <div
                                                class="font-bold text-white text-sm group-hover:text-blue transition-colors">
                                                {{ $court->name }}</div>
                                            <div
                                                class="text-[0.65rem] font-bold text-white/40 uppercase tracking-widest mt-1">
                                                @if ($court->city || $court->area)
                                                    <i class="fas fa-map-marker-alt text-white/20 mr-1"></i>
                                                    {{ $court->city }}@if ($court->area)
                                                        , {{ $court->area }}
                                                    @endif
                                                @else
                                                    <span class="italic text-white/30">No location info</span>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="py-12 text-center bg-navy border border-white/5 rounded-2xl shadow-inner">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-2xl mx-auto mb-4">
                                    <i class="fas fa-building"></i>
                                </div>
                                <p class="text-white font-black uppercase tracking-[0.2em] text-xs mb-1">No Courts
                                    Available</p>
                                <p class="text-white/40 font-bold text-[0.65rem] uppercase tracking-widest">There are no
                                    courts registered in the system yet.</p>
                            </div>
                        @endif

                        @error('court_ids')
                            <p class="mt-4 text-xs font-bold text-red-400 flex items-center gap-1"><i
                                    class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror

                        <div class="mt-8 p-5 bg-blue/10 border border-blue/20 rounded-xl shadow-inner">
                            <p class="text-xs font-bold text-blue flex items-center gap-3">
                                <i class="fas fa-info-circle text-lg"></i>
                                Select one or more courts where you actively practice or provide your services.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button Area -->
                <div
                    class="bg-navy2 border border-white/5 rounded-3xl p-8 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-6">
                    <p
                        class="text-[0.65rem] font-bold text-white/40 uppercase tracking-widest leading-relaxed max-w-xs text-center sm:text-left">
                        <i class="fas fa-shield-alt text-white/20 mr-1.5"></i> All fields will be saved together when you
                        click this button.
                    </p>
                    <button type="submit"
                        class="w-full sm:w-auto flex justify-center items-center gap-2 py-4 px-10 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                        <i class="fas fa-save text-sm"></i> Save Profile
                    </button>
                </div>

            </form>
            <!-- END UNIFIED FORM -->
        </div>

        <!-- ── RIGHT COLUMN: INFO CARDS ── -->
        <div class="lg:col-span-4 space-y-8">

            <!-- Profile Status Card -->
            <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5">
                    <h3 class="font-black text-base text-white uppercase tracking-widest">Profile Status</h3>
                </div>
                <div class="p-8 text-center bg-navy/50">
                    @if ($user->status === 'active')
                        <div
                            class="w-20 h-20 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center text-green-400 text-3xl mx-auto mb-6 shadow-[0_0_20px_rgba(34,197,94,0.15)]">
                            <i class="fas fa-check"></i>
                        </div>
                        <span
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-[0.65rem] font-black uppercase tracking-widest bg-green-500/10 text-green-400 border border-green-500/20">
                            <i class="fas fa-check-circle"></i> Active
                        </span>
                        <p class="text-white/40 text-xs font-bold mt-5 leading-relaxed">Your account is verified and
                            active. You have full access to the network.</p>
                    @else
                        <div
                            class="w-20 h-20 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-3xl mx-auto mb-6 shadow-[0_0_20px_rgba(245,158,11,0.15)]">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-[0.65rem] font-black uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            <i class="fas fa-hourglass-half"></i> Pending
                        </span>
                        <p class="text-white/40 text-xs font-bold mt-5 leading-relaxed">Your account is currently under
                            review by our team.</p>
                    @endif
                </div>
            </div>

            <!-- Account Info Card -->
            <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5">
                    <h3 class="font-black text-base text-white uppercase tracking-widest">Account Info</h3>
                </div>
                <div class="p-8 space-y-6 bg-navy/50">
                    <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner">
                        <label
                            class="block text-[10px] font-black text-white/40 uppercase tracking-widest mb-1.5">Registered
                            Role</label>
                        <div class="text-sm font-black text-blue uppercase tracking-tight">
                            {{ $user->sub_role ?? $user->role }}</div>
                    </div>
                    <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner">
                        <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest mb-1.5">Member
                            Since</label>
                        <div class="text-sm font-bold text-white/80">{{ $user->created_at->format('F Y') }}</div>
                    </div>
                    <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner">
                        <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest mb-1.5">User
                            ID</label>
                        <div class="text-sm font-black text-white/30 tracking-widest">
                            #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            /* Ensures date picker looks okay in dark mode */
            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(1);
                opacity: 0.5;
                cursor: pointer;
            }

            input[type="date"]::-webkit-calendar-picker-indicator:hover {
                opacity: 1;
            }

            /* Custom Scrollbar for Court Selection */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }
        </style>
    @endpush

@endsection
