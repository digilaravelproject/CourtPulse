@extends('layouts.advocate')
@section('title', 'My Documents')
@section('page-title', 'My Documents')

@section('content')

    @php
        $requiredDocs = [
            'profile_photo' => ['label' => 'Profile Photo', 'icon' => 'bi-person-bounding-box'],
            'bar_council_certificate' => ['label' => 'Bar Council Certificate', 'icon' => 'bi-patch-check'],
            'enrollment_certificate' => ['label' => 'Enrollment Certificate', 'icon' => 'bi-journal-check'],
            'degree_certificate' => ['label' => 'LLB / LLM Degree', 'icon' => 'bi-mortarboard'],
            'aadhar_card' => ['label' => 'Aadhar Card', 'icon' => 'bi-credit-card-2-front'],
            'pan_card' => ['label' => 'PAN Card', 'icon' => 'bi-card-text'],
            'practice_certificate' => ['label' => 'Practice Certificate (Sanad)', 'icon' => 'bi-award'],
        ];
        $uploadedTypes = $documents->pluck('document_type')->toArray();
        $approvedCount = $documents->where('status', 'approved')->count();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── LEFT: Checklist + Progress ── --}}
        <div class="space-y-5">

            {{-- Progress --}}
            @php $pct = round(($approvedCount / count($requiredDocs)) * 100) @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-display font-bold text-slate-800">Verification Progress</h3>
                    <span class="font-mono text-sm font-bold"
                        style="color:#D4AF37">{{ $approvedCount }}/{{ count($requiredDocs) }}</span>
                </div>
                <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden mb-2">
                    <div class="h-full rounded-full"
                        style="width:{{ $pct }}%;background:linear-gradient(90deg,#D4AF37,#B5952F);transition:width .7s">
                    </div>
                </div>
                <div class="text-slate-400 text-xs font-mono">{{ $pct }}% documents approved</div>
            </div>

            {{-- Checklist --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-display font-bold text-slate-800">Required Documents</h3>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach ($requiredDocs as $type => $meta)
                        @php
                            $doc = $documents->firstWhere('document_type', $type);
                            $status = $doc ? $doc->status : 'missing';
                        @endphp
                        <div class="flex items-center gap-3 px-5 py-3.5">
                            <div
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0
              @if ($status === 'approved') bg-green-100 text-green-600
              @elseif($status === 'pending') bg-yellow-100 text-yellow-600
              @elseif($status === 'rejected') bg-red-100 text-red-500
              @else bg-slate-100 text-slate-400 @endif">
                                <i
                                    class="bi {{ $status === 'approved' ? 'bi-check-lg' : ($status === 'pending' ? 'bi-clock' : ($status === 'rejected' ? 'bi-x-lg' : $meta['icon'])) }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-slate-700 truncate">{{ $meta['label'] }}</div>
                            </div>
                            @if ($status === 'approved')
                                <span
                                    class="font-mono text-[.6rem] font-bold px-2 py-0.5 rounded-full bg-green-100 text-green-700">OK</span>
                            @elseif($status === 'pending')
                                <span
                                    class="font-mono text-[.6rem] font-bold px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">REVIEW</span>
                            @elseif($status === 'rejected')
                                <span
                                    class="font-mono text-[.6rem] font-bold px-2 py-0.5 rounded-full bg-red-100 text-red-600">REJECTED</span>
                            @else
                                <span
                                    class="font-mono text-[.6rem] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500">MISSING</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Upload + Table ── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Upload Form --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-display font-bold text-slate-800">Upload Document</h3>
                </div>
                <div class="p-5">
                    <form action="{{ route('advocate.documents.upload') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label
                                    class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">Document
                                    Type *</label>
                                <select name="document_type" required
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white text-slate-700
                       focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition">
                                    <option value="">— Select Type —</option>
                                    @foreach ($requiredDocs as $type => $meta)
                                        <option value="{{ $type }}"
                                            {{ old('document_type') === $type ? 'selected' : '' }}>{{ $meta['label'] }}</option>
                                    @endforeach
                                    <option value="other_certificate">Other Certificate</option>
                                </select>
                                @error('document_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block font-mono text-[.63rem] tracking-wider uppercase text-slate-400 mb-1.5">File
                                    (PDF / JPG / PNG, max 5MB) *</label>
                                <input type="file" name="file" id="fileInput" required accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600
                       focus:outline-none focus:border-yellow-400 transition file:mr-3 file:py-1 file:px-3
                       file:rounded-lg file:border-0 file:text-xs file:font-bold file:cursor-pointer"
                                    style="file:background:#D4AF37;file:color:#060C18">
                                @error('file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Upload zone hint --}}
                        <div id="fileNamePreview"
                            class="hidden mb-4 px-4 py-2.5 rounded-xl text-sm text-slate-600 font-mono"
                            style="background:rgba(212,175,55,.07);border:1px solid rgba(212,175,55,.2)">
                            <i class="bi bi-file-earmark-check mr-2" style="color:#D4AF37"></i>
                            <span id="fileNameText"></span>
                        </div>

                        <button type="submit"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                            style="background:#D4AF37;color:#060C18" onmouseover="this.style.background='#B5952F'"
                            onmouseout="this.style.background='#D4AF37'">
                            <i class="bi bi-cloud-arrow-up"></i> Upload Document
                        </button>
                    </form>
                </div>
            </div>

            {{-- Uploaded Documents Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h3 class="font-display font-bold text-slate-800">Uploaded Documents</h3>
                    <span class="font-mono text-[.68rem] text-slate-400">{{ $documents->count() }} files</span>
                </div>

                @if ($documents->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th
                                        class="px-5 py-3 text-left font-mono text-[.58rem] tracking-widest uppercase text-slate-400">
                                        Document</th>
                                    <th
                                        class="px-5 py-3 text-left font-mono text-[.58rem] tracking-widest uppercase text-slate-400">
                                        File</th>
                                    <th
                                        class="px-5 py-3 text-left font-mono text-[.58rem] tracking-widest uppercase text-slate-400">
                                        Status</th>
                                    <th
                                        class="px-5 py-3 text-left font-mono text-[.58rem] tracking-widest uppercase text-slate-400">
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $doc)
                                    <tr class="trow border-b border-slate-50 last:border-0">
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0"
                                                    style="background:rgba(212,175,55,.1);color:#D4AF37">
                                                    <i class="bi bi-file-earmark"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-slate-800">
                                                        {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}</div>
                                                    @if ($doc->file_name)
                                                        <div
                                                            class="text-[.68rem] text-slate-400 font-mono truncate max-w-[160px]">
                                                            {{ $doc->file_name }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                class="flex items-center gap-1.5 text-xs font-semibold transition-colors"
                                                style="color:#D4AF37" onmouseover="this.style.color='#B5952F'"
                                                onmouseout="this.style.color='#D4AF37'">
                                                <i class="bi bi-box-arrow-up-right"></i> View
                                            </a>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if ($doc->status === 'approved')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[.65rem] font-mono font-bold bg-green-100 text-green-700">
                                                    <span class="dot bg-green-500"></span> Approved
                                                </span>
                                            @elseif($doc->status === 'pending')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[.65rem] font-mono font-bold bg-yellow-100 text-yellow-700">
                                                    <span class="dot bg-yellow-500"></span> Under Review
                                                </span>
                                            @else
                                                <div>
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[.65rem] font-mono font-bold bg-red-100 text-red-600">
                                                        <span class="dot bg-red-500"></span> Rejected
                                                    </span>
                                                    @if ($doc->rejection_reason)
                                                        <div class="text-red-500 text-[.68rem] mt-1">
                                                            {{ $doc->rejection_reason }}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-slate-400 text-xs font-mono whitespace-nowrap">
                                            {{ $doc->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-16 text-center">
                        <i class="bi bi-cloud-upload text-4xl text-slate-300 block mb-3"></i>
                        <p class="text-slate-400 text-sm font-medium">No documents uploaded yet.</p>
                        <p class="text-slate-300 text-xs mt-1">Upload all required documents to get your account verified.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('fileInput')?.addEventListener('change', function() {
                const preview = document.getElementById('fileNamePreview');
                const nameEl = document.getElementById('fileNameText');
                if (this.files[0]) {
                    nameEl.textContent = this.files[0].name + ' (' + (this.files[0].size / 1024).toFixed(1) + ' KB)';
                    preview.classList.remove('hidden');
                } else {
                    preview.classList.add('hidden');
                }
            });
        </script>
    @endpush

@endsection
