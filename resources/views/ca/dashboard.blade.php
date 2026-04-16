@extends('layouts.ca')
@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="cp-card p-4 text-center">
                <div class="cp-label">Approved Documents</div>
                <div class="h2 font-bold mb-0">{{ $documentsStatus['approved'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="cp-card p-4 text-center">
                <div class="cp-label">Pending Review</div>
                <div class="h2 font-bold mb-0 text-warning">{{ $documentsStatus['pending'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="cp-card p-4 text-center">
                <div class="cp-label">Feedback Given</div>
                <div class="h2 font-bold mb-0 text-primary">{{ $feedbackCount }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="cp-card p-4 text-center">
                <div class="cp-label">Profile Status</div>
                <div>
                    @if($user->status === 'active')
                        <span class="badge-cp badge-active">Active</span>
                    @else
                        <span class="badge-cp badge-pending">Pending</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="cp-card mb-4">
                <div class="cp-card-header">
                    <h3 class="cp-card-title">Professional Summary</h3>
                    <a href="{{ route('ca.profile') }}" class="btn-cp-secondary py-1 px-3">Edit</a>
                </div>
                <div class="cp-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="cp-label">Firm Name</div>
                            <div class="fw-semibold">{{ $profile->firm_name ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="cp-label">Membership Number</div>
                            <div class="fw-semibold">{{ $profile->membership_number ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="cp-label">About / Bio</div>
                            <p class="text-muted small mb-0">{{ $profile->bio ?? 'No bio provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="cp-card h-100">
                <div class="cp-card-header">
                    <h3 class="cp-card-title">Quick Actions</h3>
                </div>
                <div class="cp-card-body d-grid gap-2">
                    <a href="{{ route('ca.documents') }}" class="btn-cp-primary">
                        <i class="bi bi-upload"></i> Manage Documents
                    </a>
                    <a href="{{ route('ca.search.advocates') }}" class="btn-cp-secondary">
                        <i class="bi bi-search"></i> Search Advocates
                    </a>
                    <a href="{{ route('feedback') }}" class="btn-cp-secondary">
                        <i class="bi bi-chat-text"></i> Give Feedback
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
