@extends('layouts.advocate')

@section('title', 'Feedback')
@section('page-title', 'Feedback')

@section('content')

    <div class="row g-4">

        {{-- Received Feedback --}}
        <div class="col-lg-7">
            <div class="cp-card">
                <div class="cp-card-header">
                    <div class="cp-card-title">Feedback Received</div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="color:var(--amber);font-size:1rem;">★</span>
                        <span
                            style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:700;">{{ number_format($avgRating ?? 0, 1) }}</span>
                        <span
                            style="font-size:0.75rem;color:var(--muted);">({{ $feedbacksReceived->total() ?? $feedbacksReceived->count() }})</span>
                    </div>
                </div>
                <div class="cp-card-body" style="padding:0;">
                    @forelse($feedbacksReceived as $fb)
                        <div style="padding:16px 20px;border-bottom:1px solid rgba(229,224,216,0.5);">
                            <div
                                style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                                <div>
                                    <span style="font-weight:600;font-size:0.85rem;">
                                        {{ $fb->is_anonymous ? '🔒 Anonymous' : $fb->giver->name }}
                                    </span>
                                    @if (!$fb->is_anonymous)
                                        <span
                                            style="font-family:'DM Mono',monospace;font-size:0.62rem;color:var(--muted);text-transform:uppercase;margin-left:6px;">{{ $fb->giver->role }}</span>
                                    @endif
                                </div>
                                <div style="color:var(--amber);letter-spacing:1px;">
                                    {{ str_repeat('★', $fb->rating) }}<span
                                        style="color:var(--border);">{{ str_repeat('★', 5 - $fb->rating) }}</span>
                                </div>
                            </div>
                            @if ($fb->comment)
                                <p style="font-size:0.82rem;color:var(--muted);margin:0 0 4px;">{{ $fb->comment }}</p>
                            @endif
                            <span style="font-size:0.7rem;color:var(--muted);">{{ $fb->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div style="padding:40px;text-align:center;color:var(--muted);">
                            <div style="font-size:2rem;margin-bottom:8px;">⭐</div>
                            No feedback received yet.
                        </div>
                    @endforelse
                </div>
                @if (method_exists($feedbacksReceived, 'hasPages') && $feedbacksReceived->hasPages())
                    <div style="padding:14px 20px;border-top:1px solid var(--border);">
                        {{ $feedbacksReceived->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Give Feedback --}}
        <div class="col-lg-5">
            <div class="cp-card">
                <div class="cp-card-header">
                    <div class="cp-card-title">Give Feedback</div>
                </div>
                <div class="cp-card-body">
                    <form action="{{ route('advocate.feedback.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="cp-label">Give Feedback To *</label>
                                <select name="receiver_id" class="cp-select" required>
                                    <option value="">— Select User —</option>
                                    @foreach ($clerks as $clerk)
                                        <option value="{{ $clerk->id }}">{{ $clerk->name }} (Clerk)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="cp-label">Rating *</label>
                                <div style="display:flex;gap:8px;margin-top:2px;" id="starRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label
                                            style="cursor:pointer;font-size:1.6rem;color:var(--border);transition:color 0.15s;"
                                            class="star-label">
                                            <input type="radio" name="rating" value="{{ $i }}"
                                                style="display:none;" required>
                                            ★
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="cp-label">Comment</label>
                                <textarea name="comment" class="cp-input" rows="3" placeholder="Share your experience..."></textarea>
                            </div>
                            <div class="col-12">
                                <label style="display:flex;align-items:center;gap:8px;font-size:0.83rem;cursor:pointer;">
                                    <input type="checkbox" name="is_anonymous" value="1"
                                        style="accent-color:var(--amber);">
                                    Submit anonymously
                                </label>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-cp-primary" style="width:100%;justify-content:center;">
                                    <i class="bi bi-star-fill"></i> Submit Feedback
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            :root {
                --border: #e5e0d8;
                --muted: #7a7068;
                --amber: #c8872a;
            }

            .star-label:hover,
            .star-label.active {
                color: var(--amber) !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.querySelectorAll('.star-label').forEach((star, index, stars) => {
                star.addEventListener('click', () => {
                    stars.forEach((s, i) => s.style.color = i <= index ? 'var(--amber)' : 'var(--border)');
                    star.classList.add('active');
                });
                star.addEventListener('mouseover', () => {
                    stars.forEach((s, i) => s.style.color = i <= index ? 'var(--amber)' : 'var(--border)');
                });
                star.addEventListener('mouseout', () => {
                    const checked = document.querySelector('input[name="rating"]:checked');
                    const checkedVal = checked ? parseInt(checked.value) - 1 : -1;
                    stars.forEach((s, i) => s.style.color = i <= checkedVal ? 'var(--amber)' : 'var(--border)');
                });
            });
        </script>
    @endpush

@endsection
