@extends('layouts.main')
@section('title', 'Edit Player — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container" style="max-width:700px;">

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-2">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="p-4 rounded-4 text-white mb-4 shadow" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-pencil-fill me-2"></i>Edit Player Spotlight</h2>
            <p class="opacity-75 mb-0">Updating: <strong>{{ $player->name }}</strong></p>
        </div>
        <a href="{{ route('admin.spotlight.index') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to Spotlight
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.spotlight.update', $player) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $player->name) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control" required value="{{ old('position', $player->position) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Age <span class="text-danger">*</span></label>
                    <input type="number" name="age" class="form-control" min="5" max="50" required value="{{ old('age', $player->age) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Goals <span class="text-danger">*</span></label>
                    <input type="number" name="goals" class="form-control" min="0" required value="{{ old('goals', $player->goals) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Assists <span class="text-danger">*</span></label>
                    <input type="number" name="assists" class="form-control" min="0" required value="{{ old('assists', $player->assists) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Matches <span class="text-danger">*</span></label>
                    <input type="number" name="matches" class="form-control" min="0" required value="{{ old('matches', $player->matches) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Player Quote <span class="text-danger">*</span></label>
                    <input type="text" name="quote" class="form-control" required value="{{ old('quote', $player->quote) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Player Photo <small class="text-muted">(leave blank to keep current)</small></label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <img src="{{ asset($player->image_path) }}"
                             alt="{{ $player->name }}"
                             class="rounded-circle shadow"
                             style="width:60px;height:60px;object-fit:cover;border:2px solid #10316B;"
                             onerror="this.style.display='none';">
                        <span class="text-muted small">Current photo</span>
                    </div>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="bi bi-save-fill me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.spotlight.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</section>
@endsection
