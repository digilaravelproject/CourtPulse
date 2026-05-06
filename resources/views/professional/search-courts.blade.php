@extends('professional.layouts.master')
@section('title', 'Search Courts')
@section('page-title', 'Search Courts')

@section('content')
<!-- Search Filter Card -->
<div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-search text-blue text-sm"></i>
            Find Courts
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Search Name</label>
                <div class="relative">
                    <i class="fas fa-university absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <input type="text" name="search" id="courtSearch"
                        class="w-full bg-navy border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none placeholder:text-white/20"
                        placeholder="Type court name...">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">City</label>
                <div class="relative">
                    <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <input type="text" name="city" id="courtCity"
                        class="w-full bg-navy border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none placeholder:text-white/20"
                        placeholder="Enter city...">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">State</label>
                <div class="relative">
                    <i class="fas fa-map absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <input type="text" name="state" id="courtState"
                        class="w-full bg-navy border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none placeholder:text-white/20"
                        placeholder="Enter state...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Results Area -->
<div id="courtsResults" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    @include('professional.partials.court-list', ['courts' => $courts])
</div>

@push('scripts')
<script>
(function() {
    let debounceTimer;
    const resultsContainer = document.getElementById('courtsResults');

    function searchCourts() {
        // Show subtle loading state
        resultsContainer.style.opacity = '0.5';

        const params = new URLSearchParams({
            search: document.getElementById('courtSearch').value,
            city: document.getElementById('courtCity').value,
            state: document.getElementById('courtState').value
        });

        fetch('{{ route("professional.search.courts") }}?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            resultsContainer.style.opacity = '1';
            if (data.success) {
                resultsContainer.innerHTML = data.html;
            }
        })
        .catch(err => {
            resultsContainer.style.opacity = '1';
            console.error('Search error:', err);
        });
    }

    function debounceSearch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(searchCourts, 300);
    }

    // Attach listeners
    ['courtSearch', 'courtCity', 'courtState'].forEach(id => {
        document.getElementById(id).addEventListener('input', debounceSearch);
    });
})();
</script>
@endpush
@endsection
