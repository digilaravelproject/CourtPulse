@extends('layouts.advocate')
@section('title', $user->name . ' — Clerk Profile')
@section('page-title', 'Clerk Profile')

@push('styles')
    <style>
        .cp-hero {
            border-radius: 24px;
            overflow: hidden;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #050812 0%, #080d1a 50%, #0b1120 100%);
            border: 1px solid rgba(180,180,254,0.1);
            position: relative;
        }
        .cp-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 55% 60% at 85% 50%, rgba(180,180,254,0.08) 0%, transparent 65%),
                radial-gradient(ellipse 25% 40% at 5% 90%, rgba(180,180,254,0.04) 0%, transparent 60%);
            pointer-events: none;
        }
        .cp-grid-bg {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(180,180,254,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(180,180,254,0.03) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
        }
        .avatar-ring { position: relative; width: 80px; height: 80px; flex-shrink: 0; }
        .avatar-ring::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(#B4B4FE 0deg, #9999f0 90deg, rgba(180,180,254,0.15) 200deg, #B4B4FE 360deg);
            animation: spinRing 7s linear infinite;
        }
        .avatar-inner {
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, #B4B4FE, #9999f0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 800;
            color: #050812;
            z-index: 1;
        }
        @keyframes spinRing { to { transform: rotate(360deg); } }
        .info-card-dark {
            background: #080d1a;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            overflow: hidden;
        }
        .info-card-dark-header {
            padding: 14px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: .6rem;
            font-family: 'Manrope', monospace;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: #B4B4FE;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-row-dark {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: background .15s;
        }
        .info-row-dark:last-child { border-bottom: none; }
        .info-row-dark:hover { background: rgba(255,255,255,0.02); }
        .info-icon-dark {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(180,180,254,0.1);
            color: #B4B4FE;
            border: 1px solid rgba(180,180,254,0.2);
            font-size: .8rem;
        }
        .info-label-dark {
            font-size: .58rem;
            font-family: 'Manrope', monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            margin-bottom: 2px;
        }
        .info-value-dark {
            font-size: .85rem;
            color: rgba(255,255,255,0.8);
            font-weight: 600;
        }
        .info-value-locked {
            font-size: .85rem;
            color: rgba(255,255,255,0.2);
            filter: blur(3px);
            user-select: none;
        }
        .stat-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 12px 20px;
            border-radius: 14px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            min-width: 72px;
        }
        .stat-val {
            font-size: 1.4rem;
            font-weight: 800;
            color: #B4B4FE;
            line-height: 1;
        }
        .stat-lbl {
            font-size: .5rem;
            font-family: 'Manrope', monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            margin-top: 4px;
        }
        .rating-bar {
            height: 4px;
            border-radius: 99px;
            background: rgba(255,255,255,0.06);
            flex: 1;
            overflow: hidden;
        }
        .rating-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #B4B4FE, #9999f0);
        }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .fu { animation: fadeUp .3s ease both; }
        .fu-1 { animation-delay: .04s; }
        .fu-2 { animation-delay: .1s; }
        .fu-3 { animation-delay: .16s; }
    </style>
@endsection

