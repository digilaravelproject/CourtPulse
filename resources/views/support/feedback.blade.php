@extends('support.layouts.master')
@section('title', 'Feedback & Reviews')
@section('page-title', 'Feedback & Reviews')

@section('content')

<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
        <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-tight">User <span class="text-fuchsia-500">Feedback</span></h2>
        <p class="text-xs font-bold text-white/30 uppercase tracking-[0.2em]">Share your experience with your connections</p>
    </div>

    @if (!$hasFeedback)
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center gap-3 backdrop-blur-md">
                <div class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></div>
                <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest">Pending Review Required</span>
            </div>
        </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    {{-- Feedback Submission Form --}}
    <div class="lg:col-span-7">
        <!-- Highlighted Form Container -->
        <div class="bg-white/[0.03] border-2 border-fuchsia-500/30 rounded-[2.5rem] overflow-hidden shadow-[0_0_50px_rgba(217,70,239,0.1)] backdrop-blur-3xl relative">

            <div class="px-10 py-8 border-b border-white/5 bg-fuchsia-500/5 relative z-10">
                <h3 class="text-lg font-black text-white uppercase tracking-widest flex items-center gap-3">
                    <i class="fas fa-pen-fancy text-fuchsia-400"></i>
                    Write a Review
                </h3>
            </div>

            <div class="p-10 relative z-10">
                <!-- User Guidance Steps -->
                <div class="mb-10 grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-[9px] font-black text-fuchsia-400 uppercase mb-2">Step 1</div>
                        <div class="text-[10px] text-white/40 font-bold uppercase">Select Advocate</div>
                    </div>
                    <div class="text-center border-x border-white/5">
                        <div class="text-[9px] font-black text-fuchsia-400 uppercase mb-2">Step 2</div>
                        <div class="text-[10px] text-white/40 font-bold uppercase">Choose Rating</div>
                    </div>
                    <div class="text-center">
                        <div class="text-[9px] font-black text-fuchsia-400 uppercase mb-2">Step 3</div>
                        <div class="text-[10px] text-white/40 font-bold uppercase">Submit</div>
                    </div>
                </div>

                <form action="{{ route('support.feedback.submit') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-fuchsia-300 uppercase tracking-[0.2em] ml-1">Who would you like to rate?</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-white/20 group-focus-within:text-fuchsia-500 transition-colors">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <select name="receiver_id" required
                                class="w-full pl-12 pr-10 py-5 bg-navy border-2 border-white/10 rounded-2xl text-sm text-white focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-500/10 transition-all outline-hidden appearance-none cursor-pointer">
                                <option value="">— Select an Advocate —</option>
                                @foreach ($advocates as $advocate)
                                    <option value="{{ $advocate->id }}">
                                        {{ $advocate->name }}{{ $advocate->city ? ' (' . strtoupper($advocate->city) . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-white/20">
                                <i class="fas fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-fuchsia-300 uppercase tracking-[0.2em] ml-1">Your Overall Rating</label>
                        <div class="flex flex-col md:flex-row gap-6 p-6 rounded-2xl bg-black/20 border border-white/10" id="starRow">
                            <div class="flex gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="star-label cursor-pointer text-4xl leading-none transition-all text-white/5 hover:scale-125 active:scale-95 select-none">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>★
                                    </label>
                                @endfor
                            </div>
                            <div class="flex-1 flex items-center justify-center md:justify-end border-t md:border-t-0 md:border-l border-white/10 pt-4 md:pt-0 md:pl-6">
                                <span id="ratingHint" class="text-[10px] font-black text-white/20 uppercase tracking-widest italic">Click a star to rate</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-fuchsia-300 uppercase tracking-[0.2em] ml-1">Describe your experience (Optional)</label>
                        <textarea name="comment" rows="4" placeholder="How was the communication? Were they helpful?..."
                            class="w-full px-6 py-5 bg-navy border-2 border-white/10 rounded-2xl text-sm text-white focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-500/10 transition-all outline-hidden resize-none placeholder:text-white/10"></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-4">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_anonymous" value="1" class="peer hidden">
                                <div class="w-10 h-6 bg-white/5 border border-white/10 rounded-full peer-checked:bg-fuchsia-500/20 peer-checked:border-fuchsia-500 transition-all"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white/20 rounded-full peer-checked:translate-x-4 peer-checked:bg-fuchsia-500 transition-all"></div>
                            </div>
                            <span class="text-[10px] font-black text-white/40 uppercase tracking-widest group-hover:text-white/60">Post Anonymously</span>
                        </label>

                        <button type="submit"
                            class="w-full sm:w-auto px-12 py-5 bg-linear-to-r from-fuchsia-600 to-indigo-600 text-white text-xs font-black rounded-2xl shadow-xl shadow-fuchsia-500/20 hover:scale-[1.05] active:scale-[0.98] transition-all flex items-center justify-center gap-3 uppercase tracking-widest">
                            <i class="fas fa-paper-plane"></i>
                            Submit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Feedback History --}}
    <div class="lg:col-span-5">
        <div class="bg-navy2 border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-3xl h-full flex flex-col">
            <div class="px-10 py-8 border-b border-white/5 bg-white/2">
                <h3 class="text-lg font-black text-white uppercase tracking-widest flex items-center gap-3">
                    <i class="fas fa-history text-white/20"></i>
                    Your Review History
                </h3>
            </div>

            <div class="flex-1 overflow-y-auto max-h-[650px] custom-scrollbar">
                <div class="divide-y divide-white/5">
                    @forelse($myFeedbacks as $fb)
                        <div class="p-8 hover:bg-white/2 transition-all group">
                            <div class="flex items-start gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-fuchsia-500 to-indigo-600 p-[1px] shrink-0">
                                    <div class="w-full h-full rounded-[15px] bg-navy2 flex items-center justify-center font-black text-white text-xl">
                                        {{ $fb->is_anonymous ? '?' : strtoupper(substr(optional($fb->receiver)->name ?? 'U', 0, 1)) }}
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-white uppercase tracking-tighter truncate">
                                                {{ $fb->is_anonymous ? 'Anonymous Review' : (optional($fb->receiver)->name ?? 'Unknown User') }}
                                            </span>
                                            <span class="text-[9px] font-bold text-white/30 uppercase tracking-widest">{{ $fb->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-[10px] {{ $i <= $fb->rating ? 'text-fuchsia-500' : 'text-white/5' }}"></i>
                                            @endfor
                                        </div>
                                    </div>

                                    @if ($fb->comment)
                                        <p class="text-xs font-bold text-white/50 leading-relaxed uppercase tracking-wider italic mb-3">
                                            "{{ $fb->comment }}"
                                        </p>
                                    @endif

                                    <div class="flex items-center gap-2">
                                        @if ($fb->is_compulsory)
                                            <span class="px-2 py-0.5 rounded-md bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[8px] font-black uppercase tracking-widest">Required Review</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-32 text-center">
                            <div class="w-20 h-20 rounded-4xl bg-white/5 flex items-center justify-center text-white/10 text-3xl mx-auto mb-6 border border-white/5">
                                <i class="fas fa-comment-slash"></i>
                            </div>
                            <h4 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-2 opacity-40">No Reviews Found</h4>
                            <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest">You haven't shared any feedback yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        const ratingLabels = ['', 'Poor Experience', 'Below Average', 'Good Service', 'Excellent', 'Outstanding! 🌟'];
        const stars = document.querySelectorAll('.star-label');
        const hint = document.getElementById('ratingHint');
        const starColors = {
            active: '#D946EF', // fuchsia-500
            inactive: 'rgba(255,255,255,0.05)'
        };

        stars.forEach((star, i) => {
            star.addEventListener('click', () => {
                stars.forEach((s, j) => s.style.color = j <= i ? starColors.active : starColors.inactive);
                if (hint) {
                    hint.textContent = ratingLabels[i + 1];
                    hint.style.color = starColors.active;
                    hint.classList.remove('text-white/20');
                }
            });
            star.addEventListener('mouseover', () => {
                stars.forEach((s, j) => {
                    if (!document.querySelector('input[name="rating"]:checked')) {
                        s.style.color = j <= i ? starColors.active : starColors.inactive;
                    }
                });
            });
            star.addEventListener('mouseout', () => {
                const checked = document.querySelector('input[name="rating"]:checked');
                const val = checked ? parseInt(checked.value) - 1 : -1;
                stars.forEach((s, j) => s.style.color = j <= val ? starColors.active : starColors.inactive);
            });
        });
    })();
</script>
@endpush

@endsection
