@extends('layouts.advocate')
@section('title', $user->name . ' — Clerk Profile')
@section('page-title', 'Clerk Profile')

@push('styles')
    <style>
        .cp-hero {
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #060C18 0%, #0F1A2E 50%, #1a1a08 100%);
            border: 1px solid rgba(212, 175, 55, .15);
            position: relative;
        }

        .cp-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 55% 60% at 85% 50%, rgba(212, 175, 55, .12) 0%, transparent 65%),
                radial-gradient(ellipse 25% 40% at 5% 90%, rgba(212, 175, 55, .05) 0%, transparent 60%);
            pointer-events: none;
        }

        .cp-grid-bg {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(212, 175, 55, .04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 175, 55, .04) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
        }

        .avatar-ring {
            position: relative;
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .avatar-ring::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(#D4AF37 0deg, #B5952F 90deg, rgba(212, 175, 55, .15) 200deg, #D4AF37 360deg);
            animation: spinRing 7s linear infinite;
        }

        .avatar-inner {
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

        .info-card-dark {
            background: #0F1A2E;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 16px;
            overflow: hidden;
        }

        .info-card-dark-header {
            padding: 12px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
            font-size: .6rem;
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: #D4AF37;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-row-dark {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            transition: background .15s;
        }

        .info-row-dark:last-child {
            border-bottom: none;
        }

        .info-row-dark:hover {
            background: rgba(255, 255, 255, .02);
        }

        .info-icon-dark {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(212, 175, 55, .08);
            color: #D4AF37;
            border: 1px solid rgba(212, 175, 55, .15);
            font-size: .75rem;
        }

        .info-label-dark {
            font-size: .58rem;
            font-family: monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
            margin-bottom: 2px;
        }

        .info-value-dark {
            font-size: .85rem;
            color: rgba(255, 255, 255, .8);
            font-weight: 500;
        }

        .info-value-locked {
            font-size: .85rem;
            color: rgba(255, 255, 255, .2);
            filter: blur(3px);
            user-select: none;
        }

        .stat-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .08);
            min-width: 64px;
        }

        .stat-val {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #D4AF37;
            line-height: 1;
        }

        .stat-lbl {
            font-size: .5rem;
            font-family: monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .35);
            margin-top: 3px;
        }

        .rating-bar {
            height: 4px;
            border-radius: 99px;
            background: rgba(255, 255, 255, .06);
            flex: 1;
            overflow: hidden;
        }

        .rating-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #D4AF37, #B5952F);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .fu {
            animation: fadeUp .3s ease both;
        }

        .fu-1 {
            animation-delay: .04s;
        }

        .fu-2 {
            animation-delay: .1s;
        }

        .fu-3 {
            animation-delay: .16s;
        }
    </style>
@endpush

