@extends('layouts.main')
@section('title', 'Player Spotlight — Admin')
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
            <h2 class="fw-bold mb-1"><i class="bi bi-person-badge-fill me-2"></i>Player Spotlight</h2>
            <p class="opacity-75 mb-0">Manage the public-facing player profiles shown on the home page</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>
</div>

{{-- Add Player Form --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header py-3 fw-bold d-flex justify-content-between align-items-center" style="background:#10316B;color:#fff;">
        <span><i class="bi bi-plus-circle-fill me-2"></i>Add New Spotlight Player</span>
        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#addPlayerForm" style="color:#10316B;">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div class="collapse show" id="addPlayerForm">
        <div class="card-body p-4">
            <form action="{{ route('admin.spotlight.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Chukwuemeka Obi" required value="{{ old('name') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" placeholder="e.g. Striker" required value="{{ old('position') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Age <span class="text-danger">*</span></label>
                        <input type="number" name="age" class="form-control" min="5" max="50" required value="{{ old('age') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Goals <span class="text-danger">*</span></label>
                        <input type="number" name="goals" class="form-control" min="0" value="{{ old('goals', 0) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Assists <span class="text-danger">*</span></label>
                        <input type="number" name="assists" class="form-control" min="0" value="{{ old('assists', 0) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Matches <span class="text-danger">*</span></label>
                        <input type="number" name="matches" class="form-control" min="0" value="{{ old('matches', 0) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Player Quote <span class="text-danger">*</span></label>
                        <input type="text" name="quote" class="form-control" placeholder="e.g. Every match is a chance to prove myself." required value="{{ old('quote') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Player Photo <small class="text-muted">(optional, max 2MB)</small></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success fw-bold px-5">
                            <i class="bi bi-person-plus-fill me-2"></i>Add Player
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Players List --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header py-3 fw-bold d-flex justify-content-between align-items-center" style="background:#10316B;color:#fff;">
        <span><i class="bi bi-people-fill me-2"></i>Current Spotlight Players</span>
        <span class="badge bg-warning text-dark">{{ $players->count() }} players</span>
    </div>
    <div class="card-body p-0">
        @if($players->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-person-x fs-1 d-block mb-2"></i>No spotlight players yet. Add one above.
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Photo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Age</th>
                        <th class="d-none d-md-table-cell">Goals</th>
                        <th class="d-none d-md-table-cell">Assists</th>
                        <th class="d-none d-md-table-cell">Matches</th>
                        <th class="d-none d-lg-table-cell">Quote</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($players as $player)
                    <tr>
                        <td class="ps-3">
                            <img src="{{ asset($player->image_path) }}"
                                 alt="{{ $player->name }}"
                                 class="rounded-circle"
                                 style="width:42px;height:42px;object-fit:cover;border:2px solid #10316B;"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:42px;height:42px;background:#10316B;font-size:.8rem;display:none;">
                                {{ strtoupper(substr($player->name, 0, 1)) }}
                            </div>
                        </td>
                        <td class="fw-semibold" style="color:#10316B;">{{ $player->name }}</td>
                        <td><span class="badge bg-success">{{ $player->position }}</span></td>
                        <td>{{ $player->age }}</td>
                        <td class="d-none d-md-table-cell">{{ $player->goals }}</td>
                        <td class="d-none d-md-table-cell">{{ $player->assists }}</td>
                        <td class="d-none d-md-table-cell">{{ $player->matches }}</td>
                        <td class="d-none d-lg-table-cell text-muted small fst-italic" style="max-width:200px;">
                            "{{ Str::limit($player->quote, 60) }}"
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('admin.spotlight.edit', $player) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.spotlight.destroy', $player) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Remove {{ addslashes($player->name) }} from the spotlight?')">
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
