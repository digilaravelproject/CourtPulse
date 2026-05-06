@extends('layouts.clerk')
@section('title', 'Edit Portfolio')
@section('page-title', 'Edit Portfolio')
@section('content')

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-2">Edit Portfolio</h1>
            <p class="text-xs font-bold text-white/60 leading-relaxed">Update your clerk details and professional information.</p>
        </div>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-bold rounded-2xl flex items-center gap-3 animate-fade-in">
            <i class="fas fa-check-circle text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-5 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl animate-fade-in">
            <div class="flex items-center gap-2 mb-2 font-black text-[10px] uppercase tracking-widest">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Please fix the following errors:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-bold space-y-1 opacity-80">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT: Forms --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Profile Info Card --}}
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5">
                    <h3 class="font-black text-base text-white uppercase tracking-widest">Profile Information</h3>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mt-1">Update your basic and professional details</p>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('clerk.profile.update') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        {{-- Basic Section --}}
                        <div>
                            <h4 class="text-[10px] font-black text-blue uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                <span class="w-8 h-px bg-blue/20"></span>
                                Basic Info
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Full Name</label>
                                    <div class="relative">
                                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-white/20"></i>
                                        <input type="text" value="{{ auth()->user()->name }}" disabled
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy/50 border border-white/5 rounded-xl text-white/40 text-sm font-bold cursor-not-allowed">
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Email Address</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/20"></i>
                                        <input type="text" value="{{ auth()->user()->email }}" disabled
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy/50 border border-white/5 rounded-xl text-white/40 text-sm font-bold cursor-not-allowed">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Phone Number</label>
                                    <div class="relative">
                                        <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                            placeholder="Enter phone number"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">City</label>
                                    <div class="relative">
                                        <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="city" value="{{ old('city', auth()->user()->city) }}"
                                            placeholder="Enter your city"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Professional Section --}}
                        <div>
                            <h4 class="text-[10px] font-black text-blue uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                <span class="w-8 h-px bg-blue/20"></span>
                                Professional Details
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Clerk ID Number</label>
                                    <div class="relative">
                                        <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="clerk_id_number"
                                            value="{{ old('clerk_id_number', optional($profile)->clerk_id_number ?? 'CLK-' . auth()->user()->id) }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Employee ID</label>
                                    <div class="relative">
                                        <i class="fas fa-fingerprint absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="employee_id"
                                            value="{{ old('employee_id', optional($profile)->employee_id) }}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Court Name *</label>
                                    <div class="relative">
                                        <i class="fas fa-gavel absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="court_name"
                                            value="{{ old('court_name', optional($profile)->court_name) }}"
                                            required placeholder="e.g. Bombay High Court"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Court City *</label>
                                    <div class="relative">
                                        <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="court_city"
                                            value="{{ old('court_city', optional($profile)->court_city) }}"
                                            required
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Court State *</label>
                                    <div class="relative">
                                        <i class="fas fa-map absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="court_state"
                                            value="{{ old('court_state', optional($profile)->court_state) }}"
                                            required
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Designation</label>
                                    <div class="relative">
                                        <i class="fas fa-user-tag absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                        <input type="text" name="designation"
                                            value="{{ old('designation', optional($profile)->designation) }}"
                                            placeholder="e.g. Senior Clerk"
                                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Professional Bio</label>
                            <div class="relative">
                                <i class="fas fa-quote-left absolute left-4 top-4 text-white/30"></i>
                                <textarea name="bio" rows="4" placeholder="Tell advocates about your expertise and court experience..."
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all shadow-inner resize-none tracking-tight leading-relaxed">{{ old('bio', optional($profile)->bio) }}</textarea>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full md:w-fit flex justify-center items-center gap-2 py-3.5 px-8 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="space-y-8">

            {{-- Identity Card --}}
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden group">
                <div class="px-8 py-10 text-center relative overflow-hidden" style="background: linear-gradient(160deg, #060C18 0%, #0F1A2E 100%)">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(180,180,254,0.1),transparent_70%)]"></div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 rounded-2xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-3xl font-black mx-auto mb-4 shadow-[0_0_25px_rgba(180,180,254,0.2)] group-hover:scale-110 transition-transform duration-500">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <h2 class="font-black text-xl text-white uppercase tracking-tighter leading-tight">{{ auth()->user()->name }}</h2>
                        <p class="text-[10px] font-black text-blue uppercase tracking-[0.2em] mt-2">
                            {{ optional($profile)->designation ?? 'Court Clerk' }}
                        </p>
                        
                        <div class="mt-6 flex justify-center">
                            @if (auth()->user()->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md font-black text-[0.6rem] uppercase tracking-widest bg-green-500/10 border border-green-500/20 text-green-400">
                                    <i class="fas fa-check-double text-[8px]"></i> Verified Account
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md font-black text-[0.6rem] uppercase tracking-widest bg-amber-500/10 border border-amber-500/20 text-amber-400">
                                    <i class="fas fa-clock text-[8px]"></i> Pending Review
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-4 bg-navy/30">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Joined</span>
                        <span class="text-xs font-bold text-white tracking-tight">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                    </div>
                    @if (optional($profile)->court_name)
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-[10px] font-black text-white/40 uppercase tracking-widest pt-1 shrink-0">Primary Court</span>
                            <span class="text-xs font-bold text-white tracking-tight text-right">{{ $profile->court_name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Change Password Card --}}
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
                <div class="px-8 py-5 border-b border-white/5 bg-white/5">
                    <h3 class="font-black text-xs text-white uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-shield-alt text-blue/50"></i>
                        Security
                    </h3>
                </div>
                <div class="p-8">
                    <form action="{{ route('clerk.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="change_password" value="1">
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Current Password</label>
                            <div class="relative">
                                <i class="fas fa-lock-open absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="password" name="current_password" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">New Password</label>
                            <div class="relative">
                                <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="password" name="password" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-white/70 uppercase tracking-widest ml-1">Confirm New Password</label>
                            <div class="relative">
                                <i class="fas fa-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="password" name="password_confirmation" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center items-center gap-2 py-3.5 px-6 rounded-xl text-[10px] font-black text-white uppercase tracking-widest border border-white/10 hover:bg-white/5 transition-all">
                            <i class="fas fa-sync-alt"></i> Update Security
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
