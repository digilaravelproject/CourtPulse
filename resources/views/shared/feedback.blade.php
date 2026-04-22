@php
    $layout = match (auth()->user()->role) {
        'advocate' => 'layouts.advocate',
        'clerk' => 'layouts.clerk',
        'ca' => 'layouts.ca',
        'guest' => 'layouts.guest',
        'super_admin' => 'layouts.super-admin',
        default => 'layouts.admin',
    };
    $roleIcons = [
        'advocate' => '⚖️',
        'clerk' => '🗂️',
        'ca' => '📊',
        'guest' => '👤',
    ];
@endphp

@extends($layout)
@section('title', 'Feedback')
@section('page-title', 'Feedback')

@section('content')

    <div class="mb-6">
        <h2 class="font-display font-bold text-slate-800 text-2xl">Feedback</h2>
        <p class="text-slate-400 text-sm mt-1">Give feedback to colleagues and unlock their contact details.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ══ LEFT: Give Feedback Form ══ --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden sticky top-20">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h3 class="font-display font-bold text-slate-800 text-lg">Give Feedback</h3>
                    @if (auth()->user()->role === 'clerk')
                        <span
                            class="font-mono text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full uppercase tracking-wide">Required</span>
                    @endif
                </div>
                <div class="p-5">
                    @if ($targets->isEmpty())
                        <div class="py-10 text-center">
                            <div class="text-4xl mb-3">🔍</div>
                            <p class="text-slate-500 text-sm">No users found to give feedback to.</p>
                        </div>
                    @else
                        <form action="{{ route('feedback.store') }}" method="POST" id="feedbackForm">
                            @csrf

                            {{-- Role Tabs --}}
                            <div class="mb-4">
                                <label class="block font-mono text-xs tracking-widest uppercase text-slate-400 mb-2">
                                    Who to give feedback to?
                                </label>
                                <div class="flex gap-2 flex-wrap" id="roleTabs">
                                    @foreach ($targets as $targetRole => $users)
                                        <button type="button"
                                            class="role-tab flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold border transition-all
                                        {{ $loop->first ? 'border-[#D4AF37] text-[#060C18]' : 'bg-white border-slate-200 text-slate-500 hover:border-[#D4AF37] hover:text-[#92650a]' }}"
                                            style="{{ $loop->first ? 'background:#D4AF37' : '' }}"
                                            data-role="{{ $targetRole }}">
                                            {{ $roleIcons[$targetRole] ?? '👤' }} {{ ucfirst($targetRole) }}
                                            <span class="font-mono text-xs">({{ $users->count() }})</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- User Select per Role --}}
                            {{-- Single hidden input — Populated via JS --}}
                            <input type="hidden" name="receiver_id" id="receiverIdInput" value="">

                            @foreach ($targets as $targetRole => $users)
                                <div class="role-section mb-4 {{ $loop->first ? '' : 'hidden' }}"
                                    data-role="{{ $targetRole }}">
                                    <label class="block font-mono text-xs tracking-widest uppercase text-slate-400 mb-1.5">
                                        Select {{ ucfirst($targetRole) }} *
                                    </label>
                                    <select
                                        class="role-select receiver-select w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white text-slate-700
                                       focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition cursor-pointer"
                                        data-role="{{ $targetRole }}">
                                        <option value="">— Select {{ ucfirst($targetRole) }} —</option>
                                        @foreach ($users as $u)
                                            <option value="{{ $u->id }}"
                                                {{ in_array($u->id, $givenTo) ? 'disabled' : '' }}>
                                                {{ $u->name }}{{ $u->city ? ' (' . $u->city . ')' : '' }}{{ in_array($u->id, $givenTo) ? ' ✓ Done' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach

                            {{-- Star Rating --}}
                            <div class="mb-4">
                                <label class="block font-mono text-xs tracking-widest uppercase text-slate-400 mb-2">Rating
                                    *</label>
                                <div class="flex gap-1" id="starRow">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label
                                            class="star-label cursor-pointer text-4xl leading-none transition-all text-slate-200 hover:scale-110 select-none">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden"
                                                required>★
                                        </label>
                                    @endfor
                                </div>
                                <p class="text-slate-400 text-xs font-mono mt-1 h-4" id="ratingHint">Click to rate</p>
                            </div>

                            {{-- Comment --}}
                            <div class="mb-4">
                                <label class="block font-mono text-xs tracking-widest uppercase text-slate-400 mb-1.5">
                                    Comment <span
                                        class="normal-case text-slate-300 font-sans font-normal ml-1">(optional)</span>
                                </label>
                                <textarea name="comment" rows="3" placeholder="Share your experience..."
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm resize-none
                                       placeholder:text-slate-300 text-slate-700
                                       focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition"></textarea>
                            </div>

                            {{-- Anonymous --}}
                            <div class="mb-5">
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="checkbox" name="is_anonymous" value="1"
                                        class="w-4 h-4 rounded border-slate-300 cursor-pointer"
                                        style="accent-color:#D4AF37">
                                    <span class="text-sm text-slate-600 group-hover:text-slate-800 transition-colors">Submit
                                        anonymously</span>
                                </label>
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-bold transition-all active:scale-95"
                                style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                                onmouseout="this.style.background='#D4AF37'">
                                <i class="bi bi-star-fill"></i> Submit Feedback
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══ RIGHT: Unlocked Contacts + Received ══ --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Unlocked Contacts --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div>
                        <h3 class="font-display font-bold text-slate-800 text-lg">🔓 Unlocked Contacts</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Give feedback to unlock contact details</p>
                    </div>
                    <span
                        class="font-mono text-xs bg-slate-100 text-slate-500 px-3 py-1 rounded-full">{{ count($givenTo) }}
                        users</span>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($myFeedbacks as $fb)
                        <div
                            class="flex items-center justify-between px-5 py-4 hover:bg-slate-50 transition-colors gap-4 flex-wrap">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-11 h-11 rounded-xl flex items-center justify-center text-xl bg-slate-100 flex-shrink-0">
                                    {{ $roleIcons[$fb->receiver->role] ?? '👤' }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 text-sm">{{ $fb->receiver->name }}</div>
                                    <div class="font-mono text-xs uppercase text-slate-400 tracking-wide">
                                        {{ $fb->receiver->role }}</div>
                                    {{-- Show contact directly here --}}
                                    <div class="flex flex-col gap-0.5 mt-1">
                                        <span class="flex items-center gap-1.5 text-xs text-slate-500">
                                            <i class="bi bi-envelope text-[#D4AF37] text-xs"></i>
                                            {{ $fb->receiver->email }}
                                        </span>
                                        @if ($fb->receiver->phone)
                                            <span class="flex items-center gap-1.5 text-xs text-slate-500">
                                                <i class="bi bi-telephone text-[#D4AF37] text-xs"></i>
                                                {{ $fb->receiver->phone }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }} text-xs
                                   {{ $i <= $fb->rating ? 'text-[#D4AF37]' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                                <a href="{{ route('user.detail', $fb->receiver) }}"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap"
                                    style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                                    onmouseout="this.style.background='#D4AF37'">
                                    <i class="bi bi-person-badge"></i> Full Profile
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-14 text-center">
                            <div class="w-16 h-16 rounded-2xl mx-auto mb-3 flex items-center justify-center bg-slate-100">
                                <i class="bi bi-lock text-2xl text-slate-400"></i>
                            </div>
                            <p class="text-slate-600 font-medium text-sm">No contacts unlocked yet</p>
                            <p class="text-slate-400 text-xs mt-1">Give feedback to a clerk to unlock their contact details
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Feedback Received --}}
            @if ($received->count())
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <h3 class="font-display font-bold text-slate-800 text-lg">⭐ Feedback Received</h3>
                        <div class="flex items-center gap-1.5 px-3 py-1 rounded-full border"
                            style="background:rgba(212,175,55,.08);border-color:rgba(212,175,55,.25)">
                            <i class="bi bi-star-fill text-xs text-[#D4AF37]"></i>
                            <span
                                class="font-mono font-bold text-xs text-[#92650a]">{{ number_format($received->avg('rating'), 1) }}</span>
                        </div>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach ($received as $fb)
                            <div class="px-5 py-4 hover:bg-slate-50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-9 h-9 rounded-xl font-bold font-display text-sm flex items-center justify-center flex-shrink-0
                                    {{ $fb->is_anonymous ? 'bg-slate-100 text-slate-500' : 'bg-[#D4AF37]/10 text-[#92650a]' }}">
                                        {{ $fb->is_anonymous ? '?' : strtoupper(substr($fb->giver->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-slate-800 text-sm">
                                                    {{ $fb->is_anonymous ? 'Anonymous' : $fb->giver->name ?? 'User' }}
                                                </span>
                                                @if (!$fb->is_anonymous && isset($fb->giver))
                                                    <span
                                                        class="font-mono text-xs uppercase bg-slate-100 text-slate-500 px-2 py-0.5 rounded">{{ $fb->giver->role }}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-0.5 flex-shrink-0">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }} text-xs
                                           {{ $i <= $fb->rating ? 'text-[#D4AF37]' : 'text-slate-200' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        @if ($fb->comment)
                                            <p class="text-slate-500 text-sm">{{ $fb->comment }}</p>
                                        @endif
                                        <div class="text-slate-400 text-xs font-mono mt-1">
                                            {{ $fb->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script>
            // ── Receiver hidden input sync ──
            const receiverInput = document.getElementById('receiverIdInput');

            function syncReceiver() {
                // Assign the active select's value to the hidden input
                const activeSection = document.querySelector('.role-section:not(.hidden)');
                if (activeSection) {
                    const sel = activeSection.querySelector('select.role-select');
                    receiverInput.value = sel ? sel.value : '';
                }
            }

            // Sync the receiver whenever the selection changes
            document.querySelectorAll('select.role-select').forEach(sel => {
                sel.addEventListener('change', syncReceiver);
            });

            // Validate the form on submission
            document.getElementById('feedbackForm').addEventListener('submit', function(e) {
                syncReceiver();
                if (!receiverInput.value) {
                    e.preventDefault();
                    alert('Please select a user first.');
                    return false;
                }
                const rating = document.querySelector('input[name="rating"]:checked');
                if (!rating) {
                    e.preventDefault();
                    alert('Please provide a rating.');
                    return false;
                }
            });

            // ── Role Tabs ──
            document.querySelectorAll('.role-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const role = this.dataset.role;
                    document.querySelectorAll('.role-tab').forEach(t => {
                        t.style.background = '';
                        t.classList.remove('border-[#D4AF37]', 'text-[#060C18]');
                        t.classList.add('bg-white', 'border-slate-200', 'text-slate-500');
                    });
                    this.style.background = '#D4AF37';
                    this.classList.add('border-[#D4AF37]', 'text-[#060C18]');
                    this.classList.remove('bg-white', 'border-slate-200', 'text-slate-500');

                    document.querySelectorAll('.role-section').forEach(sec => {
                        sec.classList.add('hidden');
                    });
                    const active = document.querySelector(`.role-section[data-role="${role}"]`);
                    if (active) {
                        active.classList.remove('hidden');
                    }
                    // Sync the receiver after switching tabs
                    syncReceiver();
                });
            });

            // Perform initial synchronization on page load
            syncReceiver();

            // ── Star Rating ──
            const ratingLabels = ['', 'Terrible 😟', 'Poor 😕', 'Average 😐', 'Good 😊', 'Excellent 🌟'];
            const stars = document.querySelectorAll('.star-label');
            const ratingHint = document.getElementById('ratingHint');

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    stars.forEach((s, i) => {
                        s.style.color = i <= index ? '#D4AF37' : '#e2e8f0';
                        s.style.transform = i <= index ? 'scale(1.15)' : 'scale(1)';
                    });
                    if (ratingHint) ratingHint.textContent = ratingLabels[index + 1];
                });
                star.addEventListener('mouseover', () => {
                    stars.forEach((s, i) => s.style.color = i <= index ? '#D4AF37' : '#e2e8f0');
                });
                star.addEventListener('mouseout', () => {
                    const checked = document.querySelector('input[name="rating"]:checked');
                    const val = checked ? parseInt(checked.value) - 1 : -1;
                    stars.forEach((s, i) => {
                        s.style.color = i <= val ? '#D4AF37' : '#e2e8f0';
                        s.style.transform = i <= val ? 'scale(1.15)' : 'scale(1)';
                    });
                });
            });
        </script>
    @endpush

@endsection
