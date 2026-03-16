{{-- VERIFY MODAL --}}
<div id="vOverlay" onclick="closeModal()" class="hidden fixed inset-0 bg-navy/60 backdrop-blur-sm z-[1000]"></div>

<div id="vModal"
    class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
         w-[min(500px,calc(100vw-2rem))] bg-white rounded-2xl shadow-2xl z-[1001]">
    <div
        class="flex items-center gap-4 px-6 py-5 border-b border-slate-100 rounded-t-2xl bg-gradient-to-br from-green-50 to-white">
        <div
            class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600 text-2xl flex-shrink-0">
            <i class="bi bi-person-check-fill"></i>
        </div>
        <div class="flex-1">
            <div class="font-display font-bold text-[1.1rem] text-slate-800">Verify Professional</div>
            <div class="text-xs text-slate-500 mt-0.5">Review details before approving access.</div>
        </div>
        <button onclick="closeModal()"
            class="text-slate-400 hover:text-slate-700 transition-colors text-xl leading-none"><i
                class="bi bi-x-lg"></i></button>
    </div>
    <div class="p-6 space-y-4">
        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
            <div id="v_avatar"
                class="w-14 h-14 rounded-xl bg-navy flex items-center justify-center text-gold font-bold text-lg border-2 border-gold/30 flex-shrink-0 font-display">
            </div>
            <div>
                <div id="v_name" class="font-bold text-base text-slate-800 font-display"></div>
                <span id="v_rpill"
                    class="inline-block mt-1 text-[0.6rem] font-semibold px-2.5 py-0.5 rounded font-mono uppercase tracking-wide"></span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            @foreach ([['v_email', 'bi-envelope', 'Email'], ['v_phone', 'bi-phone', 'Phone'], ['v_date', 'bi-calendar3', 'Registered'], ['v_city', 'bi-geo-alt', 'City']] as [$id, $icon, $lbl])
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                    <div
                        class="flex items-center gap-1.5 font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5">
                        <i class="bi {{ $icon }}"></i> {{ $lbl }}
                    </div>
                    <div id="{{ $id }}" class="text-sm font-semibold text-slate-700 break-all"></div>
                </div>
            @endforeach
        </div>
        <div
            class="flex items-start gap-3 px-4 py-3 bg-amber-50 border border-amber-200 rounded-lg text-amber-700 text-xs leading-relaxed">
            <i class="bi bi-info-circle-fill flex-shrink-0 mt-0.5"></i>
            Once verified, this user gets full dashboard access and appears in the professional directory.
        </div>
    </div>
    <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100 bg-slate-50/80 rounded-b-2xl">
        <button onclick="closeModal()"
            class="px-5 py-2.5 text-sm font-medium border border-slate-200 rounded-lg hover:border-slate-400 bg-white transition-all">Cancel</button>
        <button id="vConfirmBtn" onclick="doVerify()"
            class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all shadow-md shadow-green-200">
            <i class="bi bi-check-lg"></i> Confirm Verify
        </button>
    </div>
</div>

{{-- REJECT MODAL --}}
<div id="rModal"
    class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
         w-[min(440px,calc(100vw-2rem))] bg-white rounded-2xl shadow-2xl z-[1001]">
    <div
        class="flex items-center gap-4 px-6 py-5 border-b border-slate-100 rounded-t-2xl bg-gradient-to-br from-red-50 to-white">
        <div
            class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-500 text-2xl flex-shrink-0">
            <i class="bi bi-person-x-fill"></i>
        </div>
        <div class="flex-1">
            <div class="font-display font-bold text-[1.1rem] text-slate-800">Reject Registration</div>
            <div id="r_sub" class="text-xs text-slate-500 mt-0.5"></div>
        </div>
        <button onclick="closeModal()"
            class="text-slate-400 hover:text-slate-700 transition-colors text-xl leading-none"><i
                class="bi bi-x-lg"></i></button>
    </div>
    <div class="p-6">
        <div
            class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-xs leading-relaxed">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-0.5"></i>
            This marks the user as <strong>Rejected</strong>. They won't be able to access role features.
        </div>
    </div>
    <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100 bg-slate-50/80 rounded-b-2xl">
        <button onclick="closeModal()"
            class="px-5 py-2.5 text-sm font-medium border border-slate-200 rounded-lg hover:border-slate-400 bg-white transition-all">Cancel</button>
        <button id="rConfirmBtn" onclick="doReject()"
            class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all shadow-md shadow-red-200">
            <i class="bi bi-x-lg"></i> Confirm Reject
        </button>
    </div>
</div>
