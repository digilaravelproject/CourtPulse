@extends('support.layouts.master')
@section('title', 'Search Advocates')
@section('page-title', 'Search Advocates')

@section('content')

<!-- Search Filter Card -->
<div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-white/5 bg-white/2">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-search-plus text-blue text-sm"></i>
            Find Advocates
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
            <div>
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Court Name</label>
                <select name="court_id" id="courtId" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none appearance-none cursor-pointer">
                    <option value="">All Courts</option>
                    @foreach($courts as $court)
                        <option value="{{ $court->id }}">{{ $court->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Court City</label>
                <select name="court_city" id="courtCity" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none appearance-none cursor-pointer">
                    <option value="">All Cities</option>
                    @foreach($courts->pluck('city')->unique() as $city)
                        @if($city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Court Pincode</label>
                <select name="court_pincode" id="courtPincode" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none appearance-none cursor-pointer">
                    <option value="">All Pincodes</option>
                    @foreach($courts->pluck('pincode')->unique() as $pincode)
                        @if($pincode)
                            <option value="{{ $pincode }}">{{ $pincode }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="relative pt-2">
            <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">
                Advocate Name <span class="text-blue/60 lowercase font-medium tracking-normal">(auto-search after 3 characters)</span>
            </label>
            <div class="relative">
                <i class="fas fa-user-tie absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" name="advocate_name" id="advocateName"
                    class="w-full bg-navy border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none placeholder:text-white/10"
                    placeholder="Type at least 3 characters to search...">
            </div>
        </div>
    </div>
</div>

{{-- Locked Banner --}}
@if (!$hasFeedback)
    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 mb-6 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4 text-center md:text-left">
            <div class="w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center text-red-400 shrink-0">
                <i class="fas fa-lock text-xl"></i>
            </div>
            <div>
                <h4 class="text-white font-bold uppercase tracking-widest text-sm mb-1">Contact Intelligence Restricted</h4>
                <p class="text-white/40 text-xs uppercase tracking-wider">Provide mandatory node feedback to decrypt advocate contact vectors.</p>
            </div>
        </div>
        <a href="{{ route('support.feedback') }}" class="px-8 py-3 rounded-xl bg-red-500 text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-600 transition-all">
            Unlock Data Access
        </a>
    </div>
@endif

<!-- Results Area -->
<div id="advocatesResults" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    @if($advocates->isNotEmpty())
        @include('support.partials.advocate-list', ['advocates' => $advocates, 'hasFeedback' => $hasFeedback, 'authId' => $authId])
    @else
        <div class="bg-navy2 border border-white/5 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-white/10 text-2xl mx-auto mb-4">
                <i class="fas fa-search"></i>
            </div>
            <h4 class="text-white font-semibold mb-1 uppercase tracking-widest text-sm">No advocates detected</h4>
            <p class="text-white/40 text-[10px] uppercase tracking-wider">Try adjusting your filters or search parameters.</p>
        </div>
    @endif
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function() {
    let debounceTimer;
    const minChars = 3;
    const resultsContainer = document.getElementById('advocatesResults');

    function searchAdvocates() {
        resultsContainer.style.opacity = '0.5';

        const params = new URLSearchParams({
            court_id: document.getElementById('courtId').value,
            court_city: document.getElementById('courtCity').value,
            court_pincode: document.getElementById('courtPincode').value,
            advocate_name: document.getElementById('advocateName').value,
            category: 'advocate'
        });

        fetch('{{ route("support.search.advocates") }}?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.json())
            .then(data => {
                resultsContainer.style.opacity = '1';
                resultsContainer.innerHTML = data.html;
                initConnectionButtons();
            })
            .catch(err => {
                resultsContainer.style.opacity = '1';
                console.error('Search error:', err);
            });
    }

    function debounceSearch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(searchAdvocates, 300);
    }

    function initConnectionButtons() {
        document.querySelectorAll('.send-connection-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const originalContent = this.innerHTML;

                Swal.fire({
                    title: 'INITIATE CONNECTION',
                    text: 'Add an optional handshake protocol note:',
                    input: 'textarea',
                    inputPlaceholder: 'Brief introduction...',
                    showCancelButton: true,
                    confirmButtonText: 'SEND REQUEST',
                    cancelButtonText: 'ABORT',
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#1E293B',
                    background: '#0F172A',
                    color: '#F1F5F9',
                    customClass: {
                        popup: 'rounded-4xl border border-white/10',
                        input: 'bg-navy border-white/10 rounded-xl text-white text-sm focus:border-blue/50'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const notes = result.value || '';
                        
                        this.disabled = true;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                        fetch('{{ route("support.connection.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ receiver_id: userId, notes: notes })
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                icon: data.message.includes('successfully') ? 'success' : 'error',
                                title: data.message.toUpperCase(),
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                background: '#0F172A',
                                color: '#F1F5F9'
                            });
                            if (data.message.includes('successfully')) {
                                searchAdvocates();
                            } else {
                                this.disabled = false;
                                this.innerHTML = originalContent;
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'TRANSMISSION FAILED',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                background: '#0F172A',
                                color: '#F1F5F9'
                            });
                            this.disabled = false;
                            this.innerHTML = originalContent;
                        });
                    }
                });
            });
        });
    }

    ['courtId', 'courtCity', 'courtPincode'].forEach(id => {
        document.getElementById(id).addEventListener('change', searchAdvocates);
    });

    document.getElementById('advocateName').addEventListener('input', function() {
        if (this.value.length >= minChars) {
            debounceSearch();
        } else if (this.value.length === 0) {
            searchAdvocates();
        }
    });

    initConnectionButtons();
})();
</script>
@endpush

@endsection
