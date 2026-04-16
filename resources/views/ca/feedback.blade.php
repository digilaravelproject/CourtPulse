@extends('layouts.ca')
@section('title', 'Feedback')
@section('page-title', 'Share Your Experience')

@section('content')

    <div class="row g-4">
        <!-- New Feedback Form -->
        <div class="col-lg-5">
            <div class="cp-card">
                <div class="cp-card-header">
                    <h3 class="cp-card-title">Give Feedback</h3>
                </div>
                <div class="cp-card-body">
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="cp-label">Select Advocate</label>
                            <select name="receiver_id" class="cp-select" required>
                                <option value="">Choose an advocate...</option>
                                @foreach($advocates as $adv)
                                    <option value="{{ $adv->id }}">{{ $adv->name }} ({{ $adv->advocateProfile->high_court ?? 'Advocate' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="cp-label">Rating</label>
                            <div class="d-flex gap-3 h4 mb-0">
                                @for($i=1; $i<=5; $i++)
                                    <div class="form-check form-check-inline p-0 m-0">
                                        <input class="btn-check" type="radio" name="rating" id="rate{{$i}}" value="{{$i}}" required {{ $i==5 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning rounded-circle" for="rate{{$i}}" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                                            {{$i}}
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="cp-label">Detailed Comment</label>
                            <textarea name="comment" class="cp-input" rows="4" placeholder="How was the professional interaction?"></textarea>
                        </div>
                        <button type="submit" class="btn-cp-primary w-100 justify-content-center py-2">
                            Submit Feedback
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="col-lg-7">
            <div class="cp-card">
                <div class="cp-card-header">
                    <h3 class="cp-card-title">My Feedbacks</h3>
                </div>
                <div class="cp-card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 cp-label">Professional</th>
                                    <th class="py-3 cp-label">Rating</th>
                                    <th class="pe-4 py-3 cp-label text-end">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myFeedbacks as $fb)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ $fb->receiver->name ?? 'User' }}</div>
                                            <div class="text-muted small truncate" style="max-width:200px">{{ $fb->comment ?? 'No comment' }}</div>
                                        </td>
                                        <td>
                                            <span class="text-warning">
                                                @for($i=1; $i<=$fb->rating; $i++) <i class="bi bi-star-fill"></i> @endfor
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end small text-muted">
                                            {{ $fb->created_at->format('d M, y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-5 text-center text-muted">No feedbacks given yet.</td>
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
