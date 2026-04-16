@extends('layouts.clerk')
@section('title', $user->name . ' — Advocate Profile')
@section('page-title', 'Advocate Profile')

@push('styles')
    <style>
        .ap-hero {
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #060C18 0%, #0F1A2E 50%, #1a1a08 100%);
            border: 1px solid rgba(212, 175, 55, .15);
            position: relative;
        }

        .ap-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 55% 60% at 85% 50%, rgba(212, 175, 55, .12) 0%, transparent 65%);
            pointer-events: none;
        }

        .ap-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(212, 175, 55, .04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 175, 55, .04) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
        }

        .ap-avatar {
            position: relative;
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .ap-avatar::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(#D4AF37 0deg, #B5952F 90deg, rgba(212, 175, 55, .15) 200deg, #D4AF37 360deg);
            animation: spinRing 7s linear infinite;
        }

        .ap-avatar-inner {
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37, #B5952F);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: #060C18;
            font-family: 'Playfair Display', serif;
            z-index: 1;
        }

        @keyframes spinRing {
            to {
                transform: rotate(360deg);
            }
        }

        .ap-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .12);
            min-width: 64px;
        }

        .ap-stat-val {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #D4AF37;
            line-height: 1;
        }

        .ap-stat-lbl {
            font-size: .5rem;
            font-family: monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .35);
            margin-top: 3px;
        }

        .info-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }

        .info-card-header {
            padding: 12px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: .62rem;
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: #B5952F;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-bottom: 1px solid #f8fafc;
            transition: background .15s;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row:hover {
            background: #fafbfc;
        }

        .info-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(212, 175, 55, .08);
            color: #B5952F;
            border: 1px solid rgba(212, 175, 55, .15);
            font-size: .75rem;
        }

        .info-label {
            font-size: .58rem;
            font-family: monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: .85rem;
            color: #1e293b;
            font-weight: 500;
        }

        .info-locked {
            font-size: .85rem;
            color: #cbd5e1;
            filter: blur(3px);
            user-select: none;
        }

        .rating-bar {
            height: 4px;
            border-radius: 99px;
            background: #f1f5f9;
            flex: 1;
            overflow: hidden;
        }

        .rating-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #D4AF37, #B5952F);
        }

        .locked-overlay {
            position: relative;
            overflow: hidden;
        }

        .locked-overlay::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(4px);
            border-radius: 10px;
            z-index: 2;
        }

        .locked-overlay-msg {
            position: absolute;
            inset: 0;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: .8rem;
            font-weight: 600;
            color: #B5952F;
        }
    </style>
@endpush

