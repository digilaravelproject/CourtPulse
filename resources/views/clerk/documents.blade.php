@extends('layouts.clerk')
@section('title', 'My Documents')
@section('page-title', 'My Documents')
@section('content')

    @php
        $requiredDocs = [
            'profile_photo' => ['label' => 'Profile Photo', 'icon' => 'person'],
            'court_id_card' => ['label' => 'Court ID Card', 'icon' => 'badge'],
            'clerk_appointment_letter' => ['label' => 'Appointment Letter', 'icon' => 'description'],
            'service_certificate' => ['label' => 'Service Certificate', 'icon' => 'workspace_premium'],
            'aadhar_card' => ['label' => 'Aadhaar Card', 'icon' => 'credit_card'],
            'pan_card' => ['label' => 'PAN Card', 'icon' => 'account_balance_wallet'],
        ];
        $uploadedTypes = $documents->pluck('document_type')->toArray();
        $approvedCount = $documents->where('status', 'approved')->count();
        $totalRequired = count($requiredDocs);
        $progress = $totalRequired > 0 ? round(($approvedCount / $totalRequired) * 100) : 0;
    @endphp

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-2">My Documents</h1>
            <p class="text-text-muted-light">Upload and manage your verification documents.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Checklist sidebar --}}
        <div class="space-y-5">
            <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-900">Verification Progress</h3>
                        <span class="text-sm font-bold text-primary">{{ $approvedCount }}/{{ $totalRequired }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full transition-all duration-700"
                            style="width:{{ $progress }}%"></div>
                    </div>
                    <p class="text-xs text-text-muted-light mt-1.5">{{ $progress }}% complete</p>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach ($requiredDocs as $type => $info)
                        @php
                            $doc = $documents->where('document_type', $type)->first();
                            $status = $doc ? $doc->status : 'missing';
                        @endphp
                        <div class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors">
                            <div
                                class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
              {{ $status === 'approved'
                  ? 'bg-green-100 text-green-600'
                  : ($status === 'pending'
                      ? 'bg-amber-100 text-amber-600'
                      : ($status === 'rejected'
                          ? 'bg-red-100 text-red-500'
                          : 'bg-gray-100 text-gray-400')) }}">
                                <span class="material-icons-round text-base">{{ $info['icon'] }}</span>
                            </div>
                            <span
                                class="text-sm flex-1 {{ $status === 'missing' ? 'text-text-muted-light' : 'text-gray-800 font-medium' }}">
                                {{ $info['label'] }}
                            </span>
                            <span
                                class="material-icons-round text-base flex-shrink-0
              {{ $status === 'approved'
                  ? 'text-green-500'
                  : ($status === 'pending'
                      ? 'text-amber-500'
                      : ($status === 'rejected'
                          ? 'text-red-400'
                          : 'text-gray-300')) }}">
                                {{ $status === 'approved' ? 'check_circle' : ($status === 'pending' ? 'schedule' : ($status === 'rejected' ? 'cancel' : 'radio_button_unchecked')) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex gap-3">
                <span class="material-icons-round text-amber-500 flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-amber-700 leading-relaxed">
                    Also submit feedback about an advocate to unlock full access to contacts.
                </p>
            </div>
        </div>

        {{-- Upload + Table --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Upload Form --}}
            <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Upload Document</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('clerk.documents.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Document Type *</label>
                                <select name="document_type" required
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition cursor-pointer">
                                    <option value="">— Select Type —</option>
                                    @foreach ($requiredDocs as $type => $info)
                                        <option value="{{ $type }}">{{ $info['label'] }}</option>
                                    @endforeach
                                    <option value="other_certificate">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">File (PDF/JPG/PNG) *</label>
                                <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-primary transition
                       file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-amber-800">
                            </div>
                        </div>
                        <button type="submit"
                            class="text-sm bg-gray-900 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-gray-800 transition-colors inline-flex items-center gap-2">
                            <span class="material-icons-round text-base">cloud_upload</span> Upload
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-surface-light rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Uploaded Documents</h3>
                    <span class="text-xs font-medium bg-gray-100 text-text-muted-light px-3 py-1 rounded-full">
                        {{ $documents->count() }} / {{ $totalRequired }}
                    </span>
                </div>
                @if ($documents->count())
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="border-b border-gray-100 bg-gray-50/50">
                                <tr>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-text-muted-light uppercase tracking-wider">
                                        Document</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-text-muted-light uppercase tracking-wider">
                                        File</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-text-muted-light uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-text-muted-light uppercase tracking-wider">
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($documents as $doc)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-primary hover:text-primary-dark transition-colors">
                                                <span class="material-icons-round text-sm">download</span> View
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($doc->status === 'approved')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                    <span class="material-icons-round text-xs">check_circle</span> Approved
                                                </span>
                                            @elseif($doc->status === 'pending')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                                    <span class="material-icons-round text-xs">schedule</span> Pending
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                    <span class="material-icons-round text-xs">cancel</span> Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-text-muted-light">
                                            {{ $doc->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-16 text-center">
                        <span class="material-icons-round text-5xl text-gray-200 block mb-3">folder_open</span>
                        <p class="text-gray-500 font-medium">No documents uploaded yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