@section('content')
    <div class="mb-4 fu">
        <a href="{{ route('advocate.search.clerks') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all"
            style="color:rgba(255,255,255,0.5);background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08)"
            onmouseover="this.style.borderColor='rgba(180,180,254,0.4)';this.style.color='#B4B4FE'"
            onmouseout="this.style.borderColor='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.5)'">
            <i class="fas fa-arrow-left text-xs"></i> Back to Clerks
        </a>
    </div>

    <div class="cp-hero fu fu-1">
        <div class="cp-grid-bg"></div>
        <div style="position:relative;z-index:1;padding:32px;">
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:24px;">
                <div class="avatar-ring">
                    <div class="avatar-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:8px;">
                        <span class="font-mono text-[.55rem] tracking-[.2em] uppercase px-3 py-1.5 rounded-full"
                            style="background:rgba(180,180,254,0.12);border:1px solid rgba(180,180,254,0.3);color:#B4B4FE;font-family:'Manrope';">
                            Court Clerk
                        </span>
                        @if ($user->status === 'active')
                            <span class="flex items-center gap-1.5 font-mono text-[.55rem] tracking-widest uppercase px-3 py-1.5 rounded-full"
                                style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);color:#4ade80;">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span>
                                Verified
                            </span>
                        @endif
                        @if ($connected)
                            <span class="flex items-center gap-1.5 font-mono text-[.55rem] tracking-widest uppercase px-3 py-1.5 rounded-full"
                                style="background:rgba(180,180,254,0.15);border:1px solid rgba(180,180,254,0.4);color:#B4B4FE;">
                                <i class="fas fa-check-circle"></i> Connected
                            </span>
                        @endif
                    </div>
                    <h1 class="text-white font-bold mb-1" style="font-size:clamp(1.4rem,3vw,2rem);">
                        {{ $user->name }}</h1>
                    <p class="text-sm" style="color:rgba(255,255,255,0.4);display:flex;gap:14px;flex-wrap:wrap;">
                        @if ($user->clerkProfile?->court_name)
                            <span><i class="fas fa-building" style="color:#B4B4FE;margin-right:6px;"></i>
                                {{ $connected ? $user->clerkProfile->court_name : '••••• Court' }}
                            </span>
                        @endif
                        @if ($user->clerkProfile?->court_city || $user->city)
                            <span><i class="fas fa-map-marker-alt" style="color:#B4B4FE;margin-right:6px;"></i>
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

            <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;">
                @if ($connectionStatus === 'none')
                    <button id="connectBtn" onclick="sendConnectProfile({{ $user->id }})"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-bold transition-all"
                        style="background:linear-gradient(135deg,#B4B4FE,#9999f0);color:#050812">
                        <i class="fas fa-user-plus"></i> Send Connect Request
                    </button>
                @elseif($connectionStatus === 'sent')
                    <div class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.5);">
                        <i class="fas fa-clock"></i> Request Pending
                    </div>
                @elseif($connectionStatus === 'received')
                    <button onclick="handleReq({{ $connectionReq?->id }}, 'accept')"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-bold transition-all"
                        style="background:#10b981;color:#ffffff;">
                        <i class="fas fa-check"></i> Accept Request
                    </button>
                    <button onclick="handleReq({{ $connectionReq?->id }}, 'reject')"
                        class="inline-flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold"
                        style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;">
                        <i class="fas fa-times"></i> Reject
                    </button>
                @elseif($connectionStatus === 'connected')
                    <div class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold"
                        style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.25);color:#4ade80;">
                        <i class="fas fa-check-circle"></i> Connected — Full details unlocked
                    </div>
                @endif
            </div>

            @if (!$connected)
                <div class="mt-5 p-4 rounded-xl flex items-center gap-3"
                    style="background:rgba(180,180,254,0.08);border:1px solid rgba(180,180,254,0.2);">
                    <i class="fas fa-info-circle" style="color:#B4B4FE;font-size:1rem;flex-shrink:0;"></i>
                    <span class="text-sm" style="color:rgba(255,255,255,0.5);">
                        Send a connection request to unlock full profile details, contact information, and more.
                    </span>
                </div>
            @endif
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr;gap:24px;" class="fu fu-2">
        <div style="display:grid;grid-template-columns:1fr;gap:20px;">
            <div class="info-card-dark">
                <div class="info-card-dark-header"><i class="fas fa-id-card"></i> Contact Details</div>
                <div class="info-row-dark">
                    <div class="info-icon-dark"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="info-label-dark">Email</div>
                        @if ($connected)
                            <div class="info-value-dark">{{ $user->email }}</div>
                        @else
                            <div class="info-value-locked">{{ str_repeat('•', strlen($user->email)) }}</div>
                            <div class="text-xs mt-1" style="color:rgba(180,180,254,0.5);"><i class="fas fa-lock"></i> Connect to unlock</div>
                        @endif
                    </div>
                </div>
                <div class="info-row-dark">
                    <div class="info-icon-dark"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="info-label-dark">Phone</div>
                        @if ($connected)
                            <div class="info-value-dark">{{ $user->phone ?? 'Not provided' }}</div>
                        @else
                            <div class="info-value-locked">••••••••••</div>
                            <div class="text-xs mt-1" style="color:rgba(180,180,254,0.5);"><i class="fas fa-lock"></i> Connect to unlock</div>
                        @endif
                    </div>
                </div>
                @if ($user->clerkProfile?->court_name)
                    <div class="info-row-dark">
                        <div class="info-icon-dark"><i class="fas fa-building"></i></div>
                        <div>
                            <div class="info-label-dark">Court</div>
                            <div class="info-value-dark">{{ $connected ? $user->clerkProfile->court_name : '••••• Court' }}</div>
                        </div>
                    </div>
                @endif
                @if ($user->clerkProfile?->court_city)
                    <div class="info-row-dark">
                        <div class="info-icon-dark"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="info-label-dark">Court City</div>
                            <div class="info-value-dark">{{ $connected ? $user->clerkProfile->court_city : '•••••' }}</div>
                        </div>
                    </div>
                @endif
                @if ($user->clerkProfile?->department)
                    <div class="info-row-dark">
                        <div class="info-icon-dark"><i class="fas fa-briefcase"></i></div>
                        <div>
                            <div class="info-label-dark">Department</div>
                            @if ($connected)
                                <div class="info-value-dark">{{ $user->clerkProfile->department }}</div>
                            @else
                                <div class="info-value-locked">•••••••••••••</div>
                                <div class="text-xs mt-1" style="color:rgba(180,180,254,0.5);"><i class="fas fa-lock"></i> Connect to unlock</div>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="info-row-dark">
                    <div class="info-icon-dark"><i class="fas fa-calendar"></i></div>
                    <div>
                        <div class="info-label-dark">Member Since</div>
                        <div class="info-value-dark">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            @if ($user->clerkProfile?->bio)
                <div class="info-card-dark">
                    <div class="info-card-dark-header"><i class="fas fa-user"></i> About</div>
                    @if ($connected)
                        <div style="padding:18px 24px;font-size:.85rem;color:rgba(255,255,255,0.55);line-height:1.7;">
                            {{ $user->clerkProfile->bio }}
                        </div>
                    @else
                        <div style="padding:18px 24px;position:relative;min-height:80px;">
                            <div style="font-size:.85rem;color:rgba(255,255,255,0.55);line-height:1.7;filter:blur(4px);user-select:none;">
                                {{ $user->clerkProfile->bio }}
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center gap-2 text-sm font-semibold" style="color:rgba(180,180,254,0.7);">
                                <i class="fas fa-lock"></i> Connect to read full bio
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
                <div class="info-card-dark">
                    <div class="info-card-dark-header"><i class="fas fa-chart-bar"></i> Rating Breakdown</div>
                    <div style="padding:18px 24px;">
                        @for ($star = 5; $star >= 1; $star--)
                            @php
                                $cnt = $ratingCounts[$star] ?? 0;
                                $pct = $total ? round(($cnt / $total) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-3 mb-2.5">
                                <span class="font-mono text-xs" style="color:rgba(255,255,255,0.4);width:24px;">{{ $star }}★</span>
                                <div class="rating-bar flex-1">
                                    <div class="rating-bar-fill" style="width:{{ $pct }}%"></div>
                                </div>
                                <span class="font-mono text-xs" style="color:rgba(180,180,254,0.5);width:20px;text-align:right;">{{ $cnt }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            @endif
        </div>

        <div class="info-card-dark fu fu-3">
            <div class="info-card-dark-header" style="justify-content:space-between;">
                <span><i class="fas fa-comment-quote"></i> Reviews Received</span>
                @if ($feedbacks->count())
                    <span style="color:rgba(255,255,255,0.4);font-size:.65rem;">{{ number_format($avgRating, 1) }} avg · {{ $feedbacks->count() }} reviews</span>
                @endif
            </div>

            @forelse($feedbacks as $fb)
                <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,0.04);">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0 text-navy"
                                style="background:linear-gradient(135deg,#B4B4FE,#9999f0);">
                                {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-sm text-white">{{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'Unknown' }}</div>
                                <div class="font-mono text-[.52rem]" style="color:rgba(255,255,255,0.3);">{{ $fb->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="flex gap-0.5 shrink-0;">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $fb->rating ? '' : '-empty' }}"
                                    style="font-size:.7rem;color:{{ $i <= $fb->rating ? '#B4B4FE' : 'rgba(255,255,255,0.15)' }};"></i>
                            @endfor
                        </div>
                    </div>
                    @if ($fb->comment)
                        <div class="rounded-lg px-4 py-3 text-sm" style="background:rgba(180,180,254,0.05);border-left:2px solid #B4B4FE;color:rgba(255,255,255,0.55);">
                            "{{ $fb->comment }}"
                        </div>
                    @endif
                </div>
            @empty
                <div style="padding:48px 24px;text-align:center;">
                    <i class="fas fa-comment-slash" style="font-size:2.5rem;color:rgba(255,255,255,0.1);display:block;margin-bottom:12px;"></i>
                    <p class="text-sm" style="color:rgba(255,255,255,0.3);">No reviews yet</p>
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
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                fetch('{{ route('connections.send') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ receiver_id: userId })
                })
                .then(r => r.json())
                .then(() => {
                    btn.outerHTML = '<div class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.5);"><i class="fas fa-clock"></i> Request Sent — Awaiting Response</div>';
                })
                .catch(() => { btn.disabled = false; btn.innerHTML = '<i class="fas fa-user-plus"></i> Send Connect Request'; });
            }
            function handleReq(reqId, action) {
                fetch(`/connections/${reqId}/${action}`, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                }).then(() => location.reload());
            }
        </script>
    @endpush
@endsection