@section('content')

    {{-- Back --}}
    <div class="mb-4 fu">
        <a href="{{ route('advocate.search.clerks') }}"
            style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);font-size:.85rem;text-decoration:none;transition:all .2s;"
            onmouseover="this.style.borderColor='rgba(212,175,55,.4)';this.style.color='#D4AF37'"
            onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.5)'">
            <i class="bi bi-arrow-left text-xs"></i> Back to Clerks
        </a>
    </div>

    {{-- HERO --}}
    <div class="cp-hero fu fu-1">
        <div class="cp-grid-bg"></div>
        <div style="position:relative;z-index:1;padding:28px 32px;">
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:20px;">

                <div class="avatar-ring">
                    <div class="avatar-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                </div>

                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:6px;">
                        <span
                            style="font-size:.55rem;letter-spacing:.2em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(212,175,55,.12);border:1px solid rgba(212,175,55,.3);color:#D4AF37;font-family:monospace;">Court
                            Clerk</span>
                        @if ($user->status === 'active')
                            <span
                                style="display:flex;align-items:center;gap:5px;font-size:.55rem;letter-spacing:.15em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#4ade80;font-family:monospace;">
                                <span
                                    style="width:5px;height:5px;border-radius:50%;background:#4ade80;display:inline-block;"></span>
                                Verified
                            </span>
                        @endif
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

                    {{-- Court/City: locked until connected --}}
                    <p style="font-size:.85rem;color:rgba(255,255,255,.4);display:flex;gap:12px;flex-wrap:wrap;">
                        @if ($user->clerkProfile?->court_name)
                            <span><i class="bi bi-building" style="color:#D4AF37;margin-right:4px;"></i>
                                {{ $connected ? $user->clerkProfile->court_name : '••••• Court' }}
                            </span>
                        @endif
                        @if ($user->clerkProfile?->court_city || $user->city)
                            <span><i class="bi bi-geo-alt" style="color:#D4AF37;margin-right:4px;"></i>
                                {{ $connected ? $user->clerkProfile?->court_city ?? $user->city : '•••••' }}
                            </span>
                        @endif
                    </p>
                </div>

                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <div class="stat-chip">
                        <div class="stat-val">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
                        <div class="stat-lbl">Rating</div>
                    </div>
                    <div class="stat-chip">
                        <div class="stat-val">{{ $feedbacks->count() }}</div>
                        <div class="stat-lbl">Reviews</div>
                    </div>
                    @if ($user->clerkProfile?->experience_years)
                        <div class="stat-chip">
                            <div class="stat-val">{{ $user->clerkProfile->experience_years }}</div>
                            <div class="stat-lbl">Yrs Exp</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Connect / Status Button --}}
            <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
                @if ($connectionStatus === 'none')
                    <button id="connectBtn" onclick="sendConnectProfile({{ $user->id }})"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:linear-gradient(135deg,#D4AF37,#B5952F);color:#060C18;font-weight:700;font-size:.88rem;border:none;cursor:pointer;transition:all .2s;">
                        <i class="bi bi-person-plus-fill"></i> Send Connect Request
                    </button>
                @elseif($connectionStatus === 'sent')
                    <div
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);font-size:.88rem;">
                        <i class="bi bi-clock"></i> Request Pending
                    </div>
                @elseif($connectionStatus === 'received')
                    <button onclick="handleReq({{ $connectionReq?->id }}, 'accept')"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:#16a34a;color:white;font-weight:700;font-size:.88rem;border:none;cursor:pointer;">
                        <i class="bi bi-check-lg"></i> Accept Request
                    </button>
                    <button onclick="handleReq({{ $connectionReq?->id }}, 'reject')"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:10px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#f87171;font-size:.88rem;cursor:pointer;">
                        <i class="bi bi-x-lg"></i> Reject
                    </button>
                @elseif($connectionStatus === 'connected')
                    <div
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#4ade80;font-size:.88rem;font-weight:600;">
                        <i class="bi bi-patch-check-fill"></i> Connected — Full details unlocked
                    </div>
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
    <div style="display:grid;grid-template-columns:1fr;gap:20px;" class="fu fu-2">

        <div style="display:grid;grid-template-columns:1fr;gap:16px;">

            {{-- Contact Info --}}
            <div class="info-card-dark">
                <div class="info-card-dark-header"><i class="bi bi-person-vcard"></i> Contact Details</div>

                <div class="info-row-dark">
                    <div class="info-icon-dark"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="info-label-dark">Email</div>
                        @if ($connected)
                            <div class="info-value-dark">{{ $user->email }}</div>
                        @else
                            <div class="info-value-locked">{{ str_repeat('•', strlen($user->email)) }}</div>
                            <div style="font-size:.65rem;color:rgba(212,175,55,.5);margin-top:2px;"><i
                                    class="bi bi-lock-fill"></i> Connect to unlock</div>
                        @endif
                    </div>
                </div>

                <div class="info-row-dark">
                    <div class="info-icon-dark"><i class="bi bi-telephone"></i></div>
                    <div>
                        <div class="info-label-dark">Phone</div>
                        @if ($connected)
                            <div class="info-value-dark">{{ $user->phone ?? 'Not provided' }}</div>
                        @else
                            <div class="info-value-locked">••••••••••</div>
                            <div style="font-size:.65rem;color:rgba(212,175,55,.5);margin-top:2px;"><i
                                    class="bi bi-lock-fill"></i> Connect to unlock</div>
                        @endif
                    </div>
                </div>

                @if ($user->clerkProfile?->court_name)
                    <div class="info-row-dark">
                        <div class="info-icon-dark"><i class="bi bi-building"></i></div>
                        <div>
                            <div class="info-label-dark">Court</div>
                            <div class="info-value-dark">{{ $connected ? $user->clerkProfile->court_name : '••••• Court' }}
                            </div>
                        </div>
                    </div>
                @endif

                @if ($user->clerkProfile?->court_city)
                    <div class="info-row-dark">
                        <div class="info-icon-dark"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <div class="info-label-dark">Court City</div>
                            <div class="info-value-dark">{{ $connected ? $user->clerkProfile->court_city : '•••••' }}</div>
                        </div>
                    </div>
                @endif

                @if ($user->clerkProfile?->department)
                    <div class="info-row-dark">
                        <div class="info-icon-dark"><i class="bi bi-briefcase"></i></div>
                        <div>
                            <div class="info-label-dark">Department</div>
                            @if ($connected)
                                <div class="info-value-dark">{{ $user->clerkProfile->department }}</div>
                            @else
                                <div class="info-value-locked">•••••••••••••</div>
                                <div style="font-size:.65rem;color:rgba(212,175,55,.5);margin-top:2px;"><i
                                        class="bi bi-lock-fill"></i> Connect to unlock</div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="info-row-dark">
                    <div class="info-icon-dark"><i class="bi bi-calendar3"></i></div>
                    <div>
                        <div class="info-label-dark">Member Since</div>
                        <div class="info-value-dark">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            {{-- Bio: locked until connected --}}
            @if ($user->clerkProfile?->bio)
                <div class="info-card-dark">
                    <div class="info-card-dark-header"><i class="bi bi-person-lines-fill"></i> About</div>
                    @if ($connected)
                        <div style="padding:16px 20px;font-size:.85rem;color:rgba(255,255,255,.55);line-height:1.7;">
                            {{ $user->clerkProfile->bio }}
                        </div>
                    @else
                        <div style="padding:16px 20px;position:relative;min-height:80px;">
                            <div
                                style="font-size:.85rem;color:rgba(255,255,255,.55);line-height:1.7;filter:blur(4px);user-select:none;">
                                {{ $user->clerkProfile->bio }}
                            </div>
                            <div
                                style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;gap:6px;font-size:.8rem;color:rgba(212,175,55,.7);font-weight:600;">
                                <i class="bi bi-lock-fill"></i> Connect to read full bio
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Rating Breakdown --}}
            @if ($feedbacks->count())
                @php
                    $ratingCounts = $feedbacks->groupBy('rating')->map->count();
                    $total = $feedbacks->count();
                @endphp
                <div class="info-card-dark">
                    <div class="info-card-dark-header"><i class="bi bi-bar-chart"></i> Rating Breakdown</div>
                    <div style="padding:16px 20px;">
                        @for ($star = 5; $star >= 1; $star--)
                            @php
                                $cnt = $ratingCounts[$star] ?? 0;
                                $pct = $total ? round(($cnt / $total) * 100) : 0;
                            @endphp
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                                <span
                                    style="font-size:.7rem;font-family:monospace;color:rgba(255,255,255,.4);width:20px;">{{ $star }}★</span>
                                <div class="rating-bar">
                                    <div class="rating-bar-fill" style="width:{{ $pct }}%"></div>
                                </div>
                                <span
                                    style="font-size:.7rem;font-family:monospace;color:rgba(212,175,55,.5);width:16px;text-align:right;">{{ $cnt }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            @endif
        </div>

        {{-- Reviews --}}
        <div class="info-card-dark fu fu-3">
            <div class="info-card-dark-header" style="justify-content:space-between;">
                <span><i class="bi bi-chat-quote"></i> Reviews Received</span>
                @if ($feedbacks->count())
                    <span style="color:rgba(255,255,255,.4);font-size:.65rem;">{{ number_format($avgRating, 1) }} avg ·
                        {{ $feedbacks->count() }} reviews</span>
                @endif
            </div>

            @forelse($feedbacks as $fb)
                <div style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,.04);">
                    <div
                        style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:8px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div
                                style="width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;color:#060C18;flex-shrink:0;background:linear-gradient(135deg,#D4AF37,#B5952F);">
                                {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:.85rem;font-weight:600;color:rgba(255,255,255,.8);">
                                    {{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'Unknown' }}
                                </div>
                                <div style="font-size:.65rem;color:rgba(255,255,255,.3);">
                                    {{ $fb->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:2px;flex-shrink:0;">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }}"
                                    style="font-size:.7rem;color:{{ $i <= $fb->rating ? '#D4AF37' : 'rgba(255,255,255,.15)' }};"></i>
                            @endfor
                        </div>
                    </div>
                    @if ($fb->comment)
                        <div
                            style="background:rgba(212,175,55,.05);border-left:2px solid rgba(212,175,55,.3);border-radius:0 8px 8px 0;padding:10px 14px;font-size:.82rem;color:rgba(255,255,255,.5);line-height:1.6;">
                            "{{ $fb->comment }}"
                        </div>
                    @endif
                </div>
            @empty
                <div style="padding:48px 20px;text-align:center;">
                    <i class="bi bi-chat-square-text"
                        style="font-size:2.5rem;color:rgba(255,255,255,.1);display:block;margin-bottom:10px;"></i>
                    <p style="color:rgba(255,255,255,.3);font-size:.85rem;">No reviews yet</p>
                </div>
            @endforelse
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
                            `<div style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:10px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);font-size:.88rem;"><i class="bi bi-clock"></i> Request Sent — Awaiting Response</div>`;
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
