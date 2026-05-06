@extends('layouts.clerk')
@section('title', 'Feedback')
@section('page-title', 'Feedback')
@section('content')

    @php $hasFeedback = \App\Http\Controllers\User\FeedbackController::clerkHasFeedback(auth()->id()); @endphp

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-widest mb-4">
                Feedback <span class="text-blue">Portal</span>
            </h1>
            <p class="text-white/60 font-medium tracking-wide">Submit feedback to unlock advocate contact details and maintain platform integrity.</p>
        </div>
        @if (!$hasFeedback)
            <div class="flex items-center gap-3 px-5 py-2.5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400">
                <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                <span class="text-sm font-bold uppercase tracking-wider">Action Required</span>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Give Feedback --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-black text-white uppercase tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-pen-to-square text-blue"></i>
                    {{ $hasFeedback ? 'Give More Feedback' : 'Compulsory Feedback' }}
                </h3>
                @if (!$hasFeedback)
                    <span class="text-[10px] font-black uppercase tracking-tighter bg-red-500 text-white px-3 py-1 rounded-full">Required</span>
                @endif
            </div>
            <div class="p-8">
                @if (!$hasFeedback)
                    <div class="flex gap-4 bg-red-500/10 border border-red-500/20 rounded-2xl p-5 mb-8">
                        <i class="fa-solid fa-circle-info text-red-400 mt-1"></i>
                        <p class="text-sm text-red-200/80 leading-relaxed font-medium">
                            You must submit this feedback to unlock advocate contact details. This helps us ensure the quality of service for all members.
                        </p>
                    </div>
                @endif

                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_compulsory" value="{{ !$hasFeedback ? '1' : '0' }}">
                    <div class="space-y-6">
                        <div class="relative group">
                            <label class="block text-xs font-black text-white/40 uppercase tracking-widest mb-2 ml-1">Select Advocate *</label>
                            <div class="relative">
                                <i class="fa-solid fa-user-tie absolute left-5 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue transition-colors"></i>
                                <select name="receiver_id" required
                                    class="w-full pl-12 pr-6 py-4 rounded-2xl border border-white/5 bg-navy text-white text-sm font-medium focus:outline-none focus:border-blue/50 focus:ring-4 focus:ring-blue/10 transition-all cursor-pointer appearance-none">
                                    <option value="" disabled selected>— Select Advocate —</option>
                                    @foreach ($advocates as $advocate)
                                        <option value="{{ $advocate->id }}">
                                            {{ $advocate->name }}{{ $advocate->city ? ' (' . $advocate->city . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-white/20 pointer-events-none text-xs"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-white/40 uppercase tracking-widest mb-3 ml-1">Rating *</label>
                            <div class="flex gap-3 bg-navy p-4 rounded-2xl border border-white/5" id="starRow">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="star-label cursor-pointer text-3xl leading-none transition-all text-white/10 hover:scale-110 active:scale-95 select-none">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                                        <i class="fa-solid fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            <p id="ratingHint" class="text-[10px] font-bold uppercase tracking-wider text-white/30 mt-3 ml-1 h-4 transition-all">Click a star to rate</p>
                        </div>

                        <div class="relative group">
                            <label class="block text-xs font-black text-white/40 uppercase tracking-widest mb-2 ml-1">
                                Comment <span class="text-white/20 font-normal normal-case italic ml-1">(optional)</span>
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-comment-dots absolute left-5 top-5 text-white/20 group-focus-within:text-blue transition-colors"></i>
                                <textarea name="comment" rows="4" placeholder="Describe your experience with this advocate..."
                                    class="w-full pl-12 pr-6 py-4 rounded-2xl border border-white/5 bg-navy text-white text-sm font-medium placeholder:text-white/20 focus:outline-none focus:border-blue/50 focus:ring-4 focus:ring-blue/10 transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <label class="flex items-center gap-4 cursor-pointer group p-2 rounded-xl hover:bg-white/[0.02] transition-colors w-fit">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_anonymous" value="1"
                                    class="peer appearance-none w-5 h-5 rounded-lg border border-white/10 bg-navy checked:bg-blue checked:border-blue transition-all cursor-pointer">
                                <i class="fa-solid fa-check absolute opacity-0 peer-checked:opacity-100 left-1 text-[10px] text-white pointer-events-none"></i>
                            </div>
                            <span class="text-sm font-bold text-white/60 group-hover:text-white transition-colors uppercase tracking-wider">Submit anonymously</span>
                        </label>

                        <button type="submit"
                            class="w-full flex items-center justify-center gap-3 py-4 rounded-2xl text-sm font-black uppercase tracking-widest bg-blue text-white hover:bg-blue/80 hover:shadow-lg hover:shadow-blue/20 transition-all active:scale-[0.98]">
                            <i class="fa-solid fa-paper-plane"></i>
                            {{ $hasFeedback ? 'Submit Feedback' : 'Submit Compulsory Feedback' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- History --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
            <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-black text-white uppercase tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-clock-rotate-left text-blue"></i>
                    My Feedback History
                </h3>
            </div>
            <div class="divide-y divide-white/5 overflow-y-auto max-h-[600px] custom-scrollbar">
                @forelse($myFeedbacks as $fb)
                    <div class="px-8 py-6 hover:bg-white/[0.02] transition-all group">
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue to-blue/50 flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-transform">
                                <span class="text-lg font-black text-white uppercase">{{ substr(optional($fb->receiver)->name ?? 'U', 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-black text-white text-sm uppercase tracking-wider">{{ optional($fb->receiver)->name ?? 'Unknown Advocate' }}</span>
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star text-[10px] {{ $i <= $fb->rating ? 'text-blue' : 'text-white/10' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if ($fb->comment)
                                    <p class="text-sm text-white/60 leading-relaxed font-medium bg-navy/50 p-4 rounded-2xl border border-white/5 mb-3">{{ $fb->comment }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-white/30 flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock"></i>
                                            {{ $fb->created_at->diffForHumans() }}
                                        </span>
                                        @if ($fb->is_compulsory)
                                            <span class="text-[9px] font-black uppercase tracking-tighter bg-red-500/10 text-red-400 px-2.5 py-0.5 rounded-full border border-red-500/20">Compulsory</span>
                                        @endif
                                    </div>
                                    @if($fb->is_anonymous)
                                        <span class="text-[9px] font-black uppercase tracking-widest text-white/20 italic">Anonymous</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-24 text-center">
                        <div class="w-20 h-20 bg-navy rounded-3xl flex items-center justify-center mx-auto mb-6 border border-white/5 shadow-inner">
                            <i class="fa-solid fa-comments-dollar text-4xl text-white/10"></i>
                        </div>
                        <p class="text-white/40 font-black uppercase tracking-widest text-sm">No feedback given yet</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ratingLabels = ['', 'Terrible Experience', 'Poor Quality', 'Average Service', 'Good Experience', 'Excellent Service 🌟'];
                const stars = document.querySelectorAll('.star-label');
                const hint = document.getElementById('ratingHint');
                const starIcons = document.querySelectorAll('.star-label i');

                function updateStars(index, permanent = false) {
                    starIcons.forEach((icon, i) => {
                        if (i <= index) {
                            icon.classList.remove('text-white/10');
                            icon.classList.add('text-blue');
                        } else {
                            if (permanent || !icon.parentElement.classList.contains('clicked')) {
                                icon.classList.add('text-white/10');
                                icon.classList.remove('text-blue');
                            }
                        }
                    });
                }

                stars.forEach((star, i) => {
                    star.addEventListener('click', () => {
                        stars.forEach(s => s.classList.remove('clicked'));
                        star.classList.add('clicked');
                        updateStars(i, true);
                        if (hint) {
                            hint.textContent = ratingLabels[i + 1];
                            hint.classList.remove('text-white/30');
                            hint.classList.add('text-blue');
                        }
                    });

                    star.addEventListener('mouseover', () => {
                        updateStars(i);
                        if (hint && !document.querySelector('.star-label.clicked')) {
                            hint.textContent = ratingLabels[i + 1];
                        }
                    });

                    star.addEventListener('mouseout', () => {
                        const clickedStar = document.querySelector('.star-label.clicked');
                        if (clickedStar) {
                            const clickedIndex = Array.from(stars).indexOf(clickedStar);
                            updateStars(clickedIndex, true);
                            hint.textContent = ratingLabels[clickedIndex + 1];
                        } else {
                            starIcons.forEach(icon => {
                                icon.classList.add('text-white/10');
                                icon.classList.remove('text-blue');
                            });
                            hint.textContent = 'Click a star to rate';
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection

