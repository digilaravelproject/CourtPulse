@extends('layouts.ca')
@section('title', 'Search Advocates')
@section('page-title', 'Find Professional Partners')

@section('content')

    <div class="cp-card mb-4">
        <div class="cp-card-body">
            <form action="{{ route('ca.search.advocates') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="cp-label">Search by Name</label>
                        <input type="text" name="search" class="cp-input" placeholder="Advocate Name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="cp-label">Practice Area</label>
                        <select name="practice_area" class="cp-select">
                            <option value="">All Areas</option>
                            <option value="Criminal">Criminal</option>
                            <option value="Civil">Civil</option>
                            <option value="Taxation">Taxation</option>
                            <option value="Corporate">Corporate</option>
                            <option value="Family">Family</option>
                            <option value="Labor">Labor</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="cp-label">&nbsp;</div>
                        <button type="submit" class="btn-cp-primary w-100 justify-content-center">
                            <i class="bi bi-search"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="advocateList" class="row g-4">
        @include('ca.partials.advocate-list', ['advocates' => $advocates])
    </div>

    <div class="mt-4">
        {{ $advocates->links() }}
    </div>

@endsection
