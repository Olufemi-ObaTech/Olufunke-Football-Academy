@extends('layouts.main')
@section('title', 'Training Schedules — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="p-4 rounded-4 text-white mb-4 shadow" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-calendar-check-fill me-2"></i>Training Schedules</h2>
            <p class="opacity-75 mb-0">Create and manage training sessions for your players</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>
</div>

{{-- Create Schedule Form --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header py-3 fw-bold" style="background:#10316B;color:#fff;">
        <i class="bi bi-plus-circle-fill me-2"></i>Schedule New Training Session
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Session Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Technical Drills — Ball Mastery" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" name="session_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Time <span class="text-danger">*</span></label>
                    <input type="time" name="session_time" class="form-control" value="08:00" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Session Type</label>
                    <select name="type" class="form-select">
                        <option value="technical">Technical</option>
                        <option value="tactical">Tactical</option>
                        <option value="fitness">Fitness</option>
                        <option value="match">Match / Scrimmage</option>
                        <option value="recovery">Recovery</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Age Group</label>
                    <select name="age_group" class="form-select">
                        <option value="All">All Players</option>
                        <option value="U13">U13</option>
                        <option value="U15">U15</option>
                        <option value="U17">U17</option>
                        <option value="U19">U19</option>
                        <option value="Senior">Senior</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" class="form-control" value="90" min="15" max="300">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Location</label>
                    <input type="text" name="location" class="form-control" value="Nathaniel Idowu Football Field, Oregie, Ajegunle">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description / Objectives</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="What will be covered in this session?"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Coach Notes (visible to players)</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Instructions, kit required, what to bring..."></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Assign Specific Players <small class="text-muted">(leave blank to assign all approved players)</small></label>
                    <div class="row g-2">
                        @foreach($players as $pl)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="player_ids[]" value="{{ $pl->id }}" id="pl_{{ $pl->id }}">
                                <label class="form-check-label small" for="pl_{{ $pl->id }}">
                                    {{ $pl->name }}
                                    @if($pl->age_group)<span class="badge bg-primary ms-1" style="font-size:.65rem;">{{ $pl->age_group }}</span>@endif
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success fw-bold px-5">
                        <i class="bi bi-calendar-plus-fill me-2"></i>Create Training Session
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Existing Schedules --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header py-3 fw-bold" style="background:#10316B;color:#fff;">
        <i class="bi bi-list-ul me-2"></i>All Training Sessions
        <span class="badge bg-warning text-dark ms-2">{{ $schedules->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($schedules->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>No training sessions scheduled yet.
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Session</th>
                        <th>Date & Time</th>
                        <th class="d-none d-md-table-cell">Type</th>
                        <th class="d-none d-md-table-cell">Group</th>
                        <th class="d-none d-lg-table-cell">Players</th>
                        <th class="d-none d-lg-table-cell">Location</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $s)
                    <tr class="{{ $s->session_date->isPast() ? 'opacity-75' : '' }}">
                        <td class="ps-3">
                            <div class="fw-semibold" style="color:#10316B;">{{ $s->title }}</div>
                            @if($s->description)<small class="text-muted">{{ Str::limit($s->description, 50) }}</small>@endif
                        </td>
                        <td>
                            <div class="fw-semibold small">{{ $s->session_date->format('D, d M Y') }}</div>
                            <div class="text-muted small">{{ \Carbon\Carbon::parse($s->session_time)->format('g:i A') }} · {{ $s->duration_minutes }} mins</div>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <span class="badge bg-{{ $s->type_color }}">{{ ucfirst($s->type) }}</span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <span class="badge bg-secondary">{{ $s->age_group }}</span>
                        </td>
                        <td class="d-none d-lg-table-cell">
                            <span class="badge bg-info text-dark">{{ $s->players->count() }} assigned</span>
                        </td>
                        <td class="d-none d-lg-table-cell small text-muted">{{ Str::limit($s->location, 35) }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.schedules.destroy', $s) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this training session?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
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
