let _uid = null,
    _uname = null;
const RPILL = {
    advocate: 'bg-blue-100 text-blue-700',
    clerk: 'bg-purple-100 text-purple-700',
    ca: 'bg-amber-100 text-amber-700',
    guest: 'bg-slate-100 text-slate-600',
    admin: 'bg-orange-100 text-orange-700'
};

function openVerify(id, name, role, email, phone, date, city, pCount = 0) {
    _uid = id;
    _uname = name;
    document.getElementById('v_avatar').textContent = name.substring(0, 2).toUpperCase();
    document.getElementById('v_name').textContent = name;
    document.getElementById('v_email').textContent = email;
    document.getElementById('v_phone').textContent = phone || '—';
    document.getElementById('v_date').textContent = date;
    document.getElementById('v_city').textContent = city || '—';
    
    const pWarning = document.getElementById('v_pending_warning');
    if (pWarning) {
        if (pCount > 0) {
            pWarning.innerHTML = `<i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-0.5"></i> 
                <div>User has <strong>${pCount} pending documents</strong>. Verifying will approve them all automatically.</div>`;
            pWarning.classList.remove('bg-amber-50', 'border-amber-200', 'text-amber-700');
            pWarning.classList.add('bg-red-50', 'border-red-200', 'text-red-700');
        } else {
            pWarning.innerHTML = `<i class="bi bi-info-circle-fill flex-shrink-0 mt-0.5"></i> 
                <div>Once verified, this user gets full dashboard access and appears in the professional directory.</div>`;
            pWarning.classList.remove('bg-red-50', 'border-red-200', 'text-red-700');
            pWarning.classList.add('bg-amber-50', 'border-amber-200', 'text-amber-700');
        }
    }

    const p = document.getElementById('v_rpill');
    p.textContent = role;
    p.className = `inline-block mt-1 text-[0.6rem] font-semibold px-2.5 py-0.5 rounded font-mono uppercase tracking-wide ${RPILL[role] || 'bg-slate-100 text-slate-600'}`;
    const b = document.getElementById('vConfirmBtn');
    b.disabled = false;
    b.innerHTML = '<i class="bi bi-check-lg"></i> Confirm Verify';
    document.getElementById('vOverlay').classList.remove('hidden');
    const m = document.getElementById('vModal');
    m.classList.remove('hidden');
    m.classList.add('modal-pop');
}

function openReject(id, name) {
    _uid = id;
    _uname = name;
    document.getElementById('r_sub').textContent = `Confirm rejection for "${name}"`;
    const b = document.getElementById('rConfirmBtn');
    b.disabled = false;
    b.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
    document.getElementById('vOverlay').classList.remove('hidden');
    const m = document.getElementById('rModal');
    m.classList.remove('hidden');
    m.classList.add('modal-pop');
}

function closeModal() {
    ['vModal', 'rModal'].forEach(id => {
        const m = document.getElementById(id);
        if (m) {
            m.classList.add('hidden');
            m.classList.remove('modal-pop');
        }
    });
    document.getElementById('vOverlay').classList.add('hidden');
    _uid = _uname = null;
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});

function doVerify() {
    const btn = document.getElementById('vConfirmBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Verifying…';
    fetch(`/admin/users/${_uid}/verify`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json()).then(() => {
            const n = _uname;
            closeModal();
            showToast(`${n} verified!`, 'ok');
            document.querySelectorAll(`[data-uid="${_uid || 0}"]`).forEach(r => r.remove());
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Confirm Verify';
            showToast('Error!', 'err');
        });
}

function doReject() {
    const btn = document.getElementById('rConfirmBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Rejecting…';
    fetch(`/admin/users/${_uid}/reject`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json()).then(() => {
            const n = _uname;
            closeModal();
            showToast(`${n} rejected.`, 'err');
            document.querySelectorAll(`[data-uid="${_uid || 0}"]`).forEach(r => r.remove());
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
            showToast('Error!', 'err');
        });
}
