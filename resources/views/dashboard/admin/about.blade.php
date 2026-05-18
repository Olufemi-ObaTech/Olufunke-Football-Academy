@extends('layouts.main')
@section('title', 'About Page — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
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
            <h2 class="fw-bold mb-1"><i class="bi bi-info-circle-fill me-2"></i>About Page — Management Team</h2>
            <p class="opacity-75 mb-0">Add, edit, or remove team members shown on the About page</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('about') }}" target="_blank" class="btn btn-warning btn-sm fw-bold" style="color:#10316B;">
                <i class="bi bi-eye-fill me-1"></i>View About Page
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
                <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
            </a>
        </div>
    </div>
</div>

{{-- Add Member Form --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header py-3 fw-bold d-flex justify-content-between align-items-center" style="background:#10316B;color:#fff;">
        <span><i class="bi bi-person-plus-fill me-2"></i>Add Team Member</span>
        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#addMemberForm" style="color:#10316B;">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div class="collapse show" id="addMemberForm">
        <div class="card-body p-4">
            <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Adeshina Akintayo Peter" required value="{{ old('name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Role / Title <span class="text-danger">*</span></label>
                        <input type="text" name="role" class="form-control" placeholder="e.g. Head Coach" required value="{{ old('role') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Display Order</label>
                        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', 0) }}" placeholder="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <small class="text-muted">(optional)</small></label>
                        <input type="email" name="email" class="form-control" placeholder="member@example.com" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Photo <small class="text-muted">(optional, max 2MB)</small></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success fw-bold px-5">
                            <i class="bi bi-person-plus-fill me-2"></i>Add Member
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Team Members List --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header py-3 fw-bold d-flex justify-content-between align-items-center" style="background:#10316B;color:#fff;">
        <span><i class="bi bi-people-fill me-2"></i>Current Management Team</span>
        <span class="badge bg-warning text-dark">{{ $team->count() }} members</span>
    </div>
    <div class="card-body p-0">
        @if($team->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-people fs-1 d-block mb-2"></i>No team members yet. Add one above.
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Photo</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th class="d-none d-md-table-cell">Email</th>
                        <th class="d-none d-md-table-cell text-center">Order</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($team as $member)
                    <tr>
                        <td class="ps-3">
                            @if($member->image_path)
                            <img src="{{ asset($member->image_path) }}"
                                 alt="{{ $member->name }}"
                                 class="rounded-circle"
                                 style="width:42px;height:42px;object-fit:cover;border:2px solid #10316B;"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            @endif
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:42px;height:42px;background:#10316B;font-size:.8rem;{{ $member->image_path ? 'display:none;' : '' }}">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                        </td>
                        <td class="fw-semibold" style="color:#10316B;">{{ $member->name }}</td>
                        <td><span class="badge bg-success">{{ $member->role }}</span></td>
                        <td class="d-none d-md-table-cell">
                            @if($member->email)
                                <a href="mailto:{{ $member->email }}" class="text-decoration-none small">{{ $member->email }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell text-center">
                            <span class="badge bg-secondary">{{ $member->sort_order }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('admin.about.edit', $member) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.about.destroy', $member) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Remove {{ addslashes($member->name) }} from the team?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

</div>
</section>
@endsection
