@extends('layouts.admin')
@section('title', 'Court Registry Management')
@section('page-title', 'Court Registry')

@section('content')

    {{-- ═══════════════════════════════════════════
     HEADER + ADD BUTTON
    ═══════════════════════════════════════════ --}}
    <div class="mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Court Registry</h2>
            <p class="text-white/40 text-xs font-bold uppercase tracking-widest mt-2">Manage institutional coverage and location data</p>
        </div>
        <button onclick="openModal('add')" class="flex items-center gap-2 bg-blue text-navy px-8 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_5px_20px_rgba(180,180,254,0.25)]">
            <i class="fas fa-plus"></i> Register New Court
        </button>
    </div>

    {{-- ═══════════════════════════════════════════
     FILTER BAR
    ═══════════════════════════════════════════ --}}
    <div class="bg-navy2 rounded-2xl border border-white/5 p-5 mb-6 flex flex-wrap items-end gap-4">
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest">Search</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-white/30 text-xs"></i>
                <input type="text" id="filterSearch" placeholder="Court name…"
                    class="pl-10 pr-4 py-3 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors w-52"
                    oninput="debounceFilter()">
            </div>
        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest">Type</label>
            <select id="filterType" onchange="loadCourts()"
                class="py-3 pl-4 pr-8 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors appearance-none">
                <option value="">All Types</option>
                <option value="Supreme Court">Supreme Court</option>
                <option value="High Court">High Court</option>
                <option value="District Court">District Court</option>
                <option value="Tribunal">Tribunal</option>
                <option value="ROC Office">ROC Office</option>
            </select>
        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest">Status</label>
            <select id="filterStatus" onchange="loadCourts()"
                class="py-3 pl-4 pr-8 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors appearance-none">
                <option value="">All</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button onclick="resetFilters()" class="flex items-center gap-2 px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-white/50 hover:text-white hover:bg-white/10 text-xs font-black uppercase tracking-widest transition-all">
            <i class="fas fa-times"></i> Reset
        </button>
        <div id="filterSpinner" class="hidden text-blue text-sm"><i class="fas fa-spinner fa-spin"></i></div>
    </div>

    {{-- ═══════════════════════════════════════════
     TABLE
    ═══════════════════════════════════════════ --}}
    <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
        <div id="courtsTableWrap" class="overflow-x-auto min-h-[400px]">
            @include('admin.partials.courts-table', ['courts' => $courts])
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
     ADD / EDIT MODAL
    ═══════════════════════════════════════════ --}}
    <div id="modalOverlay" onclick="closeModal()" class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-[2000] transition-opacity duration-300 opacity-0"></div>

    <div id="courtModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(600px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.8)] z-[2001] overflow-hidden transform scale-95 transition-all duration-300 opacity-0">

        {{-- Header --}}
        <div class="p-8 text-center border-b border-white/5 bg-white/5 relative">
            <button onclick="closeModal()" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-white/40 hover:text-white transition-colors focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
            <div class="w-16 h-16 mx-auto rounded-2xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-2xl mb-4 shadow-[0_0_20px_rgba(180,180,254,0.15)]">
                <i class="fas fa-landmark"></i>
            </div>
            <h3 id="modalTitle" class="text-2xl font-black text-white uppercase tracking-tighter">Register Institution</h3>
            <p id="modalSubtitle" class="text-white/40 text-[0.65rem] font-bold uppercase tracking-[0.3em] mt-2">Database Registry Entry</p>
        </div>

        {{-- Form --}}
        <div class="p-8 bg-navy/50 max-h-[60vh] overflow-y-auto">
            <input type="hidden" id="editCourtId" value="">

            <div class="space-y-5">
                {{-- Name --}}
                <div>
                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Institution / Court Name <span class="text-blue">*</span></label>
                    <div class="relative">
                        <i class="fas fa-university absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                        <input type="text" id="fName" required
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                            placeholder="e.g. Bombay High Court">
                    </div>
                </div>

                {{-- Type & Pincode --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Category / Type <span class="text-blue">*</span></label>
                        <div class="relative">
                            <i class="fas fa-sitemap absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                            <select id="fType" required
                                class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors appearance-none z-0">
                                <option value="Supreme Court">Supreme Court</option>
                                <option value="High Court">High Court</option>
                                <option value="District Court">District Court</option>
                                <option value="Tribunal">Tribunal</option>
                                <option value="ROC Office">ROC Office</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none z-10"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Location Pincode <span class="text-blue">*</span></label>
                        <div class="relative">
                            <i class="fas fa-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                            <input type="text" id="fPincode" required maxlength="6"
                                class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="400001">
                        </div>
                    </div>
                </div>

                {{-- City & State --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">City / District <span class="text-blue">*</span></label>
                        <div class="relative">
                            <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                            <input type="text" id="fCity" required
                                class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="e.g. Mumbai">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">State</label>
                        <div class="relative">
                            <i class="fas fa-flag absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                            <input type="text" id="fState"
                                class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="e.g. Maharashtra">
                        </div>
                    </div>
                </div>

                {{-- Area / Address --}}
                <div>
                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Complete Area / Address <span class="text-blue">*</span></label>
                    <div class="relative">
                        <i class="fas fa-map-marked-alt absolute left-4 top-4 text-white/30"></i>
                        <textarea id="fArea" required
                            class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/20 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors h-24 resize-none"
                            placeholder="e.g. Fort, MG Road…"></textarea>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-4 border-t border-white/5">
                    <button id="modalSubmitBtn" onclick="submitCourt()" class="w-full bg-blue text-navy py-4 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_10px_20px_rgba(180,180,254,0.2)] flex items-center justify-center gap-2">
                        <i class="fas fa-cloud-upload-alt"></i> <span id="submitBtnText">Commit to Registry</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
     DELETE CONFIRM MODAL
    ═══════════════════════════════════════════ --}}
    <div id="deleteOverlay" onclick="closeDeleteModal()" class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-3000 transition-opacity duration-300 opacity-0"></div>
    <div id="deleteModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(420px,calc(100vw-2rem))] bg-navy2 border border-red-500/20 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.8)] z-3001 overflow-hidden transform scale-95 transition-all duration-300 opacity-0">
        <div class="p-8 text-center">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400 text-2xl mb-4">
                <i class="fas fa-trash-alt"></i>
            </div>
            <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-2">Confirm Deletion</h3>
            <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-6">This action cannot be undone</p>
            <p id="deleteCourtName" class="text-white/70 text-sm font-bold mb-8"></p>
            <input type="hidden" id="deleteCourtId" value="">
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white/60 text-xs font-black uppercase tracking-widest hover:bg-white/10 transition-all">Cancel</button>
                <button onclick="confirmDelete()" id="deleteBtnConfirm" class="flex-1 py-3.5 bg-red-500 rounded-xl text-white text-xs font-black uppercase tracking-widest hover:bg-red-600 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const BASE = "{{ url('admin/courts') }}";
let debounceTimer = null;

// ── TOAST ────────────────────────────────────────────────
function showToast(msg, type = 'ok') {
    let box = document.getElementById('toastBox');
    if (!box) {
        box = document.createElement('div');
        box.id = 'toastBox';
        box.className = 'fixed top-4 right-4 z-[9999] flex flex-col gap-2 w-80 pointer-events-none';
        document.body.appendChild(box);
    }
    const isOk = type === 'ok';
    const el = document.createElement('div');
    el.className = `pointer-events-auto flex items-center gap-3 px-5 py-4 rounded-2xl border shadow-2xl text-sm font-bold backdrop-blur-xl transition-all duration-300 ${isOk ? 'bg-green-500/10 border-green-500/20 text-green-400' : 'bg-red-500/10 border-red-500/20 text-red-400'}`;
    el.innerHTML = `<i class="fas ${isOk ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span class="flex-1">${msg}</span>`;
    box.appendChild(el);
    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 3500);
}

// ── FILTERS ──────────────────────────────────────────────
function debounceFilter() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadCourts, 400);
}

