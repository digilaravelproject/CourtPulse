@extends('layouts.advocate')
@section('title', 'Browse Guests')
@section('page-title', 'Browse Guests')

@section('content')
    <div x-data="guestsPage()" x-init="init()">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3 mb-5">
            <div>
                <h1 class="text-2xl font-bold text-white" style="font-family:'Playfair Display',serif">Browse Guests</h1>
                <p class="text-sm mt-0.5" style="color:rgba(255,255,255,.4)">View guest profiles registered on Court Pulse</p>
            </div>
            <span class="font-mono text-xs px-3 py-1.5 rounded-lg"
                style="background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);color:#D4AF37"
                x-text="total + ' guests'">{{ $guests->total() }} guests</span>
        </div>

        {{-- Search --}}
        <div class="rounded-2xl p-4 mb-5" style="background:#1a2744;border:1px solid rgba(255,255,255,.07)">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block font-mono text-[0.6rem] tracking-widest uppercase mb-1.5"
                        style="color:rgba(212,175,55,.6)">Name</label>
                    <input x-model="filters.search" @input.debounce.400ms="fetchGuests()" type="text"
                        placeholder="Search by name..."
                        class="w-full px-3 py-2.5 rounded-xl text-sm text-white placeholder-white/20 focus:outline-none transition"
                        style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);focus-border-color:#D4AF37">
                </div>
                <div>
                    <label class="block font-mono text-[0.6rem] tracking-widest uppercase mb-1.5"
                        style="color:rgba(212,175,55,.6)">City</label>
                    <input x-model="filters.city" @input.debounce.400ms="fetchGuests()" type="text"
                        placeholder="Filter by city..."
                        class="w-full px-3 py-2.5 rounded-xl text-sm text-white placeholder-white/20 focus:outline-none transition"
                        style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1)">
                </div>
            </div>
            <div class="flex gap-2">
                <button @click="fetchGuests()"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all"
                    style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                    onmouseout="this.style.background='#D4AF37'">
                    <i class="bi bi-search"></i> Search
                </button>
                <button x-show="hasFilters()" @click="clearFilters()"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all"
                    style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5)">
                    <i class="bi bi-x"></i> Clear
                </button>
            </div>
        </div>

        {{-- Loading --}}
        <div x-show="loading" class="flex items-center justify-center py-20">
            <div class="w-8 h-8 rounded-full border-2 border-t-transparent animate-spin"
                style="border-color:#D4AF37;border-top-color:transparent"></div>
        </div>

        {{-- Grid --}}
        <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="guest in guests" :key="guest.id">
                <div class="rounded-2xl p-4 transition-all hover:scale-[1.01] flex flex-col h-full"
                    style="background:#1a2744;border:1px solid rgba(255,255,255,.07)">

                    {{-- Avatar + Name --}}
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg flex-shrink-0"
                            style="background:linear-gradient(135deg,rgba(212,175,55,.2),rgba(181,149,47,.1));border:1.5px solid rgba(212,175,55,.25);color:#D4AF37"
                            x-text="guest.name.charAt(0).toUpperCase()"></div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-white truncate" style="font-size:.9rem" x-text="guest.name">
                            </div>
                            <div class="font-mono text-[0.55rem] tracking-widest uppercase"
                                style="color:rgba(212,175,55,.6)">Guest User</div>
                        </div>
                        <span class="font-mono text-[0.55rem] tracking-wide px-2 py-0.5 rounded-md uppercase font-bold"
                            style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2);color:#4ade80">
                            Active
                        </span>
                    </div>

                    {{-- Details --}}
                    <div class="space-y-1.5 mb-5">
                        <div class="flex items-center gap-2 text-xs" style="color:rgba(255,255,255,.4)">
                            <i class="bi bi-envelope flex-shrink-0" style="color:#D4AF37"></i>
                            <span class="truncate" x-text="guest.email"></span>
                        </div>
                        <div class="flex items-center gap-2 text-xs" style="color:rgba(255,255,255,.4)" x-show="guest.city">
                            <i class="bi bi-geo-alt flex-shrink-0" style="color:#D4AF37"></i>
                            <span x-text="guest.city"></span>
                        </div>
                        <div class="flex items-center gap-2 text-xs" style="color:rgba(255,255,255,.4)">
                            <i class="bi bi-calendar3 flex-shrink-0" style="color:#D4AF37"></i>
                            <span
                                x-text="'Joined ' + new Date(guest.created_at).toLocaleDateString('en-IN',{month:'short',year:'numeric'})"></span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-auto pt-3 border-t" style="border-color:rgba(255,255,255,.05)">
                        <div class="flex items-center gap-2">
                            <a :href="`{{ url('advocate/guests') }}/${guest.id}`"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold no-underline transition-all"
                                style="background:rgba(212,175,55,.05);border:1px solid rgba(212,175,55,.2);color:#D4AF37"
                                onmouseover="this.style.background='rgba(212,175,55,.1)'"
                                onmouseout="this.style.background='rgba(212,175,55,.05)'">
                                <i class="bi bi-person-lines-fill"></i> View
                            </a>

                            {{-- Connection States --}}
                            <template x-if="guest.connection_status === 'none'">
                                <button @click="sendConnection(guest.id)"
                                    class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all"
                                    style="background:#D4AF37;color:#0e0e0f" onmouseover="this.style.background='#B5952F'"
                                    onmouseout="this.style.background='#D4AF37'">
                                    <i class="bi bi-person-plus-fill"></i> Connect
                                </button>
                            </template>

                            <template x-if="guest.connection_status === 'sent'">
                                <button disabled
                                    class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all"
                                    style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.4);cursor:not-allowed">
                                    <i class="bi bi-clock-history"></i> Pending
                                </button>
                            </template>

                            {{-- ✅ ACCEPT BUTTON ADDED HERE --}}
                            <template x-if="guest.connection_status === 'received'">
                                <button @click="acceptConnection(guest)"
                                    class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-lg hover:opacity-90"
                                    style="background:#10b981;color:#ffffff;border:1px solid #059669;">
                                    <i class="bi bi-check-circle-fill"></i> Accept
                                </button>
                            </template>

                            <template x-if="guest.connection_status === 'connected'">
                                <button disabled
                                    class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all"
                                    style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2);color:#4ade80;cursor:default">
                                    <i class="bi bi-check-circle-fill"></i> Connected
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Empty --}}
            <div x-show="!loading && guests.length === 0" class="col-span-full rounded-2xl p-14 text-center"
                style="background:#1a2744;border:1px solid rgba(255,255,255,.07)">
                <div class="text-4xl mb-3">👤</div>
                <p class="font-medium" style="color:rgba(255,255,255,.4)">No guests found.</p>
            </div>
        </div>

        {{-- Pagination --}}
        <div x-show="!loading && totalPages > 1" class="flex items-center justify-center gap-2 mt-6 flex-wrap">
            <button @click="goPage(currentPage-1)" :disabled="currentPage <= 1"
                class="px-3 py-2 rounded-xl text-sm transition-all disabled:opacity-30"
                style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5)">
                <i class="bi bi-chevron-left"></i>
            </button>
            <template x-for="p in pageList()" :key="p">
                <button @click="p!=='...' && goPage(p)"
                    :style="p === currentPage ? 'background:#D4AF37;color:#060C18;border-color:#D4AF37' :
                        'background:rgba(255,255,255,.05);border-color:rgba(255,255,255,.1);color:rgba(255,255,255,.5)'"
                    class="min-w-[36px] px-3 py-2 rounded-xl border text-sm font-mono transition-all"
                    x-text="p"></button>
            </template>
            <button @click="goPage(currentPage+1)" :disabled="currentPage >= totalPages"
                class="px-3 py-2 rounded-xl text-sm transition-all disabled:opacity-30"
                style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5)">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

    </div>

    @push('scripts')
        <script>
            function guestsPage() {
                return {
                    guests: @json($guests->items()),
                    total: {{ $guests->total() }},
                    currentPage: {{ $guests->currentPage() }},
                    totalPages: {{ $guests->lastPage() }},
                    loading: false,
                    filters: {
                        search: '{{ request('search', '') }}',
                        city: '{{ request('city', '') }}'
                    },

                    init() {},
                    hasFilters() {
                        return Object.values(this.filters).some(v => v !== '');
                    },
                    clearFilters() {
                        this.filters = {
                            search: '',
                            city: ''
                        };
                        this.fetchGuests();
                    },
                    goPage(p) {
                        if (p < 1 || p > this.totalPages) return;
                        this.currentPage = p;
                        this.fetchGuests();
                    },

                    pageList() {
                        const pages = [],
                            tp = this.totalPages,
                            cp = this.currentPage;
                        if (tp <= 7) {
                            for (let i = 1; i <= tp; i++) pages.push(i);
                            return pages;
                        }
                        pages.push(1);
                        if (cp > 3) pages.push('...');
                        for (let i = Math.max(2, cp - 1); i <= Math.min(tp - 1, cp + 1); i++) pages.push(i);
                        if (cp < tp - 2) pages.push('...');
                        pages.push(tp);
                        return pages;
                    },

                    async fetchGuests() {
                        this.loading = true;
                        try {
                            const params = new URLSearchParams({
                                ...this.filters,
                                page: this.currentPage,
                                ajax: 1
                            });
                            const res = await fetch(`{{ route('advocate.guests') }}?${params}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await res.json();
                            this.guests = data.data;
                            this.total = data.total;
                            this.totalPages = data.last_page;
                            this.currentPage = data.current_page;
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        } catch (e) {
                            console.error(e);
                        } finally {
                            this.loading = false;
                        }
                    },

                    // ✅ Send Connect Request
                    async sendConnection(userId) {
                        try {
                            const res = await fetch(`{{ route('connections.send') }}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    receiver_id: userId
                                })
                            });
                            if (res.ok) {
                                const guest = this.guests.find(g => g.id === userId);
                                if (guest) guest.connection_status = 'sent';
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    },

                    // ✅ Accept Received Request
                    async acceptConnection(guest) {
                        if (!guest.connection_req_id) {
                            // Agar cache/purana data hai aur ID missing hai, to uski profile par bhej do
                            window.location.href = `{{ url('advocate/guests') }}/${guest.id}`;
                            return;
                        }

                        try {
                            const res = await fetch(`/connections/${guest.connection_req_id}/accept`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });
                            if (res.ok) {
                                guest.connection_status = 'connected';
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
