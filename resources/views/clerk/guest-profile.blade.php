@extends('layouts.clerk')
@section('title', $user->name . ' — Guest Profile')
@section('page-title', 'Guest Profile')

@push('styles')
    <style>
        .gp-hero {
            border-radius: 24px; overflow: hidden; margin-bottom: 24px;
            background: linear-gradient(135deg, #050812 0%, #080d1a 50%, #0b1120 100%);
            border: 1px solid rgba(180,180,254,0.1); position: relative;
        }
        .gp-hero::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 55% 60% at 85% 50%, rgba(180,180,254,0.08) 0%, transparent 65%),
                radial-gradient(ellipse 25% 40% at 5% 90%, rgba(180,180,254,0.04) 0%, transparent 60%);
        }
        .gp-grid-bg {
            position: absolute; inset: 0;
            background-image: linear-gradient(rgba(180,180,254,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(180,180,254,0.03) 1px, transparent 1px);
            background-size: 36px 36px;
        }
        .avatar-ring { position: relative; width: 88px; height: 88px; flex-shrink: 0; }
        .avatar-ring::before {
            content: ''; position: absolute; inset: -3px; border-radius: 50%;
            background: conic-gradient(#B4B4FE 0deg, #9999f0 90deg, rgba(180,180,254,0.15) 200deg, #B4B4FE 360deg);
            animation: spinRing 7s linear infinite;
        }
        .avatar-inner {
            position: absolute; inset: 3px; border-radius: 50%;
            background: linear-gradient(135deg, #B4B4FE, #9999f0);
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; font-weight: 700; color: #050812; z-index: 1;
        }
        @keyframes spinRing { to { transform: rotate(360deg); } }
        .info-card { background: #080d1a; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; }
        .info-card-header {
            padding: 14px 24px; border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: .6rem; font-family: 'Manrope', monospace; letter-spacing: .15em;
            text-transform: uppercase; color: #B4B4FE; display: flex; align-items: center; gap: 8px;
        }
        .info-row { display: flex; align-items: center; gap: 14px; padding: 14px 24px; border-bottom: 1px solid rgba(255,255,255,0.04); }
        .info-row:last-child { border-bottom: none; }
        .info-row:hover { background: rgba(255,255,255,0.02); }
        .info-icon {
            width: 32px; height: 32px; border-radius: 10px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: rgba(180,180,254,0.1); color: #B4B4FE; border: 1px solid rgba(180,180,254,0.2); font-size: .8rem;
        }
        .info-label { font-size: .55rem; font-family: 'Manrope', monospace; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 2px; }
        .info-value { font-size: .85rem; color: rgba(255,255,255,0.8); font-weight: 600; }
        .review-item { padding: 16px 24px; border-bottom: 1px solid rgba(255,255,255,0.04); }
        .review-item:last-child { border-bottom: none; }
        .review-item:hover { background: rgba(255,255,255,0.02); }
        .rating-bar { height: 5px; border-radius: 99px; background: rgba(255,255,255,0.07); flex: 1; }
        .rating-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #B4B4FE, #9999f0); }
        .stat-chip { display: flex; flex-direction: column; align-items: center; padding: 12px 20px; border-radius: 14px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); min-width: 72px; }
        .stat-val { font-size: 1.5rem; font-weight: 700; color: #B4B4FE; line-height: 1; }
        .stat-lbl { font-size: .5rem; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,0.4); margin-top: 4px; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        .fu { animation: fadeUp .35s ease both; }
        .fu-1 { animation-delay: .04s; }
        .fu-2 { animation-delay: .1s; }
        .fu-3 { animation-delay: .16s; }
    </style>
@endsection

@section('content')
    <div class="mb-4 fu">
        <a href="{{ route('clerk.guests') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all"
            style="color:rgba(255,255,255,0.5);background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08)"
            onmouseover="this.style.borderColor='rgba(180,180,254,0.4)';this.style.color='#B4B4FE'"
            onmouseout="this.style.borderColor='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.5)'">
            <i class="fas fa-arrow-left text-xs"></i> Back to Guests
        </a>
    </div>

    <div class="gp-hero fu fu-1">
        <div class="gp-grid-bg"></div>
        <div class="relative z-10 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="avatar-ring"><div class="avatar-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div></div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 flex-wrap mb-2">
                        <span class="font-mono text-[.55rem] tracking-[.2em] uppercase px-3 py-1.5 rounded-full"
                            style="background:rgba(180,180,254,0.12);border:1px solid rgba(180,180,254,0.3);color:#B4B4FE">
                            Guest User
                        </span>
                        @if ($user->status === 'active')
                            <span class="flex items-center gap-1.5 font-mono text-[.55rem] tracking-widest uppercase px-3 py-1.5 rounded-full"
                                style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);color:#4ade80">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Active
                            </span>
                        @endif
                    </div>
                    <h1 class="font-bold text-white mb-1" style="font-size:clamp(1.4rem,3vw,2rem);">{{ $user->name }}</h1>
                    <p class="text-sm flex items-center gap-2 flex-wrap" style="color:rgba(255,255,255,0.4)">
                        <span><i class="fas fa-envelope text-xs" style="color:#B4B4FE"></i> {{ $user->email }}</span>
                        @if ($user->city) <span>·</span> <span><i class="fas fa-map-marker-alt text-xs" style="color:#B4B4FE"></i> {{ $user->city }}</span> @endif
                        <span>·</span> <span>Member since {{ $user->created_at->format('M Y') }}</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <div class="stat-chip"><div class="stat-val">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div><div class="stat-lbl">Avg Rating</div></div>
                    <div class="stat-chip"><div class="stat-val">{{ $feedbacks->count() }}</div><div class="stat-lbl">Reviews</div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2 space-y-5 fu fu-2">
            <div class="info-card">
                <div class="info-card-header"><i class="fas fa-id-card"></i> Contact Details</div>
                <div class="info-row"><div class="info-icon"><i class="fas fa-envelope"></i></div><div><div class="info-label">Email</div><div class="info-value break-all">{{ $user->email }}</div></div>
                @if ($user->phone) <div class="info-row"><div class="info-icon"><i class="fas fa-phone"></i></div><div><div class="info-label">Phone</div><div class="info-value">{{ $user->phone }}</div></div> @endif
                @if ($user->city) <div class="info-row"><div class="info-icon"><i class="fas fa-map-marker-alt"></i></div><div><div class="info-label">City</div><div class="info-value">{{ $user->city }}</div></div> @endif
                <div class="info-row"><div class="info-icon"><i class="fas fa-calendar"></i></div><div><div class="info-label">Member Since</div><div class="info-value">{{ $user->created_at->format('d M Y') }}</div></div></div>
                <div class="info-row"><div class="info-icon"><i class="fas fa-clock"></i></div><div><div class="info-label">Last Active</div><div class="info-value">{{ $user->updated_at->diffForHumans() }}</div></div></div>
            </div>

            @php
                $reqId = 'null';
                if (in_array($connectionStatus, ['received', 'sent', 'connected'])) {
                    $existingReq = \App\Models\ConnectionRequest::where(function ($q) use ($user) {
                        $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
                    })->orWhere(function ($q) use ($user) {
                        $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
                    })->first();
                    if ($existingReq) { $reqId = $existingReq->id; }
                }
            @endphp

            <div x-data="profileConnection('{{ $connectionStatus }}', {{ $user->id }}, {{ $reqId }})" class="info-card p-5">
                <div class="info-card-header p-0! mb-3!"><i class="fas fa-network-wired"></i> Network Status</div>
                <template x-if="status === 'none'">
                    <button @click="sendReq()" class="btn-primary w-full justify-center">
                        <i class="fas fa-user-plus"></i> Connect
                    </button>
                </template>
                <template x-if="status === 'sent'">
                    <button disabled class="w-full py-3 rounded-xl text-sm font-bold flex justify-center items-center gap-2 bg-white/5 border border-white/10 text-white/40 cursor-not-allowed">
                        <i class="fas fa-clock"></i> Request Sent
                    </button>
                </template>
                <template x-if="status === 'received'">
                    <button @click="acceptReq()" class="btn-primary w-full justify-center" style="background:#10b981;">
                        <i class="fas fa-check-circle"></i> Accept Request
                    </button>
                </template>
                <template x-if="status === 'connected'">
                    <button disabled class="w-full py-3 rounded-xl text-sm font-bold flex justify-center items-center gap-2 bg-green-500/10 border border-green-500/20 text-green-400 cursor-default">
                        <i class="fas fa-check-circle"></i> You are Connected
                    </button>
                </template>
            </div>

            @if ($feedbacks->count() > 0)
                @php $ratingCounts = $feedbacks->groupBy('rating')->map->count(); $total = $feedbacks->count(); @endphp
                <div class="info-card">
                    <div class="info-card-header"><i class="fas fa-chart-bar"></i> Rating Breakdown</div>
                    <div class="px-5 py-4 space-y-2.5">
                        @for ($star = 5; $star >= 1; $star--)
                            @php $cnt = $ratingCounts[$star] ?? 0; $pct = $total ? round(($cnt / $total) * 100) : 0; @endphp
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1 w-12 shrink-0"><span class="text-xs font-mono text-white/50">{{ $star }}</span><i class="fas fa-star text-xs" style="color:#B4B4FE"></i></div>
                                <div class="rating-bar flex-1"><div class="rating-bar-fill" style="width:{{ $pct }}%"></div></div>
                                <span class="text-xs font-semibold text-white/50 w-6 text-right shrink-0">{{ $cnt }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            @endif

            <div class="rounded-2xl p-4" style="background:rgba(180,180,254,0.04);border:1px solid rgba(180,180,254,0.12)">
                <div class="flex gap-3"><i class="fas fa-info-circle text-blue mt-0.5 shrink-0" style="color:#B4B4FE"></i><p class="text-xs text-white/50 leading-relaxed">Guest users browse advocates & clerks on DockIt. They give feedback to unlock contact details.</p></div>
            </div>
        </div>

        <div class="lg:col-span-3 fu fu-3">
            <div class="info-card">
                <div class="info-card-header justify-between">
                    <span class="flex items-center gap-2"><i class="fas fa-comment-quote"></i> Reviews Received</span>
                    @if ($feedbacks->count())
                        <span class="flex items-center gap-2">
                            <span class="flex gap-0.5">
                                @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star{{ $avgRating && $i <= round($avgRating) ? '' : '-empty' }} text-xs" style="color:{{ $avgRating && $i <= round($avgRating) ? '#B4B4FE' : 'rgba(255,255,255,0.12)' }}"></i> @endfor
                            </span>
                            <span class="font-bold" style="color:#B4B4FE">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-white/25" style="font-size:.65rem">({{ $feedbacks->count() }})</span>
                        </span>
                    @endif
                </div>
                @forelse($feedbacks as $fb)
                    <div class="review-item">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0 text-navy" style="background:linear-gradient(135deg,#B4B4FE,#9999f0)">
                                    {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-white text-sm">{{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'Unknown' }}</div>
                                    <div class="text-xs text-white/40">{{ !$fb->is_anonymous && $fb->giver ? ucfirst($fb->giver->role) : 'DockIt User' }}</div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1 shrink-0">
                                <div class="flex gap-0.5">@for ($i = 1; $i <= 5; $i++) <i class="fas fa-star{{ $i <= $fb->rating ? '' : '-empty' }} text-xs" style="color:{{ $i <= $fb->rating ? '#B4B4FE' : 'rgba(255,255,255,0.1)' }}"></i> @endfor</div>
                                <span class="text-xs text-white/40">{{ $fb->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if ($fb->comment) <div class="rounded-lg px-4 py-3 text-sm" style="background:rgba(180,180,254,0.07);border-left:2px solid #B4B4FE;color:rgba(255,255,255,0.55);">"{{ $fb->comment }}"</div> @endif
                    </div>
                @empty
                    <div class="py-16 text-center"><i class="fas fa-comment-slash text-5xl text-white/10 block mb-3"></i><p class="text-white/40 font-medium">No reviews yet</p></div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function profileConnection(initialStatus, userId, reqId) {
                return {
                    status: initialStatus, requestId: reqId,
                    async sendReq() {
                        try { const res = await fetch(`{{ route('connections.send') }}`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ receiver_id: userId }) });
                            if (res.ok) this.status = 'sent';
                        } catch (e) { console.error(e); }
                    },
                    async acceptReq() {
                        if (!this.requestId) return;
                        try { const res = await fetch(`/connections/${this.requestId}/accept`, { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } });
                            if (res.ok) this.status = 'connected';
                        } catch (e) { console.error(e); }
                    }
                }
            }
        </script>
    @endpush
@endsection