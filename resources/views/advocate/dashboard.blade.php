@extends('layouts.advocate')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

    <!-- Welcome -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="font-black text-3xl md:text-4xl text-white uppercase tracking-tighter leading-none mb-2">
                Welcome Back, <span class="text-blue">{{ explode(' ', auth()->user()->name)[0] }}</span>
            </h2>
            <p class="text-xs md:text-sm font-bold text-white/50 uppercase tracking-widest">
                Find clerk support for your cases and manage your profile.
            </p>
        </div>
    </div>

    <!-- ── STAT CARDS ── -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Avg Rating -->
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-6 flex items-start justify-between gap-4 hover:-translate-y-1 hover:border-blue/30 transition-all duration-300 group">
            <div>
                <div class="text-[0.65rem] font-black tracking-[0.2em] uppercase text-white/50 mb-2 group-hover:text-blue transition-colors">Avg Rating</div>
                <div class="font-black text-4xl text-white leading-none">
                    {{ number_format($avgRating ?? 0, 1) }}
                </div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue/10 border border-blue/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                <i class="fas fa-star text-blue text-2xl"></i>
            </div>
        </div>

        <!-- Total Feedbacks -->
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-6 flex items-start justify-between gap-4 hover:-translate-y-1 hover:border-blue/30 transition-all duration-300 group">
            <div>
                <div class="text-[0.65rem] font-black tracking-[0.2em] uppercase text-white/50 mb-2 group-hover:text-blue transition-colors">Total Feedbacks</div>
                <div class="font-black text-4xl text-white leading-none">
                    {{ $feedbacksReceived->count() ?? 0 }}
                </div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue/10 border border-blue/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                <i class="fas fa-comments text-blue text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- ── MAIN GRID ── -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT: Recent Activity + Quick Links -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Recent Feedback Received -->
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
                <div class="p-6 border-b border-white/5 bg-white/5 flex items-center justify-between">
                    <h3 class="font-black text-sm text-white uppercase tracking-widest">Recent Feedback</h3>
                    @if ($avgRating)
                        <div class="flex items-center gap-2 bg-blue/10 border border-blue/20 px-3 py-1 rounded-lg">
                            <span class="font-black text-sm text-blue">{{ number_format($avgRating, 1) }}</span>
                            <i class="fas fa-star text-blue text-[0.6rem] mb-0.5"></i>
                        </div>
                    @endif
                </div>

                <div class="flex-grow max-h-[400px] overflow-y-auto">
                    @if ($feedbacksReceived && $feedbacksReceived->count())
                        <div class="divide-y divide-white/5">
                            @foreach ($feedbacksReceived as $fb)
                                <div class="p-6 flex items-start gap-4 hover:bg-white/5 transition-colors group">
                                    <div class="w-10 h-10 rounded-xl border bg-blue/10 text-blue border-blue/20 flex items-center justify-center font-black text-sm shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                                        {{ strtoupper(substr($fb->givenBy->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                                            <span class="font-bold text-white text-xs uppercase tracking-wider">{{ $fb->givenBy->name ?? 'User' }}</span>
                                            <div class="flex items-center gap-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-[0.6rem]"
                                                        style="color:{{ $i <= $fb->rating ? '#B4B4FE' : 'rgba(255,255,255,0.1)' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        @if ($fb->comment)
                                            <p class="text-white/60 text-xs leading-relaxed mb-2 font-medium">
                                                {{ Str::limit($fb->comment, 150) }}
                                            </p>
                                        @endif
                                        <div class="text-white/30 text-[0.65rem] font-bold uppercase tracking-widest">
                                            <i class="far fa-clock mr-1"></i> {{ $fb->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-16 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-2xl mx-auto mb-4">
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="text-white font-black uppercase tracking-[0.2em] text-xs mb-1">No Feedback Yet</p>
                            <p class="text-white/40 font-bold text-[0.65rem] uppercase tracking-widest">Feedback will appear here once received.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('advocate.search.clerks') }}"
                    class="flex items-center gap-4 bg-navy rounded-2xl border border-white/5 p-5 hover:border-blue/50 hover:bg-white/5 transition-all group shadow-inner">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform bg-blue/10 text-blue border border-blue/20 shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="font-black text-white text-sm uppercase tracking-wider mb-0.5">Find Clerks</div>
                        <div class="text-white/50 text-[0.65rem] font-bold uppercase tracking-widest">Search network support</div>
                    </div>
                </a>
                <a href="{{ route('advocate.profile') }}"
                    class="flex items-center gap-4 bg-navy rounded-2xl border border-white/5 p-5 hover:border-blue/50 hover:bg-white/5 transition-all group shadow-inner">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform bg-blue/10 text-blue border border-blue/20 shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                        <i class="fas fa-id-badge"></i>
                    </div>
                    <div>
                        <div class="font-black text-white text-sm uppercase tracking-wider mb-0.5">My Profile</div>
                        <div class="text-white/50 text-[0.65rem] font-bold uppercase tracking-widest">Update your details</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- RIGHT: Profile Summary -->
        <div class="space-y-6">
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-8 text-center border-b border-white/5 bg-navy/50 relative">
                    <div class="w-20 h-20 rounded-2xl mx-auto flex items-center justify-center font-black text-3xl mb-4 bg-blue/10 text-blue border border-blue/20 shadow-[0_0_20px_rgba(180,180,254,0.2)]">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="font-black text-white text-lg uppercase tracking-tight mb-1">{{ auth()->user()->name }}</div>
                    <div class="text-[0.65rem] uppercase tracking-widest font-bold text-white/50">Advocate</div>

                    @if (auth()->user()->status === 'active')
                        <span class="inline-flex items-center gap-1.5 mt-4 px-3 py-1 rounded-md bg-green-500/10 border border-green-500/20 text-green-400 font-black text-[0.6rem] uppercase tracking-widest">
                            <i class="fas fa-check-circle"></i> Verified
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 mt-4 px-3 py-1 rounded-md bg-amber-500/10 border border-amber-500/20 text-amber-400 font-black text-[0.6rem] uppercase tracking-widest">
                            <i class="fas fa-hourglass-half"></i> Pending
                        </span>
                    @endif
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
                    @if (isset($profile) && $profile->high_court)
                        <div class="flex items-center gap-3 text-xs font-bold text-white/80 bg-navy p-3 rounded-xl border border-white/5 shadow-inner">
                            <i class="fas fa-building text-white/30 w-4 text-center"></i>
                            <span class="truncate">{{ $profile->high_court }}</span>
                        </div>
                    @endif
                    @if (isset($profile) && $profile->experience_years)
                        <div class="flex items-center gap-3 text-xs font-bold text-white/80 bg-navy p-3 rounded-xl border border-white/5 shadow-inner">
                            <i class="fas fa-briefcase text-white/30 w-4 text-center"></i>
                            <span>{{ $profile->experience_years }} Years Experience</span>
                        </div>
                    @endif

                    @if (isset($profile) && !empty($profile->practice_areas))
                        <div class="flex flex-wrap gap-2 pt-2">
                            @foreach (array_slice($profile->practice_areas, 0, 4) as $area)
                                <span class="px-2.5 py-1 rounded-md text-[0.6rem] font-black uppercase tracking-widest bg-white/5 border border-white/10 text-white/60">
                                    {{ $area }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Footer Action -->
                <div class="px-6 pb-6 pt-2 bg-navy/50">
                    <a href="{{ route('advocate.profile') }}"
                        class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Feedback Banner -->
    <div class="mt-8 bg-blue/10 border border-blue/20 rounded-3xl p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-[0_0_30px_rgba(180,180,254,0.1)] relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue/5 to-transparent pointer-events-none"></div>
        <div class="relative z-10 text-center sm:text-left">
            <h3 class="font-black text-white text-lg md:text-xl uppercase tracking-tight mb-1">How was your recent experience?</h3>
            <p class="text-white/60 text-xs font-bold uppercase tracking-widest">Rate interactions to help maintain network quality.</p>
        </div>
        <a href="{{ route('feedback') }}" class="relative z-10 flex-shrink-0 px-8 py-3.5 rounded-xl text-xs font-black text-white uppercase tracking-widest bg-navy border border-white/10 hover:bg-white hover:text-navy hover:border-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg flex items-center gap-2">
            <i class="fas fa-star"></i> Give Feedback
        </a>
    </div>

@endsection
