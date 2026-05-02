@extends('layouts.admin')
@section('title', $user->name)
@section('page-title', 'User Details')

@section('content')

    <div class="max-w-5xl mx-auto">

        {{-- ── BACK BUTTON ─────────────────────────────── --}}
        <div class="mb-8">
            <a href="{{ route('admin.users') ?? url()->previous() }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 text-white/70 hover:text-white transition-all text-xs font-black uppercase tracking-widest shadow-lg">
                <i class="fas fa-arrow-left"></i> Back to Directory
            </a>
        </div>

        {{-- ── MAIN PROFILE CARD ─────────────────────────────── --}}
        <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="p-8 md:p-10 border-b border-white/5 bg-white/5 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    @php
                        $roleClass = match($user->role) {
                            'advocate' => 'bg-blue/10 text-blue border-blue/20 shadow-[0_0_20px_rgba(180,180,254,0.15)]',
                            'court_clerk', 'ip_clerk' => 'bg-purple-500/10 text-purple-400 border-purple-500/20 shadow-[0_0_20px_rgba(168,85,247,0.15)]',
                            'ca_cs', 'agent' => 'bg-amber-500/10 text-amber-400 border-amber-500/20 shadow-[0_0_20px_rgba(245,158,11,0.15)]',
                            default => 'bg-white/5 text-white/50 border-white/10'
                        };
                        $initials = strtoupper(substr($user->name, 0, 1)) . (strtoupper(substr(strrchr($user->name, " "), 1, 1)) ?: '');
                    @endphp
                    <div class="w-20 h-20 rounded-2xl {{ $roleClass }} border flex items-center justify-center font-black text-3xl shrink-0">
                        {{ $initials }}
                    </div>
                    <div>
                        <h2 class="font-black text-2xl md:text-3xl text-white uppercase tracking-tight mb-3">{{ $user->name }}</h2>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-block text-[0.65rem] font-black uppercase tracking-widest {{ $roleClass }} border px-3 py-1 rounded-md">
                                {{ str_replace('_', ' ', $user->role) }}
                            </span>
                            @if ($user->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-green-500/10 border border-green-500/20 text-green-400 font-black text-[0.65rem] uppercase tracking-widest">
                                    <i class="fas fa-check-circle"></i> Active
                                </span>
                            @elseif($user->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-amber-500/10 border border-amber-500/20 text-amber-400 font-black text-[0.65rem] uppercase tracking-widest">
                                    <i class="fas fa-hourglass-half"></i> Pending Review
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-red-500/10 border border-red-500/20 text-red-400 font-black text-[0.65rem] uppercase tracking-widest">
                                    <i class="fas fa-times-circle"></i> Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @if ($user->status === 'pending')
                    <div class="flex gap-4 w-full md:w-auto mt-4 md:mt-0">
                        <button onclick="openVerify({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->role }}')"
                            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-green-500/10 border border-green-500/30 hover:bg-green-500 text-green-400 hover:text-white text-xs font-black uppercase tracking-widest transition-all shadow-lg hover:shadow-[0_0_20px_rgba(34,197,94,0.3)]">
                            <i class="fas fa-check"></i> Verify
                        </button>
                        <button onclick="openReject({{ $user->id }}, '{{ addslashes($user->name) }}')"
                            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-red-500/10 border border-red-500/30 hover:bg-red-500 text-red-400 hover:text-white text-xs font-black uppercase tracking-widest transition-all shadow-lg hover:shadow-[0_0_20px_rgba(239,68,68,0.3)]">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    </div>
                @endif
            </div>

            {{-- Body Grid --}}
            <div class="p-8 md:p-10">

                {{-- Basic Info --}}
                <div class="mb-10">
                    <h3 class="text-[0.65rem] font-black text-white/40 uppercase tracking-[0.25em] mb-6 border-b border-white/5 pb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                            $basicDetails = [
                                'Email Address' => $user->email,
                                'Phone Number' => $user->phone ?? 'Not Provided',
                                'Registered On' => $user->created_at ? $user->created_at->format('d M, Y') : 'N/A',
                            ];
                            if ($user->status === 'active') {
                                $basicDetails['Verified On'] = $user->updated_at ? $user->updated_at->format('d M, Y') : 'N/A';
                            }
                        @endphp
                        @foreach ($basicDetails as $lbl => $val)
                            <div class="bg-navy rounded-2xl border border-white/5 p-6 shadow-inner">
                                <div class="text-[0.65rem] font-black uppercase tracking-widest text-white/40 mb-2">{{ $lbl }}</div>
                                <div class="text-sm font-bold text-white break-all">{{ $val }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Professional Info --}}
                @if ($user->role !== 'guest')
                    <div>
                        <h3 class="text-[0.65rem] font-black text-white/40 uppercase tracking-[0.25em] mb-6 border-b border-white/5 pb-4">Professional Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            @php
                                $profDetails = [];
                                
                                if (in_array($user->role, ['advocate', 'court_clerk', 'ip_clerk'])) {
                                    $profDetails['Primary Court'] = $user->court ? $user->court->name : 'Not Provided';
                                }
                                
                                if ($user->sub_role) {
                                    $profDetails['Specialization'] = ucwords(str_replace('_', ' ', $user->sub_role));
                                }

                                if ($user->experience_years) {
                                    $profDetails['Experience'] = $user->experience_years . ' Years';
                                }
                                
                                if ($user->license_number) {
                                    $profDetails['License / Reg No.'] = $user->license_number;
                                }
                                
                                if ($user->capabilities) {
                                    $profDetails['Capabilities'] = $user->capabilities;
                                }
                                
                                if ($user->past_employers) {
                                    $profDetails['Past Employers'] = $user->past_employers;
                                }
                            @endphp

                            @forelse ($profDetails as $lbl => $val)
                                <div class="bg-navy rounded-2xl border border-white/5 p-6 shadow-inner">
                                    <div class="text-[0.65rem] font-black uppercase tracking-widest text-white/40 mb-2">{{ $lbl }}</div>
                                    <div class="text-sm font-bold text-white">{{ $val }}</div>
                                </div>
                            @empty
                                <div class="col-span-full p-6 text-center text-white/40 text-sm font-bold uppercase tracking-widest border border-white/5 rounded-2xl bg-white/5">
                                    No professional details provided during registration.
                                </div>
                            @endforelse

                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════
     VERIFY MODAL
    ═══════════════════════════════════════════ --}}
    <div id="vOverlay" onclick="closeModal()" class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-[2000] transition-opacity duration-300"></div>

    <div id="vModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(450px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.8)] z-[2001] overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="flex items-center gap-5 px-8 py-6 border-b border-white/5 bg-white/5">
            <div class="w-14 h-14 rounded-2xl bg-green-500/10 border border-green-500/30 flex items-center justify-center text-green-400 text-2xl shrink-0 shadow-[0_0_20px_rgba(34,197,94,0.2)]">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="flex-1">
                <div class="font-black text-base text-white uppercase tracking-widest">Verify Professional</div>
                <div id="v_sub" class="text-[0.7rem] text-white/50 uppercase tracking-wider font-bold mt-1.5">Approve Account Access</div>
            </div>
        </div>
        <div class="p-8 bg-navy/50">
            <div class="flex items-start gap-4 px-6 py-5 bg-green-500/10 border border-green-500/20 rounded-2xl text-green-400 text-sm font-bold leading-relaxed shadow-inner">
                <i class="fas fa-info-circle mt-0.5 text-xl"></i>
                <p>This will grant the user full access to the dashboard and directory.</p>
            </div>
        </div>
        <div class="flex justify-end gap-4 px-8 py-6 border-t border-white/5 bg-navy">
            <button onclick="closeModal()" class="px-8 py-3.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">Cancel</button>
            <button id="vConfirmBtn" onclick="doAction('verify')" class="flex items-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-green-500 hover:bg-green-400 text-navy rounded-xl transition-all shadow-[0_5px_20px_rgba(34,197,94,0.25)]">
                <i class="fas fa-check text-sm"></i> Confirm Verify
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
     REJECT MODAL
    ═══════════════════════════════════════════ --}}
    <div id="rModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(450px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.8)] z-[2001] overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="flex items-center gap-5 px-8 py-6 border-b border-white/5 bg-red-500/5">
            <div class="w-14 h-14 rounded-2xl bg-red-500/10 border border-red-500/30 flex items-center justify-center text-red-400 text-2xl shrink-0 shadow-[0_0_20px_rgba(239,68,68,0.2)]">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="flex-1">
                <div class="font-black text-base text-white uppercase tracking-widest">Reject Registration</div>
                <div id="r_sub" class="text-[0.7rem] text-white/50 uppercase tracking-wider font-bold mt-1.5"></div>
            </div>
        </div>
        <div class="p-8 bg-navy/50">
            <div class="flex items-start gap-4 px-6 py-5 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm font-bold leading-relaxed shadow-inner">
                <i class="fas fa-exclamation-triangle mt-0.5 text-xl"></i>
                <p>Warning: This will reject the user's profile and deny access to the network.</p>
            </div>
        </div>
        <div class="flex justify-end gap-4 px-8 py-6 border-t border-white/5 bg-navy">
            <button onclick="closeModal()" class="px-8 py-3.5 text-xs font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">Cancel</button>
            <button id="rConfirmBtn" onclick="doAction('reject')" class="flex items-center gap-2 px-8 py-3.5 text-xs font-black uppercase tracking-widest bg-red-500 hover:bg-red-400 text-white rounded-xl transition-all shadow-[0_5px_20px_rgba(239,68,68,0.3)]">
                <i class="fas fa-times text-sm"></i> Confirm Reject
            </button>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let _uid = null;

    function openVerify(id, name, role) {
        _uid = id;
        document.getElementById('v_sub').textContent = `Approve ${name}`;
        _showModal('vModal');
    }

    function openReject(id, name) {
        _uid = id;
        document.getElementById('r_sub').textContent = `Target: ${name}`;
        _showModal('rModal');
    }

    function _showModal(modalId) {
        const overlay = document.getElementById('vOverlay');
        const modal = document.getElementById(modalId);

        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');

        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            modal.classList.remove('scale-95', 'opacity-0');
            modal.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        ['vModal', 'rModal'].forEach(id => {
            const m = document.getElementById(id);
            if(m) {
                m.classList.remove('scale-100', 'opacity-100');
                m.classList.add('scale-95', 'opacity-0');
            }
        });
        const overlay = document.getElementById('vOverlay');
        if(overlay) overlay.classList.add('opacity-0');

        setTimeout(() => {
            ['vModal', 'rModal', 'vOverlay'].forEach(id => {
                if(document.getElementById(id)) document.getElementById(id).classList.add('hidden');
            });
            _uid = null;
        }, 300);
    }

    function doAction(action) {
        const btnId = action === 'verify' ? 'vConfirmBtn' : 'rConfirmBtn';
        const btn = document.getElementById(btnId);
        const originalHtml = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

        const url = `/admin/manage/users/${_uid}/verify`;

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
                }
                closeModal();
                setTimeout(() => window.location.reload(), 1000);
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
