@extends('layouts.advocate')

@section('title', 'Feedback')
@section('page-title', 'Feedback & Ratings')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- ── LEFT: Received Feedback ── --}}
        <div class="lg:col-span-7">
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col h-full">

                {{-- Header --}}
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex flex-wrap items-center justify-between gap-4">
                    <h3 class="font-black text-base text-white uppercase tracking-widest">Feedback Received</h3>

                    <div class="flex items-center gap-2 bg-blue/10 border border-blue/20 px-4 py-1.5 rounded-xl shadow-inner">
                        <i class="fas fa-star text-blue text-sm"></i>
                        <span class="font-black text-lg text-blue leading-none">{{ number_format($avgRating ?? 0, 1) }}</span>
                        <span class="text-[0.65rem] font-bold text-blue/60 uppercase tracking-widest ml-1">
                            ({{ $feedbacksReceived->total() ?? $feedbacksReceived->count() }} Reviews)
                        </span>
                    </div>
                </div>

                {{-- Feedback List --}}
                <div class="flex-grow max-h-[700px] overflow-y-auto">
                    @if ($feedbacksReceived && $feedbacksReceived->count())
                        <div class="divide-y divide-white/5">
                            @foreach ($feedbacksReceived as $fb)
                                <div class="p-8 flex items-start gap-5 hover:bg-white/5 transition-colors group">
                                    {{-- Avatar --}}
                                    <div class="w-12 h-12 rounded-xl border {{ $fb->is_anonymous ? 'bg-white/5 text-white/40 border-white/10' : 'bg-blue/10 text-blue border-blue/20' }} flex items-center justify-center font-black text-lg shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                                        {{ $fb->is_anonymous ? 'A' : strtoupper(substr($fb->giver->name ?? 'U', 0, 1)) }}
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                            <div class="flex items-center">
                                                <span class="font-bold text-white text-sm uppercase tracking-wider">
                                                    @if($fb->is_anonymous)
                                                        <i class="fas fa-user-secret mr-1.5 text-white/40"></i> Anonymous User
                                                    @else
                                                        {{ $fb->giver->name ?? 'User' }}
                                                    @endif
                                                </span>

                                                @if (!$fb->is_anonymous && isset($fb->giver->role))
                                                    <span class="ml-3 px-2 py-0.5 rounded bg-white/5 border border-white/10 text-[0.55rem] font-black text-white/50 uppercase tracking-widest">
                                                        {{ str_replace('_', ' ', $fb->giver->role) }}
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Stars --}}
                                            <div class="flex items-center gap-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-[0.7rem]"
                                                        style="color:{{ $i <= $fb->rating ? '#B4B4FE' : 'rgba(255,255,255,0.1)' }}"></i>
                                                @endfor
                                            </div>
                                        </div>

                                        @if ($fb->comment)
                                            <p class="text-white/70 text-sm leading-relaxed mb-3 font-medium">
                                                {{ $fb->comment }}
                                            </p>
                                        @endif

                                        <div class="text-white/30 text-[0.65rem] font-bold uppercase tracking-widest">
                                            <i class="far fa-clock mr-1"></i> {{ $fb->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-24 text-center px-6">
                            <div class="w-20 h-20 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/30 text-3xl mx-auto mb-5">
                                <i class="fas fa-comment-slash"></i>
                            </div>
                            <p class="text-white font-black uppercase tracking-[0.2em] text-sm mb-2">No Feedback Received</p>
                            <p class="text-white/40 font-bold text-[0.7rem] uppercase tracking-widest max-w-xs mx-auto leading-relaxed">
                                Your reviews and ratings will appear here once professionals leave feedback on your profile.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Pagination --}}
                @if (method_exists($feedbacksReceived, 'hasPages') && $feedbacksReceived->hasPages())
                    <div class="px-8 py-5 border-t border-white/5 bg-navy/50">
                        {{ $feedbacksReceived->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ── RIGHT: Give Feedback Form ── --}}
        <div class="lg:col-span-5">
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col h-full">

                {{-- Header --}}
                <div class="px-8 py-6 border-b border-white/5 bg-white/5">
                    <h3 class="font-black text-base text-white uppercase tracking-widest">Give Feedback</h3>
                    <p class="text-[0.65rem] text-white/50 font-bold uppercase tracking-widest mt-1.5">Rate interactions to help maintain network quality.</p>
                </div>

                {{-- Form --}}
                <div class="flex-grow">
                    <form action="{{ route('advocate.feedback.store') }}" method="POST" class="flex flex-col h-full">
                        @csrf

                        <div class="p-8 bg-navy/50 space-y-8 flex-grow">

                            {{-- Target User --}}
                            <div>
                                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Select Professional <span class="text-blue">*</span></label>
                                <div class="relative">
                                    <i class="fas fa-user-tie absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                    <select name="receiver_id" required
                                        class="w-full pl-11 pr-10 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold appearance-none focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner cursor-pointer">
                                        <option value="" disabled selected>— Select Network Member —</option>
                                        @foreach ($clerks as $clerk)
                                            <option value="{{ $clerk->id }}">{{ $clerk->name }} (Clerk)</option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none z-10"></i>
                                </div>
                            </div>

                            {{-- Rating Stars --}}
                            <div>
                                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-3">Your Rating <span class="text-blue">*</span></label>
                                <div class="flex items-center gap-3 bg-navy border border-white/5 px-6 py-4 rounded-xl shadow-inner w-max" id="starRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer text-2xl transition-transform duration-200 hover:scale-110 star-label" style="color: rgba(255,255,255,0.1);">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            {{-- Comment --}}
                            <div>
                                <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Experience Review (Optional)</label>
                                <div class="relative">
                                    <i class="fas fa-comment-dots absolute left-4 top-4 text-white/30"></i>
                                    <textarea name="comment" rows="4"
                                        placeholder="Share details about your interaction..."
                                        class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner resize-none"></textarea>
                                </div>
                            </div>

                            {{-- Anonymous Checkbox --}}
                            <label class="flex items-center gap-3 bg-navy border border-white/5 p-4 rounded-xl shadow-inner cursor-pointer hover:border-white/10 transition-colors group">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" name="is_anonymous" value="1" class="peer appearance-none w-5 h-5 border-2 border-white/20 rounded bg-navy2 checked:bg-blue checked:border-blue transition-colors cursor-pointer">
                                    <i class="fas fa-check absolute text-navy text-[10px] opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-black text-white/80 uppercase tracking-widest group-hover:text-white transition-colors">Submit Anonymously</span>
                                    <span class="text-[9px] font-bold text-white/40 uppercase tracking-wider mt-0.5">Hide your identity from the recipient</span>
                                </div>
                            </label>

                        </div>

                        {{-- Submit Row --}}
                        <div class="px-8 py-6 border-t border-white/5 bg-navy mt-auto">
                            <button type="submit"
                                class="w-full flex justify-center items-center gap-2 py-4 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_15px_rgba(180,180,254,0.2)]">
                                <i class="fas fa-paper-plane text-sm"></i> Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            // Custom Star Rating Logic for Dark Theme
            document.querySelectorAll('.star-label').forEach((star, index, stars) => {

                const activeColor = '#B4B4FE'; // Blue Accent
                const inactiveColor = 'rgba(255, 255, 255, 0.1)';

                star.addEventListener('click', () => {
                    stars.forEach((s, i) => s.style.color = i <= index ? activeColor : inactiveColor);
                    star.classList.add('active');
                });

                star.addEventListener('mouseover', () => {
                    stars.forEach((s, i) => s.style.color = i <= index ? activeColor : inactiveColor);
                });

                star.addEventListener('mouseout', () => {
                    const checked = document.querySelector('input[name="rating"]:checked');
                    const checkedVal = checked ? parseInt(checked.value) - 1 : -1;
                    stars.forEach((s, i) => s.style.color = i <= checkedVal ? activeColor : inactiveColor);
                });
            });
        </script>
    @endpush

@endsection
