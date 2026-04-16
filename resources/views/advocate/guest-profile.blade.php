@extends('layouts.advocate')
@section('title', $user->name . ' — Guest Profile')
@section('page-title', 'Guest Profile')

@push('styles')
    <style>
        /* ── Hero ── */
        .gp-hero {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #0c1730 0%, #0F1A2E 60%, #1a1a0a 100%);
            border: 1px solid rgba(255, 255, 255, .07);
        }

        .gp-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 80% 50%, rgba(212, 175, 55, .12) 0%, transparent 70%),
                radial-gradient(ellipse 30% 60% at 10% 80%, rgba(212, 175, 55, .05) 0%, transparent 60%);
            pointer-events: none;
        }

        .gp-hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(212, 175, 55, .03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 175, 55, .03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .gp-avatar-ring {
            position: relative;
            width: 96px;
            height: 96px;
        }

        .gp-avatar-ring::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(#D4AF37 0deg, #B5952F 90deg, rgba(212, 175, 55, .2) 180deg, #D4AF37 360deg);
            animation: spin 6s linear infinite;
        }

        .gp-avatar-inner {
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a2744, #0c1730);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            font-weight: 700;
            color: #D4AF37;
            font-family: 'Playfair Display', serif;
            z-index: 1;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Stat chips ── */
        .gp-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 12px 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .07);
            min-width: 80px;
        }

        .gp-stat-val {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #D4AF37;
            line-height: 1;
        }

        .gp-stat-lbl {
            font-family: 'JetBrains Mono', monospace;
            font-size: .52rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
        }

        /* ── Info rows ── */
        .gp-info-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .gp-info-row:last-child {
            border-bottom: none;
        }

        .gp-info-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: .8rem;
            background: rgba(212, 175, 55, .08);
            color: #D4AF37;
            border: 1px solid rgba(212, 175, 55, .15);
        }

        .gp-info-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: .52rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .25);
            margin-bottom: 2px;
        }

        .gp-info-value {
            font-size: .85rem;
            color: rgba(255, 255, 255, .85);
            font-weight: 500;
            word-break: break-all;
        }

        /* ── Review card ── */
        .review-card {
            background: rgba(255, 255, 255, .025);
            border: 1px solid rgba(255, 255, 255, .06);
            border-radius: 14px;
            padding: 16px;
            transition: all .2s;
        }

        .review-card:hover {
            background: rgba(255, 255, 255, .04);
            border-color: rgba(212, 175, 55, .2);
            transform: translateY(-1px);
        }

        /* ── Stars ── */
        .star-row {
            display: flex;
            gap: 2px;
        }

        .star-row i {
            font-size: .75rem;
        }

        /* ── Rating bar ── */
        .rating-bar-track {
            height: 4px;
            border-radius: 99px;
            background: rgba(255, 255, 255, .07);
            flex: 1;
            overflow: hidden;
        }

        .rating-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #D4AF37, #B5952F);
            transition: width .6s cubic-bezier(.4, 0, .2, 1);
        }

        /* ── Fade in ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp .4s ease both;
        }

        .fade-up-1 {
            animation-delay: .05s;
        }

        .fade-up-2 {
            animation-delay: .12s;
        }

        .fade-up-3 {
            animation-delay: .18s;
        }

        .fade-up-4 {
            animation-delay: .24s;
        }
    </style>
@endpush

@section('content')

    {{-- Back --}}
    <div class="mb-4 fade-up">
        <a href="{{ route('advocate.guests') }}"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all"
            style="color:rgba(255,255,255,.35);background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08)"
            onmouseover="this.style.color='rgba(255,255,255,.8)';this.style.borderColor='rgba(255,255,255,.15)'"
            onmouseout="this.style.color='rgba(255,255,255,.35)';this.style.borderColor='rgba(255,255,255,.08)'">
            <i class="bi bi-arrow-left text-xs"></i> Back to Guests
        </a>
    </div>

    {{-- ── HERO BANNER ── --}}
    <div class="gp-hero fade-up fade-up-1">
        <div class="gp-hero-grid"></div>
        <div class="relative z-10 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">

                {{-- Avatar --}}
                <div class="gp-avatar-ring flex-shrink-0">
                    <div class="gp-avatar-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                </div>

                {{-- Identity --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 flex-wrap mb-1">
                        <span class="font-mono text-[.55rem] tracking-[.2em] uppercase px-2.5 py-1 rounded-full"
                            style="background:rgba(212,175,55,.12);border:1px solid rgba(212,175,55,.25);color:#D4AF37">
                            Guest User
                        </span>
                        @if ($user->status === 'active')
                            <span
                                class="flex items-center gap-1.5 font-mono text-[.55rem] tracking-widest uppercase px-2.5 py-1 rounded-full"
                                style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#4ade80">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse inline-block"></span>
                                Active
                            </span>
                        @endif
                    </div>

                    <h1 class="text-white font-bold mb-1"
                        style="font-family:'Playfair Display',serif;font-size:clamp(1.4rem,3vw,2rem);letter-spacing:-.01em">
                        {{ $user->name }}
                    </h1>
                    <p class="text-sm" style="color:rgba(255,255,255,.35)">
                        {{ $user->email }}
                        @if ($user->city)
                            &nbsp;·&nbsp; <i class="bi bi-geo-alt-fill" style="color:#D4AF37"></i> {{ $user->city }}
                        @endif
                        &nbsp;·&nbsp; Member since {{ $user->created_at->format('M Y') }}
                    </p>
                </div>

                {{-- Stats --}}
                <div class="flex gap-3 flex-shrink-0">
                    <div class="gp-stat">
                        <div class="gp-stat-val">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
                        <div class="gp-stat-lbl">Rating</div>
                    </div>
                    <div class="gp-stat">
                        <div class="gp-stat-val">{{ $feedbacks->count() }}</div>
                        <div class="gp-stat-lbl">Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- LEFT SIDEBAR --}}
        <div class="lg:col-span-2 space-y-4 fade-up fade-up-2">

            {{-- Contact info --}}
            <div class="rounded-2xl p-5" style="background:#1a2744;border:1px solid rgba(255,255,255,.07)">
                <div class="font-mono text-[.55rem] tracking-[.18em] uppercase mb-4 flex items-center gap-2"
                    style="color:rgba(212,175,55,.5)">
                    <i class="bi bi-person-vcard"></i> Contact Details
                </div>

                <div class="gp-info-row">
                    <div class="gp-info-icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="gp-info-label">Email</div>
                        <div class="gp-info-value">{{ $user->email }}</div>
                    </div>
                </div>

                @if ($user->phone)
                    <div class="gp-info-row">
                        <div class="gp-info-icon"><i class="bi bi-telephone"></i></div>
                        <div>
                            <div class="gp-info-label">Phone</div>
                            <div class="gp-info-value">{{ $user->phone }}</div>
                        </div>
                    </div>
                @endif

                @if ($user->city)
                    <div class="gp-info-row">
                        <div class="gp-info-icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <div class="gp-info-label">City</div>
                            <div class="gp-info-value">{{ $user->city }}</div>
                        </div>
                    </div>
                @endif

                <div class="gp-info-row">
                    <div class="gp-info-icon"><i class="bi bi-calendar3"></i></div>
                    <div>
                        <div class="gp-info-label">Joined</div>
                        <div class="gp-info-value">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="gp-info-row">
                    <div class="gp-info-icon"><i class="bi bi-activity"></i></div>
                    <div>
                        <div class="gp-info-label">Last Active</div>
                        <div class="gp-info-value">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            {{-- Connect Action Box (UPDATED with Accept Logic) --}}
            @php
                // Request ki ID fetch kar rahe hain taaki accept route sahi se hit ho sake
                $reqId = 'null';
                if (in_array($connectionStatus, ['received', 'sent', 'connected'])) {
                    $existingReq = \App\Models\ConnectionRequest::where(function ($q) use ($user) {
                        $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
                    })
                        ->orWhere(function ($q) use ($user) {
                            $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
                        })
                        ->first();

                    if ($existingReq) {
                        $reqId = $existingReq->id;
                    }
                }
            @endphp

            <div x-data="profileConnection('{{ $connectionStatus }}', {{ $user->id }}, {{ $reqId }})" class="rounded-2xl p-5"
                style="background:#1a2744;border:1px solid rgba(255,255,255,.07)">
                <div class="font-mono text-[.55rem] tracking-[.18em] uppercase mb-4 flex items-center gap-2"
                    style="color:rgba(212,175,55,.5)">
                    <i class="bi bi-diagram-3"></i> Network
                </div>

                {{-- No connection --}}
                <template x-if="status === 'none'">
                    <button @click="sendReq()"
                        class="w-full py-3 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2"
                        style="background:#D4AF37;color:#0e0e0f">
                        <i class="bi bi-person-plus-fill text-lg"></i> Connect
                    </button>
                </template>

                {{-- We sent request (Pending) --}}
                <template x-if="status === 'sent'">
                    <button disabled
                        class="w-full py-3 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2"
                        style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.4);cursor:not-allowed">
                        <i class="bi bi-clock-history text-lg"></i> Request Sent
                    </button>
                </template>

                {{-- They sent us a request (We must Accept) --}}
                <template x-if="status === 'received'">
                    <button @click="acceptReq()"
                        class="w-full py-3 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2 shadow-lg hover:opacity-90"
                        style="background:#10b981;color:#ffffff">
                        <i class="bi bi-check-circle-fill text-lg"></i> Accept Request
                    </button>
                </template>

                {{-- Already connected --}}
                <template x-if="status === 'connected'">
                    <button disabled
                        class="w-full py-3 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2"
                        style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2);color:#4ade80;cursor:default">
                        <i class="bi bi-patch-check-fill text-lg"></i> You are Connected
                    </button>
                </template>
            </div>

            {{-- Rating breakdown --}}
            @if ($feedbacks->count() > 0)
                <div class="rounded-2xl p-5" style="background:#1a2744;border:1px solid rgba(255,255,255,.07)">
                    <div class="font-mono text-[.55rem] tracking-[.18em] uppercase mb-4 flex items-center gap-2"
                        style="color:rgba(212,175,55,.5)">
                        <i class="bi bi-bar-chart"></i> Rating Breakdown
                    </div>

                    @php
                        $ratingCounts = $feedbacks->groupBy('rating')->map->count();
                        $total = $feedbacks->count();
                    @endphp

                    @for ($star = 5; $star >= 1; $star--)
                        @php
                            $cnt = $ratingCounts[$star] ?? 0;
                            $pct = $total ? round(($cnt / $total) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-3 mb-2.5">
                            <div class="flex items-center gap-1 w-14 flex-shrink-0">
                                <span class="font-mono text-xs"
                                    style="color:rgba(255,255,255,.5)">{{ $star }}</span>
                                <i class="bi bi-star-fill text-xs" style="color:#D4AF37"></i>
                            </div>
                            <div class="rating-bar-track">
                                <div class="rating-bar-fill" style="width:{{ $pct }}%"></div>
                            </div>
                            <span class="font-mono text-xs w-8 text-right flex-shrink-0"
                                style="color:rgba(212,175,55,.6)">{{ $cnt }}</span>
                        </div>
                    @endfor
                </div>
            @endif

            {{-- Note --}}
            <div class="rounded-2xl p-4" style="background:rgba(212,175,55,.04);border:1px solid rgba(212,175,55,.12)">
                <div class="flex gap-3">
                    <i class="bi bi-shield-check mt-0.5 flex-shrink-0" style="color:#D4AF37"></i>
                    <p class="text-xs leading-relaxed" style="color:#b8a87a">
                        Guest users browse advocates & clerks on Court Pulse. They give feedback to unlock contact details.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Reviews --}}
        <div class="lg:col-span-3 fade-up fade-up-3">
            <div class="rounded-2xl p-5" style="background:#1a2744;border:1px solid rgba(255,255,255,.07)">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-5">
                    <div class="font-mono text-[.55rem] tracking-[.18em] uppercase flex items-center gap-2"
                        style="color:rgba(212,175,55,.5)">
                        <i class="bi bi-chat-quote"></i> Reviews Received
                    </div>
                    @if ($feedbacks->count())
                        <div class="flex items-center gap-2">
                            <div class="flex gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $avgRating && $i <= round($avgRating) ? '-fill' : '' }} text-xs"
                                        style="color:{{ $avgRating && $i <= round($avgRating) ? '#D4AF37' : 'rgba(255,255,255,.12)' }}"></i>
                                @endfor
                            </div>
                            <span class="font-mono text-xs font-bold"
                                style="color:#D4AF37">{{ number_format($avgRating, 1) }}</span>
                            <span class="font-mono text-[.6rem]"
                                style="color:rgba(255,255,255,.25)">({{ $feedbacks->count() }})</span>
                        </div>
                    @endif
                </div>

                {{-- Reviews list --}}
                @forelse($feedbacks as $fb)
                    <div class="review-card mb-3">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0"
                                    style="background:linear-gradient(135deg,rgba(212,175,55,.15),rgba(212,175,55,.05));border:1px solid rgba(212,175,55,.2);color:#D4AF37">
                                    {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-sm text-white">
                                        {{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'Unknown' }}
                                    </div>
                                    <div class="font-mono text-[.52rem] tracking-widest uppercase"
                                        style="color:rgba(212,175,55,.5)">
                                        @if (!$fb->is_anonymous && $fb->giver)
                                            {{ ucfirst($fb->giver->role) }}
                                        @else
                                            Court Pulse User
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                <div class="star-row">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }}"
                                            style="color:{{ $i <= $fb->rating ? '#D4AF37' : 'rgba(255,255,255,.1)' }}"></i>
                                    @endfor
                                </div>
                                <span class="font-mono text-[.52rem]" style="color:rgba(212,175,55,.4)">
                                    {{ $fb->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        @if ($fb->comment)
                            <div class="rounded-lg px-3 py-2.5 text-sm leading-relaxed"
                                style="background:rgba(212,175,55,.07);border-left:2px solid #D4AF37;color:#e8d5a3">
                                "{{ $fb->comment }}"
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-14 text-center">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-4"
                            style="background:rgba(212,175,55,.06);border:1px solid rgba(212,175,55,.12)">⭐</div>
                        <p class="font-medium text-sm mb-1" style="color:#c9b97a">No reviews yet</p>
                        <p class="text-xs" style="color:rgba(212,175,55,.45)">This guest hasn't received any feedback yet.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function profileConnection(initialStatus, userId, reqId) {
                return {
                    status: initialStatus,
                    requestId: reqId,

                    // Send Request
                    async sendReq() {
                        try {
                            const res = await fetch(`{{ route('connections.send') }}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    receiver_id: userId
                                })
                            });
                            if (res.ok) this.status = 'sent';
                        } catch (e) {
                            console.error(e);
                        }
                    },

                    // Accept Request (NEW)
                    async acceptReq() {
                        if (!this.requestId) return; // ID ke bina accept nahi ho sakta
                        try {
                            const res = await fetch(`/connections/${this.requestId}/accept`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });
                            if (res.ok) this.status = 'connected';
                        } catch (e) {
                            console.error(e);
                        }
                    }
                }
            }
        </script>
    @endpush

@endsection
