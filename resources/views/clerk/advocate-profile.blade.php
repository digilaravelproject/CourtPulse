@extends('layouts.clerk')
@section('title', $user->name . ' — Advocate Profile')
@section('page-title', 'Advocate Profile')

@section('content')

    {{-- Header / Back --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div class="flex items-center gap-6">
            <a href="{{ route('clerk.advocates') }}"
                class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/[0.03] border border-white/5 text-white/40 hover:text-white hover:bg-white/[0.08] hover:border-white/10 transition-all group shadow-inner">
                <i class="fa-solid fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-widest leading-none mb-2">
                    Advocate <span class="text-blue">Profile</span>
                </h1>
                <p class="text-white/40 font-bold uppercase tracking-[0.2em] text-[10px]">Digital Professional Portfolio</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            @if ($connected)
                <div class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue/10 border border-blue/20 text-blue shadow-lg shadow-blue/5">
                    <i class="fa-solid fa-link"></i>
                    <span class="text-xs font-black uppercase tracking-widest">Connected Member</span>
                </div>
            @endif
        </div>
    </div>

    {{-- HERO SECTION --}}
    <div class="relative rounded-[40px] overflow-hidden border border-white/5 shadow-2xl mb-8 bg-navy2 min-h-[300px]">
        {{-- Background Effects --}}
        <div class="absolute inset-0 bg-linear-to-br from-navy2 via-navy2 to-blue/5"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay"></div>
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
             style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        {{-- Content Grid --}}
        <div class="relative z-10 p-8 md:p-12 h-full flex flex-col md:flex-row items-center md:items-end justify-between gap-12">
            
            <div class="flex flex-col md:flex-row items-center md:items-end gap-10 text-center md:text-left w-full md:w-auto">
                {{-- Animated Avatar Container --}}
                <div class="relative group shrink-0">
                    <div class="absolute -inset-4 bg-linear-to-tr from-blue to-blue/20 rounded-full opacity-20 blur-2xl group-hover:opacity-40 transition-opacity duration-700 animate-pulse"></div>
                    <div class="relative w-40 h-40 md:w-48 md:h-48 rounded-full p-1.5 bg-linear-to-br from-white/20 to-transparent shadow-2xl overflow-hidden group">
                        {{-- Spin Ring --}}
                        <div class="absolute inset-0 rounded-full border-2 border-dashed border-blue/30 animate-[spin_20s_linear_infinite] group-hover:animate-[spin_10s_linear_infinite]"></div>
                        
                        <div class="w-full h-full rounded-full bg-navy flex items-center justify-center border border-white/10 relative overflow-hidden">
                            {{-- Identity Background --}}
                            <div class="absolute inset-0 bg-linear-to-br from-blue/10 to-transparent"></div>
                            <span class="text-6xl md:text-7xl font-black text-white/90 drop-shadow-2xl z-10">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    
                    {{-- Verified Badge --}}
                    <div class="absolute -bottom-2 -right-2 bg-blue text-white w-12 h-12 rounded-2xl flex items-center justify-center border-4 border-navy2 shadow-xl animate-bounce" title="Verified Professional">
                        <i class="fa-solid fa-shield-check text-xl"></i>
                    </div>
                </div>

                <div class="flex-1 space-y-4">
                    <div class="flex items-center gap-3 flex-wrap justify-center md:justify-start">
                        <span class="px-4 py-1.5 rounded-full bg-white/[0.05] border border-white/10 text-[10px] font-black uppercase tracking-widest text-white/60">Professional Advocate</span>
                        <span class="px-4 py-1.5 rounded-full bg-blue/10 border border-blue/20 text-[10px] font-black uppercase tracking-widest text-blue flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue animate-ping"></span> Active
                        </span>
                    </div>
                    
                    <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-[0.9] drop-shadow-lg">
                        {{ $user->name }}
                    </h2>
                    
                    <div class="flex items-center gap-6 text-white/40 font-bold uppercase tracking-widest text-[11px] justify-center md:justify-start">
                        <span class="flex items-center gap-2 group transition-colors hover:text-blue">
                            <i class="fa-solid fa-location-dot text-blue"></i>
                            {{ $connected ? ($user->city ?? 'Location Secured') : 'Location Secured' }}
                        </span>
                        <span class="flex items-center gap-2 group transition-colors hover:text-blue">
                            <i class="fa-solid fa-building-columns text-blue"></i>
                            {{ $connected ? ($profile?->high_court ?? 'Court Locked') : 'High Court Locked' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Action & Stats Area --}}
            <div class="flex flex-col items-center md:items-end gap-8 w-full md:w-auto">
                <div class="flex gap-4">
                    <div class="bg-white/[0.03] border border-white/5 backdrop-blur-xl px-8 py-5 rounded-3xl text-center group hover:bg-white/[0.08] transition-all">
                        <div class="text-3xl font-black text-white mb-1 group-hover:scale-110 transition-transform">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
                        <div class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em]">Platform Rating</div>
                    </div>
                    <div class="bg-white/[0.03] border border-white/5 backdrop-blur-xl px-8 py-5 rounded-3xl text-center group hover:bg-white/[0.08] transition-all">
                        <div class="text-3xl font-black text-white mb-1 group-hover:scale-110 transition-transform">{{ $feedbacks->count() }}</div>
                        <div class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em]">Verified Reviews</div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 justify-center">
                    @if ($connectionStatus === 'none')
                        <button id="connectBtn" onclick="sendConnectProfile({{ $user->id }})"
                            class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-blue text-white font-black uppercase tracking-widest text-sm hover:bg-blue/80 hover:shadow-2xl hover:shadow-blue/30 transition-all active:scale-95 group">
                            <i class="fa-solid fa-user-plus group-hover:rotate-12 transition-transform"></i>
                            Request Connection
                        </button>
                    @elseif($connectionStatus === 'sent')
                        <div class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-white/5 border border-white/10 text-white/40 font-black uppercase tracking-widest text-sm">
                            <i class="fa-solid fa-clock animate-spin-slow"></i>
                            Request Pending
                        </div>
                    @elseif($connectionStatus === 'received')
                        <div class="flex gap-2">
                            <button onclick="handleReq({{ $connectionReq?->id }}, 'accept')"
                                class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-green-500 text-white font-black uppercase tracking-widest text-sm hover:bg-green-600 transition-all">
                                <i class="fa-solid fa-check"></i> Accept
                            </button>
                            <button onclick="handleReq({{ $connectionReq?->id }}, 'reject')"
                                class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 font-black uppercase tracking-widest text-sm hover:bg-red-500 hover:text-white transition-all">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    @elseif($connectionStatus === 'connected')
                        <div class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-blue/10 border border-blue/20 text-blue font-black uppercase tracking-widest text-sm shadow-inner">
                            <i class="fa-solid fa-handshake"></i>
                            Member Connected
                        </div>
                    @endif

                    @if (!$hasFeedback)
                        <a href="{{ route('feedback') }}"
                            class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 font-black uppercase tracking-widest text-sm hover:bg-red-500 hover:text-white transition-all group">
                            <i class="fa-solid fa-lock group-hover:shake"></i>
                            Submit Feedback to Unlock
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT AREA --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- LEFT: DETAILS --}}
        <div class="lg:col-span-4 space-y-8">
            
            {{-- Contact Information Card --}}
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden group">
                <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-3">
                        <i class="fa-solid fa-address-card text-blue"></i> Contact Intelligence
                    </h3>
                </div>
                
                <div class="p-4 space-y-2">
                    @php
                        $contactItems = [
                            ['label' => 'Primary Email', 'icon' => 'fa-envelope', 'value' => $user->email, 'locked' => !($connected && $hasFeedback)],
                            ['label' => 'Phone Network', 'icon' => 'fa-phone-volume', 'value' => $user->phone ?? 'Not Registered', 'locked' => !($connected && $hasFeedback)],
                            ['label' => 'High Court Jurisdiction', 'icon' => 'fa-gavel', 'value' => $profile?->high_court ?? 'Not Specified', 'locked' => !$connected],
                        ];
                    @endphp

                    @foreach($contactItems as $item)
                        <div class="relative bg-navy/40 border border-white/5 p-5 rounded-2xl hover:border-blue/20 hover:bg-navy transition-all overflow-hidden group/item">
                            @if($item['locked'])
                                <div class="absolute inset-0 backdrop-blur-md bg-navy/60 z-10 flex flex-col items-center justify-center gap-1 opacity-0 group-hover/item:opacity-100 transition-opacity">
                                    <i class="fa-solid fa-lock text-blue text-lg"></i>
                                    <span class="text-[8px] font-black text-white uppercase tracking-tighter">Information Encrypted</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-5 relative z-0">
                                <div class="w-12 h-12 rounded-xl bg-navy flex items-center justify-center text-blue border border-white/5 shadow-inner">
                                    <i class="fa-solid {{ $item['icon'] }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.2em] mb-1">{{ $item['label'] }}</p>
                                    <p class="text-sm font-bold text-white truncate {{ $item['locked'] ? 'blur-[5px] select-none opacity-20' : '' }}">
                                        {{ $item['locked'] ? str_repeat('•', 15) : $item['value'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Experience Card --}}
            @if($profile?->experience_years || $profile?->practice_areas)
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                        <h3 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-3">
                            <i class="fa-solid fa-briefcase text-blue"></i> Professional Experience
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        @if($profile?->experience_years)
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-white/40 uppercase tracking-wider">Years Active</span>
                                <span class="px-4 py-1.5 rounded-xl bg-blue/10 border border-blue/20 text-blue font-black text-sm">{{ $profile->experience_years }} Years</span>
                            </div>
                        @endif

                        @if($profile?->practice_areas)
                            <div>
                                <span class="block text-xs font-bold text-white/40 uppercase tracking-wider mb-4">Core Specializations</span>
                                @if($connected)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $profile->practice_areas) as $area)
                                            <span class="px-3 py-1.5 rounded-lg bg-navy border border-white/5 text-[10px] font-bold text-white/60 hover:text-white hover:border-blue/30 transition-all cursor-default uppercase">
                                                {{ trim($area) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-6 rounded-2xl bg-navy/40 border border-white/5 border-dashed text-center">
                                        <i class="fa-solid fa-shield-slash text-white/10 text-3xl mb-3"></i>
                                        <p class="text-[10px] font-black text-white/30 uppercase tracking-widest">Connect to view practice areas</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Rating Breakdown --}}
            @if ($feedbacks->count())
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                        <h3 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-3">
                            <i class="fa-solid fa-chart-line text-blue"></i> Rating Performance
                        </h3>
                    </div>
                    <div class="p-8 space-y-5">
                        @php
                            $ratingCounts = $feedbacks->groupBy('rating')->map->count();
                            $total = $feedbacks->count();
                        @endphp
                        @for ($star = 5; $star >= 1; $star--)
                            @php
                                $cnt = $ratingCounts[$star] ?? 0;
                                $pct = $total ? round(($cnt / $total) * 100) : 0;
                            @endphp
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                                    <span class="text-white/40">{{ $star }} Star Recognition</span>
                                    <span class="text-blue">{{ $cnt }}</span>
                                </div>
                                <div class="h-2 w-full bg-navy rounded-full overflow-hidden border border-white/5 p-[1px]">
                                    <div class="h-full bg-linear-to-r from-blue to-blue/40 rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(59,130,246,0.3)]" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endif
        </div>

        {{-- RIGHT: REVIEWS & BIO --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- Bio Card --}}
            @if ($profile?->bio)
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden relative group">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                        <h3 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-3">
                            <i class="fa-solid fa-user-gear text-blue"></i> About the Professional
                        </h3>
                    </div>
                    <div class="p-8 relative">
                        @if ($connected)
                            <p class="text-white/60 font-medium leading-loose text-lg italic bg-navy/40 p-8 rounded-[32px] border border-white/5">
                                <i class="fa-solid fa-quote-left text-blue/30 text-4xl -mb-6 mr-4"></i>
                                {{ $profile->bio }}
                                <i class="fa-solid fa-quote-right text-blue/30 text-4xl -mt-6 ml-4"></i>
                            </p>
                        @else
                            <div class="relative min-h-[200px] flex items-center justify-center overflow-hidden rounded-[32px] bg-navy/40 border border-white/5 border-dashed">
                                <div class="absolute inset-0 blur-2xl opacity-20 pointer-events-none p-10 leading-relaxed font-serif text-white italic">
                                    {{ $profile->bio }} {{ $profile->bio }}
                                </div>
                                <div class="relative z-10 flex flex-col items-center gap-6 text-center px-12">
                                    <div class="w-16 h-16 rounded-3xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-2xl shadow-xl shadow-blue/5">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <div class="space-y-2">
                                        <h4 class="text-lg font-black text-white uppercase tracking-widest">Biography Encrypted</h4>
                                        <p class="text-sm font-bold text-white/30 uppercase tracking-widest leading-relaxed">Secure a connection with this advocate to review their professional background and expertise.</p>
                                    </div>
                                    <button onclick="sendConnectProfile({{ $user->id }})" class="px-8 py-4 rounded-2xl bg-blue text-white font-black uppercase tracking-widest text-xs hover:bg-blue/80 transition-all active:scale-95">
                                        Request Access
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Reviews Card --}}
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col min-h-[500px]">
                <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-3">
                        <i class="fa-solid fa-star-half-stroke text-blue"></i> Professional Testimonials
                    </h3>
                    @if ($feedbacks->count())
                        <div class="flex items-center gap-4 bg-navy/40 px-5 py-2.5 rounded-2xl border border-white/5">
                             <div class="flex gap-1">
                                @for($i=1;$i<=5;$i++)
                                    <i class="fa-solid fa-star text-[8px] {{ $i <= floor($avgRating) ? 'text-blue' : 'text-white/10' }}"></i>
                                @endfor
                             </div>
                             <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ number_format($avgRating, 1) }} Score</span>
                        </div>
                    @endif
                </div>
                
                <div class="flex-1 divide-y divide-white/5 custom-scrollbar">
                    @forelse($feedbacks as $fb)
                        <div class="p-8 hover:bg-white/[0.02] transition-all group">
                            <div class="flex items-start gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-blue to-navy border border-white/10 flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-all duration-500">
                                    <span class="text-xl font-black text-white uppercase">
                                        {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'A', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                        <div>
                                            <h4 class="font-black text-white uppercase tracking-widest text-sm mb-1 group-hover:text-blue transition-colors">
                                                {{ $fb->is_anonymous ? 'Anonymous Member' : $fb->giver->name ?? 'Unknown Member' }}
                                            </h4>
                                            <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] flex items-center gap-2">
                                                <i class="fa-regular fa-calendar-check text-blue/40"></i>
                                                {{ $fb->created_at->format('M d, Y') }}
                                                <span class="text-white/5 font-normal mx-1">|</span>
                                                {{ $fb->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="flex gap-1.5 bg-navy px-4 py-2 rounded-xl border border-white/5 group-hover:border-blue/20 transition-all">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star text-[10px] {{ $i <= $fb->rating ? 'text-blue shadow-blue/50' : 'text-white/10' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    @if ($fb->comment)
                                        <div class="relative bg-navy/40 p-6 rounded-3xl border border-white/5 group-hover:border-white/10 group-hover:bg-navy transition-all overflow-hidden italic text-white/70 leading-relaxed font-medium">
                                            <i class="fa-solid fa-quote-left absolute top-4 left-4 text-blue/5 text-4xl"></i>
                                            "{{ $fb->comment }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex-1 flex flex-col items-center justify-center p-12 text-center">
                            <div class="w-24 h-24 bg-navy rounded-[32px] flex items-center justify-center mb-8 border border-white/5 shadow-inner">
                                <i class="fa-solid fa-comments text-4xl text-white/10"></i>
                            </div>
                            <h4 class="text-lg font-black text-white uppercase tracking-widest mb-3">No Testimonials Found</h4>
                            <p class="text-sm font-bold text-white/20 uppercase tracking-[0.2em] max-w-xs">Be the first to provide professional feedback for this advocate.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

            function sendConnectProfile(userId) {
                const btn = document.getElementById('connectBtn');
                if(!btn) return;
                
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin"></i> Initializing...';
                
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
                        btn.classList.remove('bg-blue');
                        btn.classList.add('bg-white/5', 'text-white/40', 'border', 'border-white/10');
                        btn.innerHTML = '<i class="fa-solid fa-clock"></i> Request Sent';
                    })
                    .catch(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Try Again';
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

