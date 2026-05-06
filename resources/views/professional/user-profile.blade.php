@extends('professional.layouts.master')
@section('title', $targetUser->name)
@section('page-title', 'User Profile')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: User Details -->
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">{{ $targetUser->name }}</h3>
                @if($isConnected)
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                        <i class="fas fa-check"></i> Connected
                    </span>
                @endif
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Role</label>
                        <div class="text-sm font-semibold text-blue">
                            @if($targetUser->role === 'advocate')
                                Advocate
                            @elseif($targetUser->sub_role === 'ca')
                                Chartered Accountant
                            @elseif($targetUser->sub_role === 'cs')
                                Company Secretary
                            @else
                                {{ ucfirst(str_replace('_', ' ', $targetUser->sub_role ?? $targetUser->role)) }}
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Court</label>
                        <div class="text-sm text-white/70">{{ $targetUser->court->name ?? 'Not assigned' }}</div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Email Address</label>
                        @if($isConnected)
                            <div class="text-sm text-white">{{ $targetUser->email }}</div>
                        @else
                            <div class="text-xs text-white/20 italic flex items-center gap-2">
                                <i class="fas fa-lock text-[10px]"></i> Connect to view email
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Phone Number</label>
                        @if($isConnected)
                            <div class="text-sm text-white">{{ $targetUser->phone ?? 'Not set' }}</div>
                        @else
                            <div class="text-xs text-white/20 italic flex items-center gap-2">
                                <i class="fas fa-lock text-[10px]"></i> Connect to view phone
                            </div>
                        @endif
                    </div>
                    @if($targetUser->city)
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">City</label>
                            <div class="text-sm text-white/70">{{ $targetUser->city }}</div>
                        </div>
                    @endif
                </div>

                @php
                    $profile = null;
                    if ($targetUser->role === 'advocate') $profile = $targetUser->advocateProfile;
                    elseif ($targetUser->role === 'ca_cs') $profile = $targetUser->caProfile;
                    elseif (in_array($targetUser->role, ['court_clerk', 'ip_clerk'])) $profile = $targetUser->clerkProfile;
                @endphp

                @if($profile)
                    <div class="my-8 h-px bg-white/5"></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($targetUser->role === 'advocate')
                            <div>
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Bar Council</label>
                                <div class="text-sm text-white">{{ $profile->bar_council ?? 'Not set' }}</div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Experience</label>
                                <div class="text-sm text-white/70">{{ $profile->experience_years ?? 0 }} years</div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Practice Areas</label>
                                <p class="text-sm text-white/70 leading-relaxed">{{ $profile->practice_areas ?? 'Not specified.' }}</p>
                            </div>
                        @elseif($targetUser->role === 'ca_cs')
                            <div>
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Firm Name</label>
                                <div class="text-sm text-white">{{ $profile->firm_name ?? 'Not set' }}</div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Membership Number</label>
                                <div class="text-sm text-white/70">{{ $profile->membership_number ?? 'Not set' }}</div>
                            </div>
                        @elseif(in_array($targetUser->role, ['court_clerk', 'ip_clerk']))
                            <div>
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Designation</label>
                                <div class="text-sm text-white">{{ $profile->designation ?? 'Not set' }}</div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">Experience</label>
                                <div class="text-sm text-white/70">{{ $profile->experience_years ?? 0 }} years</div>
                            </div>
                        @endif

                        @if($profile->bio)
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1">About</label>
                                <p class="text-sm text-white/70 leading-relaxed italic">"{{ $profile->bio }}"</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-bold text-white">Reviews</h3>
            </div>
            <div class="p-6">
                @if($feedbacks->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="text-white/10 text-4xl mb-4"><i class="fas fa-star"></i></div>
                        <p class="text-white/30 text-sm">This user hasn't received any feedback yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($feedbacks as $feedback)
                            <div class="p-4 bg-white/[0.02] border border-white/5 rounded-xl">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-blue/10 border border-blue/20 flex items-center justify-center text-blue font-bold shrink-0">
                                        {{ strtoupper(substr($feedback->giver->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="text-sm font-bold text-white truncate">{{ $feedback->giver->name }}</h4>
                                            <span class="text-[10px] text-white/20 uppercase font-bold">{{ $feedback->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex gap-0.5 text-[10px] mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-amber-400' : 'text-white/10' }}"></i>
                                            @endfor
                                        </div>
                                        @if($feedback->comment)
                                            <p class="text-sm text-white/60 leading-relaxed italic">"{{ $feedback->comment }}"</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Stats & Networking -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Rating Card -->
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="p-8 text-center">
                <label class="block text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-2">Average Rating</label>
                <div class="text-5xl font-extrabold text-white mb-2">{{ number_format($avgRating, 1) }}</div>
                <div class="flex justify-center gap-1 text-amber-400 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($avgRating) ? '' : 'opacity-20' }}"></i>
                    @endfor
                </div>
                <div class="text-xs text-white/40 font-bold uppercase tracking-widest">
                    {{ $totalRatings }} {{ $totalRatings === 1 ? 'review' : 'reviews' }}
                </div>
            </div>
        </div>

        <!-- Networking Actions -->
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-network-wired text-blue"></i> Networking
                </h3>
            </div>
            <div class="p-6">
                @if(auth()->id() === $targetUser->id)
                    <div class="p-4 bg-blue/5 border border-blue/10 rounded-xl text-blue text-xs font-medium flex items-center gap-3">
                        <i class="fas fa-user-circle text-lg"></i>
                        This is your public profile.
                    </div>
                @elseif($connectionStatus === 'none')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Add a Note (Optional)</label>
                            <textarea id="connectNotes" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none" rows="3" placeholder="Introduce yourself..."></textarea>
                        </div>
                        <button id="sendConnectionBtn" class="w-full py-4 bg-blue text-navy font-extrabold rounded-xl hover:bg-blue2 shadow-lg shadow-blue/10 transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i> Send Connection Request
                        </button>
                    </div>
                @elseif($connectionStatus === 'sent')
                    <div class="p-4 bg-amber-500/5 border border-amber-500/10 rounded-xl text-amber-500 text-xs font-medium flex items-center gap-3">
                        <i class="fas fa-clock text-lg"></i>
                        Request Sent. Waiting for response.
                    </div>
                @elseif($connectionStatus === 'received')
                    <div class="space-y-3">
                        <div class="p-3 bg-blue/5 border border-blue/10 rounded-xl text-blue text-center text-xs font-bold uppercase tracking-tighter">
                            <i class="fas fa-bell me-2"></i> Request Received
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <button onclick="handleReq({{ $connectionReq?->id }}, 'accept')" class="py-3 bg-emerald-500 text-navy font-bold rounded-xl hover:bg-emerald-600 transition-all">
                                Accept
                            </button>
                            <button onclick="handleReq({{ $connectionReq?->id }}, 'reject')" class="py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-all">
                                Reject
                            </button>
                        </div>
                    </div>
                @elseif($connectionStatus === 'connected')
                    <div class="space-y-4">
                        <div class="p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-xl text-emerald-500 text-xs font-bold flex items-center gap-3">
                            <i class="fas fa-check-circle text-lg"></i>
                            You are connected
                        </div>
                        <button onclick="handleReq({{ $connectionReq?->id }}, 'reject')" class="w-full py-3 border border-red-500/30 text-red-500 hover:bg-red-500/10 font-bold rounded-xl transition-all text-xs uppercase tracking-widest">
                            <i class="fas fa-user-minus me-2"></i> Disconnect
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const csrf = '{{ csrf_token() }}';

function handleReq(reqId, action) {
    if(!confirm(`Are you sure you want to ${action} this connection?`)) return;

    let url = `/connections/${reqId}/${action}`;

    fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            window.location.reload();
        }
    })
    .catch(err => alert('Failed to process request'));
}

document.getElementById('sendConnectionBtn')?.addEventListener('click', function() {
    const notes = document.getElementById('connectNotes')?.value || '';
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

    fetch('{{ route("professional.connection.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({
            receiver_id: {{ $targetUser->id }},
            notes: notes
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            if (data.message.includes('successfully')) {
                window.location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-user-plus me-2"></i> Send Connection Request';
            }
        }
    })
    .catch(err => {
        alert('Failed to send request');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-user-plus me-2"></i> Send Connection Request';
    });
});
</script>
@endpush
@endsection
