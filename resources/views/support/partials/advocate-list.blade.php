@if (isset($advocates) && $advocates->count())
    <div class="mb-3 text-sm text-slate-400 font-mono">
        {{ $advocates->total() }} advocate(s) found
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($advocates as $advocate)
            @php
                $status = \App\Models\ConnectionRequest::getStatus($authId, $advocate->id);
                $connected = $status === 'connected';
            @endphp
            <div
                class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-yellow-400 hover:shadow-lg transition-all duration-200">

                <!-- Header -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg flex-shrink-0"
                        style="background:linear-gradient(135deg,#0F1A2E,#1a2744);color:#D4AF37">
                        {{ strtoupper(substr($advocate->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-display font-bold text-slate-800 truncate">{{ $advocate->name }}</div>
                        <span
                            class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[.58rem] font-mono font-bold bg-green-100 text-green-700">
                            ✓ Verified
                        </span>
                    </div>
                    @if ($connected)
                        <span
                            class="flex items-center gap-1 text-[0.6rem] font-bold px-2 py-1 rounded-full bg-green-100 text-green-700 flex-shrink-0">
                            <i class="bi bi-patch-check-fill"></i> Connected
                        </span>
                    @endif
                </div>

                <!-- Info — encrypted unless connected -->
                @if ($advocate->advocateProfile)
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="bi bi-building-columns w-4 text-slate-400 flex-shrink-0"></i>
                            <span
                                class="truncate">{{ $connected ? $advocate->advocateProfile->high_court ?? 'N/A' : '••••• High Court' }}</span>
                        </div>
                        @if ($advocate->city)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-geo-alt w-4 text-slate-400 flex-shrink-0"></i>
                                <span>{{ $connected ? $advocate->city : '•••••, •••••' }}</span>
                            </div>
                        @endif
                        @if ($advocate->advocateProfile->experience_years)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-briefcase w-4 text-slate-400 flex-shrink-0"></i>
                                <span>{{ $advocate->advocateProfile->experience_years }} yrs experience</span>
                            </div>
                        @endif
                        <!-- Contact encrypted unless connected -->
                        @if ($hasFeedback)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-envelope w-4 flex-shrink-0" style="color:#D4AF37"></i>
                                <span class="truncate {{ !$connected ? 'blur-sm select-none' : '' }}">
                                    {{ $connected ? $advocate->email : str_repeat('•', strlen($advocate->email)) }}
                                </span>
                            </div>
                            @if ($advocate->phone)
                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                    <i class="bi bi-telephone w-4 flex-shrink-0" style="color:#D4AF37"></i>
                                    <span class="{{ !$connected ? 'blur-sm select-none' : '' }}">
                                        {{ $connected ? $advocate->phone : '••••••••••' }}
                                    </span>
                                </div>
                            @endif
                        @else
                            <div
                                class="flex items-center gap-1.5 text-xs text-red-500 bg-red-50 border border-red-100 rounded-lg px-3 py-2">
                                <i class="bi bi-lock-fill"></i>
                                <span>Submit feedback to unlock contacts</span>
                            </div>
                        @endif
                    </div>
                @endif

                @if (!$connected)
                    <div
                        class="flex items-center gap-1.5 text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2 mb-4">
                        <i class="bi bi-lock-fill"></i>
                        <span>Connect to unlock all details</span>
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('clerk.advocate.profile', $advocate->id) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-semibold border transition-all"
                        style="border-color:#D4AF37;color:#B5952F;background:rgba(212,175,55,0.06)"
                        onmouseover="this.style.background='rgba(212,175,55,0.15)'"
                        onmouseout="this.style.background='rgba(212,175,55,0.06)'">
                        <i class="bi bi-person-lines-fill text-xs"></i> View Profile
                    </a>

                    @if ($status === 'none')
                        <button onclick="sendConnect({{ $advocate->id }}, this)"
                            class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-bold transition-all"
                            style="background:#0F1A2E;color:#D4AF37">
                            <i class="bi bi-person-plus-fill text-xs"></i> Connect
                        </button>
                    @elseif($status === 'sent')
                        <button disabled
                            class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-400 cursor-not-allowed">
                            <i class="bi bi-clock text-xs"></i> Pending
                        </button>
                    @elseif($status === 'received')
                        @php
                            $req = \App\Models\ConnectionRequest::where('sender_id', $advocate->id)
                                ->where('receiver_id', $authId)
                                ->first();
                        @endphp
                        <button onclick="acceptConnect({{ $req?->id }}, this)"
                            class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-bold bg-green-600 text-white hover:bg-green-700 transition-all">
                            <i class="bi bi-check-lg text-xs"></i> Accept
                        </button>
                    @elseif($status === 'connected')
                        <button disabled
                            class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-semibold bg-green-100 text-green-700 cursor-default">
                            <i class="bi bi-patch-check-fill text-xs"></i> Connected
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($advocates->hasPages())
        <div class="mt-5">{{ $advocates->withQueryString()->links() }}</div>
    @endif
@else
    <div class="bg-white rounded-2xl border border-slate-200 py-16 text-center">
        <i class="bi bi-search text-4xl text-slate-300 block mb-3"></i>
        <p class="text-slate-400 font-medium">No advocates found.</p>
        <p class="text-slate-300 text-xs mt-1">Try different search terms.</p>
    </div>
@endif

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    function sendConnect(userId, btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split text-xs"></i> Sending...';
        fetch('{{ route('connections.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    receiver_id: userId
                })
            })
            .then(r => r.json())
            .then(() => {
                btn.innerHTML = '<i class="bi bi-clock text-xs"></i> Pending';
                btn.style.background = '#f1f5f9';
                btn.style.color = '#94a3b8';
                btn.disabled = true;
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-person-plus-fill text-xs"></i> Connect';
            });
    }

    function acceptConnect(reqId, btn) {
        btn.disabled = true;
        fetch(`/connections/${reqId}/accept`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(() => {
                btn.innerHTML = '<i class="bi bi-patch-check-fill text-xs"></i> Connected';
                btn.className =
                    'flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-semibold bg-green-100 text-green-700 cursor-default';
                setTimeout(() => location.reload(), 800);
            });
    }
</script>
