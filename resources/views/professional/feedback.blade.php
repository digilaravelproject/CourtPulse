@extends('professional.layouts.master')
@section('title', 'Feedback')
@section('page-title', 'Give Feedback')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Left Column: Give Feedback -->
    <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
            <h3 class="text-lg font-bold text-white">Give Feedback</h3>
        </div>
        <div class="p-6">
            @if($connectedUsers->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-white/20 text-2xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-1">No connections yet</h4>
                    <p class="text-white/50 text-sm mb-6">You can only give feedback to users you're connected with.</p>
                    <a href="{{ route('professional.search.clerks') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue text-navy font-bold rounded-xl hover:bg-blue2 transition-colors duration-200">
                        <i class="fas fa-search"></i> Find Clerks
                    </a>
                </div>
            @else
                <form action="{{ route('professional.feedback.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-white/40 uppercase tracking-widest mb-2">Select User</label>
                        <select name="receiver_id" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue/50 focus:ring-0 transition-all outline-hidden" required>
                            <option value="">Choose a connected user...</option>
                            @foreach($connectedUsers as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->sub_role ?? $user->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-white/40 uppercase tracking-widest mb-2">Rating</label>
                        <div class="star-input flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-btn text-2xl text-white/10 hover:scale-110 transition-all duration-200" data-rating="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-white/40 uppercase tracking-widest mb-2">Comment (Optional)</label>
                        <textarea name="comment" rows="4" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-white/20 focus:border-blue/50 focus:ring-0 transition-all outline-hidden" placeholder="Share your experience working with this person..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-blue text-navy font-extrabold rounded-xl hover:bg-blue2 shadow-lg shadow-blue/10 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Right Column: My Feedbacks -->
    <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
            <h3 class="text-lg font-bold text-white">My Feedbacks</h3>
        </div>
        <div class="p-6">
            @if($myFeedbacks->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center text-white/20">
                    <div class="text-4xl mb-4"><i class="fas fa-star"></i></div>
                    <div class="text-sm font-medium">No feedback given yet</div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($myFeedbacks as $feedback)
                        <div class="p-4 bg-white/[0.02] border border-white/5 rounded-xl hover:border-white/10 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <div class="font-bold text-white">
                                    {{ $feedback->receiver->name }}
                                </div>
                                <div class="flex gap-0.5 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-amber-400' : 'text-white/10' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($feedback->comment)
                                <p class="text-white/60 text-sm italic leading-relaxed">
                                    "{{ $feedback->comment }}"
                                </p>
                            @endif
                            <div class="mt-3 text-[10px] font-bold text-white/20 uppercase tracking-tight">
                                {{ $feedback->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const starBtns = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('ratingInput');
    const activeColor = '#fbbf24'; // Tailwind amber-400
    const inactiveColor = 'rgba(255,255,255,0.1)';

    function updateStars(rating) {
        starBtns.forEach((btn, i) => {
            btn.style.color = i < rating ? activeColor : inactiveColor;
        });
    }

    starBtns.forEach((btn) => {
        btn.addEventListener('click', function() {
            const rating = this.dataset.rating;
            ratingInput.value = rating;
            updateStars(rating);
        });

        btn.addEventListener('mouseenter', function() {
            updateStars(this.dataset.rating);
        });
    });

    document.querySelector('.star-input')?.addEventListener('mouseleave', function() {
        updateStars(ratingInput.value || 0);
    });
});
</script>
@endpush
@endsection
