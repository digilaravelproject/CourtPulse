{{-- ══ MODALS ═══════════════════════════════════════════════════ --}}
<div id="vOverlay" onclick="closeModal()" class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-2000 transition-opacity duration-300"></div>

{{-- Verify Modal --}}
<div id="vModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(450px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.8)] z-2001 overflow-hidden transform scale-95 transition-transform duration-300">
    <div class="flex items-center gap-4 px-6 py-5 border-b border-white/5 bg-white/5">
        <div class="w-12 h-12 rounded-xl bg-green-500/10 border border-green-500/30 flex items-center justify-center text-green-400 text-xl shrink-0 shadow-[0_0_15px_rgba(34,197,94,0.2)]">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="flex-1">
            <div class="font-black text-sm text-white uppercase tracking-widest">Verify Identity</div>
            <div class="text-[0.65rem] text-white/50 uppercase tracking-wider font-bold mt-1">Approve Account Access</div>
        </div>
        <button onclick="closeModal()" class="text-white/40 hover:text-white transition-colors text-lg focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="p-6 space-y-5 bg-navy/50">
        <div class="flex items-center gap-4 p-4 bg-navy rounded-xl border border-white/5 shadow-inner">
            <div id="v_avatar" class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center font-black text-sm text-blue shrink-0"></div>
            <div>
                <div id="v_name" class="font-bold text-sm text-white mb-1"></div>
                <span id="v_rpill" class="inline-block text-[0.55rem] font-black px-2 py-0.5 rounded border uppercase tracking-widest"></span>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-navy rounded-xl border border-white/5 p-4 shadow-inner">
                <div class="text-[0.6rem] font-black uppercase tracking-[0.2em] text-white/40 mb-1">Email Address</div>
                <div id="v_email" class="text-xs font-bold text-white break-all"></div>
            </div>
            <div class="bg-navy rounded-xl border border-white/5 p-4 shadow-inner">
                <div class="text-[0.6rem] font-black uppercase tracking-[0.2em] text-white/40 mb-1">Phone Number</div>
                <div id="v_phone" class="text-xs font-bold text-white font-mono tracking-wider"></div>
            </div>
            <div class="bg-navy rounded-xl border border-white/5 p-4 shadow-inner sm:col-span-2">
                <div class="text-[0.6rem] font-black uppercase tracking-[0.2em] text-white/40 mb-1">Associated Court & City</div>
                <div id="v_court" class="text-xs font-bold text-white uppercase tracking-tight"></div>
            </div>
        </div>
    </div>
    <div class="flex justify-end gap-3 px-6 py-5 border-t border-white/5 bg-navy">
        <button onclick="closeModal()" class="px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">Cancel</button>
        <button id="vConfirmBtn" onclick="doAction('verify')" class="flex items-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-green-500 hover:bg-green-400 text-navy rounded-xl transition-all shadow-[0_5px_15px_rgba(34,197,94,0.2)]">
            <i class="fas fa-check"></i> Confirm Verify
        </button>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(450px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.8)] z-2001 overflow-hidden transform scale-95 transition-transform duration-300">
    <div class="flex items-center gap-4 px-6 py-5 border-b border-white/5 bg-red-500/5">
        <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/30 flex items-center justify-center text-red-400 text-xl shrink-0 shadow-[0_0_15px_rgba(239,68,68,0.2)]">
            <i class="fas fa-user-times"></i>
        </div>
        <div class="flex-1">
            <div class="font-black text-sm text-white uppercase tracking-widest">Account Action</div>
            <div id="r_sub" class="text-[0.65rem] text-white/50 uppercase tracking-wider font-bold mt-1"></div>
        </div>
        <button onclick="closeModal()" class="text-white/40 hover:text-white transition-colors text-lg focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="p-6 bg-navy/50">
        <div class="flex items-start gap-3 px-5 py-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-xs font-bold leading-relaxed shadow-inner">
            <i class="fas fa-exclamation-triangle mt-0.5 text-lg"></i>
            <p>Warning: This action will restrict the user's access. They will be denied access to verified features until re-verified.</p>
        </div>
    </div>
    <div class="flex justify-end gap-3 px-6 py-5 border-t border-white/5 bg-navy">
        <button onclick="closeModal()" class="px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">Cancel</button>
        <button id="rConfirmBtn" onclick="doAction('reject')" class="flex items-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-red-500 hover:bg-red-400 text-white rounded-xl transition-all shadow-[0_5px_15px_rgba(239,68,68,0.3)]">
            <i class="fas fa-times"></i> Confirm Action
        </button>
    </div>
</div>

@push('scripts')
<script>
    let _uid = null;
    let _uname = null;

    function openVerify(id, name, role, email, phone, court, city) {
        _uid = id;
        _uname = name;
        document.getElementById('v_avatar').textContent = name.substring(0, 2).toUpperCase();
        document.getElementById('v_name').textContent = name;
        document.getElementById('v_email').textContent = email;
        document.getElementById('v_phone').textContent = phone || 'Not Provided';
        document.getElementById('v_court').textContent = `${court} (${city})`;

        const p = document.getElementById('v_rpill');
        p.textContent = role.replace('_', ' ');

        let rClass = 'bg-white/10 text-white border-white/20';
        if(role === 'advocate') rClass = 'bg-blue/10 text-blue border-blue/20';
        else if(role === 'court_clerk' || role === 'ip_clerk') rClass = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
        else if(role === 'ca_cs' || role === 'agent') rClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';

        p.className = `inline-block text-[0.55rem] font-black px-2 py-0.5 rounded border uppercase tracking-widest ${rClass}`;

        const overlay = document.getElementById('vOverlay');
        const modal = document.getElementById('vModal');

        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            modal.classList.remove('scale-95');
            modal.classList.add('scale-100');
        }, 10);
    }

    function openReject(id, name) {
        _uid = id;
        _uname = name;
        document.getElementById('r_sub').textContent = `Target: ${name}`;

        const overlay = document.getElementById('vOverlay');
        const modal = document.getElementById('rModal');

        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            modal.classList.remove('scale-95');
            modal.classList.add('scale-100');
        }, 10);
    }

    function closeModal() {
        const overlay = document.getElementById('vOverlay');
        const vModal = document.getElementById('vModal');
        const rModal = document.getElementById('rModal');

        overlay.classList.add('opacity-0');
        vModal.classList.remove('scale-100');
        vModal.classList.add('scale-95');
        rModal.classList.remove('scale-100');
        rModal.classList.add('scale-95');

        setTimeout(() => {
            overlay.classList.add('hidden');
            vModal.classList.add('hidden');
            rModal.classList.add('hidden');
            _uid = _uname = null;
        }, 300);
    }

    function doAction(action) {
        const btnId = action === 'verify' ? 'vConfirmBtn' : 'rConfirmBtn';
        const btn = document.getElementById(btnId);
        const originalHtml = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

        const url = `{{ url('/admin/manage/users') }}/${_uid}/verify`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ action: action })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message || "Action completed successfully!", "ok");
                } else {
                    alert(data.message || "Action completed successfully!");
                }
                closeModal();

                const row = document.querySelector(`tr[data-uid="${_uid}"]`);
                if (row) {
                    row.style.transition = 'all 0.4s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        if (window.location.pathname.includes('/admin/dashboard')) {
                            row.remove();
                        } else {
                            window.location.reload();
                        }
                    }, 400);
                } else {
                    window.location.reload();
                }
            } else {
                throw new Error(data.message || "Something went wrong");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast(error.message || "Failed to process request", "err");
            } else {
                alert(error.message || "Failed to process request");
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    }
</script>
@endpush
