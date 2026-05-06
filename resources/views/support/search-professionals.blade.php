@extends('support.layouts.master')
@section('title', 'Find Professionals')
@section('page-title', 'Search Experts')

@section('content')

<!-- Search Filter Card -->
<div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-white/5 bg-white/2">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-search text-blue text-sm"></i>
            Search for Professionals
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-5">
            <div>
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Expert Category</label>
                <select name="professional_type" id="professionalType" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none appearance-none cursor-pointer">
                    <option value="">All Categories</option>
                    <option value="advocate">Advocates</option>
                    <option value="ca_cs">CA / CS</option>
                    <option value="agent">IP Agents</option>
                </select>
            </div>
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
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">City</label>
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
                <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2">Pincode</label>
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
                Search by Name <span class="text-blue/60 lowercase font-medium tracking-normal">(enter at least 3 characters)</span>
            </label>
            <div class="relative">
                <i class="fas fa-user-edit absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" name="professional_name" id="professionalName"
                    class="w-full bg-navy border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none placeholder:text-white/10"
                    placeholder="Enter name to find experts...">
            </div>
        </div>
    </div>
</div>

<!-- Results Area -->
<div id="professionalsResults" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    @if($advocates->isNotEmpty())
        @include('support.partials.professional-list', ['professionals' => $advocates, 'hasFeedback' => $hasFeedback, 'authId' => $authId])
    @else
        <div class="bg-navy2 border border-white/5 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-white/10 text-2xl mx-auto mb-4">
                <i class="fas fa-search-minus"></i>
            </div>
            <h4 class="text-white font-semibold mb-1 uppercase tracking-widest text-sm">No Results Found</h4>
            <p class="text-white/40 text-[10px] uppercase tracking-wider">Try changing your filters or checking the spelling.</p>
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
    const resultsContainer = document.getElementById('professionalsResults');

    function searchProfessionals() {
        resultsContainer.style.opacity = '0.5';

        const params = new URLSearchParams({
            professional_type: document.getElementById('professionalType').value,
            court_id: document.getElementById('courtId').value,
            court_city: document.getElementById('courtCity').value,
            court_pincode: document.getElementById('courtPincode').value,
            advocate_name: document.getElementById('professionalName').value,
            category: 'advocate'
        });

        fetch('{{ route("support.search.professionals") }}?' + params.toString(), {
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
        debounceTimer = setTimeout(searchProfessionals, 300);
    }

    function initConnectionButtons() {
        document.querySelectorAll('.send-connection-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const originalContent = this.innerHTML;

                Swal.fire({
                    title: 'Send Connection Request',
                    text: 'Would you like to include a note?',
                    input: 'textarea',
                    inputPlaceholder: 'Write your message here...',
                    showCancelButton: true,
                    confirmButtonText: 'Send Request',
                    cancelButtonText: 'Cancel',
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
                            const isSuccess = data.message.toLowerCase().includes('success');
                            Swal.fire({
                                icon: isSuccess ? 'success' : 'error',
                                title: isSuccess ? 'Request Sent' : 'Message',
                                text: data.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                background: '#0F172A',
                                color: '#F1F5F9'
                            });
                            if (isSuccess) {
                                searchProfessionals();
                            } else {
                                this.disabled = false;
                                this.innerHTML = originalContent;
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Something went wrong. Please try again.',
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

    ['professionalType', 'courtId', 'courtCity', 'courtPincode'].forEach(id => {
        document.getElementById(id).addEventListener('change', searchProfessionals);
    });

    document.getElementById('professionalName').addEventListener('input', function() {
        if (this.value.length >= minChars) {
            debounceSearch();
        } else if (this.value.length === 0) {
            searchProfessionals();
        }
    });

    initConnectionButtons();
})();
</script>
@endpush

@endsection
