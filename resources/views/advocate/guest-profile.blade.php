@extends('layouts.advocate')
@section('title', $user->name . ' — Guest Profile')
@section('page-title', 'Guest Profile')

@push('styles')
    <style>
        .gp-hero {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #050812 0%, #080d1a 60%, #0b1120 100%);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .gp-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 50% at 80% 50%, rgba(180,180,254,0.08) 0%, transparent 70%),
                radial-gradient(ellipse 30% 60% at 10% 80%, rgba(180,180,254,0.04) 0%, transparent 60%);
            pointer-events: none;
        }
        .gp-hero-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(180,180,254,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(180,180,254,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }
        .gp-avatar-ring { position: relative; width: 96px; height: 96px; }
        .gp-avatar-ring::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(#B4B4FE 0deg, #9999f0 90deg, rgba(180,180,254,0.2) 180deg, #B4B4FE 360deg);
            animation: spin 6s linear infinite;
        }
        .gp-avatar-inner {
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, #080d1a, #0b1120);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            font-weight: 700;
            color: #B4B4FE;
            z-index: 1;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .gp-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 14px 24px;
            border-radius: 14px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            min-width: 88px;
        }
        .gp-stat-val { font-size: 1.5rem; font-weight: 700; color: #B4B4FE; line-height: 1; }
        .gp-stat-lbl { font-size: .52rem; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,0.3); }
        .gp-info-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .gp-info-row:last-child { border-bottom: none; }
        .gp-info-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: .85rem;
            background: rgba(180,180,254,0.1);
            color: #B4B4FE;
            border: 1px solid rgba(180,180,254,0.2);
        }
        .gp-info-label {
            font-size: .52rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            margin-bottom: 2px;
        }
        .gp-info-value { font-size: .85rem; color: rgba(255,255,255,0.85); font-weight: 600; word-break: break-all; }
        .review-card {
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px;
            padding: 18px;
            transition: all .2s;
        }
        .review-card:hover { background: rgba(255,255,255,0.04); border-color: rgba(180,180,254,0.2); transform: translateY(-1px); }
        .star-row { display: flex; gap: 2px; }
        .star-row i { font-size: .75rem; }
        .rating-bar-track { height: 4px; border-radius: 99px; background: rgba(255,255,255,0.07); flex: 1; overflow: hidden; }
        .rating-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #B4B4FE, #9999f0); transition: width .6s cubic-bezier(.4, 0, .2, 1); }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp .4s ease both; }
        .fade-up-1 { animation-delay: .05s; }
        .fade-up-2 { animation-delay: .12s; }
        .fade-up-3 { animation-delay: .18s; }
        .fade-up-4 { animation-delay: .24s; }
    </style>
@endsection

