@extends('layouts.main')
@section('title', 'Edit Match Result — Admin')
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
            <h2 class="fw-bold mb-1"><i class="bi bi-pencil-fill me-2"></i>Edit Match Result</h2>
            <p class="opacity-75 mb-0">Updating: <strong>{{ $result->opponent }}</strong> — {{ $result->match_date->format('d M Y') }}</p>
        </div>
        <a href="{{ route('admin.league.index', ['tab' => 'results']) }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to League
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.league.results.update', $result) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Match Date</label>
                    <input type="date" name="match_date" class="form-control form-control-sm"
                           value="{{ old('match_date', $result->match_date->format('Y-m-d')) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Week Label</label>
                    <input type="text" name="week_label" class="form-control form-control-sm" placeholder="e.g. WK4"
                           value="{{ old('week_label', $result->week_label) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Opponent <span class="text-danger">*</span></label>
                    <input type="text" name="opponent" class="form-control form-control-sm" required
                           value="{{ old('opponent', $result->opponent) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Competition <span class="text-danger">*</span></label>
                    <input type="text" name="competition" class="form-control form-control-sm" required
                           value="{{ old('competition', $result->competition) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Result Badge <span class="text-danger">*</span></label>
                    <input type="text" name="result_badge" class="form-control form-control-sm" required
                           placeholder="e.g. OFA 2 – 4 Team 360"
                           value="{{ old('result_badge', $result->result_badge) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Badge Colour <span class="text-danger">*</span></label>
                    <select name="status_color" class="form-select form-select-sm" required>
                        <option value="success"   {{ old('status_color', $result->status_color) == 'success'   ? 'selected' : '' }}>✅ Win (Green)</option>
                        <option value="danger"    {{ old('status_color', $result->status_color) == 'danger'    ? 'selected' : '' }}>❌ Loss (Red)</option>
                        <option value="warning"   {{ old('status_color', $result->status_color) == 'warning'   ? 'selected' : '' }}>🟡 Draw (Yellow)</option>
                        <option value="secondary" {{ old('status_color', $result->status_color) == 'secondary' ? 'selected' : '' }}>⏸ Postponed (Grey)</option>
                        <option value="primary"   {{ old('status_color', $result->status_color) == 'primary'   ? 'selected' : '' }}>🔵 Other (Blue)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Kick-off Time</label>
                    <input type="time" name="kick_off_time" class="form-control form-control-sm"
                           value="{{ old('kick_off_time', $result->kick_off_time ? substr($result->kick_off_time, 0, 5) : '') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Venue</label>
                    <input type="text" name="venue" class="form-control form-control-sm"
                           value="{{ old('venue', $result->venue) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Notes</label>
                    <input type="text" name="notes" class="form-control form-control-sm"
                           placeholder="e.g. A tough home defeat — the squad will bounce back stronger"
                           value="{{ old('notes', $result->notes) }}">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="bi bi-save-fill me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.league.index', ['tab' => 'results']) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</section>
@endsection