function loadCourts() {
    const params = new URLSearchParams();
    const s = document.getElementById('filterSearch').value;
    const t = document.getElementById('filterType').value;
    const st = document.getElementById('filterStatus').value;
    if (s) params.set('search', s);
    if (t) params.set('type', t);
    if (st) params.set('status', st);

    document.getElementById('filterSpinner').classList.remove('hidden');

    fetch(BASE + (params.toString() ? '?' + params : ''), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(d => {
        document.getElementById('courtsTableWrap').innerHTML = d.html;
        document.getElementById('filterSpinner').classList.add('hidden');
    })
    .catch(() => {
        document.getElementById('filterSpinner').classList.add('hidden');
        showToast('Failed to filter courts', 'err');
    });
}

function resetFilters() {
    document.getElementById('filterSearch').value = '';
    document.getElementById('filterType').value = '';
    document.getElementById('filterStatus').value = '';
    loadCourts();
}

// ── ADD / EDIT MODAL ─────────────────────────────────────
function openModal(mode, court = null) {
    const overlay = document.getElementById('modalOverlay');
    const modal = document.getElementById('courtModal');

    // Reset form
    document.getElementById('editCourtId').value = '';
    document.getElementById('fName').value = '';
    document.getElementById('fType').value = 'Supreme Court';
    document.getElementById('fPincode').value = '';
    document.getElementById('fCity').value = '';
    document.getElementById('fState').value = '';
    document.getElementById('fArea').value = '';

    if (mode === 'edit' && court) {
        document.getElementById('editCourtId').value = court.id;
        document.getElementById('fName').value = court.name || '';
        document.getElementById('fType').value = court.type || 'Supreme Court';
        document.getElementById('fPincode').value = court.pincode || '';
        document.getElementById('fCity').value = court.city || '';
        document.getElementById('fState').value = court.state || '';
        document.getElementById('fArea').value = court.area || '';
        document.getElementById('modalTitle').textContent = 'Edit Institution';
        document.getElementById('modalSubtitle').textContent = 'Update Registry Entry';
        document.getElementById('submitBtnText').textContent = 'Save Changes';
    } else {
        document.getElementById('modalTitle').textContent = 'Register Institution';
        document.getElementById('modalSubtitle').textContent = 'Database Registry Entry';
        document.getElementById('submitBtnText').textContent = 'Commit to Registry';
    }

    overlay.classList.remove('hidden');
    modal.classList.remove('hidden');
    setTimeout(() => {
        overlay.classList.remove('opacity-0');
        modal.classList.remove('scale-95', 'opacity-0');
        modal.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal() {
    const overlay = document.getElementById('modalOverlay');
    const modal = document.getElementById('courtModal');
    overlay.classList.add('opacity-0');
    modal.classList.remove('scale-100', 'opacity-100');
    modal.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        overlay.classList.add('hidden');
        modal.classList.add('hidden');
    }, 300);
}

function submitCourt() {
    const btn = document.getElementById('modalSubmitBtn');
    const courtId = document.getElementById('editCourtId').value;
    const data = {
        name: document.getElementById('fName').value.trim(),
        type: document.getElementById('fType').value,
        pincode: document.getElementById('fPincode').value.trim(),
        city: document.getElementById('fCity').value.trim(),
        state: document.getElementById('fState').value.trim(),
        area: document.getElementById('fArea').value.trim(),
    };

    if (!data.name || !data.type || !data.pincode || !data.city || !data.area) {
        showToast('Please fill all required fields', 'err');
        return;
    }

    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing…';

    const url = courtId ? `${BASE}/${courtId}` : BASE;
    const method = courtId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(data),
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false;
        btn.innerHTML = orig;
        if (d.success) {
            showToast(d.message, 'ok');
            closeModal();
            loadCourts();
        } else {
            showToast(d.message || 'Validation failed', 'err');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = orig;
        showToast('Request failed', 'err');
    });
}

// ── TOGGLE STATUS ────────────────────────────────────────
function toggleCourt(id, btn) {
    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';

    fetch(`${BASE}/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false;
        if (d.success) {
            showToast(d.message, 'ok');
            loadCourts(); // Reload table to reflect new status
        } else {
            btn.innerHTML = orig;
            showToast(d.message || 'Toggle failed', 'err');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = orig;
        showToast('Toggle failed', 'err');
    });
}

// ── DELETE ────────────────────────────────────────────────
function openDeleteModal(id, name) {
    document.getElementById('deleteCourtId').value = id;
    document.getElementById('deleteCourtName').textContent = `"${name}" will be permanently removed from the registry.`;

    const overlay = document.getElementById('deleteOverlay');
    const modal = document.getElementById('deleteModal');
    overlay.classList.remove('hidden');
    modal.classList.remove('hidden');
    setTimeout(() => {
        overlay.classList.remove('opacity-0');
        modal.classList.remove('scale-95', 'opacity-0');
        modal.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const overlay = document.getElementById('deleteOverlay');
    const modal = document.getElementById('deleteModal');
    overlay.classList.add('opacity-0');
    modal.classList.remove('scale-100', 'opacity-100');
    modal.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        overlay.classList.add('hidden');
        modal.classList.add('hidden');
    }, 300);
}

function confirmDelete() {
    const id = document.getElementById('deleteCourtId').value;
    const btn = document.getElementById('deleteBtnConfirm');
    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting…';

    fetch(`${BASE}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false;
        btn.innerHTML = orig;
        if (d.success) {
            showToast(d.message, 'ok');
            closeDeleteModal();
            loadCourts();
        } else {
            showToast(d.message || 'Delete failed', 'err');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = orig;
        showToast('Delete failed', 'err');
    });
}

// Escape key handlers
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
        closeDeleteModal();
    }
});
</script>
@endpush
