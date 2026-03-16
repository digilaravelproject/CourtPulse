@if (isset($clerks) && $clerks->count())
    <div class="mb-3 text-sm text-slate-400 font-mono">
        {{ $clerks->total() }} clerk(s) found
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($clerks as $clerk)
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
                            class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[.58rem] font-mono font-bold
          {{ $clerk->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $clerk->status === 'active' ? '✓ Verified' : 'Pending' }}
                        </span>
                    </div>
                </div>

                <!-- Info -->
                @if ($clerk->clerkProfile)
                    <div class="space-y-2 mb-4">
                        @if ($clerk->clerkProfile->court_name)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-building w-4 text-slate-400 flex-shrink-0"></i>
                                <span class="truncate">{{ $clerk->clerkProfile->court_name }}</span>
                            </div>
                        @endif
                        @if ($clerk->clerkProfile->court_city ?? $clerk->city)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-geo-alt w-4 text-slate-400 flex-shrink-0"></i>
                                <span>{{ $clerk->clerkProfile->court_city ?? $clerk->city }}</span>
                            </div>
                        @endif
                        @if ($clerk->clerkProfile->department)
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <i class="bi bi-briefcase w-4 text-slate-400 flex-shrink-0"></i>
                                <span>{{ $clerk->clerkProfile->department }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Contact -->
                @if (auth()->user()->status === 'active')
                    <div class="border-t border-slate-100 pt-3 space-y-1.5">
                        <div class="flex items-center gap-2 text-xs text-slate-600">
                            <i class="bi bi-envelope w-4 flex-shrink-0" style="color:#D4AF37"></i>
                            <span class="truncate">{{ $clerk->email }}</span>
                        </div>
                        @if ($clerk->phone)
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <i class="bi bi-telephone w-4 flex-shrink-0" style="color:#D4AF37"></i>
                                <span>{{ $clerk->phone }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="border-t border-slate-100 pt-3 text-center">
                        <span class="text-xs text-slate-400">
                            <i class="bi bi-lock mr-1"></i> Verify account to see contact
                        </span>
                    </div>
                @endif
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
