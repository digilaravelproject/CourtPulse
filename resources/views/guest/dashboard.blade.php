@extends('layouts.guest')
@section('title', 'Home')
@section('content')

    {{-- Welcome --}}
    <div class="mb-5">
        <h2 class="font-display font-bold text-3xl text-ink mb-1">Welcome, {{ explode(' ', auth()->user()->name)[0] }}! 👋
        </h2>
        <p class="text-muted text-sm">Browse verified advocates & clerks. Give feedback to unlock their contacts.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
        <div class="bg-white border border-border rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">⚖️</div>
            <div class="font-display font-bold text-2xl text-ink">{{ $totalAdvocates }}</div>
            <div class="text-[0.72rem] text-muted mt-1">Advocates</div>
        </div>
        <div class="bg-white border border-border rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">🗂️</div>
            <div class="font-display font-bold text-2xl text-ink">{{ $totalClerks }}</div>
            <div class="text-[0.72rem] text-muted mt-1">Clerks</div>
        </div>
        <div class="bg-white border border-border rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">🏛️</div>
            <div class="font-display font-bold text-2xl text-ink">{{ $totalCourts }}</div>
            <div class="text-[0.72rem] text-muted mt-1">Courts</div>
        </div>
        <a href="{{ route('feedback') }}"
            class="bg-gold rounded-xl p-4 text-center block hover:bg-gold-h transition-colors no-underline">
            <div class="text-2xl mb-1">⭐</div>
            <div class="text-sm font-bold text-ink">Feedback</div>
            <div class="text-[0.68rem] text-ink/50 mt-0.5">Unlock contacts</div>
        </a>
    </div>

    {{-- How it works --}}
    <div class="bg-white border border-border rounded-xl p-4 mb-5">
        <div class="font-display font-bold text-lg mb-4 flex items-center gap-2">
            <span style="color:#D4AF37">★</span> How It Works
        </div>
        <div class="flex flex-col sm:flex-row gap-4">
            @foreach ([['1', 'Browse Profiles', 'Find advocates & clerks'], ['2', 'Give Feedback', 'Rate & review them'], ['3', 'Connect', 'Unlock email & phone']] as [$n, $t, $d])
                <div class="flex items-start gap-3 flex-1">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 font-mono font-bold text-sm"
                        style="background:rgba(212,175,55,.12);border:1.5px solid rgba(212,175,55,.25);color:#B5952F">
                        {{ $n }}</div>
                    <div>
                        <div class="font-semibold text-sm mb-0.5">{{ $t }}</div>
                        <div class="text-xs text-muted">{{ $d }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Recent Advocates --}}
    <div class="flex items-center justify-between mb-3">
        <span class="font-display font-bold text-xl">Recent Advocates</span>
        <a href="{{ route('guest.advocates') }}" class="text-sm font-semibold no-underline" style="color:#B5952F">View all
            →</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($recentAdvocates as $adv)
            <div class="bg-white border border-border rounded-xl p-4 hover:border-gold hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                        style="background:rgba(212,175,55,.10);border:1.5px solid rgba(212,175,55,.2)">⚖️</div>
                    <div class="flex-1 min-w-0">
                        <div class="font-display font-bold text-base truncate">{{ $adv->name }}</div>
                        <div class="font-mono text-[0.57rem] tracking-widest uppercase" style="color:#B5952F">Advocate</div>
                    </div>
                    <span
                        class="font-mono text-[0.57rem] tracking-wide px-2 py-0.5 rounded bg-green-100 text-green-700 uppercase font-bold flex-shrink-0">Verified</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-muted mb-1.5">
                    <i class="bi bi-building flex-shrink-0" style="color:#D4AF37"></i>
                    <span class="truncate">{{ $adv->advocateProfile->high_court ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-muted mb-3">
                    <i class="bi bi-geo-alt flex-shrink-0" style="color:#D4AF37"></i>
                    <span>{{ $adv->city ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-border gap-2">
                    <span class="flex items-center gap-1 text-[0.7rem] text-muted min-w-0">
                        <i class="bi bi-lock flex-shrink-0" style="color:#D4AF37"></i>
                        <span class="truncate">Give feedback to connect</span>
                    </span>
                    <a href="{{ route('feedback') }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold no-underline flex-shrink-0 transition-all"
                        style="background:#D4AF37;color:#0e0e0f" onmouseover="this.style.background='#B5952F'"
                        onmouseout="this.style.background='#D4AF37'">
                        <i class="bi bi-star-fill"></i> Feedback
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
