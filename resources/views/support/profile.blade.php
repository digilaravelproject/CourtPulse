@extends('support.layouts.master')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Left Column: Forms -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Basic Information Card -->
            <div class="bg-navy2 rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
                <div class="px-8 py-6 border-b border-white/5 bg-white/2">
                    <div class="flex items-center gap-3 mb-1">
                        <i class="fas fa-user-circle text-blue"></i>
                        <h3 class="text-lg font-bold text-white tracking-tight">Personal Information</h3>
                    </div>
                    <p class="text-xs text-white/40 font-medium tracking-wide">Update your basic contact details and professional role</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('support.profile.update') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Account Status -->
                        <div class="p-4 rounded-2xl bg-blue/5 border border-blue/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue/20 flex items-center justify-center text-blue">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-white uppercase tracking-wider">Account Role</div>
                                    <div class="text-[10px] text-blue font-bold tracking-widest uppercase">{{ str_replace('_', ' ', auth()->user()->role) }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase tracking-widest">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active Member
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">Full Name</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    <input type="text" value="{{ auth()->user()->name }}" disabled
                                           class="w-full pl-11 pr-4 py-3.5 bg-white/2 border border-white/10 rounded-2xl text-sm text-white/40 cursor-not-allowed font-semibold">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">Email Address</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </div>
                                    <input type="email" value="{{ auth()->user()->email }}" disabled
                                           class="w-full pl-11 pr-4 py-3.5 bg-white/2 border border-white/10 rounded-2xl text-sm text-white/40 cursor-not-allowed font-semibold">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">Phone Number</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-blue transition-colors">
                                        <i class="fas fa-phone text-sm"></i>
                                    </div>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                           placeholder="Enter mobile number"
                                           class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">City</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-blue transition-colors">
                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                    </div>
                                    <input type="text" name="city" value="{{ old('city', auth()->user()->city) }}"
                                           placeholder="e.g. Mumbai"
                                           class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/5">
                            <div class="flex items-center gap-3 mb-6">
                                <i class="fas fa-briefcase text-blue text-sm"></i>
                                <h4 class="text-sm font-bold text-white uppercase tracking-widest">Work Details</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">ID Number</label>
                                    <input type="text" name="clerk_id_number"
                                           value="{{ old('clerk_id_number', optional($profile)->clerk_id_number ?? 'ID-' . auth()->user()->id) }}"
                                           placeholder="Enter your ID number"
                                           class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">Organization ID</label>
                                    <input type="text" name="employee_id"
                                           value="{{ old('employee_id', optional($profile)->employee_id) }}"
                                           placeholder="Employee or Govt. ID"
                                           class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">Select Your Court</label>
                                    @if($courts->count() > 0)
                                        <select name="court_id" class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                            <option value="">-- Select Court --</option>
                                            @foreach($courts as $court)
                                                <option value="{{ $court->id }}" {{ old('court_id', $user->court_id) == $court->id ? 'selected' : '' }}>
                                                    {{ $court->name }}@if($court->city || $court->area) ({{ $court->city }}{{ $court->area ? ', ' . $court->area : '' }})@endif
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" name="court_name" value="{{ old('court_name', optional($profile)->court_name) }}" placeholder="Enter Court Name" class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">City</label>
                                    <input type="text" name="court_city" value="{{ old('court_city', optional($profile)->court_city ?? $user->city) }}" placeholder="e.g. Mumbai"
                                           class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">State</label>
                                    <input type="text" name="court_state" value="{{ old('court_state', optional($profile)->court_state) }}" placeholder="e.g. Maharashtra"
                                           class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">Job Designation</label>
                                    <input type="text" name="designation"
                                           value="{{ old('designation', optional($profile)->designation) }}"
                                           placeholder="e.g. Senior Clerk"
                                           class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden">
                                </div>

                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">About / Bio</label>
                                    <textarea name="bio" rows="4"
                                              placeholder="Tell others about your professional experience..."
                                              class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-blue focus:ring-4 focus:ring-blue/10 transition-all font-semibold outline-hidden resize-none">{{ old('bio', optional($profile)->bio) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4">
                            <button type="submit"
                                    class="px-8 py-4 bg-linear-to-r from-blue to-blue2 text-navy text-sm font-bold rounded-2xl shadow-lg shadow-blue/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-3">
                                <i class="fas fa-save"></i>
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary -->
        <div class="space-y-8">
            <div class="bg-navy2 rounded-3xl border border-white/5 overflow-hidden shadow-2xl relative">
                <div class="p-8 text-center border-b border-white/5 bg-white/2">
                    <div class="relative inline-block mb-4">
                        <div class="w-24 h-24 rounded-3xl bg-linear-to-br from-blue to-blue2 p-[2px] shadow-2xl shadow-blue/20">
                            <div class="w-full h-full rounded-[22px] bg-navy2 flex items-center justify-center">
                                <span class="text-3xl font-black text-blue tracking-tighter">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-xl bg-emerald-500 border-4 border-navy2 flex items-center justify-center text-white text-[10px]">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-white tracking-tight">{{ auth()->user()->name }}</h2>
                    <div class="text-blue text-[11px] font-black uppercase tracking-[0.2em] mt-1">{{ optional($profile)->designation ?? 'Member' }}</div>

                    <div class="mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                        <i class="fas fa-calendar-alt text-white/30 text-xs"></i>
                        <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Member Since: {{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                </div>

                <div class="p-4">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between p-4 rounded-2xl">
                            <span class="text-xs font-bold text-white/40 uppercase tracking-widest">Reviews Given</span>
                            <span class="text-xs font-black text-white px-2.5 py-1 rounded-lg bg-white/5">{{ auth()->user()->feedbacksGiven()->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-2xl">
                            <span class="text-xs font-bold text-white/40 uppercase tracking-widest">Location</span>
                            <span class="text-[10px] font-black text-blue uppercase text-right truncate max-w-[50%]">{{ optional($profile)->court_city ?? $user->city ?? 'Not Set' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Change -->
            <div class="bg-navy2 rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
                <div class="px-8 py-6 border-b border-white/5 bg-white/2">
                    <div class="flex items-center gap-3 mb-1">
                        <i class="fas fa-lock text-emerald-400"></i>
                        <h3 class="text-lg font-bold text-white tracking-tight">Security</h3>
                    </div>
                    <p class="text-xs text-white/40 font-medium tracking-wide">Change your account password</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('support.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="change_password" value="1">

                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">Current Password</label>
                            <input type="password" name="current_password" required
                                   class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-emerald-500 outline-hidden">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-white/30 uppercase tracking-[0.15em] ml-1">New Password</label>
                            <input type="password" name="password" required minlength="8"
                                   class="w-full px-4 py-3.5 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-emerald-500 outline-hidden">
                        </div>

                        <button type="submit"
                                class="w-full py-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold rounded-2xl hover:bg-emerald-500 hover:text-navy transition-all">
                            Save New Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Auto-fill city/state when court is selected
document.addEventListener('DOMContentLoaded', function() {
    const courtSelect = document.querySelector('select[name="court_id"]');
    const cityInput = document.querySelector('input[name="court_city"]');
    const stateInput = document.querySelector('input[name="court_state"]');
    
    // Store court data from PHP
    const courtData = @json($courts->keyBy('id')->toArray());
    
    if(courtSelect && cityInput && stateInput) {
        courtSelect.addEventListener('change', function() {
            const selectedCourt = courtData[this.value];
            if(selectedCourt) {
                if(cityInput && selectedCourt.city) cityInput.value = selectedCourt.city;
                if(stateInput && selectedCourt.state) stateInput.value = selectedCourt.state;
            }
        });
    }
});
</script>
@endpush
