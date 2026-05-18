@extends('layouts.main')
@section('title', 'Edit Team Member — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container" style="max-width:640px;">

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
            <h2 class="fw-bold mb-1"><i class="bi bi-pencil-fill me-2"></i>Edit Team Member</h2>
            <p class="opacity-75 mb-0">Updating: <strong>{{ $member->name }}</strong></p>
        </div>
        <a href="{{ route('admin.about.index') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to About
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.about.update', $member) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-7">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $member->name) }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Role / Title <span class="text-danger">*</span></label>
                    <input type="text" name="role" class="form-control" required value="{{ old('role', $member->role) }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Email <small class="text-muted">(optional)</small></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Display Order</label>
                    <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $member->sort_order) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Photo <small class="text-muted">(leave blank to keep current)</small></label>
                    @if($member->image_path)
                    <div class="mb-2 d-flex align-items-center gap-3">
                        <img src="{{ asset($member->image_path) }}"
                             alt="{{ $member->name }}"
                             class="rounded-circle shadow"
                             style="width:56px;height:56px;object-fit:cover;border:2px solid #10316B;"
                             onerror="this.style.display='none';">
                        <span class="text-muted small">Current photo</span>
                    </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="bi bi-save-fill me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.about.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</section>
@endsection