@section('content')

    {{-- Back --}}
    <div class="mb-4">
        <a href="{{ route('clerk.advocates') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium border border-gray-200 bg-white text-text-muted-light hover:text-gray-800 hover:border-gray-300 transition-all shadow-sm">
            <i class="bi bi-arrow-left text-xs"></i> Back to Advocates
        </a>
    </div>

    {{-- HERO --}}
    <div class="ap-hero">
        <div class="ap-grid"></div>
        <div style="position:relative;z-index:1;padding:28px 32px;">
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:20px;">

                <div class="ap-avatar">
                    <div class="ap-avatar-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                </div>

                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:6px;">
                        <span
                            style="font-size:.55rem;letter-spacing:.2em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.3);color:#D4AF37;font-family:monospace;">Advocate</span>
                        <span
                            style="display:flex;align-items:center;gap:5px;font-size:.55rem;letter-spacing:.15em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2);color:#4ade80;font-family:monospace;">
                            <span
                                style="width:5px;height:5px;border-radius:50%;background:#4ade80;display:inline-block;"></span>
                            Verified
                        </span>
                        @if ($connected)
                            <span
                                style="display:flex;align-items:center;gap:5px;font-size:.55rem;letter-spacing:.15em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.4);color:#D4AF37;font-family:monospace;">
                                <i class="bi bi-patch-check-fill"></i> Connected
                            </span>
                        @endif
                    </div>

                    {{-- Name always visible --}}
                    <h1
                        style="font-family:'Playfair Display',serif;font-size:clamp(1.4rem,3vw,2rem);font-weight:700;color:#F1F5F9;margin-bottom:6px;">
                        {{ $user->name }}</h1>

                    {{-- City/Court: only when connected --}}
                    <p style="font-size:.85rem;color:rgba(255,255,255,.45);display:flex;gap:12px;flex-wrap:wrap;">
                        @if ($profile?->high_court)
                            <span><i class="bi bi-building-columns" style="color:#D4AF37;margin-right:4px;"></i>
                                {{ $connected ? $profile->high_court : '••••• High Court' }}
                            </span>
                        @endif
                        @if ($user->city)
                            <span><i class="bi bi-geo-alt" style="color:#D4AF37;margin-right:4px;"></i>
                                {{ $connected ? $user->city : '•••••' }}
                            </span>
                        @endif
                    </p>
                </div>

                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <div class="ap-stat">
                        <div class="ap-stat-val">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
                        <div class="ap-stat-lbl">Rating</div>
                    </div>
                    <div class="ap-stat">
                        <div class="ap-stat-val">{{ $feedbacks->count() }}</div>
                        <div class="ap-stat-lbl">Reviews</div>
                    </div>
                    @if ($profile?->experience_years)
                        <div class="ap-stat">
                            <div class="ap-stat-val">{{ $profile->experience_years }}</div>
                            <div class="ap-stat-lbl">Yrs Exp</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Connect / Status --}}
            <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
                @if ($connectionStatus === 'none')
                    <button id="connectBtn" onclick="sendConnectProfile({{ $user->id }})"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:linear-gradient(135deg,#D4AF37,#B5952F);color:#060C18;font-weight:700;font-size:.88rem;border:none;cursor:pointer;">
                        <i class="bi bi-person-plus-fill"></i> Send Connect Request
                    </button>
                @elseif($connectionStatus === 'sent')
                    <div
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.5);font-size:.88rem;">
                        <i class="bi bi-clock"></i> Request Pending
                    </div>
                @elseif($connectionStatus === 'received')
                    <button onclick="handleReq({{ $connectionReq?->id }}, 'accept')"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:#16a34a;color:white;font-weight:700;font-size:.88rem;border:none;cursor:pointer;">
                        <i class="bi bi-check-lg"></i> Accept Request
                    </button>
                    <button onclick="handleReq({{ $connectionReq?->id }}, 'reject')"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:10px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#f87171;font-size:.88rem;cursor:pointer;background-color:transparent;">
                        <i class="bi bi-x-lg"></i> Reject
                    </button>
                @elseif($connectionStatus === 'connected')
                    <div
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#4ade80;font-size:.88rem;font-weight:600;">
                        <i class="bi bi-patch-check-fill"></i> Connected — Full details unlocked
                    </div>
                @endif

                @if (!$hasFeedback)
                    <a href="{{ route('feedback') }}"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:10px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#fca5a5;font-size:.85rem;text-decoration:none;">
                        <i class="bi bi-lock-fill"></i> Submit Feedback to Unlock Contact
                    </a>
                @endif
            </div>

            {{-- Not connected notice --}}
            @if (!$connected)
                <div
                    style="margin-top:16px;padding:10px 16px;border-radius:10px;background:rgba(212,175,55,.08);border:1px solid rgba(212,175,55,.2);display:flex;align-items:center;gap:10px;">
                    <i class="bi bi-info-circle" style="color:#D4AF37;font-size:1rem;flex-shrink:0;"></i>
                    <span style="font-size:.8rem;color:rgba(255,255,255,.5);">
                        Send a connection request to unlock full profile details, contact information, and more.
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- BODY --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- LEFT SIDEBAR --}}
        <div class="lg:col-span-2 space-y-4">

            <div class="info-card">
                <div class="info-card-header"><i class="bi bi-person-vcard"></i> Contact Details</div>

                <div class="info-row">
                    <div class="info-icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="info-label">Email</div>
                        @if ($connected && $hasFeedback)
                            <div class="info-value">{{ $user->email }}</div>
                        @else
                            <div class="info-locked">{{ str_repeat('•', strlen($user->email)) }}</div>
                            <div style="font-size:.65rem;color:#D4AF37;margin-top:2px;"><i class="bi bi-lock-fill"></i>
                                Connect & submit feedback</div>
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon"><i class="bi bi-telephone"></i></div>
                    <div>
                        <div class="info-label">Phone</div>
                        @if ($connected && $hasFeedback)
                            <div class="info-value">{{ $user->phone ?? 'Not provided' }}</div>
                        @else
                            <div class="info-locked">••••••••••</div>
                            <div style="font-size:.65rem;color:#D4AF37;margin-top:2px;"><i class="bi bi-lock-fill"></i>
                                Connect & submit feedback</div>
                        @endif
                    </div>
                </div>

                @if ($profile?->high_court)
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-building-columns"></i></div>
                        <div>
                            <div class="info-label">High Court</div>
                            <div class="info-value">{{ $connected ? $profile->high_court : '••••• High Court' }}</div>
                        </div>
                    </div>
                @endif

                @if ($profile?->practice_areas)
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-briefcase"></i></div>
                        <div>
                            <div class="info-label">Practice Areas</div>
                            @if ($connected)
                                <div class="info-value" style="font-size:.8rem;">{{ $profile->practice_areas }}</div>
                            @else
                                <div class="info-locked">•••••••••••••••••</div>
                                <div style="font-size:.65rem;color:#D4AF37;margin-top:2px;"><i class="bi bi-lock-fill"></i>
                                    Connect to unlock</div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="info-icon"><i class="bi bi-calendar3"></i></div>
                    <div>
                        <div class="info-label">Member Since</div>
                        <div class="info-value">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            {{-- Bio: only when connected --}}
            @if ($profile?->bio)
                <div class="info-card">
                    <div class="info-card-header"><i class="bi bi-person-lines-fill"></i> About</div>
                    @if ($connected)
                        <div style="padding:16px 20px;font-size:.85rem;color:#64748b;line-height:1.7;">{{ $profile->bio }}
                        </div>
                    @else
                        <div style="padding:16px 20px;position:relative;min-height:80px;">
                            <div style="font-size:.85rem;color:#64748b;line-height:1.7;filter:blur(4px);user-select:none;">
                                {{ $profile->bio }}
                            </div>
                            <div
                                style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;gap:6px;font-size:.8rem;color:#B5952F;font-weight:600;">
                                <i class="bi bi-lock-fill"></i> Connect to read full bio
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if ($feedbacks->count())
                @php
                    $ratingCounts = $feedbacks->groupBy('rating')->map->count();
                    $total = $feedbacks->count();
                @endphp
                <div class="info-card">
                    <div class="info-card-header"><i class="bi bi-bar-chart"></i> Rating Breakdown</div>
                    <div style="padding:16px 20px;">
                        @for ($star = 5; $star >= 1; $star--)
                            @php
                                $cnt = $ratingCounts[$star] ?? 0;
                                $pct = $total ? round(($cnt / $total) * 100) : 0;
                            @endphp
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                                <span
                                    style="font-size:.7rem;font-family:monospace;color:#94a3b8;width:20px;">{{ $star }}★</span>
                                <div class="rating-bar">
                                    <div class="rating-fill" style="width:{{ $pct }}%"></div>
                                </div>
                                <span
                                    style="font-size:.7rem;color:#D4AF37;width:16px;text-align:right;">{{ $cnt }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            @endif
        </div>

        {{-- REVIEWS --}}
        <div class="lg:col-span-3">
            <div class="info-card">
                <div class="info-card-header" style="justify-content:space-between;">
                    <span><i class="bi bi-chat-quote"></i> Reviews Received</span>
                    @if ($feedbacks->count())
                        <span style="color:#94a3b8;font-size:.65rem;">{{ number_format($avgRating, 1) }} avg ·
                            {{ $feedbacks->count() }} reviews</span>
                    @endif
                </div>
                @forelse($feedbacks as $fb)
                    <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                        <div
                            style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:8px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div
                                    style="width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;color:#060C18;flex-shrink:0;background:linear-gradient(135deg,#D4AF37,#B5952F);">
                                    {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-size:.85rem;font-weight:600;color:#1e293b;">
                                        {{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'Unknown' }}
                                    </div>
                                    <div style="font-size:.65rem;color:#94a3b8;">{{ $fb->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div style="display:flex;gap:2px;flex-shrink:0;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }}"
                                        style="font-size:.7rem;color:{{ $i <= $fb->rating ? '#D4AF37' : '#e2e8f0' }};"></i>
                                @endfor
                            </div>
                        </div>
                        @if ($fb->comment)
                            <div
                                style="background:#faf9f6;border-left:3px solid #D4AF37;border-radius:0 8px 8px 0;padding:10px 14px;font-size:.82rem;color:#64748b;line-height:1.6;">
                                "{{ $fb->comment }}"
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="padding:48px 20px;text-align:center;">
                        <span class="material-icons-round"
                            style="font-size:2.5rem;color:#e2e8f0;display:block;margin-bottom:10px;">reviews</span>
                        <p style="color:#94a3b8;font-size:.85rem;">No reviews yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

            function sendConnectProfile(userId) {
                const btn = document.getElementById('connectBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sending...';
                fetch('{{ route('connections.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            receiver_id: userId
                        })
                    })
                    .then(r => r.json())
                    .then(() => {
                        btn.outerHTML =
                            `<div style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.5);font-size:.88rem;"><i class="bi bi-clock"></i> Request Sent</div>`;
                    })
                    .catch(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-person-plus-fill"></i> Send Connect Request';
                    });
            }

            function handleReq(reqId, action) {
                fetch(`/connections/${reqId}/${action}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                }).then(() => location.reload());
            }
        </script>
    @endpush

@endsection
