@extends('support.layouts.master')
@section('title', $user->name . ' — Professional Profile')
@section('page-title', 'Professional Profile')

@push('styles')
<style>
.premium-avatar-ring {
    position: relative;
    width: 88px;
    height: 88px;
    flex-shrink: 0;
    border-radius: 24px;
}

.premium-avatar-ring::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 26px;
    background: conic-gradient(#B4B4FE 0deg, #9999f0 90deg, rgba(180, 180, 254, 0.15) 200deg, #B4B4FE 360deg);
    animation: spinRing 6s linear infinite;
}

.premium-avatar-inner {
    position: absolute;
    inset: 3px;
    border-radius: 22px;
    background: linear-gradient(135deg, #080d1a, #0b1120);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 900;
    color: #B4B4FE;
    z-index: 1;
    box-shadow: inset 0 0 20px rgba(180, 180, 254, 0.2);
}

@keyframes spinRing {
    to { transform: rotate(360deg); }
}
</style>
@endpush

@section('content')

{{-- Back Button --}}
<div class="mb-8">
    <a href="{{ route('support.search.professionals') }}"
        class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 text-white/70 hover:text-white transition-all text-xs font-black uppercase tracking-widest shadow-lg">
        <i class="fas fa-arrow-left"></i> Back to Search
    </a>
</div>

{{-- Hero Section --}}
<div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden relative mb-8">
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:36px_36px] pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue/10 rounded-full blur-[100px] pointer-events-none -mr-20 -mt-20"></div>

    <div class="relative z-10 p-8 md:p-12">
        <div class="flex flex-col md:flex-row md:items-center gap-8">

            {{-- Avatar --}}
            <div class="premium-avatar-ring">
                <div class="premium-avatar-inner font-sans">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-md bg-blue/10 border border-blue/20 text-blue font-black text-[0.6rem] uppercase tracking-widest">
                        {{ ucfirst($user->role) }}
                    </span>
                    @if($user->court)
                        <span class="inline-flex items-center px-3 py-1 rounded-md bg-purple-500/10 border border-purple-500/20 text-purple-400 font-black text-[0.6rem] uppercase tracking-widest">
                            <i class="fas fa-building mr-1"></i> {{ $user->court->name }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-green-500/10 border border-green-500/20 text-green-400 font-black text-[0.6rem] uppercase tracking-widest">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                    @if ($connected)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-blue/10 border border-blue/30 text-blue font-black text-[0.6rem] uppercase tracking-widest shadow-[0_0_15px_rgba(180,180,254,0.2)]">
                            <i class="fas fa-user-check"></i> Connected
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-3">
                    {{ $user->name }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 text-[0.7rem] font-bold text-white/50 uppercase tracking-wider">
                    @if ($profile?->high_court)
                        <span class="flex items-center gap-2">
                            <i class="fas fa-university text-blue"></i>
                            {{ $connected ? $profile->high_court : 'Hidden' }}
                        </span>
                    @endif
                    @if ($user->city)
                        <span class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-blue"></i>
                            {{ $user->city }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3">
                @if ($connectionStatus === 'none')
                    <button id="connectBtn" onclick="sendConnectProfile({{ $user->id }})"
                        class="flex items-center gap-2 px-8 py-3.5 rounded-xl bg-blue-600 text-white text-xs font-black uppercase tracking-widest hover:bg-blue-700 hover:shadow-[0_10px_30px_rgba(37,99,235,0.4)] transition-all">
                        <i class="fas fa-user-plus"></i> Connect
                    </button>
                @elseif($connectionStatus === 'sent')
                    <div class="flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white/50 text-xs font-black uppercase tracking-widest cursor-not-allowed">
                        <i class="fas fa-clock"></i> Request Sent
                    </div>
                @elseif($connectionStatus === 'received')
                    <button onclick="handleReq({{ $connectionReq->id }}, 'accept')"
                        class="flex items-center gap-2 px-6 py-3.5 rounded-xl bg-green-500 text-navy text-xs font-black uppercase tracking-widest hover:bg-green-600 transition-all">
                        <i class="fas fa-check"></i> Accept
                    </button>
                    <button onclick="handleReq({{ $connectionReq->id }}, 'reject')"
                        class="flex items-center gap-2 px-6 py-3.5 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-black uppercase tracking-widest hover:bg-red-500/20 transition-all">
                        <i class="fas fa-times"></i> Decline
                    </button>
                @elseif($connectionStatus === 'connected')
                    <div class="flex items-center gap-2 px-6 py-3.5 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-black uppercase tracking-widest shadow-inner">
                        <i class="fas fa-check-circle"></i> Connected
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Not Connected Notice --}}
    @if (!$connected)
        <div class="mx-8 mb-8 flex items-start gap-3 px-5 py-4 bg-amber-500/10 border border-amber-500/20 rounded-xl text-amber-400 text-xs font-bold leading-relaxed shadow-inner">
            <i class="fas fa-info-circle mt-0.5 text-lg"></i>
            <p>Send a connection request to view contact details.</p>
        </div>
    @endif
</div>

{{-- Main Body Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    {{-- Left Sidebar: Contact & Info --}}
    <div class="lg:col-span-5 space-y-8">

        <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
            <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center gap-3">
                <i class="fas fa-address-card text-blue"></i>
                <h3 class="font-black text-base text-white uppercase tracking-widest">Contact Details</h3>
            </div>

            <div class="p-8 bg-navy/50 space-y-6">

                {{-- Email --}}
                <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-lg shrink-0">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-1">Email Address</div>
                        @if ($connected)
                            <div class="text-sm font-bold text-white truncate">{{ $user->email }}</div>
                        @else
                            <div class="text-sm font-bold text-white/30 tracking-widest select-none blur-sm">Hidden</div>
                        @endif
                    </div>
                </div>

                {{-- Phone --}}
                <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-lg shrink-0">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-1">Phone Number</div>
                        @if ($connected)
                            <div class="text-sm font-bold text-white">{{ $user->phone ?? 'Not provided' }}</div>
                        @else
                            <div class="text-sm font-bold text-white/30 tracking-widest select-none blur-sm">Hidden</div>
                        @endif
                    </div>
                </div>

                {{-- High Court --}}
                @if ($profile?->high_court)
                    <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-lg shrink-0">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-1">Primary High Court</div>
                            <div class="text-sm font-bold text-white truncate">{{ $connected ? $profile->high_court : 'Hidden' }}</div>
                        </div>
                    </div>
                @endif

                {{-- Practice Areas --}}
                @if ($profile?->practice_areas)
                    <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner flex items-start gap-5">
                        <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-lg shrink-0">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-2">Practice Areas</div>
                            @if ($connected)
                                <div class="flex flex-wrap gap-2">
                                    @foreach (is_array($profile->practice_areas) ? $profile->practice_areas : explode(',', $profile->practice_areas) as $area)
                                        <span class="inline-block px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-[0.65rem] font-black text-white/70 uppercase tracking-widest">
                                            {{ trim($area) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-sm font-bold text-white/30 tracking-widest">Hidden</div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Member Since --}}
                <div class="bg-navy p-5 rounded-2xl border border-white/5 shadow-inner flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-lg shrink-0">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-1">Member Since</div>
                        <div class="text-sm font-bold text-white">{{ $user->created_at->format('d M, Y') }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Right Sidebar: Reviews & Bio --}}
    <div class="lg:col-span-7 space-y-8">

        {{-- Professional Bio --}}
        @if ($profile?->bio)
            <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center gap-3">
                    <i class="fas fa-user-edit text-blue"></i>
                    <h3 class="font-black text-base text-white uppercase tracking-widest">About</h3>
                </div>
                <div class="p-8 bg-navy/50 relative">
                    @if ($connected)
                        <p class="text-sm text-white/70 leading-relaxed font-medium">
                            {{ $profile->bio }}
                        </p>
                    @else
                        <p class="text-sm text-white/30 leading-relaxed font-medium">Hidden - Connect to view</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Reviews Section --}}
        @if ($feedbacks->count())
            <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-star text-blue"></i>
                        <h3 class="font-black text-base text-white uppercase tracking-widest">Reviews</h3>
                    </div>
                    @if ($feedbacks->count())
                        <span class="text-[0.65rem] font-black text-white/50 uppercase tracking-widest">
                            {{ number_format($avgRating, 1) }} AVG &middot; {{ $feedbacks->count() }} REVIEWS
                        </span>
                    @endif
                </div>

                <div class="bg-navy/50">
                    @forelse($feedbacks as $fb)
                        <div class="p-8 border-b border-white/5 last:border-0">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center font-black text-sm text-blue shrink-0">
                                        {{ strtoupper(substr($fb->giver->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-white uppercase tracking-tight">
                                            {{ $fb->giver->name ?? 'User' }}
                                        </div>
                                        <div class="text-[0.65rem] font-bold text-white/40 uppercase tracking-widest mt-0.5">
                                            {{ $fb->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 shrink-0 bg-white/5 px-3 py-1.5 rounded-lg border border-white/10">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-[0.65rem]" style="color: {{ $i <= $fb->rating ? '#B4B4FE' : 'rgba(255,255,255,0.1)' }};"></i>
                                    @endfor
                                </div>
                            </div>
                            @if ($fb->comment)
                                <div class="mt-4 p-5 bg-white/5 border-l-2 border-blue rounded-r-2xl">
                                    <p class="text-sm text-white/70 font-medium italic">"{{ $fb->comment }}"</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-white/40">No reviews yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Give Feedback (Only if Connected) --}}
        @if ($connected)
            @php
                $existingFeedback = $feedbacks->where('given_by', auth()->id())->first();
            @endphp
            <div class="bg-navy2 border border-white/5 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center gap-3">
                    <i class="fas fa-star text-blue"></i>
                    <h3 class="font-black text-base text-white uppercase tracking-widest">Give Feedback</h3>
                </div>
                <form action="{{ route('support.feedback.submit') }}" method="POST" class="p-8 bg-navy/50 space-y-6">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                    
                    <div>
                        <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest mb-3">Your Rating</label>
                        <div class="flex items-center gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})" class="star-btn w-12 h-12 rounded-xl bg-navy border border-white/10 hover:border-blue/50 transition-all text-xl" data-rating="{{ $i }}">
                                    <i class="fas fa-star text-white/30 hover:text-yellow-400"></i>
                                </button>
                            @endfor
                            <input type="hidden" name="rating" id="ratingInput" value="{{ $existingFeedback->rating ?? '' }}">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest mb-2">Your Comment (Optional)</label>
                        <textarea name="comment" rows="3" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder="Write your experience...">{{ $existingFeedback->comment ?? '' }}</textarea>
                    </div>
                    
                    <button type="submit" class="px-8 py-3 rounded-xl bg-blue text-navy text-xs font-black uppercase tracking-widest hover:bg-blue2 transition-all">
                        {{ $existingFeedback ? 'Update Feedback' : 'Submit Feedback' }}
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

// Star rating functionality
function setRating(rating) {
    document.getElementById('ratingInput').value = rating;
    document.querySelectorAll('.star-btn').forEach((btn, index) => {
        const icon = btn.querySelector('i');
        if (index < rating) {
            icon.classList.remove('text-white/30');
            icon.classList.add('text-yellow-400');
        } else {
            icon.classList.remove('text-yellow-400');
            icon.classList.add('text-white/30');
        }
    });
}

// Initialize existing rating
const existingRating = document.getElementById('ratingInput').value;
if (existingRating) {
    setRating(parseInt(existingRating));
}

function sendConnectProfile(userId) {
    const btn = document.getElementById('connectBtn');
    const originalContent = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i> Sending...';

    fetch('{{ route('support.connection.send') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            receiver_id: userId
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success || data.message) {
            btn.outerHTML = `<div class="flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white/50 text-xs font-black uppercase tracking-widest"><i class="fas fa-clock"></i> Request Sent</div>`;
            if(typeof showToast === 'function') showToast(data.message || 'Request Sent', 'success');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = originalContent;
        if(typeof showToast === 'function') showToast('Failed to send request', 'error');
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