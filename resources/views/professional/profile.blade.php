@extends('professional.layouts.master')
@section('title', 'My Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: Forms -->
    <div class="lg:col-span-8 space-y-6">

        <!-- Basic Information Card -->
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-bold text-white">Basic Information</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('professional.profile.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Name *</label>
                            <input type="text" name="name" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Email *</label>
                            <input type="email" name="email" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Phone Number *</label>
                            <input type="text" name="phone_number" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('phone_number', $user->phone) }}" required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">City</label>
                            <input type="text" name="city" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('city', $user->city) }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">State</label>
                            <input type="text" name="state" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('state', $user->state) }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Pincode</label>
                            <input type="text" name="pincode" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('pincode', $user->pincode) }}" placeholder="Optional">
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Address</label>
                            <textarea name="address" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" rows="2" placeholder="Optional">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue text-navy font-bold rounded-xl hover:bg-blue2 shadow-lg shadow-blue/10 transition-all duration-200">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Professional Details Card -->
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Professional Details</h3>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-500/10 text-amber-500 border border-amber-500/20">Optional</span>
            </div>
            <div class="p-6">
                <form action="{{ route('professional.profile.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Firm / Practice Name</label>
                            <input type="text" name="firm_name" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('firm_name', $profile->firm_name ?? '') }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Membership Number</label>
                            <input type="text" name="membership_number" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('membership_number', $profile->membership_number ?? '') }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">ICAI Region</label>
                            <input type="text" name="icai_region" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('icai_region', $profile->icai_region ?? '') }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Membership Date</label>
                            <input type="date" name="membership_date" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden color-scheme-dark" value="{{ old('membership_date', $profile->membership_date ?? '') }}">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Years of Experience</label>
                            <input type="number" name="experience_years" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" value="{{ old('experience_years', $profile->experience_years ?? '') }}" min="0" max="50" placeholder="Optional">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Office Address</label>
                            <textarea name="office_address" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" rows="2" placeholder="Optional">{{ old('office_address', $profile->office_address ?? '') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">About / Bio</label>
                            <textarea name="bio" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" rows="4" placeholder="Tell others about your practice...">{{ old('bio', $profile->bio ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue text-navy font-bold rounded-xl hover:bg-blue2 shadow-lg shadow-blue/10 transition-all duration-200">
                            <i class="fas fa-save"></i> Save Professional Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Info Cards -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Profile Status Card -->
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-bold text-white">Profile Status</h3>
            </div>
            <div class="p-8 text-center">
                @if($user->status === 'active')
                    <div class="w-16 h-16 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500 text-2xl mx-auto mb-4">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                        <i class="fas fa-check-circle"></i> Active
                    </span>
                    <p class="text-white/40 text-sm mt-4">Your account is verified and active.</p>
                @else
                    <div class="w-16 h-16 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 text-2xl mx-auto mb-4">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-amber-500/10 text-amber-500 border border-amber-500/20">
                        <i class="fas fa-hourglass-half"></i> Pending
                    </span>
                    <p class="text-white/40 text-sm mt-4">Your account is under review.</p>
                @endif
            </div>
        </div>

        <!-- Account Info Card -->
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-bold text-white">Account Info</h3>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-1">Role</label>
                    <div class="text-sm font-semibold text-blue">{{ $user->sub_role ?? $user->role }}</div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-1">Member Since</label>
                    <div class="text-sm font-semibold text-white/80">{{ $user->created_at->format('F Y') }}</div>
                </div>
                <div class="pt-4 border-t border-white/5">
                    <label class="block text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-1">User ID</label>
                    <div class="text-xs font-mono text-white/40">#{{ $user->id }}</div>
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
    }
</style>
@endpush

@endsection
