@extends('layouts.ca')
@section('title', 'My Documents')
@section('page-title', 'Verification Documents')

@section('content')

    <div class="row g-4">
        <div class="col-lg-12">
            <div class="cp-card">
                <div class="cp-card-header">
                    <h3 class="cp-card-title">Document History</h3>
                    <div class="badge-cp badge-pending">Max size 5MB</div>
                </div>
                <div class="cp-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 cp-label">Document Type</th>
                                    <th class="py-3 cp-label text-center">Status</th>
                                    <th class="py-3 cp-label text-center">Uploaded On</th>
                                    <th class="pe-4 py-3 cp-label text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-capitalize">{{ str_replace('_', ' ', $doc->document_type) }}</div>
                                        </td>
                                        <td class="text-center">
                                            @if($doc->status === 'approved')
                                                <span class="badge-cp badge-active">Approved</span>
                                            @elseif($doc->status === 'rejected')
                                                <span class="badge-cp badge-rejected">Rejected</span>
                                            @else
                                                <span class="badge-cp badge-pending">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center small text-muted">
                                            {{ $doc->created_at->format('d M, Y') }}
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn-cp-secondary py-1 px-3">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-5 text-center text-muted">
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
    </div>

@endsection
