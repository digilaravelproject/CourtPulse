@extends('layouts.main')

@section('title', 'Find Professionals — DockIt')

@section('content')
<style>
    .glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.06);
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--accent);
        box-shadow: 0 10px 30px rgba(180, 180, 254, 0.1);
    }

    .filter-panel {
        position: sticky;
        top: 100px;
        height: min-content;
    }

    .tab-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 2px solid transparent;
        color: var(--text2);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
    }

    .tab-btn.active {
        border-bottom: 2px solid var(--accent);
        color: var(--white);
    }

    .tab-btn:hover {
        color: var(--white);
    }

    .stat-badge {
        background: rgba(180, 180, 254, 0.1);
        color: var(--accent);
        font-weight: 800;
        font-size: 0.65rem;
        padding: 4px 10px;
        border-radius: 4px;
        text-transform: uppercase;
    }

    input[type="text"], select {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        height: 48px;
        padding: 12px 16px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    input[type="text"]:focus, select:focus {
        border-color: var(--accent) !important;
        background: rgba(255, 255, 255, 0.08) !important;
        outline: none !important;
        box-shadow: 0 0 15px rgba(180, 180, 254, 0.15);
    }

    .profile-blur {
        filter: blur(4px);
        user-select: none;
        pointer-events: none;
    }
</style>

<div class="max-w-[1500px] mx-auto px-6 py-12">
    <!-- Header Section -->
    <div class="mb-16">
        <span class="section-label">Intelligent Search</span>
        <h1 class="section-head mb-4 tracking-tighter">PROFESSIONAL <span class="text-(--accent)">DIRECTORY</span></h1>
        <p class="text-slate-400 max-w-2xl text-lg">Connect with verified court clerks, advocates, and procedural specialists across 2,000+ Indian judicial forums.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        <!-- Sidebar Filters -->
        <aside class="lg:col-span-1">
            <div class="filter-panel glass rounded-2xl p-8">
                <form action="{{ route('find') }}" method="GET" id="search-form">
                    <input type="hidden" name="category" value="{{ $category }}">
                    
                    <div class="space-y-8">
                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 block">Location City</label>
                            <input type="text" name="city" value="{{ request('city') }}" placeholder="Ex: Mumbai, Delhi..." class="w-full rounded-lg">
                        </div>

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 block">State</label>
                            <select name="state" class="w-full rounded-lg appearance-none">
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if(in_array($category, ['court_clerk', 'advocate']))
                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 block">Court / Tribunal</label>
                            <input type="text" name="court" value="{{ request('court') }}" placeholder="Ex: High Court, NCLT..." class="w-full rounded-lg">
                        </div>
                        @endif

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 block">Specialization / Domain</label>
                            <input type="text" name="domain" value="{{ request('domain') }}" placeholder="Ex: Corporate, Criminal..." class="w-full rounded-lg">
                        </div>

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 block">Min. Experience (Years)</label>
                            <div class="flex items-center gap-4">
                                <input type="range" name="exp" min="0" max="40" value="{{ request('exp', 0) }}" class="flex-1 accent-(--accent)" id="expRange">
                                <span class="text-white font-bold" id="expVal">{{ request('exp', 0) }}+</span>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn-primary w-full py-4 text-sm tracking-widest">
                                APPLY FILTERS
                            </button>
                            <a href="{{ route('find', ['category' => $category]) }}" class="text-center block mt-4 text-[0.7rem] text-slate-500 hover:text-white uppercase font-bold tracking-widest no-underline">Reset All</a>
                        </div>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Main Content (Results) -->
        <main class="lg:col-span-3">
            <!-- category Tabs -->
            <div class="flex items-center gap-10 mb-10 border-b border-white/5 pb-2 overflow-x-auto whitespace-nowrap scrollbar-hide">
                <a href="{{ route('find', ['category' => 'court_clerk'] + request()->except('category')) }}" class="tab-btn pb-4 no-underline {{ $category == 'court_clerk' ? 'active' : '' }}">
                    Court Clerks
                </a>
                <a href="{{ route('find', ['category' => 'ip_clerk'] + request()->except('category')) }}" class="tab-btn pb-4 no-underline {{ $category == 'ip_clerk' ? 'active' : '' }}">
                    IP Specialists
                </a>
                <a href="{{ route('find', ['category' => 'roc_agent'] + request()->except('category')) }}" class="tab-btn pb-4 no-underline {{ $category == 'roc_agent' ? 'active' : '' }}">
                    RoC Agents
                </a>
                <a href="{{ route('find', ['category' => 'advocate'] + request()->except('category')) }}" class="tab-btn pb-4 no-underline {{ $category == 'advocate' ? 'active' : '' }}">
                    Advocates
                </a>
            </div>

            <!-- Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-8">
                @forelse($users as $u)
                    <div class="glass p-8 rounded-2xl flex flex-col justify-between transition-all duration-300 card-hover relative group">
                        
                        <!-- Top Row: Avatar & Status -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-800 border border-white/10 p-1">
                                    <img src="{{ $u->profile_photo ? asset('storage/' . $u->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=111830&color=B4B4FE' }}" class="w-full h-full object-cover rounded-lg" alt="Profile">
                                </div>
                                <div>
                                        <h3 class="text-white font-extrabold text-xl m-0 {{ Auth::guest() ? 'profile-blur' : '' }}">
                                        {{ Auth::guest() ? 'Professional User' : $u->name }}
                                        @if($u->is_reviewed)
                                            <i class="bi bi-patch-check-fill text-(--accent) text-lg align-middle ml-1"></i>
                                        @endif
                                    </h3>
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">
                                        {{ strtoupper(str_replace('_', ' ', $u->sub_role ?? $u->role)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="stat-badge">{{ $u->experience_years ?? 0 }} Yrs Exp</span>
                                <div class="flex items-center gap-1 text-(--accent) text-[0.7rem] font-black uppercase">
                                    <i class="bi bi-star-fill"></i> 4.8
                                </div>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <span class="text-slate-300">{{ $u->city }}, {{ $u->state }}</span>
                            </div>

                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-braces-asterisk"></i>
                                </div>
                                <span class="text-slate-300 line-clamp-1 italic">{{ $u->capabilities ?? 'Procedural Expert' }}</span>
                            </div>

                            @if($category == 'court_clerk' && $u->clerkProfile)
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-bank"></i>
                                </div>
                                <span class="text-slate-300">{{ $u->clerkProfile->court_name }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-6 border-t border-white/5 mt-auto">
                            <div class="flex items-center justify-between gap-4">
                                <a href="{{ route('user.detail', $u->id) }}" class="text-[0.65rem] font-black text-slate-500 hover:text-white uppercase tracking-widest no-underline border-b border-transparent hover:border-white transition pb-1">
                                    See Past feedback Before Contacting 
                                </a>
                                
                                @auth
                                    @php $connStatus = App\Models\ConnectionRequest::getStatus(Auth::id(), $u->id); @endphp
                                    
                                    @if($u->id != Auth::id())
                                        @if($connStatus == 'none')
                                            <button onclick="sendRequest({{ $u->id }}, this)" class="btn-primary shrink-0 text-[0.65rem]! px-4! py-3!">
                                                CONNECT
                                            </button>
                                        @elseif($connStatus == 'sent')
                                            <button disabled class="btn-ghost shrink-0 text-[0.65rem]! px-4! py-3! opacity-50!">
                                                REQUESTED
                                            </button>
                                        @elseif($connStatus == 'connected')
                                            <span class="text-(--accent) font-black text-[0.6rem] uppercase tracking-widest">
                                                <i class="bi bi-link-45deg"></i> CONNECTED
                                            </span>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn-primary shrink-0 text-[0.65rem]! px-4! py-3!">
                                        LOGIN TO CONNECT
                                    </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-2 py-24 text-center glass rounded-2xl">
                        <i class="bi bi-search text-6xl text-slate-800 mb-6 block"></i>
                        <h2 class="text-white font-black uppercase tracking-tighter">No Professionals Found</h2>
                        <p class="text-slate-500">Try adjusting your filters or checking another category.</p>
                        <a href="{{ route('find') }}" class="btn-ghost inline-block mt-6">Clear All Filters</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $users->links() }}
            </div>
        </main>
    </div>
</div>

@auth
<script>
    function sendRequest(receiverId, btn) {
        const originalText = btn.innerText;
        btn.innerText = 'SENDING...';
        btn.disabled = true;

        fetch('{{ route('connections.send') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ receiver_id: receiverId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'sent') {
                btn.innerText = 'REQUESTED';
                btn.classList.replace('btn-primary', 'btn-ghost');
                btn.style.opacity = '0.5';
            } else {
                alert(data.message || 'Error occurred');
                btn.innerText = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            btn.innerText = originalText;
            btn.disabled = false;
        });
    }
</script>
@endauth

<script>
    // Slider value display
    const range = document.getElementById('expRange');
    const label = document.getElementById('expVal');
    if(range) {
        range.addEventListener('input', (e) => {
            label.innerText = e.target.value + '+';
        });
    }
</script>
@endsection
