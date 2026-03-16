@extends('layouts.advocate')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

    @if (auth()->user()->status === 'pending')
        <div class="flex items-center gap-3 rounded-xl px-5 py-4 mb-6 border"
            style="background:rgba(212,175,55,.07);border-color:rgba(212,175,55,.25)">
            <i class="bi bi-clock text-xl" style="color:#D4AF37"></i>
            <div>
                <div class="font-semibold text-sm" style="color:#D4AF37">Account Pending Verification</div>
                <div class="text-slate-500 text-xs mt-0.5">Upload all required documents. Admin will verify and activate your
                    account.</div>
            </div>
            <a href="{{ route('advocate.documents') }}" class="ml-auto flex-shrink-0 px-4 py-2 rounded-lg text-sm font-bold"
                style="background:#D4AF37;color:#060C18">Upload Docs →</a>
        </div>
    @endif

    <!-- Welcome -->
    <div class="mb-6">
        <h2 class="font-display font-bold text-slate-800 text-2xl">
            Welcome back, <span style="color:#D4AF37">{{ explode(' ', auth()->user()->name)[0] }}</span>
        </h2>
        <p class="text-slate-400 text-sm mt-1">Manage your documents and find clerk support for your cases.</p>
    </div>

    <!-- ── STAT CARDS ── -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div
            class="bg-white rounded-2xl border border-slate-200 p-4 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <div class="font-mono text-[.57rem] tracking-widest uppercase text-slate-400 mb-1">Total Docs</div>
                <div class="font-display font-bold text-3xl text-slate-800">{{ $documentsStatus['total'] }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg"
                style="background:rgba(212,175,55,.12);color:#D4AF37">
                <i class="bi bi-file-earmark-text"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl border-l-4 border border-slate-200 p-4 flex items-center justify-between hover:shadow-md transition-shadow"
            style="border-left-color:#16a34a">
            <div>
                <div class="font-mono text-[.57rem] tracking-widest uppercase text-slate-400 mb-1">Approved</div>
                <div class="font-display font-bold text-3xl" style="color:#16a34a">{{ $documentsStatus['approved'] }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg bg-green-100 text-green-600">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl border-l-4 border border-slate-200 p-4 flex items-center justify-between hover:shadow-md transition-shadow"
            style="border-left-color:#D4AF37">
            <div>
                <div class="font-mono text-[.57rem] tracking-widest uppercase text-slate-400 mb-1">Pending</div>
                <div class="font-display font-bold text-3xl" style="color:#D4AF37">{{ $documentsStatus['pending'] }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg"
                style="background:rgba(212,175,55,.12);color:#D4AF37">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl border-l-4 border border-slate-200 p-4 flex items-center justify-between hover:shadow-md transition-shadow"
            style="border-left-color:#ef4444">
            <div>
                <div class="font-mono text-[.57rem] tracking-widest uppercase text-slate-400 mb-1">Rejected</div>
                <div class="font-display font-bold text-3xl text-red-500">{{ $documentsStatus['rejected'] }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg bg-red-100 text-red-500">
                <i class="bi bi-x-circle-fill"></i>
            </div>
        </div>
    </div>

    <!-- ── MAIN GRID ── -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: Recent Activity + Rating -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Recent Feedback Received -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h3 class="font-display font-bold text-slate-800 text-[1rem]">Recent Feedback</h3>
                    @if ($avgRating)
                        <div class="flex items-center gap-1.5">
                            <span class="font-display font-bold text-lg"
                                style="color:#D4AF37">{{ number_format($avgRating, 1) }}</span>
                            <i class="bi bi-star-fill text-sm" style="color:#D4AF37"></i>
                        </div>
                    @endif
                </div>
                @if ($feedbacksReceived->count())
                    <div class="divide-y divide-slate-50">
                        @foreach ($feedbacksReceived as $fb)
                            <div class="px-5 py-3.5 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm font-display flex-shrink-0"
                                    style="background:rgba(212,175,55,.12);color:#D4AF37">
                                    {{ strtoupper(substr($fb->givenBy->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span
                                            class="font-semibold text-slate-800 text-sm">{{ $fb->givenBy->name ?? 'User' }}</span>
                                        <div class="flex items-center gap-0.5 ml-auto">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }} text-[.6rem]"
                                                    style="color:{{ $i <= $fb->rating ? '#D4AF37' : '#cbd5e1' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    @if ($fb->comment)
                                        <p class="text-slate-500 text-xs leading-relaxed">
                                            {{ Str::limit($fb->comment, 120) }}</p>
                                    @endif
                                    <div class="text-slate-400 text-[.68rem] font-mono mt-1">
                                        {{ $fb->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center">
                        <i class="bi bi-star text-3xl text-slate-300 block mb-2"></i>
                        <p class="text-slate-400 text-sm">No feedback received yet.</p>
                    </div>
                @endif
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <a href="{{ route('advocate.documents') }}"
                    class="flex items-center gap-3 bg-white rounded-xl border border-slate-200 p-4 hover:border-yellow-400 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform"
                        style="background:rgba(212,175,55,.12);color:#D4AF37">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-slate-800 text-sm">Upload Docs</div>
                        <div class="text-slate-400 text-xs">Add documents</div>
                    </div>
                </a>
                <a href="{{ route('advocate.search.clerks') }}"
                    class="flex items-center gap-3 bg-white rounded-xl border border-slate-200 p-4 hover:border-yellow-400 hover:shadow-md transition-all group">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform bg-blue-100 text-blue-600">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-slate-800 text-sm">Find Clerks</div>
                        <div class="text-slate-400 text-xs">Search support</div>
                    </div>
                </a>
                <a href="{{ route('advocate.profile') }}"
                    class="flex items-center gap-3 bg-white rounded-xl border border-slate-200 p-4 hover:border-yellow-400 hover:shadow-md transition-all group">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform bg-purple-100 text-purple-600">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-slate-800 text-sm">My Profile</div>
                        <div class="text-slate-400 text-xs">Update info</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- RIGHT: Profile Summary -->
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <!-- Header -->
                <div class="px-5 py-5 text-center border-b border-slate-100"
                    style="background:linear-gradient(135deg,#060C18 0%,#1a2744 100%)">
                    <div class="w-14 h-14 rounded-2xl mx-auto flex items-center justify-center font-bold font-display text-2xl mb-2"
                        style="background:linear-gradient(135deg,#D4AF37,#B5952F);color:#060C18">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="font-display font-bold text-white text-[1rem]">{{ auth()->user()->name }}</div>
                    <div class="font-mono text-[.6rem] uppercase tracking-widest mt-0.5" style="color:rgba(212,175,55,.7)">
                        Advocate</div>
                    @if (auth()->user()->status === 'active')
                        <span class="inline-block mt-2 px-3 py-0.5 rounded-full text-[.6rem] font-mono font-bold uppercase"
                            style="background:rgba(34,197,94,.12);color:#16a34a;border:1px solid rgba(34,197,94,.2)">
                            ✓ Verified
                        </span>
                    @else
                        <span class="inline-block mt-2 px-3 py-0.5 rounded-full text-[.6rem] font-mono font-bold uppercase"
                            style="background:rgba(212,175,55,.12);color:#D4AF37;border:1px solid rgba(212,175,55,.25)">
                            ⏳ Pending
                        </span>
                    @endif
                </div>

                <div class="p-4 space-y-3">
                    <div class="flex items-center gap-2.5 text-sm">
                        <i class="bi bi-envelope text-slate-400 w-4"></i>
                        <span class="text-slate-600 truncate">{{ auth()->user()->email }}</span>
                    </div>
                    @if (auth()->user()->phone)
                        <div class="flex items-center gap-2.5 text-sm">
                            <i class="bi bi-telephone text-slate-400 w-4"></i>
                            <span class="text-slate-600">{{ auth()->user()->phone }}</span>
                        </div>
                    @endif
                    @if ($profile && $profile->high_court)
                        <div class="flex items-center gap-2.5 text-sm">
                            <i class="bi bi-building text-slate-400 w-4"></i>
                            <span class="text-slate-600">{{ $profile->high_court }}</span>
                        </div>
                    @endif
                    @if ($profile && $profile->experience_years)
                        <div class="flex items-center gap-2.5 text-sm">
                            <i class="bi bi-briefcase text-slate-400 w-4"></i>
                            <span class="text-slate-600">{{ $profile->experience_years }} Years Experience</span>
                        </div>
                    @endif
                    @if ($profile && !empty($profile->practice_areas))
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach (array_slice($profile->practice_areas, 0, 4) as $area)
                                <span class="px-2.5 py-0.5 rounded-full text-[.65rem] font-mono font-semibold"
                                    style="background:rgba(212,175,55,.1);color:#92650a;border:1px solid rgba(212,175,55,.2)">
                                    {{ $area }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="px-4 pb-4">
                    <a href="{{ route('advocate.profile') }}"
                        class="block text-center py-2 rounded-xl text-sm font-bold transition-all border"
                        style="border-color:#D4AF37;color:#D4AF37"
                        onmouseover="this.style.background='#D4AF37';this.style.color='#060C18'"
                        onmouseout="this.style.background='';this.style.color='#D4AF37'">
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Document Progress -->
            @php
                $required = 7;
                $done = $documentsStatus['approved'];
                $pct = $required > 0 ? round(($done / $required) * 100) : 0;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-display font-bold text-slate-800 text-[.95rem]">Document Progress</h4>
                    <span class="font-mono text-[.68rem] font-bold"
                        style="color:#D4AF37">{{ $done }}/{{ $required }}</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden mb-2">
                    <div class="h-full rounded-full transition-all duration-700"
                        style="width:{{ $pct }}%;background:linear-gradient(90deg,#D4AF37,#B5952F)"></div>
                </div>
                <div class="text-slate-400 text-xs font-mono">{{ $pct }}% complete</div>
            </div>
        </div>

    </div>

    <!-- Feedback Banner -->
    <div class="mt-6 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4"
        style="background:linear-gradient(135deg,#060C18 0%,#1E2D5A 100%)">
        <div>
            <h3 class="font-display font-bold text-white text-lg">How was your recent experience?</h3>
            <p class="text-white/50 text-sm mt-1">Rate your recent interactions to help maintain quality in our network.
            </p>
        </div>
        <a href="#" class="flex-shrink-0 px-6 py-2.5 rounded-xl text-sm font-bold text-white transition-all border"
            style="border-color:rgba(255,255,255,.25)"
            onmouseover="this.style.background='#D4AF37';this.style.color='#060C18';this.style.borderColor='#D4AF37'"
            onmouseout="this.style.background='';this.style.color='white';this.style.borderColor='rgba(255,255,255,.25)'">
            Give Feedback
        </a>
    </div>

@endsection
