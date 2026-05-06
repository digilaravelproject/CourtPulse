@extends('support.layouts.master')
@section('title', 'Feedback Operations')
@section('page-title', 'Feedback Operations')

@section('content')

{{-- $hasFeedback is passed from SupportController@feedback --}}

<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
        <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-tight">Intelligence <span class="text-fuchsia-500">Feed</span></h2>
        <p class="text-xs font-bold text-white/30 uppercase tracking-[0.2em]">Mandatory node verification & reputation management</p>
    </div>

    @if (!$hasFeedback)
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center gap-3 backdrop-blur-md">
                <div class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></div>
                <span class="text-[10px] font-black text-red-400 uppercase tracking-widest text-wrap">Restricted Access Mode</span>
            </div>
        </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    {{-- Feedback Submission Engine --}}
    <div class="lg:col-span-7">
        <div class="bg-navy2 border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-3xl relative">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03]">
                <i class="fas fa-comment-dots text-9xl text-white"></i>
            </div>

            <div class="px-10 py-8 border-b border-white/5 bg-white/2 relative z-10">
                <h3 class="text-lg font-black text-white uppercase tracking-widest flex items-center gap-3">
                    <i class="fas fa-plus-circle text-fuchsia-500"></i>
                    {{ $hasFeedback ? 'Initiate New Review' : 'Mandatory Node Verification' }}
                </h3>
            </div>

            <div class="p-10 relative z-10">
                @if (!$hasFeedback)
                    <div class="mb-8 p-6 rounded-2xl bg-red-500/5 border border-red-500/10 flex gap-4 items-start">
                        <div class="h-10 w-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-400 shrink-0">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Security Gating Active</div>
                            <p class="text-xs font-bold text-white/40 leading-relaxed uppercase tracking-wider">
                                Provide mandatory feedback for at least one advocate node to unlock restricted contact intelligence vectors.
                            </p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('support.feedback.submit') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-white/30 uppercase tracking-[0.2em] ml-1">Select Target Node (Advocate)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-white/20 group-focus-within:text-fuchsia-500 transition-colors">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <select name="receiver_id" required
                                class="w-full pl-12 pr-10 py-4 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-500/10 transition-all outline-hidden appearance-none cursor-pointer">
                                <option value="">— Select Advocate Profile —</option>
                                @foreach ($advocates as $advocate)
                                    <option value="{{ $advocate->id }}">
                                        {{ $advocate->name }}{{ $advocate->city ? ' [' . strtoupper($advocate->city) . ']' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-white/20">
                                <i class="fas fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-white/30 uppercase tracking-[0.2em] ml-1">Node Rating Performance</label>
                        <div class="flex gap-4 p-6 rounded-2xl bg-white/2 border border-white/5" id="starRow">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="star-label cursor-pointer text-4xl leading-none transition-all text-white/5 hover:scale-110 active:scale-95 select-none">
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>★
                                </label>
                            @endfor
                            <div class="ml-auto flex items-center px-4 rounded-xl bg-white/2 border border-white/5">
                                <span id="ratingHint" class="text-[10px] font-black text-white/20 uppercase tracking-widest italic">Signal Strength</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-white/30 uppercase tracking-[0.2em] ml-1">Transmission Logs (Optional)</label>
                        <textarea name="comment" rows="4" placeholder="Describe interaction quality, responsiveness, or professional conduct..."
                            class="w-full px-6 py-4 bg-navy border border-white/10 rounded-2xl text-sm text-white focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-500/10 transition-all outline-hidden resize-none placeholder:text-white/10"></textarea>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_anonymous" value="1" class="peer hidden">
                                <div class="w-10 h-6 bg-white/5 border border-white/10 rounded-full peer-checked:bg-fuchsia-500/20 peer-checked:border-fuchsia-500 transition-all"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white/20 rounded-full peer-checked:translate-x-4 peer-checked:bg-fuchsia-500 transition-all"></div>
                            </div>
                            <span class="text-[10px] font-black text-white/40 uppercase tracking-widest group-hover:text-white/60">Anonymize Source</span>
                        </label>

                        <button type="submit"
                            class="px-10 py-4 bg-linear-to-r from-fuchsia-600 to-indigo-600 text-white text-xs font-black rounded-2xl shadow-lg shadow-fuchsia-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-3 uppercase tracking-widest">
                            <i class="fas fa-paper-plane"></i>
                            Transmit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Intelligence History --}}
    <div class="lg:col-span-5">
        <div class="bg-navy2 border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-3xl h-full flex flex-col">
            <div class="px-10 py-8 border-b border-white/5 bg-white/2">
                <h3 class="text-lg font-black text-white uppercase tracking-widest flex items-center gap-3">
                    <i class="fas fa-history text-white/20"></i>
                    Submission Archives
                </h3>
            </div>

            <div class="flex-1 overflow-y-auto max-h-[600px] custom-scrollbar">
                <div class="divide-y divide-white/5">
                    @forelse($myFeedbacks as $fb)
                        <div class="p-8 hover:bg-white/2 transition-all group">
                            <div class="flex items-start gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-fuchsia-500 to-indigo-600 p-[1px] shrink-0 shadow-lg shadow-fuchsia-500/10">
                                    <div class="w-full h-full rounded-[15px] bg-navy2 flex items-center justify-center font-black text-white text-xl">
                                        {{ $fb->is_anonymous ? '?' : strtoupper(substr(optional($fb->receiver)->name ?? 'U', 0, 1)) }}
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-white uppercase tracking-tighter truncate">
                                                {{ $fb->is_anonymous ? 'SOURCE CLOAKED' : (optional($fb->receiver)->name ?? 'UNKNOWN NODE') }}
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
                                            <span class="px-2 py-0.5 rounded-md bg-red-500/10 border border-red-500/20 text-red-400 text-[8px] font-black uppercase tracking-widest">Protocol Required</span>
                                        @endif
                                        @if ($fb->is_anonymous)
                                            <span class="px-2 py-0.5 rounded-md bg-white/5 border border-white/5 text-white/30 text-[8px] font-black uppercase tracking-widest">Identity Masked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-32 text-center">
                            <div class="w-20 h-20 rounded-4xl bg-white/5 flex items-center justify-center text-white/10 text-3xl mx-auto mb-6 border border-white/5">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h4 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-2 opacity-40">No Archives Detected</h4>
                            <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest">Your transmission history is currently empty.</p>
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
        const ratingLabels = ['', 'Critical Failure', 'Sub-Optimal', 'Standard', 'Superior', 'Peak Performance 🌟'];
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
