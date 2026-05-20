@extends('layouts.main')
@section('title', 'Edit Fixture — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container" style="max-width:760px;">

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-2">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="p-4 rounded-4 text-white mb-4 shadow" style="background:linear-gradient(135deg,#10316B 60%,#1e4db7 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-pencil-fill me-2"></i>Edit Fixture</h2>
            <p class="opacity-75 mb-0">Updating: <strong>{{ $fixture->home_team }} vs {{ $fixture->away_team }}</strong></p>
        </div>
        <a href="{{ route('admin.league.index', ['tab' => 'fixtures']) }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to League
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.league.fixtures.update', $fixture) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Week Label <span class="text-danger">*</span></label>
                    <input type="text" name="week_label" class="form-control form-control-sm" required
                           placeholder="e.g. WK5"
                           value="{{ old('week_label', $fixture->week_label) }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Home Team <span class="text-danger">*</span></label>
                    <input type="text" name="home_team" class="form-control form-control-sm" required
                           value="{{ old('home_team', $fixture->home_team) }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Away Team <span class="text-danger">*</span></label>
                    <input type="text" name="away_team" class="form-control form-control-sm" required
                           value="{{ old('away_team', $fixture->away_team) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Competition <span class="text-danger">*</span></label>
                    <input type="text" name="competition" class="form-control form-control-sm" required
                           value="{{ old('competition', $fixture->competition) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Fixture Date <span class="text-danger">*</span></label>
                    <input type="date" name="fixture_date" class="form-control form-control-sm" required
                           value="{{ old('fixture_date', $fixture->fixture_date->format('Y-m-d')) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Kick-off Time <span class="text-danger">*</span></label>
                    <input type="time" name="kick_off_time" class="form-control form-control-sm" required
                           value="{{ old('kick_off_time', substr($fixture->kick_off_time, 0, 5)) }}">
                </div>
                <div class="col-md-7">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Venue <span class="text-danger">*</span></label>
                    <input type="text" name="venue" class="form-control form-control-sm" required
                           value="{{ old('venue', $fixture->venue) }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                               {{ old('is_active', $fixture->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive" style="font-size:.85rem;">
                            Set as Active (shown on homepage)
                        </label>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="bi bi-save-fill me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.league.index', ['tab' => 'fixtures']) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</section>
@endsection
