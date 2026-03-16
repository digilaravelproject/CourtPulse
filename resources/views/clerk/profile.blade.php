@extends('layouts.clerk')
@section('title', 'Edit Portfolio')
@section('page-title', 'Edit Portfolio')
@section('content')

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-2">Edit Portfolio</h1>
            <p class="text-text-muted-light">Update your clerk details and professional information.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Forms --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Basic Info --}}
            <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Profile Information</h3>
                    <p class="text-xs text-text-muted-light mt-0.5">Update your basic and professional details</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('clerk.profile.update') }}" method="POST">
                        @csrf
                        <p class="text-xs font-semibold text-text-muted-light uppercase tracking-wider mb-4">Basic Info</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                                <input type="text" value="{{ auth()->user()->name }}" disabled
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-400 text-sm cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                                <input type="text" value="{{ auth()->user()->email }}" disabled
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-400 text-sm cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                    placeholder="Phone number"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
                                <input type="text" name="city" value="{{ old('city', auth()->user()->city) }}"
                                    placeholder="Your city"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                        </div>

                        <p class="text-xs font-semibold text-text-muted-light uppercase tracking-wider mb-4">Clerk Details
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Clerk ID Number *</label>
                                <input type="text" name="clerk_id_number"
                                    value="{{ old('clerk_id_number', optional($profile)->clerk_id_number) }}"
                                    placeholder="e.g. CLK/MH/001"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Employee ID</label>
                                <input type="text" name="employee_id"
                                    value="{{ old('employee_id', optional($profile)->employee_id) }}"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Court Name *</label>
                                <input type="text" name="court_name"
                                    value="{{ old('court_name', optional($profile)->court_name) }}"
                                    placeholder="e.g. Bombay High Court"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Court City *</label>
                                <input type="text" name="court_city"
                                    value="{{ old('court_city', optional($profile)->court_city) }}"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Court State *</label>
                                <input type="text" name="court_state"
                                    value="{{ old('court_state', optional($profile)->court_state) }}"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                                <input type="text" name="department"
                                    value="{{ old('department', optional($profile)->department) }}"
                                    placeholder="e.g. Civil Section"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Designation</label>
                                <input type="text" name="designation"
                                    value="{{ old('designation', optional($profile)->designation) }}"
                                    placeholder="e.g. Senior Clerk"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Experience Years</label>
                                <input type="number" name="experience_years" min="0" max="50"
                                    value="{{ old('experience_years', optional($profile)->experience_years ?? 0) }}"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Bio</label>
                            <textarea name="bio" rows="3" placeholder="Tell advocates about yourself..."
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm resize-none focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">{{ old('bio', optional($profile)->bio) }}</textarea>
                        </div>

                        <button type="submit"
                            class="text-sm bg-gray-900 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-gray-800 transition-colors inline-flex items-center gap-2">
                            <span class="material-icons-round text-base">save</span> Save Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- Account Card --}}
            <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-8 text-center" style="background:linear-gradient(160deg,#060C18,#0F1A2E)">
                    <div class="w-16 h-16 rounded-full mx-auto mb-3 font-display font-bold text-2xl flex items-center justify-center text-white shadow-lg"
                        style="background:linear-gradient(135deg,#D4AF37,#B5952F)">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <p class="font-display font-bold text-white text-xl">{{ auth()->user()->name }}</p>
                    <p class="text-sm mt-1" style="color:rgba(212,175,55,.7)">
                        {{ optional($profile)->designation ?? 'Court Clerk' }}</p>
                    @if (auth()->user()->status === 'active')
                        <span
                            class="inline-flex items-center gap-1 mt-3 px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-400 border border-green-500/20">
                            <span class="material-icons-round text-xs">verified</span> Verified
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1 mt-3 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            ⏳ Pending
                        </span>
                    @endif
                </div>
                <div class="divide-y divide-gray-50">
                    <div class="flex items-center justify-between px-5 py-3">
                        <span class="text-xs text-text-muted-light uppercase tracking-wide font-medium">Member Since</span>
                        <span
                            class="text-sm font-semibold text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3">
                        <span class="text-xs text-text-muted-light uppercase tracking-wide font-medium">Documents</span>
                        <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->documents()->count() }}
                            uploaded</span>
                    </div>
                    @if (optional($profile)->court_name)
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-xs text-text-muted-light uppercase tracking-wide font-medium">Court</span>
                            <span
                                class="text-sm font-semibold text-gray-900 text-right max-w-[55%]">{{ $profile->court_name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Change Password --}}
            <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Change Password</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('clerk.profile.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="change_password" value="1">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
                                <input type="password" name="current_password" placeholder="Current password"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                                <input type="password" name="password" placeholder="Min 8 characters"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            </div>
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-medium border border-gray-200 text-gray-700 hover:border-gray-300 bg-white transition-all">
                                <span class="material-icons-round text-base">key</span> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