@section('content')
    <div class="mb-4 fade-up">
        <a href="{{ route('advocate.guests') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all"
            style="color:rgba(255,255,255,0.35);background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08)"
            onmouseover="this.style.color='rgba(255,255,255,0.8)';this.style.borderColor='rgba(180,180,254,0.3)'"
            onmouseout="this.style.color='rgba(255,255,255,0.35)';this.style.borderColor='rgba(255,255,255,0.08)'">
            <i class="fas fa-arrow-left text-xs"></i> Back to Guests
        </a>
    </div>

    <div class="gp-hero fade-up fade-up-1">
        <div class="gp-hero-grid"></div>
        <div class="relative z-10 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="gp-avatar-ring shrink-0">
                    <div class="gp-avatar-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 flex-wrap mb-2">
                        <span class="font-mono text-[.55rem] tracking-[.2em] uppercase px-3 py-1.5 rounded-full"
                            style="background:rgba(180,180,254,0.12);border:1px solid rgba(180,180,254,0.25);color:#B4B4FE">
                            Guest User
                        </span>
                        @if ($user->status === 'active')
                            <span class="flex items-center gap-1.5 font-mono text-[.55rem] tracking-widest uppercase px-3 py-1.5 rounded-full"
                                style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);color:#4ade80">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse inline-block"></span>
                                Active
                            </span>
                        @endif
                    </div>
                    <h1 class="text-white font-bold mb-1" style="font-size:clamp(1.4rem,3vw,2rem);">
                        {{ $user->name }}</h1>
                    <p class="text-sm" style="color:rgba(255,255,255,0.35)">
                        {{ $user->email }}
                        @if ($user->city)
                            &nbsp;·&nbsp; <i class="fas fa-map-marker-alt" style="color:#B4B4FE"></i> {{ $user->city }}
                        @endif
                        &nbsp;·&nbsp; Member since {{ $user->created_at->format('M Y') }}
                    </p>
                </div>
                <div class="flex gap-3 shrink-0">
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

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 space-y-5 fade-up fade-up-2">
            <div class="rounded-2xl p-5" style="background:#080d1a;border:1px solid rgba(255,255,255,0.05)">
                <div class="font-mono text-[.55rem] tracking-[.18em] uppercase mb-4 flex items-center gap-2" style="color:rgba(180,180,254,0.5)">
                    <i class="fas fa-id-card"></i> Contact Details
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="gp-info-label">Email</div>
                        <div class="gp-info-value">{{ $user->email }}</div>
                    </div>
                </div>
                @if ($user->phone)
                    <div class="gp-info-row">
                        <div class="gp-info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <div class="gp-info-label">Phone</div>
                            <div class="gp-info-value">{{ $user->phone }}</div>
                        </div>
                    </div>
                @endif
                @if ($user->city)
                    <div class="gp-info-row">
                        <div class="gp-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="gp-info-label">City</div>
                            <div class="gp-info-value">{{ $user->city }}</div>
                        </div>
                    </div>
                @endif
                <div class="gp-info-row">
                    <div class="gp-info-icon"><i class="fas fa-calendar"></i></div>
                    <div>
                        <div class="gp-info-label">Joined</div>
                        <div class="gp-info-value">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="gp-info-label">Last Active</div>
                        <div class="gp-info-value">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            @php
                $reqId = 'null';
                if (in_array($connectionStatus, ['received', 'sent', 'connected'])) {
                    $existingReq = \App\Models\ConnectionRequest::where(function ($q) use ($user) {
                        $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
                    })
                    ->orWhere(function ($q) use ($user) {
                        $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
                    })
                    ->first();
                    if ($existingReq) { $reqId = $existingReq->id; }
                }
            @endphp

            <div x-data="profileConnection('{{ $connectionStatus }}', {{ $user->id }}, {{ $reqId }})" class="rounded-2xl p-5" style="background:#080d1a;border:1px solid rgba(255,255,255,0.05)">
                <div class="font-mono text-[.55rem] tracking-[.18em] uppercase mb-4 flex items-center gap-2" style="color:rgba(180,180,254,0.5)">
                    <i class="fas fa-network-wired"></i> Network
                </div>
                <template x-if="status === 'none'">
                    <button @click="sendReq()" class="w-full py-3 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2" style="background:#B4B4FE;color:#050812">
                        <i class="fas fa-user-plus"></i> Connect
                    </button>
                </template>
                <template x-if="status === 'sent'">
                    <button disabled class="w-full py-3 rounded-xl text-sm font-bold flex justify-center items-center gap-2" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.4);cursor:not-allowed">
                        <i class="fas fa-clock"></i> Request Sent
                    </button>
                </template>
                <template x-if="status === 'received'">
                    <button @click="acceptReq()" class="w-full py-3 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2" style="background:#10b981;color:#ffffff">
                        <i class="fas fa-check-circle"></i> Accept Request
                    </button>
                </template>
                <template x-if="status === 'connected'">
                    <button disabled class="w-full py-3 rounded-xl text-sm font-bold flex justify-center items-center gap-2" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#4ade80;cursor:default">
                        <i class="fas fa-check-circle"></i> You are Connected
                    </button>
                </template>
            </div>

            @if ($feedbacks->count() > 0)
                <div class="rounded-2xl p-5" style="background:#080d1a;border:1px solid rgba(255,255,255,0.05)">
                    <div class="font-mono text-[.55rem] tracking-[.18em] uppercase mb-4 flex items-center gap-2" style="color:rgba(180,180,254,0.5)">
                        <i class="fas fa-chart-bar"></i> Rating Breakdown
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
                            <div class="flex items-center gap-1 w-14 shrink-0">
                                <span class="font-mono text-xs" style="color:rgba(255,255,255,0.5)">{{ $star }}</span>
                                <i class="fas fa-star text-xs" style="color:#B4B4FE"></i>
                            </div>
                            <div class="rating-bar-track">
                                <div class="rating-bar-fill" style="width:{{ $pct }}%"></div>
                            </div>
                            <span class="font-mono text-xs w-8 text-right shrink-0" style="color:rgba(180,180,254,0.6)">{{ $cnt }}</span>
                        </div>
                    @endfor
                </div>
            @endif

            <div class="rounded-2xl p-4" style="background:rgba(180,180,254,0.04);border:1px solid rgba(180,180,254,0.12)">
                <div class="flex gap-3">
                    <i class="fas fa-shield-alt mt-0.5 shrink-0" style="color:#B4B4FE"></i>
                    <p class="text-xs leading-relaxed" style="color:rgba(255,255,255,0.5)">
                        Guest users browse advocates & clerks on DockIt. They give feedback to unlock contact details.
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 fade-up fade-up-3">
            <div class="rounded-2xl p-5" style="background:#080d1a;border:1px solid rgba(255,255,255,0.05)">
                <div class="flex items-center justify-between mb-5">
                    <div class="font-mono text-[.55rem] tracking-[.18em] uppercase flex items-center gap-2" style="color:rgba(180,180,254,0.5)">
                        <i class="fas fa-comment-quote"></i> Reviews Received
                    </div>
                    @if ($feedbacks->count())
                        <div class="flex items-center gap-2">
                            <div class="flex gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $avgRating && $i <= round($avgRating) ? '' : '-empty' }} text-xs"
                                        style="color:{{ $avgRating && $i <= round($avgRating) ? '#B4B4FE' : 'rgba(255,255,255,0.12)' }}"></i>
                                @endfor
                            </div>
                            <span class="font-mono text-xs font-bold" style="color:#B4B4FE">{{ number_format($avgRating, 1) }}</span>
                            <span class="font-mono text-[.6rem]" style="color:rgba(255,255,255,0.25)">({{ $feedbacks->count() }})</span>
                        </div>
                    @endif
                </div>

                @forelse($feedbacks as $fb)
                    <div class="review-card mb-3">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0"
                                    style="background:rgba(180,180,254,0.15);border:1px solid rgba(180,180,254,0.2);color:#B4B4FE">
                                    {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-sm text-white">{{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'Unknown' }}</div>
                                    <div class="font-mono text-[.52rem] tracking-widest uppercase" style="color:rgba(180,180,254,0.5)">
                                        @if (!$fb->is_anonymous && $fb->giver)
                                            {{ ucfirst($fb->giver->role) }}
                                        @else
                                            DockIt User
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 shrink-0">
                                <div class="star-row">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $fb->rating ? '' : '-empty' }}"
                                            style="color:{{ $i <= $fb->rating ? '#B4B4FE' : 'rgba(255,255,255,0.1)' }}"></i>
                                    @endfor
                                </div>
                                <span class="font-mono text-[.52rem]" style="color:rgba(180,180,254,0.4)">{{ $fb->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if ($fb->comment)
                            <div class="rounded-lg px-4 py-3 text-sm" style="background:rgba(180,180,254,0.07);border-left:2px solid #B4B4FE;color:rgba(255,255,255,0.55);">
                                "{{ $fb->comment }}"
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-14 text-center">
                        <i class="fas fa-comment-slash" style="font-size:2.5rem;color:rgba(255,255,255,0.1);display:block;margin-bottom:12px;"></i>
                        <p class="font-medium text-sm" style="color:rgba(255,255,255,0.3);">No reviews yet</p>
                        <p class="text-xs" style="color:rgba(255,255,255,0.25);">This guest hasn't received any feedback yet.</p>
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
                    async sendReq() {
                        try {
                            const res = await fetch(`{{ route('connections.send') }}`, {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                body: JSON.stringify({ receiver_id: userId })
                            });
                            if (res.ok) this.status = 'sent';
                        } catch (e) { console.error(e); }
                    },
                    async acceptReq() {
                        if (!this.requestId) return;
                        try {
                            const res = await fetch(`/connections/${this.requestId}/accept`, {
                                method: 'PATCH',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                            });
                            if (res.ok) this.status = 'connected';
                        } catch (e) { console.error(e); }
                    }
                }
            }
        </script>
    @endpush
@endsection