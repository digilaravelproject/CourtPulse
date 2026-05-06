@extends('professional.layouts.master')
@section('title', 'Search Clerks')
@section('page-title', 'Search Clerks')

@section('content')

<!-- Search Filter Card -->
<div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-search-users text-blue text-sm"></i>
            Find Court Clerks
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
                Clerk Name <span class="text-blue/60 lowercase font-medium tracking-normal">(auto-search after 3 characters)</span>
            </label>
            <div class="relative">
                <i class="fas fa-user-tie absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                <input type="text" name="clerk_name" id="clerkName"
                    class="w-full bg-navy border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:border-blue/50 focus:ring-0 transition-all outline-none placeholder:text-white/10"
                    placeholder="Type at least 3 characters to search...">
            </div>
        </div>
    </div>
</div>

<!-- Results Container -->
<div id="clerksResults" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    @if($clerks->isNotEmpty())
        @include('professional.partials.clerk-list', ['clerks' => $clerks])
    @else
        <div class="bg-navy2 border border-white/5 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-white/10 text-2xl mx-auto mb-4">
                <i class="fas fa-search"></i>
            </div>
            <h4 class="text-white font-semibold mb-1">No clerks found</h4>
            <p class="text-white/40 text-sm">Try adjusting your search filters or type a clerk name to search.</p>
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
    const resultsContainer = document.getElementById('clerksResults');

    function searchClerks() {
        resultsContainer.style.opacity = '0.5';

        const params = new URLSearchParams({
            court_id: document.getElementById('courtId').value,
            court_city: document.getElementById('courtCity').value,
            court_pincode: document.getElementById('courtPincode').value,
            clerk_name: document.getElementById('clerkName').value
        });

        fetch('{{ route("professional.search.clerks.ajax") }}?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
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
        debounceTimer = setTimeout(searchClerks, 300);
    }

    function initConnectionButtons() {
        document.querySelectorAll('.send-connection-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const originalContent = this.innerHTML;

                // Show SweetAlert2 popup with note input
                Swal.fire({
                    title: 'Send Connection Request',
                    text: 'Add an optional note to introduce yourself:',
                    input: 'textarea',
                    inputPlaceholder: 'Write something nice...',
                    showCancelButton: true,
                    confirmButtonText: 'Send Request',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#6B7280',
                    background: '#0F172A',
                    color: '#F1F5F9',
                    inputAttributes: {
                        'aria-label': 'Optional note'
                    },
                    inputValidator: (value) => {
                        // No validation needed, empty is fine
                        return null;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const notes = result.value || '';
                        const payload = { receiver_id: userId, notes: notes };

                        this.disabled = true;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

                        fetch('{{ route("professional.connection.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.message) {
                                Swal.fire({
                                    icon: data.message.includes('successfully') ? 'success' : 'error',
                                    title: data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    background: '#0F172A',
                                    color: '#F1F5F9'
                                }).then(() => {
                                    if (data.message.includes('successfully')) {
                                        searchClerks(); // Refresh results
                                    } else {
                                        this.disabled = false;
                                        this.innerHTML = originalContent;
                                    }
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to send request',
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

    // Event Listeners
    ['courtId', 'courtCity', 'courtPincode'].forEach(id => {
        document.getElementById(id).addEventListener('change', searchClerks);
    });

    document.getElementById('clerkName').addEventListener('input', function() {
        if (this.value.length >= minChars) {
            debounceSearch();
        } else if (this.value.length === 0) {
            searchClerks();
        }
    });

    initConnectionButtons();
})();
</script>
@endpush

@endsection
