@extends('layouts.clerk')
@section('title', 'Browse Guests')
@section('page-title', 'Browse Guests')
@section('content')
<div x-data="guestsPage()" x-init="init()">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Browse Guests</h1>
            <p class="text-sm text-white/50">View guest profiles registered on DockIt.</p>
        </div>
        <span class="text-sm font-semibold text-white/60 bg-navy3 border border-white/5 px-4 py-2 rounded-full">{{ $guests->total() }} guests found</span>
    </div>

    <div class="bg-navy2 border border-white/5 rounded-2xl p-5 mb-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-mono text-xs tracking-widest uppercase text-white/40 mb-1.5">Name</label>
                <input x-model="filters.search" @input.debounce.400ms="fetchGuests()" type="text" placeholder="Search by name..."
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-navy text-white text-sm font-semibold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition placeholder-white/20">
            </div>
            <div>
                <label class="block font-mono text-xs tracking-widest uppercase text-white/40 mb-1.5">City</label>
                <input x-model="filters.city" @input.debounce.400ms="fetchGuests()" type="text" placeholder="Filter by city..."
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-navy text-white text-sm font-semibold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition placeholder-white/20">
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button @click="fetchGuests()" class="btn-primary"><i class="fas fa-search"></i> Search</button>
            <button x-show="hasFilters()" @click="clearFilters()" class="btn-secondary"><i class="fas fa-times"></i> Clear</button>
            <div x-show="loading" class="flex items-center gap-2 text-sm text-white/50">
                <svg class="animate-spin w-4 h-4 text-blue" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Searching...
            </div>
        </div>
    </div>

    <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <template x-for="guest in guests" :key="guest.id">
            <div class="bg-navy2 border border-white/5 rounded-2xl p-5 hover:border-blue/30 transition-all flex flex-col h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg shrink-0" style="background:linear-gradient(135deg,#B4B4FE,#9999f0);color:#050812" x-text="guest.name.charAt(0).toUpperCase()"></div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-white truncate" x-text="guest.name"></div>
                        <div class="font-mono text-[0.6rem] tracking-widest uppercase text-blue">DockIt User</div>
                    </div>
                    <span class="flex items-center gap-1 text-[0.6rem] font-semibold px-2 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/20"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Active</span>
                </div>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-sm text-white/50"><i class="fas fa-envelope text-blue text-xs shrink-0"></i><span class="truncate" x-text="guest.email"></span></div>
                    <div class="flex items-center gap-2 text-sm text-white/50" x-show="guest.city"><i class="fas fa-map-marker-alt text-blue text-xs shrink-0"></i><span x-text="guest.city"></span></div>
                    <div class="flex items-center gap-2 text-sm text-white/50"><i class="fas fa-calendar text-blue text-xs shrink-0"></i><span x-text="'Joined ' + new Date(guest.created_at).toLocaleDateString('en-IN',{month:'short',year:'numeric'})"></span></div>
                </div>
                <div class="mt-auto pt-4 border-t border-white/5 flex gap-2">
                    <a :href="`{{ route('support.guest.profile', '') }}/${guest.id}`" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold no-underline transition-all border border-white/10 text-white/60 hover:bg-white/5"><i class="fas fa-user"></i> View</a>
                    <template x-if="guest.connection_status === 'none'"><button @click="sendConnection(guest.id)" class="btn-primary flex-1"><i class="fas fa-user-plus"></i> Connect</button></template>
                    <template x-if="guest.connection_status === 'sent'"><button disabled class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold bg-white/5 border border-white/10 text-white/40 cursor-not-allowed"><i class="fas fa-clock"></i> Pending</button></template>
                    <template x-if="guest.connection_status === 'received'"><button @click="acceptConnection(guest)" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all" style="background:#10b981;color:#ffffff;border:1px solid #059669;"><i class="fas fa-check-circle"></i> Accept</button></template>
                    <template x-if="guest.connection_status === 'connected'"><button disabled class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold bg-green-500/10 text-green-400 border border-green-500/20 cursor-default"><i class="fas fa-check-circle"></i> Connected</button></template>
                </div>
            </div>
        </template>
        <div x-show="!loading && guests.length === 0" class="col-span-full bg-navy2 border border-white/5 rounded-2xl p-14 text-center"><i class="fas fa-user-search text-5xl text-white/10 block mb-3"></i><p class="text-white/50 font-medium">No guests found.</p></div>
    </div>

    <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <template x-for="i in 6" :key="i"><div class="bg-navy2 border border-white/5 rounded-2xl p-5 animate-pulse"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-white/5"></div><div class="flex-1"><div class="h-4 bg-white/5 rounded mb-2 w-3/4"></div><div class="h-3 bg-white/5 rounded w-1/2"></div></div></div><div class="space-y-2 mb-4"><div class="h-3 bg-white/5 rounded"></div><div class="h-3 bg-white/5 rounded w-2/3"></div></div><div class="h-10 bg-white/5 rounded-xl"></div></div></template>
    </div>

    <div x-show="!loading && totalPages > 1" class="flex items-center justify-center gap-2 mt-6 flex-wrap">
        <button @click="goPage(currentPage-1)" :disabled="currentPage <= 1" class="px-3 py-2 rounded-xl border border-white/10 text-sm text-white/50 hover:border-blue hover:text-blue transition-all disabled:opacity-40 disabled:cursor-not-allowed bg-navy2"><i class="fas fa-chevron-left"></i></button>
        <template x-for="p in pageList()" :key="p"><button @click="p!=='...' && goPage(p)" :class="p === currentPage ? 'border-blue text-blue font-bold bg-blue/10' : 'border-white/10 text-white/50 hover:border-blue hover:text-blue bg-navy2'" class="min-w-[36px] px-3 py-2 rounded-xl border text-sm transition-all" x-text="p"></button></template>
        <button @click="goPage(currentPage+1)" :disabled="currentPage >= totalPages" class="px-3 py-2 rounded-xl border border-white/10 text-sm text-white/50 hover:border-blue hover:text-blue transition-all disabled:opacity-40 disabled:cursor-not-allowed bg-navy2"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

