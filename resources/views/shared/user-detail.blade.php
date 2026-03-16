@php
    $layout = match (auth()->user()->role) {
        'advocate' => 'layouts.advocate',
        'clerk' => 'layouts.clerk',
        'ca' => 'layouts.ca',
        'guest' => 'layouts.guest',
        default => 'layouts.admin',
    };
    $roleIcons = ['advocate' => '⚖️', 'clerk' => '🗂️', 'ca' => '📊', 'guest' => '👤'];
    $roleLabel = ['advocate' => 'Advocate', 'clerk' => 'Court Clerk', 'ca' => 'CA', 'guest' => 'Guest'];
@endphp

@extends($layout)
@section('title', $user->name)
@section('page-title', 'User Profile')

@section('content')

    {{-- Back --}}
    <div class="mb-5">
        <a href="{{ route('feedback') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200
              bg-white text-slate-500 hover:text-slate-800 hover:border-slate-300 text-sm transition-all">
            <i class="bi bi-arrow-left"></i> Back to Feedback
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ══ LEFT COLUMN ══ --}}
        <div class="space-y-5">

            {{-- Profile Hero Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                {{-- Dark header --}}
                <div class="px-6 pt-8 pb-6 text-center" style="background:linear-gradient(160deg,#060C18 0%,#0F1A2E 100%)">
                    <div class="w-20 h-20 rounded-2xl mx-auto mb-4 flex items-center justify-center text-3xl"
                        style="background:rgba(212,175,55,.12);border:2px solid rgba(212,175,55,.25)">
                        {{ $roleIcons[$user->role] ?? '👤' }}
                    </div>
                    <h2 class="font-display font-bold text-white text-xl leading-tight">{{ $user->name }}</h2>
                    <div class="font-mono text-xs uppercase tracking-widest mt-1" style="color:#D4AF37">
                        {{ $roleLabel[$user->role] ?? ucfirst($user->role) }}
                    </div>
                    @if ($user->status === 'active')
                        <span
                            class="inline-flex items-center gap-1 mt-3 px-3 py-1 rounded-full text-xs font-semibold
                             bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <i class="bi bi-patch-check-fill text-xs"></i> Verified
                        </span>
                    @endif

                    @if ($avgRating)
                        <div class="mt-4 pt-4 border-t border-white/10">
                            <div class="flex items-center justify-center gap-0.5 mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }} text-sm
                               {{ $i <= round($avgRating) ? 'text-[#D4AF37]' : 'text-white/10' }}"></i>
                                @endfor
                            </div>
                            <div class="text-white font-bold font-display text-xl">{{ number_format($avgRating, 1) }}</div>
                            <div class="text-white/40 text-xs font-mono">{{ $feedbacksReceived->count() }} reviews</div>
                        </div>
                    @endif
                </div>

                {{-- Contact Details --}}
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="font-mono text-xs uppercase tracking-widest text-slate-400">
                            @if ($gaveFeedback)
                                🔓 Contact Details
                            @else
                                🔒 Contact Locked
                            @endif
                        </span>
                    </div>

                    @if ($gaveFeedback)
                        <div class="space-y-3">
                            {{-- Email --}}
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                    style="background:rgba(212,175,55,.1)">
                                    <i class="bi bi-envelope-fill text-sm" style="color:#D4AF37"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs text-slate-400 font-mono">Email</div>
                                    <div class="text-sm font-semibold text-slate-800 truncate">{{ $user->email }}</div>
                                </div>
                                <a href="mailto:{{ $user->email }}" class="ml-auto flex-shrink-0">
                                    <i class="bi bi-box-arrow-up-right text-slate-400 hover:text-slate-600 text-xs"></i>
                                </a>
                            </div>

                            {{-- Phone --}}
                            @if ($user->phone)
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                        style="background:rgba(212,175,55,.1)">
                                        <i class="bi bi-telephone-fill text-sm" style="color:#D4AF37"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-slate-400 font-mono">Phone</div>
                                        <div class="text-sm font-semibold text-slate-800">{{ $user->phone }}</div>
                                    </div>
                                    <a href="tel:{{ $user->phone }}" class="ml-auto flex-shrink-0">
                                        <i class="bi bi-telephone-outbound text-slate-400 hover:text-slate-600 text-xs"></i>
                                    </a>
                                </div>
                            @endif

                            {{-- City --}}
                            @if ($user->city)
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                        style="background:rgba(212,175,55,.1)">
                                        <i class="bi bi-geo-alt-fill text-sm" style="color:#D4AF37"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-400 font-mono">Location</div>
                                        <div class="text-sm font-semibold text-slate-800">
                                            {{ $user->city }}{{ $user->state ? ', ' . $user->state : '' }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Office Phone from profile --}}
                            @if ($profile && !empty($profile->office_phone))
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                        style="background:rgba(212,175,55,.1)">
                                        <i class="bi bi-building text-sm" style="color:#D4AF37"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-400 font-mono">Office Phone</div>
                                        <div class="text-sm font-semibold text-slate-800">{{ $profile->office_phone }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Website --}}
                            @if ($profile && !empty($profile->website))
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                        style="background:rgba(212,175,55,.1)">
                                        <i class="bi bi-globe text-sm" style="color:#D4AF37"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-xs text-slate-400 font-mono">Website</div>
                                        <a href="{{ $profile->website }}" target="_blank"
                                            class="text-sm font-semibold truncate block hover:underline"
                                            style="color:#D4AF37">{{ $profile->website }}</a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @else
                        {{-- Locked State --}}
                        <div class="rounded-xl border border-red-100 bg-red-50 p-5 text-center">
                            <div class="w-12 h-12 rounded-xl mx-auto mb-3 flex items-center justify-center bg-red-100">
                                <i class="bi bi-lock-fill text-red-400 text-xl"></i>
                            </div>
                            <div class="font-semibold text-red-600 text-sm mb-1">Contact Locked</div>
                            <div class="text-slate-500 text-xs mb-4">
                                Give feedback to this person to unlock their contact details
                            </div>
                            <a href="{{ route('feedback') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all"
                                style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                                onmouseout="this.style.background='#D4AF37'">
                                <i class="bi bi-star-fill"></i> Give Feedback →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Professional Info Card --}}
            @if ($profile)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h3 class="font-display font-bold text-slate-800 text-base">Professional Info</h3>
                    </div>
                    <div class="divide-y divide-slate-50">

                        @if ($user->role === 'clerk')
                            @if (!empty($profile->court_name))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">Court</span>
                                    <span
                                        class="text-sm font-semibold text-slate-800 text-right">{{ $profile->court_name }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->court_city))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">Court City</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $profile->court_city }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->court_state))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">State</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $profile->court_state }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->department))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">Department</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $profile->department }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->clerk_id_number))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">Clerk ID</span>
                                    <span class="text-sm font-mono text-slate-800">{{ $profile->clerk_id_number }}</span>
                                </div>
                            @endif
                        @elseif($user->role === 'advocate')
                            @if (!empty($profile->bar_council_number))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">Bar Council
                                        No.</span>
                                    <span
                                        class="text-sm font-mono text-slate-800">{{ $profile->bar_council_number }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->high_court))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">High
                                        Court</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $profile->high_court }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->experience_years))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span
                                        class="text-xs text-slate-400 font-mono uppercase tracking-wide">Experience</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $profile->experience_years }}
                                        years</span>
                                </div>
                            @endif
                            @if (!empty($profile->practice_areas))
                                <div class="px-5 py-3">
                                    <span
                                        class="text-xs text-slate-400 font-mono uppercase tracking-wide block mb-2">Practice
                                        Areas</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ((array) $profile->practice_areas as $area)
                                            <span
                                                class="text-xs px-2 py-0.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-600">{{ $area }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @elseif($user->role === 'ca')
                            @if (!empty($profile->membership_number))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">Membership
                                        No.</span>
                                    <span
                                        class="text-sm font-mono text-slate-800">{{ $profile->membership_number }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->icai_region))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">ICAI
                                        Region</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $profile->icai_region }}</span>
                                </div>
                            @endif
                            @if (!empty($profile->firm_name))
                                <div class="flex items-center justify-between px-5 py-3">
                                    <span class="text-xs text-slate-400 font-mono uppercase tracking-wide">Firm</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $profile->firm_name }}</span>
                                </div>
                            @endif
                        @endif

                        @if (!empty($profile->bio))
                            <div class="px-5 py-3">
                                <span
                                    class="text-xs text-slate-400 font-mono uppercase tracking-wide block mb-2">Bio</span>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $profile->bio }}</p>
                            </div>
                        @endif

                    </div>
                </div>
            @endif

        </div>

        {{-- ══ RIGHT COLUMN: Reviews ══ --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h3 class="font-display font-bold text-slate-800 text-lg">Reviews & Feedback</h3>
                    <span class="font-mono text-xs bg-slate-100 text-slate-500 px-3 py-1 rounded-full">
                        {{ $feedbacksReceived->count() }} reviews
                    </span>
                </div>

                {{-- Rating bar summary --}}
                @if ($avgRating && $feedbacksReceived->count() > 0)
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-6">
                        <div class="text-center flex-shrink-0">
                            <div class="font-display font-bold text-slate-800 text-5xl leading-none">
                                {{ number_format($avgRating, 1) }}
                            </div>
                            <div class="flex items-center justify-center gap-0.5 mt-1.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }} text-xs
                               {{ $i <= round($avgRating) ? 'text-[#D4AF37]' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                            <div class="text-slate-400 text-xs font-mono mt-1">out of 5</div>
                        </div>
                        <div class="flex-1 space-y-1.5">
                            @for ($star = 5; $star >= 1; $star--)
                                @php
                                    $cnt = $feedbacksReceived->where('rating', $star)->count();
                                    $pct =
                                        $feedbacksReceived->count() > 0
                                            ? round(($cnt / $feedbacksReceived->count()) * 100)
                                            : 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-mono text-xs text-slate-400 w-3 text-right">{{ $star }}</span>
                                    <i class="bi bi-star-fill text-xs text-[#D4AF37]"></i>
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full"
                                            style="width:{{ $pct }}%;background:#D4AF37"></div>
                                    </div>
                                    <span class="font-mono text-xs text-slate-400 w-5">{{ $cnt }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endif

                {{-- Review List --}}
                <div class="divide-y divide-slate-50">
                    @forelse($feedbacksReceived as $fb)
                        <div class="px-5 py-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-9 h-9 rounded-xl font-bold font-display text-sm flex items-center
                                    justify-center flex-shrink-0
                                    {{ $fb->is_anonymous ? 'bg-slate-100 text-slate-500' : 'bg-[#D4AF37]/10 text-[#92650a]' }}">
                                    {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-semibold text-slate-800 text-sm">
                                                {{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'User' }}
                                            </span>
                                            @if (!$fb->is_anonymous && isset($fb->giver))
                                                <span
                                                    class="font-mono text-xs uppercase bg-slate-100 text-slate-500 px-2 py-0.5 rounded">
                                                    {{ $fb->giver->role }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-0.5 flex-shrink-0">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }} text-xs
                                           {{ $i <= $fb->rating ? 'text-[#D4AF37]' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    @if ($fb->comment)
                                        <p class="text-slate-500 text-sm leading-relaxed">{{ $fb->comment }}</p>
                                    @endif
                                    <div class="text-slate-400 text-xs font-mono mt-1.5">
                                        {{ $fb->created_at->format('d M Y') }} · {{ $fb->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center">
                            <div class="w-16 h-16 rounded-2xl mx-auto mb-3 flex items-center justify-center"
                                style="background:rgba(212,175,55,.08)">
                                <i class="bi bi-star text-2xl text-[#D4AF37]"></i>
                            </div>
                            <p class="text-slate-600 font-medium text-sm">No reviews yet</p>
                            <p class="text-slate-400 text-xs mt-1">Be the first to leave a review</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

@endsection
