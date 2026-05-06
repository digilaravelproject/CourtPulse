@extends('professional.layouts.master')
@section('title', $targetUser->name)
@section('page-title', 'Advocate Profile')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 reveal">
    <!-- Main Profile Content -->
    <div class="lg:col-span-8 space-y-8">
        <!-- Identity Card -->
        <div class="glass-dark rounded-[2.5rem] overflow-hidden border border-white/10">
            <div class="px-8 py-10 bg-gradient-to-br from-indigo-500/10 via-transparent to-transparent">
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <!-- Avatar/Initials -->
                    <div class="relative shrink-0">
                        <div class="h-32 w-32 rounded-3xl bg-indigo-500/20 flex items-center justify-center text-4xl font-black text-indigo-400 border border-indigo-500/30 shadow-[0_0_30px_rgba(79,70,229,0.2)]">
                            {{ strtoupper(substr($targetUser->name, 0, 1)) }}
                        </div>
                        @if($isConnected)
                            <div class="absolute -bottom-2 -right-2 h-10 w-10 rounded-full bg-emerald-500 flex items-center justify-center text-white border-4 border-navy shadow-lg" title="Connected">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 space-y-4">
                        <div>
                            <h2 class="text-4xl font-black text-white tracking-tighter uppercase mb-1">{{ $targetUser->name }}</h2>
                            <p class="text-xs font-black text-indigo-400 uppercase tracking-[0.3em]">{{ $targetUser->sub_role ?? $targetUser->role }}</p>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 flex items-center gap-2">
                                <i class="fas fa-landmark text-indigo-400 text-xs"></i>
                                <span class="text-[11px] font-bold text-white/70 uppercase tracking-widest">{{ $targetUser->court->name ?? 'Independant' }}</span>
                            </div>
                            @if($targetUser->city)
                                <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 flex items-center gap-2">
                                    <i class="fas fa-location-dot text-indigo-400 text-xs"></i>
                                    <span class="text-[11px] font-bold text-white/70 uppercase tracking-widest">{{ $targetUser->city }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-white/5">
                <div class="space-y-1">
                    <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Email Address</p>
                    @if($isConnected)
                        <p class="text-sm font-bold text-white">{{ $targetUser->email }}</p>
                    @else
                        <div class="flex items-center gap-2 text-sm font-bold text-white/20 uppercase tracking-widest">
                            <i class="fas fa-lock text-[10px]"></i> Encrypted
                        </div>
                    @endif
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Phone Number</p>
                    @if($isConnected)
                        <p class="text-sm font-bold text-white">{{ $targetUser->phone ?? 'Not provided' }}</p>
                    @else
                        <div class="flex items-center gap-2 text-sm font-bold text-white/20 uppercase tracking-widest">
                            <i class="fas fa-lock text-[10px]"></i> Encrypted
                        </div>
                    @endif
                </div>
                @if($targetUser->address)
                    <div class="md:col-span-2 space-y-1">
                        <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Office Address</p>
                        <p class="text-sm font-bold text-white/70">{{ $targetUser->address }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if($targetUser->advocateProfile)
            <!-- Professional Details -->
            <div class="glass-dark rounded-[2.5rem] p-8 border border-white/10 space-y-8">
                <h3 class="text-lg font-black text-white uppercase tracking-tighter flex items-center gap-3">
                    <span class="h-8 w-1 bg-indigo-500 rounded-full"></span>
                    Professional Intelligence
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Bar Council Identity</p>
                        <p class="text-base font-bold text-white">{{ $targetUser->advocateProfile->bar_council ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Operational Tenure</p>
                        <p class="text-base font-bold text-white">{{ $targetUser->advocateProfile->experience_years ?? 0 }} Years Experience</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Specialization Areas</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $targetUser->advocateProfile->practice_areas ?? 'General Practice') as $area)
                                <span class="px-3 py-1.5 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-[10px] font-black text-indigo-400 uppercase tracking-widest">
                                    {{ trim($area) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em]">Bio / Dossier</p>
                        <p class="text-sm font-medium text-white/60 leading-relaxed italic">
                            "{{ $targetUser->advocateProfile->bio ?? 'No detailed biography provided for this professional.' }}"
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Reviews Section -->
        <div class="glass-dark rounded-[2.5rem] p-8 border border-white/10 space-y-8">
            <h3 class="text-lg font-black text-white uppercase tracking-tighter flex items-center gap-3">
                <span class="h-8 w-1 bg-indigo-500 rounded-full"></span>
                Network Feedback
            </h3>

            @if($feedbacks->isEmpty())
                <div class="py-12 flex flex-col items-center justify-center text-center">
                    <div class="h-16 w-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/20 mb-4">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                    <p class="text-xs font-black text-white/30 uppercase tracking-[0.2em]">No operational history recorded</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($feedbacks as $feedback)
                        <div class="p-6 rounded-3xl bg-white/5 border border-white/5 space-y-4 hover:border-white/10 transition-colors group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-sm font-black text-indigo-400 border border-indigo-500/30">
                                        {{ strtoupper(substr($feedback->giver->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-white uppercase tracking-tighter">{{ $feedback->giver->name }}</p>
                                        <p class="text-[9px] font-bold text-white/30 uppercase tracking-widest">{{ $feedback->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-1 text-[10px]">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.3)]' : 'text-white/10' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($feedback->comment)
                                <p class="text-xs font-medium text-white/60 leading-relaxed">
                                    "{{ $feedback->comment }}"
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="lg:col-span-4 space-y-8">
        <!-- Reputation Card -->
        <div class="glass-dark rounded-[2.5rem] p-8 border border-white/10 text-center space-y-6">
            <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em]">Aggregate Rating</p>
            <div class="relative inline-block">
                <div class="text-6xl font-black text-white tracking-tighter">{{ number_format($avgRating, 1) }}</div>
                <div class="absolute -top-2 -right-4 h-6 w-6 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] text-white font-black shadow-lg">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="flex justify-center gap-1.5">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-lg {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-white/10' }}"></i>
                @endfor
            </div>
            <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest">
                Based on {{ $totalRatings }} Verified Observations
            </p>
        </div>

        <!-- Connection Card -->
        @if(!$isConnected)
            <div class="glass-dark rounded-[2.5rem] p-8 border border-white/10 space-y-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 text-indigo-500/5 -rotate-12">
                    <i class="fas fa-user-plus text-8xl"></i>
                </div>
                
                <h3 class="text-sm font-black text-white uppercase tracking-[0.3em]">Initiate Link</h3>
                
                <div class="space-y-4 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Engagement Note</label>
                        <textarea id="connectNotes" class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-sm text-white placeholder:text-white/20 focus:border-indigo-500/50 focus:ring-0 transition-all outline-none" rows="4" placeholder="Briefly introduce your requirement..."></textarea>
                    </div>

                    <button id="sendConnectionBtn" class="w-full py-4 rounded-2xl bg-indigo-500 hover:bg-indigo-600 text-white text-[11px] font-black uppercase tracking-[0.2em] shadow-[0_10px_30px_rgba(79,70,229,0.3)] hover:shadow-[0_15px_40px_rgba(79,70,229,0.5)] transition-all duration-300 active:scale-95 group">
                        Establish Connection <i class="fas fa-bolt ml-2 group-hover:animate-pulse"></i>
                    </button>
                    
                    <p class="text-[9px] font-bold text-white/20 text-center uppercase tracking-widest">
                        Requests are subject to professional approval
                    </p>
                </div>
            </div>
        @else
            <div class="glass-dark rounded-[2.5rem] p-8 border border-white/10 space-y-6 bg-gradient-to-br from-emerald-500/5 to-transparent">
                <div class="h-16 w-16 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 mx-auto">
                    <i class="fas fa-handshake text-2xl"></i>
                </div>
                <div class="text-center space-y-2">
                    <h3 class="text-sm font-black text-white uppercase tracking-[0.2em]">Neural Link Active</h3>
                    <p class="text-xs font-bold text-white/40 uppercase tracking-widest">You are verified nodes in the same network</p>
                </div>
                
                <div class="pt-4 border-t border-white/5 space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-white/2 border border-white/5">
                        <span class="text-[9px] font-black text-white/30 uppercase tracking-widest">Secure Email</span>
                        <span class="text-[11px] font-bold text-indigo-400">{{ $targetUser->email }}</span>
                    </div>
                    @if($targetUser->phone)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/2 border border-white/5">
                            <span class="text-[9px] font-black text-white/30 uppercase tracking-widest">Direct Line</span>
                            <span class="text-[11px] font-bold text-indigo-400">{{ $targetUser->phone }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.getElementById('sendConnectionBtn')?.addEventListener('click', function() {
    const btn = this;
    const notes = document.getElementById('connectNotes')?.value || '';
    
    // Visual feedback
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> TRANSMITTING...';
    
    fetch('{{ route("professional.connection.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            receiver_id: {{ $targetUser->id }}, 
            notes: notes 
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            if (data.message.includes('successfully')) {
                // Smooth success state
                btn.classList.replace('bg-indigo-500', 'bg-emerald-500');
                btn.innerHTML = '<i class="fas fa-check"></i> REQUEST TRANSMITTED';
                setTimeout(() => window.location.reload(), 1500);
            } else {
                alert(data.message);
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }
    })
    .catch(err => {
        alert('Transmission Failure');
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});
</script>
@endpush

@endsection