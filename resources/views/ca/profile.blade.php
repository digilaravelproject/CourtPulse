@extends('layouts.ca')
@section('title', 'My Profile')
@section('page-title', 'Firm Profile')

@section('content')

    <div class="cp-card">
        <form action="{{ route('ca.profile.update') }}" method="POST">
            @csrf
            <div class="cp-card-header">
                <h3 class="cp-card-title">Profile Settings</h3>
                <button type="submit" class="btn-cp-primary">Update Profile</button>
            </div>
            <div class="cp-card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="cp-label">Firm Name</label>
                        <input type="text" name="firm_name" class="cp-input" value="{{ old('firm_name', $profile->firm_name) }}" placeholder="e.g. Khanna & Associates">
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">Membership Number (ICAI)</label>
                        <input type="text" name="membership_number" class="cp-input" value="{{ old('membership_number', $profile->membership_number) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">ICAI Region</label>
                        <input type="text" name="icai_region" class="cp-input" value="{{ old('icai_region', $profile->icai_region) }}" placeholder="e.g. NIRC, WIRC" required>
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">Membership Since</label>
                        <input type="date" name="membership_date" class="cp-input" value="{{ old('membership_date', $profile->membership_date ? \Carbon\Carbon::parse($profile->membership_date)->format('Y-m-d') : '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="cp-label">Experience (Years)</label>
                        <input type="number" name="experience_years" class="cp-input" value="{{ old('experience_years', $profile->experience_years) }}" min="0">
                    </div>
                    <div class="col-md-12">
                        <label class="cp-label">Office Address</label>
                        <textarea name="office_address" class="cp-input" rows="3">{{ old('office_address', $profile->office_address) }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="cp-label">Professional Bio</label>
                        <textarea name="bio" class="cp-input" rows="5" placeholder="Tell advocates about your expertise...">{{ old('bio', $profile->bio) }}</textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
