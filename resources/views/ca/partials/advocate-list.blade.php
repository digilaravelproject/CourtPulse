@forelse($advocates as $adv)
    <div class="col-md-4">
        <div class="cp-card h-100 p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="user-avatar-sb text-dark bg-secondary bg-opacity-10 rounded-pill p-3">
                    {{ strtoupper(substr($adv->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <h5 class="mb-0 text-truncate">{{ $adv->name }}</h5>
                    <div class="cp-label text-gold mb-0">{{ $adv->advocateProfile->high_court ?? 'Advocate' }}</div>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="cp-label">Specializations</div>
                <div class="d-flex flex-wrap gap-1">
                    @forelse($adv->advocateProfile->practice_areas ?? [] as $area)
                        <span class="badge bg-light text-dark border small fw-normal">{{ $area }}</span>
                    @empty
                        <span class="text-muted small">Not specified</span>
                    @endforelse
                </div>
            </div>

            <div class="mt-auto d-grid">
                <a href="{{ route('user.detail', $adv) }}" class="btn-cp-secondary text-center justify-content-center">
                    View Full Profile
                </a>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 py-5 text-center text-muted">
        No advocates found matching your criteria.
    </div>
@endforelse