@push('scripts')
<script>
function guestsPage() {
    return {
        guests: @json($guests->items()), total: {{ $guests->total() }}, currentPage: {{ $guests->currentPage() }}, totalPages: {{ $guests->lastPage() }}, loading: false,
        filters: { search: '{{ request('search', '') }}', city: '{{ request('city', '') }}' },
        init() {}, hasFilters() { return Object.values(this.filters).some(v => v !== ''); },
        clearFilters() { this.filters = { search: '', city: '' }; this.fetchGuests(); },
        goPage(p) { if (p < 1 || p > this.totalPages) return; this.currentPage = p; this.fetchGuests(); },
        pageList() { const pages = [], tp = this.totalPages, cp = this.currentPage; if (tp <= 7) { for (let i = 1; i <= tp; i++) pages.push(i); return pages; } pages.push(1); if (cp > 3) pages.push('...'); for (let i = Math.max(2, cp - 1); i <= Math.min(tp - 1, cp + 1); i++) pages.push(i); if (cp < tp - 2) pages.push('...'); pages.push(tp); return pages; },
        async fetchGuests() { this.loading = true; try { const params = new URLSearchParams({ ...this.filters, page: this.currentPage, ajax: 1 }); const res = await fetch(`{{ route('support.guests') }}?${params}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }); const data = await res.json(); this.guests = data.data; this.total = data.total; this.totalPages = data.last_page; this.currentPage = data.current_page; window.scrollTo({ top: 0, behavior: 'smooth' }); } catch (e) { console.error(e); } finally { this.loading = false; } },
        async sendConnection(userId) { try { const res = await fetch(`{{ route('connections.send') }}`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ receiver_id: userId }) }); if (res.ok) { const guest = this.guests.find(g => g.id === userId); if (guest) guest.connection_status = 'sent'; } } catch (e) { console.error(e); } },
        async acceptConnection(guest) { if (!guest.connection_req_id) { window.location.href = `{{ route('support.guest.profile', '') }}/${guest.id}`; return; } try { const res = await fetch(`/connections/${guest.connection_req_id}/accept`, { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }); if (res.ok) { guest.connection_status = 'connected'; } } catch (e) { console.error(e); } }
    }
}
</script>
@endpush
@endsection
                        placeholder="Filter by city..."
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700
                              focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button @click="fetchGuests()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                    style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                    onmouseout="this.style.background='#D4AF37'">
                    <i class="bi bi-search"></i> Search
                </button>
                <button x-show="hasFilters()" @click="clearFilters()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 text-gray-600 hover:border-gray-300 bg-white transition-all">
                    <i class="bi bi-x-lg"></i> Clear
                </button>
                <div x-show="loading" class="flex items-center gap-2 text-sm text-text-muted-light">
                    <svg class="animate-spin w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Searching...
                </div>
            </div>
        </div>

        {{-- Grid --}}
        <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="guest in guests" :key="guest.id">
                <div
                    class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all flex flex-col h-full">

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg shrink-0 text-white"
                            style="background:linear-gradient(135deg,#D4AF37,#B5952F)"
                            x-text="guest.name.charAt(0).toUpperCase()"></div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-900 truncate" x-text="guest.name"></div>
                            <div class="font-mono text-[0.6rem] tracking-widest uppercase text-primary-dark">Guest User
                            </div>
                        </div>
                        <span
                            class="flex items-center gap-1 text-[0.6rem] font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span> Active
                        </span>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-sm text-text-muted-light">
                            <i class="bi bi-envelope text-primary text-xs shrink-0"></i>
                            <span class="truncate" x-text="guest.email"></span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-text-muted-light" x-show="guest.city">
                            <i class="bi bi-geo-alt text-primary text-xs shrink-0"></i>
                            <span x-text="guest.city"></span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-text-muted-light">
                            <i class="bi bi-calendar3 text-primary text-xs shrink-0"></i>
                            <span
                                x-text="'Joined ' + new Date(guest.created_at).toLocaleDateString('en-IN',{month:'short',year:'numeric'})"></span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">
                        <a :href="`{{ route('support.guest.profile', '') }}/${guest.id}`"
                            class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold no-underline transition-all border border-gray-200 text-gray-600 hover:bg-gray-50">
                            <i class="bi bi-person-lines-fill"></i> View
                        </a>

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
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed">
                                <i class="bi bi-clock-history"></i> Pending
                            </button>
                        </template>

                        <template x-if="guest.connection_status === 'received'">
                            <button @click="acceptConnection(guest)"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-lg hover:opacity-90"
                                style="background:#10b981;color:#ffffff;border:1px solid #059669;">
                                <i class="bi bi-check-circle-fill"></i> Accept
                            </button>
                        </template>

                        <template x-if="guest.connection_status === 'connected'">
                            <button disabled
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all bg-green-50 text-green-600 border border-green-200 cursor-default">
                                <i class="bi bi-patch-check-fill"></i> Connected
                            </button>
                        </template>
                    </div>

                </div>
            </template>

            {{-- Empty --}}
            <div x-show="!loading && guests.length === 0"
                class="col-span-full bg-white border border-gray-200 rounded-2xl p-14 text-center shadow-sm">
                <span class="material-icons-round text-5xl text-gray-200 block mb-3">person_search</span>
                <p class="text-gray-500 font-medium">No guests found.</p>
            </div>
        </div>

        {{-- Loading skeleton --}}
        <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="i in 6" :key="i">
                <div class="bg-white border border-gray-200 rounded-2xl p-5 animate-pulse">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100"></div>
                        <div class="flex-1">
                            <div class="h-4 bg-gray-100 rounded mb-2 w-3/4"></div>
                            <div class="h-3 bg-gray-100 rounded w-1/2"></div>
                        </div>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="h-3 bg-gray-100 rounded"></div>
                        <div class="h-3 bg-gray-100 rounded w-2/3"></div>
                    </div>
                    <div class="h-10 bg-gray-100 rounded-xl"></div>
                </div>
            </template>
        </div>

        {{-- Pagination --}}
        <div x-show="!loading && totalPages > 1" class="flex items-center justify-center gap-2 mt-6 flex-wrap">
            <button @click="goPage(currentPage-1)" :disabled="currentPage <= 1"
                class="px-3 py-2 rounded-xl border border-gray-200 text-sm text-text-muted-light hover:border-primary hover:text-primary-dark transition-all disabled:opacity-40 disabled:cursor-not-allowed bg-white">
                <i class="bi bi-chevron-left"></i>
            </button>
            <template x-for="p in pageList()" :key="p">
                <button @click="p!=='...' && goPage(p)"
                    :class="p === currentPage ? 'border-primary text-primary-dark font-bold bg-primary/5' :
                        'border-gray-200 text-text-muted-light hover:border-primary hover:text-primary-dark bg-white'"
                    class="min-w-[36px] px-3 py-2 rounded-xl border text-sm transition-all" x-text="p"></button>
            </template>
            <button @click="goPage(currentPage+1)" :disabled="currentPage >= totalPages"
                class="px-3 py-2 rounded-xl border border-gray-200 text-sm text-text-muted-light hover:border-primary hover:text-primary-dark transition-all disabled:opacity-40 disabled:cursor-not-allowed bg-white">
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
                            const res = await fetch(`{{ route('support.guests') }}?${params}`, {
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
                            window.location.href = `{{ route('support.guest.profile', '') }}/${guest.id}`;
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
