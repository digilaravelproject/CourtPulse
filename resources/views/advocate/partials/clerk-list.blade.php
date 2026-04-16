@if (isset($clerks) && $clerks->count())
    <div class="mb-3 text-sm text-slate-400 font-mono">
        {{ $clerks->total() }} clerk(s) found
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($clerks as $clerk)
            @php
                $status = \App\Models\ConnectionRequest::getStatus($authId, $clerk->id);
                $connected = $status === 'connected';
            @endphp
            <div
                class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-yellow-400 hover:shadow-lg transition-all duration-200 group">

                <!-- Header -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold font-display text-lg flex-shrink-0"
                        style="background:linear-gradient(135deg,#0F1A2E,#1a2744);color:#D4AF37">
                        {{ strtoupper(substr($clerk->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-display font-bold text-slate-800 truncate">{{ $clerk->name }}</div>
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
                @if ($clerk->clerkProfile)
                    <div class="space-y-2 mb-4">
                        @if ($clerk->clerkProfile->court_name)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-building w-4 text-slate-400 flex-shrink-0"></i>
                                <span
                                    class="truncate">{{ $connected ? $clerk->clerkProfile->court_name : '••••• Court' }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="bi bi-geo-alt w-4 text-slate-400 flex-shrink-0"></i>
                            <span>{{ $connected ? $clerk->clerkProfile->court_city ?? ($clerk->city ?? 'N/A') : '•••••, •••••' }}</span>
                        </div>
                        @if ($clerk->clerkProfile->department)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-briefcase w-4 text-slate-400 flex-shrink-0"></i>
                                <span>{{ $connected ? $clerk->clerkProfile->department : '••••• Section' }}</span>
                            </div>
                        @endif
                        <!-- Email & Phone encrypted unless connected -->
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="bi bi-envelope w-4 flex-shrink-0" style="color:#D4AF37"></i>
                            <span class="truncate {{ !$connected ? 'blur-sm select-none' : '' }}">
                                {{ $connected ? $clerk->email : str_repeat('•', strlen($clerk->email)) }}
                            </span>
                        </div>
                        @if ($clerk->phone)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-telephone w-4 flex-shrink-0" style="color:#D4AF37"></i>
                                <span class="{{ !$connected ? 'blur-sm select-none' : '' }}">
                                    {{ $connected ? $clerk->phone : '••••••••••' }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endif

                @if (!$connected && $clerk->clerkProfile)
                    <div
                        class="flex items-center gap-1.5 text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2 mb-4">
                        <i class="bi bi-lock-fill"></i>
                        <span>Connect to unlock full details</span>
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('advocate.clerk.profile', $clerk->id) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-semibold border transition-all"
                        style="border-color:#D4AF37;color:#B5952F;background:rgba(212,175,55,0.06)"
                        onmouseover="this.style.background='rgba(212,175,55,0.15)'"
                        onmouseout="this.style.background='rgba(212,175,55,0.06)'">
                        <i class="bi bi-person-lines-fill text-xs"></i> View Profile
                    </a>

                    @if ($status === 'none')
                        <button onclick="sendConnect({{ $clerk->id }}, this)"
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
                            $req = \App\Models\ConnectionRequest::where('sender_id', $clerk->id)
                                ->where('receiver_id', $authId)
                                ->first();
                        @endphp
                        <button onclick="acceptConnect({{ $req?->id }}, this)"
                            class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-bold transition-all bg-green-600 text-white hover:bg-green-700">
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

    @if ($clerks->hasPages())
        <div class="mt-5">{{ $clerks->withQueryString()->links() }}</div>
    @endif
@else
    <div class="bg-white rounded-2xl border border-slate-200 py-16 text-center">
        <i class="bi bi-search text-4xl text-slate-300 block mb-3"></i>
        <p class="text-slate-400 font-medium">No clerks found.</p>
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
            .then(d => {
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
            .then(d => {
                btn.innerHTML = '<i class="bi bi-patch-check-fill text-xs"></i> Connected';
                btn.className =
                    'flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-semibold bg-green-100 text-green-700 cursor-default';
                btn.disabled = true;
                // Reload to show decrypted data
                setTimeout(() => location.reload(), 800);
            });
    }
</script>
