@extends('layouts.clerk')
@section('title', 'Feedback')
@section('page-title', 'Feedback')
@section('content')

    @php $hasFeedback = \App\Http\Controllers\FeedbackController::clerkHasFeedback(auth()->id()); @endphp

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-2">Feedback</h1>
            <p class="text-text-muted-light">Submit feedback to unlock advocate contact details.</p>
        </div>
        @if (!$hasFeedback)
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-600 border border-red-200 w-fit">
                <span class="material-icons-round text-sm">warning</span> Action Required
            </span>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Give Feedback --}}
        <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">
                    {{ $hasFeedback ? 'Give More Feedback' : '⚠️ Compulsory Feedback' }}
                </h3>
                @if (!$hasFeedback)
                    <span class="text-xs font-semibold bg-red-100 text-red-600 px-2.5 py-1 rounded-full">Required</span>
                @endif
            </div>
            <div class="p-6">
                @if (!$hasFeedback)
                    <div class="flex gap-3 bg-red-50 border border-red-100 rounded-xl p-4 mb-5">
                        <span class="material-icons-round text-red-400 flex-shrink-0 mt-0.5">info</span>
                        <p class="text-sm text-red-600">You must submit this feedback to unlock advocate contact details.
                        </p>
                    </div>
                @endif

                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_compulsory" value="{{ !$hasFeedback ? '1' : '0' }}">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Select Advocate *</label>
                            <select name="receiver_id" required
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition cursor-pointer">
                                <option value="">— Select Advocate —</option>
                                @foreach ($advocates as $advocate)
                                    <option value="{{ $advocate->id }}">
                                        {{ $advocate->name }}{{ $advocate->city ? ' (' . $advocate->city . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                            <div class="flex gap-2" id="starRow">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label
                                        class="star-label cursor-pointer text-4xl leading-none transition-all text-gray-200 select-none">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden"
                                            required>★
                                    </label>
                                @endfor
                            </div>
                            <p id="ratingHint" class="text-xs text-text-muted-light mt-1 h-4">Click a star to rate</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Comment
                                <span class="text-text-muted-light font-normal ml-1">(optional)</span>
                            </label>
                            <textarea name="comment" rows="3" placeholder="Describe your experience..."
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm resize-none
                     focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"></textarea>
                        </div>

                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="checkbox" name="is_anonymous" value="1"
                                class="w-4 h-4 rounded border-gray-300" style="accent-color:#D4AF37">
                            <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Submit
                                anonymously</span>
                        </label>

                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold transition-all active:scale-95 shadow-sm"
                            style="background:#D4AF37;color:#1a1a1a" onmouseover="this.style.background='#B5952F'"
                            onmouseout="this.style.background='#D4AF37'">
                            <span class="material-icons-round text-base">star</span>
                            {{ $hasFeedback ? 'Submit Feedback' : 'Submit Compulsory Feedback' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- History --}}
        <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">My Feedback History</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($myFeedbacks as $fb)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full font-display font-bold flex items-center justify-center flex-shrink-0 text-white text-sm"
                                style="background:linear-gradient(135deg,#D4AF37,#B5952F)">
                                {{ strtoupper(substr(optional($fb->receiver)->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span
                                        class="font-semibold text-gray-900 text-sm">{{ optional($fb->receiver)->name ?? 'User' }}</span>
                                    <div class="flex items-center gap-0.5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="material-icons-round text-sm {{ $i <= $fb->rating ? 'text-primary' : 'text-gray-200' }}">star</span>
                                        @endfor
                                    </div>
                                </div>
                                @if ($fb->comment)
                                    <p class="text-sm text-gray-600">{{ $fb->comment }}</p>
                                @endif
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-xs text-text-muted-light">{{ $fb->created_at->diffForHumans() }}</span>
                                    @if ($fb->is_compulsory)
                                        <span
                                            class="text-xs font-semibold bg-red-100 text-red-600 px-1.5 py-0.5 rounded">Compulsory</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center">
                        <span class="material-icons-round text-5xl text-gray-200 block mb-3">reviews</span>
                        <p class="text-gray-500 font-medium">No feedback given yet</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            const ratingLabels = ['', 'Terrible', 'Poor', 'Average', 'Good', 'Excellent 🌟'];
            const stars = document.querySelectorAll('.star-label');
            const hint = document.getElementById('ratingHint');
            stars.forEach((star, i) => {
                star.addEventListener('click', () => {
                    stars.forEach((s, j) => s.style.color = j <= i ? '#D4AF37' : '#e5e7eb');
                    if (hint) hint.textContent = ratingLabels[i + 1];
                });
                star.addEventListener('mouseover', () => stars.forEach((s, j) => s.style.color = j <= i ? '#D4AF37' :
                    '#e5e7eb'));
                star.addEventListener('mouseout', () => {
                    const checked = document.querySelector('input[name="rating"]:checked');
                    const val = checked ? parseInt(checked.value) - 1 : -1;
                    stars.forEach((s, j) => s.style.color = j <= val ? '#D4AF37' : '#e5e7eb');
                });
            });
        </script>
    @endpush
@endsection
