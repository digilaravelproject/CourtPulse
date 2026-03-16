@if ($advocates->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($advocates as $advocate)
            <div
                class="bg-white rounded-2xl border border-slate-200 overflow-hidden
                hover:border-[#D4AF37] hover:shadow-md transition-all group">
                {{-- Card Header --}}
                <div class="px-5 pt-5 pb-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-11 h-11 rounded-xl font-bold font-display text-base flex items-center justify-center flex-shrink-0"
                            style="background:rgba(212,175,55,.12);color:#92650a">
                            {{ strtoupper(substr($advocate->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="font-display font-bold text-slate-800 text-sm leading-tight truncate">
                                {{ $advocate->name }}
                            </div>
                            @if ($advocate->status === 'active')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                    <i class="bi bi-patch-check-fill text-xs"></i> Verified
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($advocate->advocateProfile)
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <i class="bi bi-building text-slate-400 w-3.5 flex-shrink-0"></i>
                                <span class="truncate">{{ $advocate->advocateProfile->high_court ?? '—' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <i class="bi bi-geo-alt text-slate-400 w-3.5 flex-shrink-0"></i>
                                <span>{{ $advocate->city ?? '—' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <i class="bi bi-clock-history text-slate-400 w-3.5 flex-shrink-0"></i>
                                <span>{{ $advocate->advocateProfile->experience_years ?? 0 }} yrs experience</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Contact Section --}}
                <div class="border-t border-slate-100 px-5 py-3">
                    @if ($hasFeedback)
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <i class="bi bi-envelope text-xs flex-shrink-0" style="color:#D4AF37"></i>
                                <span class="truncate">{{ $advocate->email }}</span>
                            </div>
                            @if ($advocate->phone)
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class="bi bi-telephone text-xs flex-shrink-0" style="color:#D4AF37"></i>
                                    <span>{{ $advocate->phone }}</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center justify-center gap-2 py-1">
                            <i class="bi bi-lock-fill text-slate-300 text-xs"></i>
                            <span class="text-xs text-slate-400">Give feedback to see contact</span>
                        </div>
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
        <div class="w-16 h-16 rounded-2xl mx-auto mb-3 flex items-center justify-center bg-slate-100">
            <span class="text-2xl">⚖️</span>
        </div>
        <p class="text-slate-500 font-medium text-sm">No advocates found</p>
        <p class="text-slate-400 text-xs mt-1">Try adjusting your search filters</p>
    </div>
@endif
