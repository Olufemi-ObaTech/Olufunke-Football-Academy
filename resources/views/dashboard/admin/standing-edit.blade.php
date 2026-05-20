@extends('layouts.main')
@section('title', 'Edit Standing — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container" style="max-width:700px;">

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-2">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="p-4 rounded-4 text-white mb-4 shadow" style="background:linear-gradient(135deg,#10316B 60%,#1e4db7 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-pencil-fill me-2"></i>Edit Standing</h2>
            <p class="opacity-75 mb-0">Updating: <strong>{{ $standing->club_name }}</strong></p>
        </div>
        <a href="{{ route('admin.league.index', ['tab' => 'standings']) }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to League
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.league.standings.update', $standing) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Pos <span class="text-danger">*</span></label>
                    <input type="number" name="rank" class="form-control form-control-sm" min="1" required
                           value="{{ old('rank', $standing->rank) }}">
                </div>
                <div class="col-md-10">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Club Name <span class="text-danger">*</span></label>
                    <input type="text" name="club_name" class="form-control form-control-sm" required
                           value="{{ old('club_name', $standing->club_name) }}">
                </div>

                {{-- Stats row --}}
                <div class="col-12">
                    <p class="fw-semibold mb-2" style="font-size:.82rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">Match Statistics</p>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">Played <span class="text-danger">*</span></label>
                    <input type="number" name="played" class="form-control form-control-sm" min="0" required
                           value="{{ old('played', $standing->played) }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">Won <span class="text-danger">*</span></label>
                    <input type="number" name="won" class="form-control form-control-sm" min="0" required
                           value="{{ old('won', $standing->won) }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">Drawn <span class="text-danger">*</span></label>
                    <input type="number" name="drawn" class="form-control form-control-sm" min="0" required
                           value="{{ old('drawn', $standing->drawn) }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">Lost <span class="text-danger">*</span></label>
                    <input type="number" name="lost" class="form-control form-control-sm" min="0" required
                           value="{{ old('lost', $standing->lost) }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">GF <span class="text-danger">*</span></label>
                    <input type="number" name="goals_for" class="form-control form-control-sm" min="0" required
                           value="{{ old('goals_for', $standing->goals_for) }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">GA <span class="text-danger">*</span></label>
                    <input type="number" name="goals_against" class="form-control form-control-sm" min="0" required
                           value="{{ old('goals_against', $standing->goals_against) }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">Points <span class="text-danger">*</span></label>
                    <input type="number" name="points" class="form-control form-control-sm" min="0" required
                           value="{{ old('points', $standing->points) }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured_club" value="1" id="isFeatured"
                               {{ old('is_featured_club', $standing->is_featured_club) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isFeatured" style="font-size:.85rem;">
                            <i class="bi bi-shield-fill-check text-success me-1"></i>Highlight as OFA (featured club)
                        </label>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="bi bi-save-fill me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.league.index', ['tab' => 'standings']) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</section>
@endsection
