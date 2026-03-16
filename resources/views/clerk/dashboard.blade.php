@extends('layouts.clerk')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')

    @php
        $hasFeedback = \App\Http\Controllers\FeedbackController::clerkHasFeedback(auth()->id());
        $firstName = explode(' ', $user->name)[0];
        $approvedDocs = $documentsStatus['approved'];
        $pendingDocs = $documentsStatus['pending'];
        $totalDocs = $documentsStatus['total'];
        $requiredTotal = 6;
        $completePct = $requiredTotal > 0 ? min(100, round(($approvedDocs / $requiredTotal) * 100)) : 0;
        $designation = optional($profile)->designation ?? 'Senior Court Clerk';
    @endphp

    {{-- ── TOP HEADER ── --}}
    <section>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Welcome back, {{ $firstName }}
                </h1>
                <p class="text-text-muted-light">Here's what's happening with your profile today.</p>
            </div>
            <div
                class="flex items-center gap-2 bg-surface-light px-4 py-2 rounded-full border border-gray-200 shadow-sm w-fit">
                <span class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75
                     {{ $user->status === 'active' ? 'bg-green-400' : 'bg-amber-400' }}"></span>
                    <span
                        class="relative inline-flex rounded-full h-3 w-3
                     {{ $user->status === 'active' ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                </span>
                <span class="text-sm font-medium text-gray-700">
                    {{ $user->status === 'active' ? 'Profile Visible' : 'Pending Verification' }}
                </span>
            </div>
        </div>

        {{-- Profile Completeness Card --}}
        <div class="bg-surface-light rounded-2xl p-6 shadow-sm border border-gray-200 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
            <div class="flex flex-col md:flex-row gap-6 items-center relative z-10">
                <div class="flex-1 w-full">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-lg text-gray-900">Profile Completeness</h3>
                        <span class="font-bold text-primary">{{ $completePct }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-primary h-2.5 rounded-full transition-all duration-1000 ease-out"
                            style="width:{{ $completePct }}%"></div>
                    </div>
                    <p class="text-sm text-text-muted-light mb-4">
                        Complete your profile to increase visibility to top advocates.
                        @if ($approvedDocs < $requiredTotal)
                            You are missing:
                            <span class="font-medium text-gray-700">
                                {{ $requiredTotal - $approvedDocs }} document(s) pending approval
                            </span>
                        @else
                            Your profile is complete! 🎉
                        @endif
                    </p>
                    <a href="{{ route('clerk.documents') }}"
                        class="inline-block text-sm bg-gray-900 text-white px-4 py-2 rounded-lg font-medium
                  hover:bg-gray-800 transition-colors">
                        Complete Profile
                    </a>
                </div>
                <div class="hidden md:block w-px h-24 bg-gray-200 mx-4"></div>
                <div class="flex gap-8 md:w-auto w-full justify-around md:justify-start flex-shrink-0">
                    <div class="text-center">
                        <p class="text-3xl font-display font-bold text-gray-900">{{ $approvedDocs }}</p>
                        <p class="text-xs font-medium text-text-muted-light uppercase tracking-wide mt-1">Docs Approved</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-display font-bold text-gray-900">
                            {{ $avgRating ? number_format($avgRating, 1) : '—' }}
                        </p>
                        <p class="text-xs font-medium text-text-muted-light uppercase tracking-wide mt-1">Avg Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── INTERESTED ADVOCATES ── --}}
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-2xl font-bold text-gray-900">Interested Advocates</h2>
            <a href="{{ route('clerk.advocates') }}"
                class="text-primary hover:text-primary-dark font-medium text-sm flex items-center gap-1">
                View All <span class="material-icons-round text-sm">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($interestedAdvocates as $adv)
                <div
                    class="bg-surface-light rounded-2xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 font-display font-bold text-2xl text-white shadow-sm"
                            style="background:linear-gradient(135deg,#D4AF37,#B5952F)">
                            {{ strtoupper(substr($adv->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <h3
                                class="font-semibold text-lg text-gray-900 group-hover:text-primary transition-colors leading-tight">
                                Adv. {{ $adv->name }}
                            </h3>
                            <p class="text-sm text-text-muted-light">
                                {{ optional($adv->advocateProfile)->high_court ?? ($adv->city ?? 'Advocate') }}
                            </p>
                            @php $advRating = round($adv->feedbacksReceived()->avg('rating') ?? 0, 1); @endphp
                            @if ($advRating > 0)
                                <div class="flex items-center gap-1 mt-1 text-xs text-text-muted-light">
                                    <span class="material-icons-round text-sm text-primary">star</span>
                                    <span class="font-medium text-gray-700">{{ $advRating }}</span>
                                    @if (optional($adv->advocateProfile)->practice_areas)
                                        <span>•
                                            {{ is_array($adv->advocateProfile->practice_areas) ? $adv->advocateProfile->practice_areas[0] : Str::limit($adv->advocateProfile->practice_areas, 20) }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <p class="text-sm text-gray-600 line-clamp-2">
                            "{{ optional($adv->advocateProfile)->bio ?? 'Looking for an experienced clerk for filing and drafting assistance in court matters.' }}"
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        @if ($hasFeedback)
                            <a href="{{ route('user.detail', $adv) }}"
                                class="flex-1 text-center text-sm font-medium py-2.5 px-4 rounded-lg transition-colors shadow-sm"
                                style="background:#D4AF37;color:#1a1a1a" onmouseover="this.style.background='#B5952F'"
                                onmouseout="this.style.background='#D4AF37'">
                                Contact
                            </a>
                        @else
                            <button onclick="showToast('Give feedback first to unlock contacts','error')"
                                class="flex-1 text-sm font-medium py-2.5 px-4 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                🔒 Locked
                            </button>
                        @endif
                        <a href="{{ route('user.detail', $adv) }}"
                            class="flex-1 text-center bg-white border border-gray-200 hover:border-gray-300
                  text-gray-700 text-sm font-medium py-2.5 px-4 rounded-lg transition-colors">
                            View Details
                        </a>
                    </div>
                    <p class="text-xs text-center text-text-muted-light mt-3">
                        Joined {{ $adv->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <div class="xl:col-span-3 bg-surface-light rounded-2xl p-12 border border-gray-200 shadow-sm text-center">
                    <div class="text-4xl mb-3">⚖️</div>
                    <p class="font-medium text-gray-500">No advocates found yet</p>
                    <p class="text-sm text-text-muted-light mt-1">Check back soon as advocates register on the platform</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ── NOTIFICATIONS + QUICK ACTIONS ── --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Recent Notifications --}}
        <div class="lg:col-span-2 bg-surface-light rounded-2xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display font-bold text-xl text-gray-900">Recent Notifications</h3>
                <button class="text-sm text-primary hover:text-primary-dark">Mark all read</button>
            </div>
            <div class="space-y-2">
                @if ($user->status === 'active')
                    <div class="flex gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <span class="material-icons-round text-lg">verified</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Profile Verified</p>
                            <p class="text-sm text-text-muted-light">Your basic profile details have been verified by the
                                Admin. You can now accept requests.</p>
                            <p class="text-xs text-text-muted-light mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endif

                @if (!$hasFeedback)
                    <div class="flex gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary-dark flex-shrink-0">
                            <span class="material-icons-round text-lg">star_rate</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Feedback Required</p>
                            <p class="text-sm text-text-muted-light">Submit compulsory feedback to unlock advocate contacts
                                and boost profile visibility.</p>
                            <p class="text-xs text-text-muted-light mt-1">Action required</p>
                        </div>
                    </div>
                @else
                    <div class="flex gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary-dark flex-shrink-0">
                            <span class="material-icons-round text-lg">visibility</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Contacts Unlocked</p>
                            <p class="text-sm text-text-muted-light">You can now view advocate contact details. Browse and
                                connect.</p>
                        </div>
                    </div>
                @endif

                @if ($pendingDocs > 0)
                    <div class="flex gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 flex-shrink-0">
                            <span class="material-icons-round text-lg">warning</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Documents Pending</p>
                            <p class="text-sm text-text-muted-light">{{ $pendingDocs }} document(s) pending admin review.
                                Please check your submissions.</p>
                            <p class="text-xs text-text-muted-light mt-1">Awaiting review</p>
                        </div>
                    </div>
                @endif

                @if ($user->status === 'active' && $hasFeedback && $pendingDocs === 0)
                    <div class="py-6 text-center text-text-muted-light text-sm">
                        <span class="material-icons-round text-2xl block mb-2 text-gray-300">notifications_none</span>
                        All caught up! No new notifications.
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-surface-light rounded-2xl p-6 border border-gray-200 shadow-sm">
            <h3 class="font-display font-bold text-xl text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('clerk.documents') }}"
                    class="w-full flex items-center justify-between p-3 rounded-xl border border-gray-200
                hover:border-primary hover:bg-gray-50 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                            <span class="material-icons-round text-lg">upload_file</span>
                        </div>
                        <span class="font-medium text-gray-700">Upload Certificates</span>
                    </div>
                    <span
                        class="material-icons-round text-gray-400 group-hover:text-primary transition-colors">chevron_right</span>
                </a>
                <a href="{{ route('clerk.profile') }}"
                    class="w-full flex items-center justify-between p-3 rounded-xl border border-gray-200
                hover:border-primary hover:bg-gray-50 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <span class="material-icons-round text-lg">edit</span>
                        </div>
                        <span class="font-medium text-gray-700">Update Profile Bio</span>
                    </div>
                    <span
                        class="material-icons-round text-gray-400 group-hover:text-primary transition-colors">chevron_right</span>
                </a>
                <a href="{{ route('feedback') }}"
                    class="w-full flex items-center justify-between p-3 rounded-xl border border-gray-200
                hover:border-primary hover:bg-gray-50 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-lg text-green-600">
                            <span class="material-icons-round text-lg">contact_support</span>
                        </div>
                        <span class="font-medium text-gray-700">Give Feedback</span>
                    </div>
                    <span
                        class="material-icons-round text-gray-400 group-hover:text-primary transition-colors">chevron_right</span>
                </a>
            </div>
        </div>

    </section>

@endsection
