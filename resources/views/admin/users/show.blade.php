@extends('layouts.admin')
@section('title', $user->name)
@section('page-title', 'User Detail')

@section('content')

    <div class="mb-4">
        <a href="{{ route('admin.users') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium
           border border-slate-200 rounded-lg hover:border-slate-400 bg-white
           text-slate-600 transition-all">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ── LEFT: Profile Card ─────────────────────────────── --}}
        <div class="lg:col-span-1 space-y-5">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="font-display font-bold text-[1rem] text-slate-800">Profile</h2>
                    @if ($user->status === 'active')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-green-100 text-green-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Active</span>
                    @elseif($user->status === 'pending')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-100 text-amber-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span>Pending</span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-red-100 text-red-600 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>Rejected</span>
                    @endif
                </div>

                <div class="p-5">
                    {{-- Avatar + Name --}}
                    <div class="flex items-center gap-4 pb-4 mb-4 border-b border-slate-100">
                        <div
                            class="w-14 h-14 rounded-xl bg-navy border-2 border-gold/30 flex items-center justify-center text-gold font-bold text-xl font-display flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-display font-bold text-[1.15rem] text-slate-800">{{ $user->name }}</div>
                            <div class="font-mono text-[0.62rem] uppercase tracking-[1.5px] text-slate-400 mt-0.5">
                                {{ $user->role }}</div>
                        </div>
                    </div>

                    {{-- Basic details --}}
                    @foreach (['Email' => $user->email, 'Phone' => $user->phone ?? '—', 'City' => $user->city ?? '—', 'State' => $user->state ?? '—', 'Joined' => $user->created_at->format('d M Y')] as $lbl => $val)
                        <div
                            class="flex justify-between items-start py-2.5 border-b border-slate-100 last:border-0 text-sm gap-3">
                            <span class="text-slate-400 flex-shrink-0">{{ $lbl }}</span>
                            <span class="font-medium text-slate-700 text-right break-all">{{ $val }}</span>
                        </div>
                    @endforeach

                    {{-- Role-specific --}}
                    @if ($user->advocateProfile)
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <div class="font-mono text-[0.55rem] tracking-[2px] uppercase text-slate-400 mb-3">Advocate Info
                            </div>
                            @foreach (['Bar Council No.' => $user->advocateProfile->bar_council_number ?? '—', 'High Court' => $user->advocateProfile->high_court ?? '—', 'Experience' => ($user->advocateProfile->experience_years ?? 0) . ' yrs'] as $l => $v)
                                <div
                                    class="flex justify-between py-2 text-sm border-b border-slate-100 last:border-0 gap-3">
                                    <span class="text-slate-400 flex-shrink-0">{{ $l }}</span><span
                                        class="font-medium text-slate-700">{{ $v }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($user->clerkProfile)
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <div class="font-mono text-[0.55rem] tracking-[2px] uppercase text-slate-400 mb-3">Clerk Info
                            </div>
                            @foreach (['Clerk ID' => $user->clerkProfile->clerk_id_number ?? '—', 'Court' => $user->clerkProfile->court_name ?? '—', 'Dept' => $user->clerkProfile->department ?? '—'] as $l => $v)
                                <div
                                    class="flex justify-between py-2 text-sm border-b border-slate-100 last:border-0 gap-3">
                                    <span class="text-slate-400 flex-shrink-0">{{ $l }}</span><span
                                        class="font-medium text-slate-700">{{ $v }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($user->caProfile)
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <div class="font-mono text-[0.55rem] tracking-[2px] uppercase text-slate-400 mb-3">CA Info</div>
                            @foreach (['Membership No.' => $user->caProfile->membership_number ?? '—', 'ICAI Region' => $user->caProfile->icai_region ?? '—'] as $l => $v)
                                <div
                                    class="flex justify-between py-2 text-sm border-b border-slate-100 last:border-0 gap-3">
                                    <span class="text-slate-400 flex-shrink-0">{{ $l }}</span><span
                                        class="font-medium text-slate-700">{{ $v }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Verify / Reject --}}
                    @if ($user->status === 'pending')
                        <div class="mt-5 pt-4 border-t border-slate-100 flex gap-3">
                            <button
                                onclick="openVerify({{ $user->id }},'{{ addslashes($user->name) }}','{{ $user->role }}','{{ $user->email }}','{{ $user->phone ?? '' }}','{{ $user->created_at->format('d M Y') }}','{{ $user->city ?? '' }}')"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold
                   bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all shadow-sm shadow-green-200">
                                <i class="bi bi-check-circle"></i> Verify
                            </button>
                            <button onclick="openReject({{ $user->id }},'{{ addslashes($user->name) }}')"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold
                   bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-200 hover:border-red-500 rounded-lg transition-all">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Documents ───────────────────────────────── --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="font-display font-bold text-[1rem] text-slate-800">Uploaded Documents</h2>
                    <span class="font-mono text-[0.65rem] text-slate-400">{{ $user->documents->count() }} total</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th
                                    class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                                    Type</th>
                                <th
                                    class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                                    File</th>
                                <th
                                    class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                                    Status</th>
                                <th
                                    class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400 hidden md:table-cell">
                                    Uploaded</th>
                                <th
                                    class="px-4 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->documents as $doc)
                                <tr class="trow" data-docid="{{ $doc->id }}">
                                    <td class="font-medium text-slate-700">
                                        {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}</td>
                                    <td>
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 text-gold hover:text-gold-h text-[0.82rem] font-medium transition-colors">
                                            <i class="bi bi-file-earmark-arrow-down"></i> View
                                        </a>
                                    </td>
                                    <td>
                                        @if ($doc->status === 'approved')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-green-100 text-green-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Approved</span>
                                        @elseif($doc->status === 'pending')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-100 text-amber-700 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                                    class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span>Pending</span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-red-100 text-red-600 font-mono text-[0.6rem] uppercase tracking-wide font-semibold"><span
                                                    class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-slate-400 text-[0.75rem] hidden md:table-cell">
                                        {{ $doc->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="flex items-center gap-1.5 justify-end">
                                            @if ($doc->status === 'pending')
                                                <button
                                                    onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Document approved!','ok')"
                                                    data-body='{"status":"approved"}'
                                                    class="flex items-center gap-1 px-3 h-8 rounded-lg bg-green-500 hover:bg-green-600 text-white text-xs font-bold transition-all">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                                <button
                                                    onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Document rejected.','err')"
                                                    data-body='{"status":"rejected","rejection_reason":"Document not valid"}'
                                                    class="flex items-center gap-1 px-3 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-bold transition-all">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            @elseif($doc->status === 'rejected')
                                                <span
                                                    class="text-[0.72rem] text-red-500 max-w-[140px]">{{ $doc->rejection_reason }}</span>
                                            @else
                                                <span class="text-[0.72rem] text-green-600 font-medium">✓ Verified</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                        <i class="bi bi-file-earmark text-2xl block mb-2 text-slate-300"></i>
                                        No documents uploaded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.verify-reject-modals')

@endsection
@push('scripts')
    <script>
        @include('admin.partials.modal-script')
        // After verify on show page, redirect back
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
                    showToast('Verified!', 'ok');
                    setTimeout(() => location.reload(), 1200);
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
                    showToast('Rejected.', 'err');
                    setTimeout(() => location.reload(), 1200);
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-x-lg"></i> Confirm Reject';
                    showToast('Error!', 'err');
                });
        }
    </script>
@endpush
