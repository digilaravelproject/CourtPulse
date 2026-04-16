@extends($layout)
@section('title', 'My Connections')
@section('page-title', 'My Connections')
@section('content')

    <div class="mb-6">
        <h2 class="font-display font-bold text-slate-800 text-2xl">My Connections</h2>
        <p class="text-slate-400 text-sm mt-1">Manage your professional network on Court Pulse.</p>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 p-3 mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Pending Requests Received --}}
    @if ($pendingReceived->count())
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3">
                <h3 class="font-semibold text-slate-700 text-base">Pending Requests</h3>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                    {{ $pendingReceived->count() }}
                </span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($pendingReceived as $req)
                    <div class="bg-white rounded-2xl border border-amber-200 p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-bold text-base flex-shrink-0"
                                style="background:linear-gradient(135deg,#0F1A2E,#1a2744);color:#D4AF37">
                                {{ strtoupper(substr($req->sender->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-slate-800 truncate">{{ $req->sender->name }}</div>
                                <div class="text-xs text-slate-400 capitalize">{{ $req->sender->role }}</div>
                            </div>
                            <span
                                class="flex items-center gap-1 text-[0.6rem] font-bold px-2 py-1 rounded-full bg-amber-100 text-amber-700">
                                <i class="bi bi-clock"></i> Pending
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 mb-4">
                            <i class="bi bi-calendar3 mr-1"></i> {{ $req->created_at->diffForHumans() }}
                        </div>
                        <div class="flex gap-2">
                            <button onclick="handleRequest({{ $req->id }}, 'accept', this)"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-bold bg-green-600 text-white hover:bg-green-700 transition-all">
                                <i class="bi bi-check-lg"></i> Accept
                            </button>
                            <button onclick="handleRequest({{ $req->id }}, 'reject', this)"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-semibold border border-red-200 text-red-500 hover:bg-red-50 transition-all bg-white">
                                <i class="bi bi-x-lg"></i> Reject
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Sent Requests --}}
    @if ($pendingSent->count())
        <div class="mb-6">
            <h3 class="font-semibold text-slate-700 text-base mb-3">Sent Requests</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($pendingSent as $req)
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-bold text-base flex-shrink-0"
                                style="background:linear-gradient(135deg,#0F1A2E,#1a2744);color:#D4AF37">
                                {{ strtoupper(substr($req->receiver->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-slate-800 truncate">{{ $req->receiver->name }}</div>
                                <div class="text-xs text-slate-400 capitalize">{{ $req->receiver->role }}</div>
                            </div>
                            <span
                                class="flex items-center gap-1 text-[0.6rem] font-bold px-2 py-1 rounded-full bg-slate-100 text-slate-500">
                                <i class="bi bi-clock"></i> Awaiting
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 mt-3">
                            <i class="bi bi-calendar3 mr-1"></i> Sent {{ $req->created_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Connected --}}
    <div>
        <div class="flex items-center gap-2 mb-3">
            <h3 class="font-semibold text-slate-700 text-base">Connected</h3>
            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                {{ $connected->count() }}
            </span>
        </div>

        @if ($connected->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($connected as $person)
                    <div class="bg-white rounded-2xl border border-green-200 p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-bold text-base flex-shrink-0"
                                style="background:linear-gradient(135deg,#D4AF37,#B5952F);color:#0A1120">
                                {{ strtoupper(substr($person->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-slate-800 truncate">{{ $person->name }}</div>
                                <div class="text-xs text-slate-400 capitalize">{{ $person->role }}</div>
                            </div>
                            <i class="bi bi-patch-check-fill text-green-500 flex-shrink-0"></i>
                        </div>
                        <!-- Full details visible since connected -->
                        <div class="space-y-1.5 text-sm text-slate-600">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-envelope text-xs" style="color:#D4AF37"></i>
                                <span class="truncate">{{ $person->email }}</span>
                            </div>
                            @if ($person->phone)
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-telephone text-xs" style="color:#D4AF37"></i>
                                    <span>{{ $person->phone }}</span>
                                </div>
                            @endif
                            @if ($person->city)
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-geo-alt text-xs" style="color:#D4AF37"></i>
                                    <span>{{ $person->city }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 py-16 text-center">
                <i class="bi bi-people text-5xl text-slate-200 block mb-3"></i>
                <p class="text-slate-400 font-medium">No connections yet</p>
                <p class="text-slate-300 text-xs mt-1">Search and connect with advocates or clerks.</p>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            function handleRequest(reqId, action, btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                fetch(`/connections/${reqId}/${action}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(() => location.reload())
                    .catch(() => {
                        btn.disabled = false;
                    });
            }
        </script>
    @endpush

@endsection
