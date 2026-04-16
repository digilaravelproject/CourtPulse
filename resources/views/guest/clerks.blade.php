@extends('layouts.guest')
@section('title', 'Browse Clerks')
@section('content')

    <div x-data="clerksPage()" x-init="init()">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
            <h2 class="font-display font-bold text-3xl text-ink">Court Clerks</h2>
            <span class="font-mono text-xs text-muted" x-text="total + ' found'">{{ $clerks->total() }} found</span>
        </div>

        {{-- Search Card --}}
        <div class="bg-white border border-border rounded-xl mb-4 overflow-hidden">
            <div class="p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
                    <div>
                        <label
                            class="font-mono text-[0.62rem] tracking-widest uppercase text-muted mb-1.5 block">Name</label>
                        <input x-model="filters.search" @input.debounce.400ms="fetchClerks()" type="text"
                            placeholder="Clerk name..."
                            class="w-full border border-border rounded-lg px-3 py-2.5 text-sm font-sans focus:outline-none focus:border-gold transition-colors gold-ring">
                    </div>
                    <div>
                        <label class="font-mono text-[0.62rem] tracking-widest uppercase text-muted mb-1.5 block">Court
                            City</label>
                        <input x-model="filters.court_city" @input.debounce.400ms="fetchClerks()" type="text"
                            placeholder="City..."
                            class="w-full border border-border rounded-lg px-3 py-2.5 text-sm font-sans focus:outline-none focus:border-gold transition-colors gold-ring">
                    </div>
                    <div>
                        <label class="font-mono text-[0.62rem] tracking-widest uppercase text-muted mb-1.5 block">Court
                            Name</label>
                        <input x-model="filters.court_name" @input.debounce.400ms="fetchClerks()" type="text"
                            placeholder="Court name..."
                            class="w-full border border-border rounded-lg px-3 py-2.5 text-sm font-sans focus:outline-none focus:border-gold transition-colors gold-ring">
                    </div>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <button @click="fetchClerks()"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all flex-1 sm:flex-none justify-center"
                        style="background:#D4AF37;color:#0e0e0f" onmouseover="this.style.background='#B5952F'"
                        onmouseout="this.style.background='#D4AF37'">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <button x-show="hasFilters()" @click="clearFilters()"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium border border-border text-muted hover:border-gold hover:text-gold-h transition-all">
                        <i class="bi bi-x"></i> Clear
                    </button>
                </div>
            </div>
        </div>

        {{-- Loading --}}
        <div x-show="loading" class="flex items-center justify-center py-16">
            <div class="w-8 h-8 rounded-full border-2 border-gold border-t-transparent animate-spin"></div>
        </div>

        {{-- Results Grid --}}
        <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="clerk in clerks" :key="clerk.id">
                <div
                    class="bg-white border border-border rounded-xl p-4 hover:border-gold hover:shadow-md transition-all flex flex-col h-full">

                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                            style="background:rgba(212,175,55,.07);border:1.5px solid rgba(212,175,55,.2)">🗂️</div>
                        <div class="flex-1 min-w-0">
                            <div class="font-display font-bold text-base truncate" x-text="clerk.name"></div>
                            <div class="font-mono text-[0.57rem] tracking-widest uppercase" style="color:#B5952F">Court
                                Clerk</div>
                        </div>
                        <span
                            class="font-mono text-[0.57rem] tracking-wide px-2 py-0.5 rounded bg-green-100 text-green-700 uppercase font-bold flex-shrink-0">Verified</span>
                    </div>

                    <div class="flex items-center gap-1.5 text-xs text-muted mb-1.5">
                        <i class="bi bi-building flex-shrink-0" style="color:#D4AF37"></i>
                        <span class="truncate" x-text="clerk.clerk_profile?.court_name || '—'"></span>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-muted mb-1.5">
                        <i class="bi bi-geo-alt flex-shrink-0" style="color:#D4AF37"></i>
                        <span x-text="clerk.clerk_profile?.court_city || clerk.city || '—'"></span>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-muted mb-4" x-show="clerk.clerk_profile?.department">
                        <i class="bi bi-briefcase flex-shrink-0" style="color:#D4AF37"></i>
                        <span class="truncate" x-text="clerk.clerk_profile?.department"></span>
                    </div>

                    {{-- Buttons Section --}}
                    <div class="mt-auto flex flex-col gap-2 pt-3 border-t border-border">
                        <div class="flex items-center gap-2 w-full">
                            {{-- View Details --}}
                            <a :href="`/user/${clerk.id}/detail`"
                                class="flex-1 text-center py-2 rounded-lg text-xs font-bold border border-border text-muted hover:border-gold hover:text-gold-h transition-all">
                                View Details
                            </a>

                            {{-- Connection States --}}
                            <template x-if="clerk.connection_status === 'none'">
                                <button @click="sendConnection(clerk.id)"
                                    class="flex-1 py-2 rounded-lg text-xs font-bold transition-all flex justify-center items-center gap-1"
                                    style="background:#D4AF37;color:#0e0e0f" onmouseover="this.style.background='#B5952F'"
                                    onmouseout="this.style.background='#D4AF37'">
                                    <i class="bi bi-person-plus-fill"></i> Connect
                                </button>
                            </template>

                            <template x-if="clerk.connection_status === 'sent'">
                                <button disabled
                                    class="flex-1 py-2 rounded-lg text-xs font-bold transition-all flex justify-center items-center gap-1 bg-gray-100 text-gray-500 border border-gray-200 cursor-not-allowed">
                                    <i class="bi bi-clock-history"></i> Pending
                                </button>
                            </template>

                            <template x-if="clerk.connection_status === 'received'">
                                <button disabled
                                    class="flex-1 py-2 rounded-lg text-xs font-bold transition-all flex justify-center items-center gap-1 bg-gray-100 text-gray-500 border border-gray-200 cursor-not-allowed">
                                    <i class="bi bi-inbox"></i> Requested You
                                </button>
                            </template>

                            <template x-if="clerk.connection_status === 'connected'">
                                <button disabled
                                    class="flex-1 py-2 rounded-lg text-xs font-bold transition-all flex justify-center items-center gap-1 bg-green-50 text-green-600 border border-green-200 cursor-default">
                                    <i class="bi bi-check-circle-fill"></i> Connected
                                </button>
                            </template>
                        </div>

                        {{-- Give Feedback Link (Preserved) --}}
                        <a href="{{ route('feedback') }}"
                            class="w-full flex justify-center items-center gap-1.5 px-3 py-1.5 rounded-lg text-[0.7rem] font-medium text-muted hover:text-gold-h transition-all">
                            <i class="bi bi-star-fill text-[0.65rem]"></i> Give feedback to review
                        </a>
                    </div>
                </div>
            </template>

            {{-- Empty --}}
            <div x-show="!loading && clerks.length === 0"
                class="col-span-full bg-white border border-border rounded-xl p-12 text-center text-muted">
                <div class="text-4xl mb-3">🔍</div>
                <p class="font-medium">No clerks found.</p>
            </div>
        </div>

        {{-- Pagination --}}
        <div x-show="!loading && totalPages > 1" class="flex items-center justify-center gap-2 mt-5 flex-wrap">
            <button @click="goPage(currentPage-1)" :disabled="currentPage <= 1"
                class="px-3 py-2 rounded-lg border border-border text-sm text-muted hover:border-gold hover:text-gold-h transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                <i class="bi bi-chevron-left"></i>
            </button>
            <template x-for="p in pageList()" :key="p">
                <button @click="p!=='...' && goPage(p)"
                    :class="p === currentPage ? 'border-gold text-gold-h font-bold' :
                        'border-border text-muted hover:border-gold hover:text-gold-h'"
                    :disabled="p === '...'"
                    class="min-w-[36px] px-3 py-2 rounded-lg border text-sm transition-all disabled:cursor-default"
                    x-text="p"></button>
            </template>
            <button @click="goPage(currentPage+1)" :disabled="currentPage >= totalPages"
                class="px-3 py-2 rounded-lg border border-border text-sm text-muted hover:border-gold hover:text-gold-h transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

    </div>

    @push('scripts')
        <script>
            function clerksPage() {
                return {
                    clerks: @json($clerks->items()),
                    total: {{ $clerks->total() }},
                    currentPage: {{ $clerks->currentPage() }},
                    totalPages: {{ $clerks->lastPage() }},
                    loading: false,
                    filters: {
                        search: '{{ request('search', '') }}',
                        court_city: '{{ request('court_city', '') }}',
                        court_name: '{{ request('court_name', '') }}'
                    },

                    init() {},
                    hasFilters() {
                        return Object.values(this.filters).some(v => v !== '');
                    },
                    clearFilters() {
                        this.filters = {
                            search: '',
                            court_city: '',
                            court_name: ''
                        };
                        this.fetchClerks();
                    },
                    goPage(p) {
                        if (p < 1 || p > this.totalPages) return;
                        this.currentPage = p;
                        this.fetchClerks();
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

                    async fetchClerks() {
                        this.loading = true;
                        try {
                            const params = new URLSearchParams({
                                ...this.filters,
                                page: this.currentPage,
                                ajax: 1
                            });
                            const res = await fetch(`{{ route('guest.clerks') }}?${params}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await res.json();
                            this.clerks = data.data;
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
                                // Status ko real-time update kar do bina page refresh ke
                                const clerk = this.clerks.find(c => c.id === userId);
                                if (clerk) clerk.connection_status = 'sent';
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
