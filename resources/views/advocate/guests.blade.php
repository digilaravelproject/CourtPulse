@extends('layouts.advocate')
@section('title', 'Browse Guests')
@section('page-title', 'Browse Guests')

@section('content')
<div x-data="guestsPage()" x-init="init()">
    <div class="flex items-center justify-between flex-wrap gap-3 mb-5">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-2">Browse Guests</h1>
            <p class="text-xs font-bold text-white/50 uppercase tracking-widest">View guest profiles registered on DockIt</p>
        </div>
        <span class="font-black text-xs px-4 py-2 rounded-xl bg-blue/10 border border-blue/20 text-blue uppercase tracking-widest">{{ $guests->total() }} guests</span>
    </div>

    <div class="bg-navy2 border border-white/5 rounded-2xl p-4 mb-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
            <div>
                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Name</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                    <input x-model="filters.search" @input.debounce.400ms="fetchGuests()" type="text" placeholder="Search by name..."
                        class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">City</label>
                <div class="relative">
                    <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                    <input x-model="filters.city" @input.debounce.400ms="fetchGuests()" type="text" placeholder="Filter by city..."
                        class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner">
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <button @click="fetchGuests()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-blue hover:bg-white text-navy rounded-xl transition-all duration-300 shadow-[0_5px_20px_rgba(180,180,254,0.25)] transform hover:scale-[1.02] active:scale-[0.98]">
                <i class="fas fa-search"></i> Search
            </button>
            <button x-show="hasFilters()" @click="clearFilters()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-white/5 hover:bg-white/10 text-white rounded-xl transition-all duration-300 border border-white/10">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>
    </div>

    <div x-show="loading" class="flex items-center justify-center py-20">
        <div class="w-8 h-8 rounded-full border-2 border-t-transparent animate-spin border-blue border-top-transparent"></div>
    </div>

    <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <template x-for="guest in guests" :key="guest.id">
            <div class="bg-navy2 border border-white/5 rounded-2xl p-4 transition-all hover:border-blue/30 flex flex-col h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-lg shrink-0 bg-blue/10 border border-blue/20 text-blue shadow-[0_0_15px_rgba(180,180,254,0.15)]"
                        x-text="guest.name.charAt(0).toUpperCase()"></div>
                    <div class="flex-1 min-w-0">
                        <div class="font-black text-base text-white uppercase tracking-widest truncate" x-text="guest.name"></div>
                        <div class="font-black text-[10px] tracking-widest uppercase text-white/50">Guest User</div>
                    </div>
                    <span class="font-black text-[10px] tracking-widest px-3 py-1 rounded-md uppercase bg-green-500/10 text-green-400 border border-green-500/20">Active</span>
                </div>

                <div class="space-y-2 mb-6">
                    <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                        <i class="fas fa-envelope shrink-0 text-white/30"></i><span class="truncate" x-text="guest.email"></span>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold text-white/60" x-show="guest.city">
                        <i class="fas fa-map-marker-alt shrink-0 text-white/30"></i><span x-text="guest.city"></span>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold text-white/60">
                        <i class="fas fa-calendar shrink-0 text-white/30"></i><span x-text="'Joined ' + new Date(guest.created_at).toLocaleDateString('en-IN',{month:'short',year:'numeric'})"></span>
                    </div>
                </div>

                <div class="mt-auto pt-3 border-t border-white/5">
                    <div class="flex items-center gap-2">
                        <a :href="`{{ route('advocate.guests.show', '') }}/${guest.id}`" class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 bg-white/5 border border-white/10 text-white hover:bg-white/10">
                            <i class="fas fa-user text-xs"></i> View
                        </a>

                        <template x-if="guest.connection_status === 'none'">
                            <button @click="sendConnection(guest.id)" class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue hover:bg-white text-navy transition-all duration-300 shadow-[0_5px_15px_rgba(180,180,254,0.2)] transform hover:scale-[1.02] active:scale-[0.98]"><i class="fas fa-user-plus text-xs"></i> Connect</button>
                        </template>
                        <template x-if="guest.connection_status === 'sent'">
                            <button disabled class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-amber-500/10 border border-amber-500/20 text-amber-400 cursor-not-allowed transition-all"><i class="fas fa-clock text-xs"></i> Pending</button>
                        </template>
                        <template x-if="guest.connection_status === 'received'">
                            <button @click="acceptConnection(guest)" class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-green-500/10 border border-green-500/20 text-green-400 hover:bg-green-500 hover:text-white transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]"><i class="fas fa-check-circle text-xs"></i> Accept</button>
                        </template>
                        <template x-if="guest.connection_status === 'connected'">
                            <button disabled class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white/5 border border-white/10 text-white/30 cursor-not-allowed transition-all"><i class="fas fa-check-circle text-xs"></i> Connected</button>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        <div x-show="!loading && guests.length === 0" class="col-span-full bg-navy2 border border-white/5 rounded-2xl p-14 text-center">
            <i class="fas fa-users text-4xl text-white/10 block mb-3"></i><p class="text-white/40 font-medium">No guests found.</p>
        </div>
    </div>

    <div x-show="!loading && totalPages > 1" class="flex items-center justify-center gap-2 mt-6 flex-wrap">
        <button @click="goPage(currentPage-1)" :disabled="currentPage <= 1" class="px-3 py-2 rounded-xl text-sm transition-all disabled:opacity-30 bg-navy2 border border-white/10 text-white/50 hover:border-blue"><i class="fas fa-chevron-left"></i></button>
        <template x-for="p in pageList()" :key="p">
            <button @click="p!=='...' && goPage(p)" :class="p === currentPage ? 'bg-blue text-navy border-blue' : 'bg-navy2 border-white/10 text-white/50 hover:border-blue'" class="min-w-[36px] px-3 py-2 rounded-xl border text-sm font-mono transition-all" x-text="p"></button>
        </template>
        <button @click="goPage(currentPage+1)" :disabled="currentPage >= totalPages" class="px-3 py-2 rounded-xl text-sm transition-all disabled:opacity-30 bg-navy2 border border-white/10 text-white/50 hover:border-blue"><i class="fas fa-chevron-right"></i></button>
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
        async fetchGuests() { this.loading = true; try { const params = new URLSearchParams({ ...this.filters, page: this.currentPage, ajax: 1 }); const res = await fetch(`{{ route('advocate.guests') }}?${params}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }); const data = await res.json(); this.guests = data.data; this.total = data.total; this.totalPages = data.last_page; this.currentPage = data.current_page; window.scrollTo({ top: 0, behavior: 'smooth' }); } catch (e) { console.error(e); } finally { this.loading = false; } },
        async sendConnection(userId) { try { const res = await fetch(`{{ route('connections.send') }}`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ receiver_id: userId }) }); if (res.ok) { const guest = this.guests.find(g => g.id === userId); if (guest) guest.connection_status = 'sent'; } } catch (e) { console.error(e); } },
        async acceptConnection(guest) { if (!guest.connection_req_id) { window.location.href = `{{ route('advocate.guests.show', '') }}/${guest.id}`; return; } try { const res = await fetch(`/connections/${guest.connection_req_id}/accept`, { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }); if (res.ok) { guest.connection_status = 'connected'; } } catch (e) { console.error(e); } }
    }
}
</script>
@endpush
@endsection