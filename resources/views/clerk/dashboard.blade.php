@extends('layouts.clerk')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')

    @php
        $hasFeedback = \App\Http\Controllers\User\FeedbackController::clerkHasFeedback(auth()->id());
        $firstName = explode(' ', $user->name)[0];
        $designation = optional($profile)->designation ?? 'Senior Court Clerk';
        
        // Calculate profile completeness based on filled fields instead of documents
        $fields = ['bio', 'experience_years', 'city', 'phone', 'address'];
        $filled = 0;
        foreach($fields as $f) if(!empty($user->$f) || ($profile && !empty($profile->$f))) $filled++;
        $completePct = round(($filled / count($fields)) * 100);
    @endphp

    {{-- ── TOP HEADER ── --}}
    <section>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-2">
                    Welcome back, {{ $firstName }}
                </h1>
                <p class="text-xs font-bold text-white/60 leading-relaxed">Here's what's happening with your profile today.</p>
            </div>
            <div
                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md font-black text-[0.6rem] uppercase tracking-widest border {{ $user->status === 'active' ? 'bg-green-500/10 border-green-500/20 text-green-400' : 'bg-amber-500/10 border-amber-500/20 text-amber-400' }}">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 bg-current"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-current"></span>
                </span>
                <span>
                    {{ $user->status === 'active' ? 'Profile Visible' : 'Account Active' }}
                </span>
            </div>
        </div>

        {{-- Profile Completeness Card --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-6 md:p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
            <div class="flex flex-col md:flex-row gap-6 items-center relative z-10">
                <div class="flex-1 w-full">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-black text-base text-white uppercase tracking-widest">Profile Completeness</h3>
                        <span class="font-black text-blue">{{ $completePct }}%</span>
                    </div>
                    <div class="w-full bg-navy border border-white/5 rounded-full h-2.5 mb-4">
                        <div class="bg-blue h-2.5 rounded-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(180,180,254,0.5)]"
                            style="width:{{ $completePct }}%"></div>
                    </div>
                    <p class="text-xs font-bold text-white/60 leading-relaxed mb-4">
                        Complete your profile details to increase visibility to top advocates.
                    </p>
                    <a href="{{ route('clerk.profile') }}" class="w-fit flex justify-center items-center gap-2 py-3.5 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                        Update Profile
                    </a>
                </div>
                <div class="hidden md:block w-px h-24 bg-white/5 mx-4"></div>
                <div class="flex gap-8 md:w-auto w-full justify-around md:justify-start shrink-0">
                    <div class="text-center">
                        <p class="text-3xl font-black text-white">
                            {{ $avgRating ? number_format($avgRating, 1) : '—' }}
                        </p>
                        <p class="text-[10px] font-black text-white/70 uppercase tracking-widest mt-1">Avg Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── INTERESTED ADVOCATES ── --}}
    <section class="mt-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-black text-white uppercase tracking-widest">Interested Advocates</h2>
            <a href="{{ route('clerk.advocates') }}"
                class="text-blue hover:text-white transition-colors font-black text-[10px] uppercase tracking-widest flex items-center gap-1">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($interestedAdvocates as $adv)
                <div
                    class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-6 transition-all duration-300 hover:border-white/10 group">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 text-lg font-black bg-blue/10 border border-blue/20 text-blue shadow-[0_0_15px_rgba(180,180,254,0.15)]">
                            {{ strtoupper(substr($adv->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <h3
                                class="font-black text-base text-white uppercase tracking-widest group-hover:text-blue transition-colors leading-tight">
                                Adv. {{ $adv->name }}
                            </h3>
                            <p class="text-[10px] font-black text-white/50 uppercase tracking-widest mt-1">
                                {{ optional($adv->advocateProfile)->high_court ?? ($adv->city ?? 'Advocate') }}
                            </p>
                            @php $advRating = round($adv->feedbacksReceived()->avg('rating') ?? 0, 1); @endphp
                            @if ($advRating > 0)
                                <div class="flex items-center gap-1 mt-1 text-[10px] font-bold text-white/40 uppercase tracking-widest">
                                    <i class="fas fa-star text-blue"></i>
                                    <span class="text-white">{{ $advRating }}</span>
                                    @if (optional($adv->advocateProfile)->practice_areas)
                                        <span>•
                                            {{ is_array($adv->advocateProfile->practice_areas) ? $adv->advocateProfile->practice_areas[0] : Str::limit($adv->advocateProfile->practice_areas, 20) }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-navy rounded-2xl border border-white/5 p-4 mb-4 shadow-inner">
                        <p class="text-xs font-bold text-white/60 leading-relaxed line-clamp-2">
                            "{{ optional($adv->advocateProfile)->bio ?? 'Looking for an experienced clerk for filing and drafting assistance in court matters.' }}"
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        @if ($hasFeedback)
                            <a href="{{ route('user.detail', $adv) }}"
                                class="flex-1 flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl text-[10px] font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                                Contact
                            </a>
                        @else
                            <button onclick="showToast('Give feedback first to unlock contacts','error')"
                                class="flex-1 flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl text-[10px] font-black uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20 cursor-not-allowed">
                                <i class="fas fa-lock"></i> Locked
                            </button>
                        @endif
                        <a href="{{ route('user.detail', $adv) }}" class="flex-1 flex justify-center items-center py-2.5 px-4 text-[10px] font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">
                            Details
                        </a>
                    </div>
                    <p class="text-[10px] text-center font-bold text-white/30 uppercase tracking-widest mt-4">
                        Joined {{ $adv->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <div class="xl:col-span-3 bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-12 text-center">
                    <div class="text-4xl mb-4 text-white/20"><i class="fas fa-scale-balanced"></i></div>
                    <p class="font-black text-white uppercase tracking-widest">No advocates found yet</p>
                    <p class="text-xs font-bold text-white/50 mt-2">Check back soon as advocates register on the platform</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ── NOTIFICATIONS + QUICK ACTIONS ── --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

        {{-- Recent Notifications --}}
        <div class="lg:col-span-2 bg-navy2 rounded-3xl p-6 md:p-8 border border-white/5 shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-black text-lg text-white uppercase tracking-widest">Recent Notifications</h3>
                <button class="text-[10px] font-black text-blue hover:text-white uppercase tracking-widest transition-colors">Mark all read</button>
            </div>
            <div class="space-y-3">
                @if ($user->status === 'active')
                    <div class="flex gap-4 p-4 rounded-2xl bg-navy border border-white/5 hover:border-white/10 transition-all">
                        <div
                            class="w-10 h-10 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center justify-center text-green-400 shrink-0">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-white uppercase tracking-widest">Profile Verified</p>
                            <p class="text-xs font-bold text-white/60 leading-relaxed mt-1">Your basic profile details have been verified by the Admin. You can now accept requests.</p>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-widest mt-2">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endif

                @if (!$hasFeedback)
                    <div class="flex gap-4 p-4 rounded-2xl bg-navy border border-white/5 hover:border-white/10 transition-all">
                        <div
                            class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0">
                            <i class="fas fa-star text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-white uppercase tracking-widest">Feedback Required</p>
                            <p class="text-xs font-bold text-white/60 leading-relaxed mt-1">Submit compulsory feedback to unlock advocate contacts and boost profile visibility.</p>
                            <p class="text-[10px] font-black text-amber-400 uppercase tracking-widest mt-2">Action required</p>
                        </div>
                    </div>
                @else
                    <div class="flex gap-4 p-4 rounded-2xl bg-navy border border-white/5 hover:border-white/10 transition-all">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue shrink-0">
                            <i class="fas fa-eye text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-white uppercase tracking-widest">Contacts Unlocked</p>
                            <p class="text-xs font-bold text-white/60 leading-relaxed mt-1">You can now view advocate contact details. Browse and connect.</p>
                        </div>
                    </div>
                @endif

                @if ($user->status === 'active' && $hasFeedback)
                    <div class="py-8 text-center">
                        <i class="far fa-bell text-3xl text-white/20 mb-3 block"></i>
                        <span class="text-xs font-bold text-white/50 uppercase tracking-widest">All caught up! No new notifications.</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-navy2 rounded-3xl p-6 md:p-8 border border-white/5 shadow-2xl">
            <h3 class="font-black text-lg text-white uppercase tracking-widest mb-6">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('feedback') }}" class="w-full flex items-center justify-between p-4 rounded-2xl bg-navy border border-white/5
                    hover:border-blue/50 hover:bg-white/5 transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 flex items-center justify-center">
                            <i class="fas fa-comment-dots text-sm"></i>
                        </div>
                        <span class="text-xs font-black text-white uppercase tracking-widest">Give Feedback</span>
                    </div>
                    <i class="fas fa-chevron-right text-white/30 group-hover:text-blue transition-colors text-xs"></i>
                </a>
            </div>
        </div>

    </section>

@endsection
