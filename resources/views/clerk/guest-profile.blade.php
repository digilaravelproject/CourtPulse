@extends('layouts.clerk')
@section('title', $user->name . ' — Guest Profile')
@section('page-title', 'Guest Profile')

@push('styles')
    <style>
        .gp-hero-light {
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #060C18 0%, #0F1A2E 50%, #1a1a08 100%);
            border: 1px solid rgba(212, 175, 55, .15);
            position: relative;
        }

        .gp-hero-light::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 55% 60% at 85% 50%, rgba(212, 175, 55, .15) 0%, transparent 65%),
                radial-gradient(ellipse 25% 40% at 5% 90%, rgba(212, 175, 55, .06) 0%, transparent 60%);
            pointer-events: none;
        }

        .gp-grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(212, 175, 55, .04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 175, 55, .04) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
        }

        .avatar-spin-ring {
            position: relative;
            width: 88px;
            height: 88px;
            flex-shrink: 0;
        }

        .avatar-spin-ring::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: conic-gradient(#D4AF37 0deg, #B5952F 90deg, rgba(212, 175, 55, .15) 200deg, #D4AF37 360deg);
            animation: spinRing 7s linear infinite;
        }

        .avatar-spin-inner {
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37, #B5952F);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
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

        .info-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }

        .info-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: .65rem;
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
            width: 32px;
            height: 32px;
            border-radius: 9px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(212, 175, 55, .08);
            color: #B5952F;
            border: 1px solid rgba(212, 175, 55, .15);
            font-size: .8rem;
        }

        .info-label {
            font-size: .6rem;
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

        .review-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item:hover {
            background: #fafbfc;
        }

        .rating-bar {
            height: 5px;
            border-radius: 99px;
            background: #f1f5f9;
            flex: 1;
            overflow: hidden;
        }

        .rating-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #D4AF37, #B5952F);
        }

        .stat-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 12px 18px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .1);
            min-width: 72px;
        }

        .stat-val {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #D4AF37;
            line-height: 1;
        }

        .stat-lbl {
            font-size: .5rem;
            font-family: monospace;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .4);
            margin-top: 3px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .fu {
            animation: fadeUp .35s ease both;
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
        <a href="{{ route('clerk.guests') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium border border-gray-200 bg-white text-text-muted-light hover:text-gray-800 hover:border-gray-300 transition-all shadow-sm">
            <i class="bi bi-arrow-left text-xs"></i> Back to Guests
        </a>
    </div>

    {{-- ── HERO BANNER ── --}}
    <div class="gp-hero-light fu fu-1">
        <div class="gp-grid-bg"></div>
        <div class="relative z-10 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">

                {{-- Spinning avatar --}}
                <div class="avatar-spin-ring">
                    <div class="avatar-spin-inner">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-1.5">
                        <span class="font-mono text-[.55rem] tracking-[.2em] uppercase px-2.5 py-1 rounded-full"
                            style="background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.3);color:#D4AF37">
                            Guest User
                        </span>
                        @if ($user->status === 'active')
                            <span
                                class="flex items-center gap-1.5 font-mono text-[.55rem] tracking-widest uppercase px-2.5 py-1 rounded-full"
                                style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#4ade80">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse inline-block"></span>
                                Active
                            </span>
                        @endif
                    </div>
                    <h1 class="font-display font-bold text-white mb-1.5" style="font-size:clamp(1.4rem,3vw,2rem)">
                        {{ $user->name }}</h1>
                    <p class="text-sm flex items-center gap-2 flex-wrap" style="color:rgba(255,255,255,.4)">
                        <span><i class="bi bi-envelope-fill text-xs" style="color:#D4AF37"></i> {{ $user->email }}</span>
                        @if ($user->city)
                            <span>·</span>
                            <span><i class="bi bi-geo-alt-fill text-xs" style="color:#D4AF37"></i>
                                {{ $user->city }}</span>
                        @endif
                        <span>·</span>
                        <span>Member since {{ $user->created_at->format('M Y') }}</span>
                    </p>
                </div>

                {{-- Stats --}}
                <div class="flex gap-3">
                    <div class="stat-chip">
                        <div class="stat-val">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
                        <div class="stat-lbl">Avg Rating</div>
                    </div>
                    <div class="stat-chip">
                        <div class="stat-val">{{ $feedbacks->count() }}</div>
                        <div class="stat-lbl">Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- SIDEBAR --}}
        <div class="lg:col-span-2 space-y-4 fu fu-2">

            {{-- Contact --}}
            <div class="info-card">
                <div class="info-card-header"><i class="bi bi-person-vcard"></i> Contact Details</div>

                <div class="info-row">
                    <div class="info-icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="info-label">Email</div>
                        <div class="info-value break-all">{{ $user->email }}</div>
                    </div>
                </div>
                @if ($user->phone)
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-telephone"></i></div>
                        <div>
                            <div class="info-label">Phone</div>
                            <div class="info-value">{{ $user->phone }}</div>
                        </div>
                    </div>
                @endif
                @if ($user->city)
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <div class="info-label">City</div>
                            <div class="info-value">{{ $user->city }}</div>
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
                <div class="info-row">
                    <div class="info-icon"><i class="bi bi-clock-history"></i></div>
                    <div>
                        <div class="info-label">Last Active</div>
                        <div class="info-value">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            {{-- Rating breakdown --}}
            @if ($feedbacks->count() > 0)
                @php
                    $ratingCounts = $feedbacks->groupBy('rating')->map->count();
                    $total = $feedbacks->count();
                @endphp
                <div class="info-card">
                    <div class="info-card-header"><i class="bi bi-bar-chart"></i> Rating Breakdown</div>
                    <div class="px-5 py-4 space-y-2.5">
                        @for ($star = 5; $star >= 1; $star--)
                            @php
                                $cnt = $ratingCounts[$star] ?? 0;
                                $pct = $total ? round(($cnt / $total) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1 w-12 flex-shrink-0">
                                    <span class="text-xs font-mono text-text-muted-light">{{ $star }}</span>
                                    <i class="bi bi-star-fill text-xs text-primary"></i>
                                </div>
                                <div class="rating-bar">
                                    <div class="rating-bar-fill" style="width:{{ $pct }}%"></div>
                                </div>
                                <span
                                    class="text-xs font-semibold text-text-muted-light w-6 text-right flex-shrink-0">{{ $cnt }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            @endif

            {{-- Note --}}
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex gap-3">
                <i class="bi bi-info-circle text-amber-500 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-amber-700 leading-relaxed">
                    Guest users browse advocates & clerks on Court Pulse. They give feedback to unlock contact details.
                </p>
            </div>
        </div>

        {{-- REVIEWS --}}
        <div class="lg:col-span-3 fu fu-3">
            <div class="info-card">
                <div class="info-card-header justify-between">
                    <span class="flex items-center gap-2"><i class="bi bi-chat-quote"></i> Reviews Received</span>
                    @if ($feedbacks->count())
                        <span class="flex items-center gap-2">
                            <span class="flex gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $avgRating && $i <= round($avgRating) ? '-fill' : '' }} text-xs"
                                        style="color:{{ $avgRating && $i <= round($avgRating) ? '#D4AF37' : '#e2e8f0' }}"></i>
                                @endfor
                            </span>
                            <span class="font-bold" style="color:#B5952F">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-gray-400 font-normal normal-case"
                                style="font-size:.65rem">({{ $feedbacks->count() }})</span>
                        </span>
                    @endif
                </div>

                @forelse($feedbacks as $fb)
                    <div class="review-item">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0 text-white"
                                    style="background:linear-gradient(135deg,#D4AF37,#B5952F)">
                                    {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">
                                        {{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'Unknown' }}
                                    </div>
                                    <div class="text-xs text-text-muted-light">
                                        {{ !$fb->is_anonymous && $fb->giver ? ucfirst($fb->giver->role) : 'Court Pulse User' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1 flex-shrink-0">
                                <div class="flex gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }} text-xs"
                                            style="color:{{ $i <= $fb->rating ? '#D4AF37' : '#e2e8f0' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-text-muted-light">{{ $fb->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if ($fb->comment)
                            <div class="rounded-lg px-3 py-2.5 text-sm text-gray-600 leading-relaxed"
                                style="background:#faf9f6;border-left:3px solid #D4AF37">
                                "{{ $fb->comment }}"
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-16 text-center">
                        <span class="material-icons-round text-5xl text-gray-200 block mb-3">reviews</span>
                        <p class="text-gray-500 font-medium">No reviews yet</p>
                        <p class="text-sm text-text-muted-light mt-1">This guest hasn't received any feedback yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
