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
        <div class="lg:col-span-2 space-y-5">
            {{-- Awaiting Review --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-amber-50/30">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-clock-history text-amber-500"></i>
                        <h2 class="font-display font-bold text-[1rem] text-slate-800">Awaiting Review</h2>
                    </div>
                    <span class="font-mono text-[0.6rem] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">
                        {{ $user->documents->where('status', 'pending')->count() }} Required
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Type</th>
                                <th class="px-4 py-3 text-left font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">File</th>
                                <th class="px-4 py-3 text-center font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Status</th>
                                <th class="px-4 py-3 text-right font-mono text-[0.58rem] tracking-widest uppercase text-slate-400">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->documents->where('status', 'pending') as $doc)
                                <tr class="trow" data-docid="{{ $doc->id }}">
                                    <td class="font-medium text-slate-700">
                                        {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}</td>
                                    <td>
                                        <button onclick="openDocViewer('{{ Storage::url($doc->file_path) }}', '{{ ucwords(str_replace('_', ' ', $doc->document_type)) }}')"
                                            class="inline-flex items-center gap-1.5 text-gold hover:text-gold-h text-[0.82rem] font-medium transition-colors">
                                            <i class="bi bi-eye"></i> View PDF/Image
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-amber-100 text-amber-700 font-mono text-[0.55rem] uppercase tracking-wide font-bold">
                                            Pending
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-1.5 justify-end">
                                            <button
                                                onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Approved!','ok')"
                                                data-body='{"status":"approved"}'
                                                class="flex items-center gap-1 px-3 h-8 rounded-lg bg-green-500 hover:bg-green-600 text-white text-xs font-bold transition-all">
                                                <i class="bi bi-check-lg"></i> Approve
                                            </button>
                                            <button
                                                onclick="ajaxAction('/admin/documents/{{ $doc->id }}/review','PATCH',this,'Rejected.','err')"
                                                data-body='{"status":"rejected","rejection_reason":"Document not valid"}'
                                                class="flex items-center gap-1 px-3 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-bold transition-all">
                                                <i class="bi bi-x-lg"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-slate-400 text-sm italic">
                                        All documents reviewed or nothing pending.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Verified Documents --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden opacity-80 hover:opacity-100 transition-opacity">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <div class="flex items-center gap-2 text-slate-600">
                        <i class="bi bi-shield-check text-green-500"></i>
                        <h2 class="font-display font-medium text-[0.95rem]">Verified Documents</h2>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-slate-100">
                            @forelse($user->documents->whereIn('status', ['approved', 'rejected']) as $doc)
                                <tr class="trow bg-slate-50/30">
                                    <td class="px-4 py-3 font-medium text-slate-500 w-1/3 text-[0.8rem]">
                                        {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <button onclick="openDocViewer('{{ Storage::url($doc->file_path) }}', '{{ ucwords(str_replace('_', ' ', $doc->document_type)) }}')"
                                            class="text-slate-400 hover:text-gold text-[0.75rem] flex items-center gap-1">
                                            <i class="bi bi-file-earmark"></i> Re-view
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @if ($doc->status === 'approved')
                                            <span class="text-green-600 font-bold text-[0.65rem] uppercase tracking-widest inline-flex items-center gap-1">
                                                <i class="bi bi-check-circle"></i> Verified
                                            </span>
                                        @else
                                            <div class="flex flex-col items-end">
                                                <span class="text-red-500 font-bold text-[0.65rem] uppercase tracking-widest">Rejected</span>
                                                <span class="text-[0.6rem] text-slate-400">{{ $doc->rejection_reason }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-slate-400 text-sm">No documents verified yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Document Viewer Modal --}}
    <div id="docViewer" class="hidden fixed inset-0 z-[1000] items-center justify-center p-4">
        <div onclick="closeDocViewer()" class="absolute inset-0 bg-navy/80 backdrop-blur-sm"></div>
        <div id="docBox" class="bg-white rounded-2xl w-full max-w-5xl h-[85vh] relative flex flex-col overflow-hidden shadow-2xl transition-all duration-300 transform scale-95 opacity-0">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
                <div>
                    <h3 class="font-display font-bold text-slate-800" id="docModelTitle">Document Review</h3>
                    <p class="text-[0.65rem] text-slate-400 font-mono uppercase tracking-wider mt-0.5">Confidential User Data</p>
                </div>
                <button onclick="closeDocViewer()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="flex-1 bg-slate-50 overflow-hidden relative">
                <iframe id="docFrame" class="w-full h-full border-0" src=""></iframe>
                <div id="docImageWrap" class="hidden w-full h-full overflow-auto items-center justify-center p-4">
                    <img id="docImage" src="" class="max-w-full shadow-lg rounded-lg">
                </div>
            </div>
            <div class="px-6 py-3 border-t bg-slate-50 flex justify-between items-center">
                <span class="text-[0.7rem] text-slate-400">Tip: Scroll inside the viewer to see the full document.</span>
                <button onclick="closeDocViewer()" class="px-5 py-1.5 bg-slate-800 text-white rounded-lg text-sm font-bold">Close</button>
            </div>
        </div>
    </div>

    @include('admin.partials.verify-reject-modals')

@endsection

@push('scripts')
    <script>
        @include('admin.partials.modal-script')

        // Document Viewer Logic
        function openDocViewer(url, title) {
            const modal = document.getElementById('docViewer');
            const box = document.getElementById('docBox');
            const frame = document.getElementById('docFrame');
            const imgWrap = document.getElementById('docImageWrap');
            const img = document.getElementById('docImage');
            const titleEl = document.getElementById('docModelTitle');

            titleEl.innerText = title;
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const isImg = url.match(/\.(jpeg|jpg|gif|png|webp)$/i);

            if (isImg) {
                frame.classList.add('hidden');
                imgWrap.classList.remove('hidden');
                imgWrap.classList.add('flex');
                img.src = url;
            } else {
                imgWrap.classList.remove('flex');
                imgWrap.classList.add('hidden');
                frame.classList.remove('hidden');
                frame.src = url;
            }

            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
            }, 50);
        }

        function closeDocViewer() {
            const modal = document.getElementById('docViewer');
            const box = document.getElementById('docBox');
            box.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('docFrame').src = '';
                document.getElementById('docImage').src = '';
            }, 300);
        }

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
