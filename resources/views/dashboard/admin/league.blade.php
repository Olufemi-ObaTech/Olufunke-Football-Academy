@extends('layouts.main')
@section('title', 'League Manager — Admin')
@section('content')
<style>
*{box-sizing:border-box;}
.dash-wrap{display:flex;min-height:calc(100vh - 72px);background:#f0f4f8;}
.lpnl{background:#fff;border-radius:16px;box-shadow:0 2px 16px rgba(0,0,0,.06);overflow:hidden;margin-bottom:24px;border:1px solid #e8edf2;}
.lpnl-h{padding:13px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #f0f4f8;}
.lpnl-h .lph{font-size:.9rem;font-weight:700;color:#0d1117;display:flex;align-items:center;gap:8px;}
.lpnl-h .lphi{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem;}
.mtbl thead th{background:#f8fafc;font-size:.7rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#64748b;border-bottom:2px solid #e5eaf0;padding:10px 14px;}
.mtbl tbody tr:hover{background:#f8fafc;}
.mtbl td{vertical-align:middle;font-size:.83rem;border-color:#f0f4f8;padding:9px 14px;}
.pl{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:700;}
.pl-g{background:#dcfce7;color:#15803d;} .pl-r{background:#fee2e2;color:#b91c1c;}
.pl-y{background:#fef9c3;color:#a16207;} .pl-b{background:#dbeafe;color:#1d4ed8;}
.abtn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;font-size:.82rem;transition:all .15s;}
.section-tabs .nav-link{font-size:.82rem;font-weight:600;color:#64748b;border-radius:10px 10px 0 0;}
.section-tabs .nav-link.active{color:#10316B;background:#fff;border-color:#e8edf2 #e8edf2 #fff;}
</style>

<div class="dash-wrap">
<div class="flex-grow-1 p-4">

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
  <div>
    <h2 class="fw-bold mb-0" style="color:#0d1117;font-size:1.3rem;">
      <i class="bi bi-trophy-fill text-warning me-2"></i>League Manager
    </h2>
    <p class="text-muted mb-0" style="font-size:.8rem;">Manage match results, standings &amp; next fixture</p>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-sm fw-bold px-4"
     style="background:#10316B;color:#fff;border-radius:10px;">
    <i class="bi bi-arrow-left me-1"></i>Dashboard
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4">
  <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4">
  <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Section Tabs --}}
<ul class="nav nav-tabs section-tabs mb-0" id="leagueTabs" role="tablist" style="border-color:#e8edf2;">
  <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-results">
    <i class="bi bi-calendar2-check me-1"></i>Match Results</button></li>
  <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-standings">
    <i class="bi bi-bar-chart-line-fill me-1"></i>Standings</button></li>
  <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-fixtures">
    <i class="bi bi-calendar-event-fill me-1"></i>Next Fixture</button></li>
</ul>

<div class="tab-content" style="background:#fff;border:1px solid #e8edf2;border-top:none;border-radius:0 0 16px 16px;padding:24px;">

{{-- ══════════════ TAB 1: MATCH RESULTS ══════════════ --}}
<div class="tab-pane fade show active" id="tab-results">

  {{-- Add Result Form --}}
  <div class="lpnl mb-4">
    <div class="lpnl-h">
      <div class="lph"><div class="lphi" style="background:#dbeafe;"><i class="bi bi-plus-circle-fill" style="color:#2563eb;"></i></div>Add Match Result</div>
      <button class="btn btn-sm" style="background:#f0f4f8;border-radius:8px;" type="button" data-bs-toggle="collapse" data-bs-target="#addResultForm">
        <i class="bi bi-chevron-down"></i>
      </button>
    </div>
    <div class="collapse show" id="addResultForm">
      <div class="p-4">
        <form action="{{ route('admin.league.results.store') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Match Date <span class="text-danger">*</span></label>
              <input type="date" name="match_date" class="form-control form-control-sm" required value="{{ old('match_date') }}">
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Week Label</label>
              <input type="text" name="week_label" class="form-control form-control-sm" placeholder="e.g. WK4" value="{{ old('week_label') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Opponent <span class="text-danger">*</span></label>
              <input type="text" name="opponent" class="form-control form-control-sm" placeholder="e.g. Team 360" required value="{{ old('opponent') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Competition <span class="text-danger">*</span></label>
              <input type="text" name="competition" class="form-control form-control-sm" value="{{ old('competition', 'LSFA State League 2026/27 — Atlantic Conference') }}" required>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Result Badge <span class="text-danger">*</span></label>
              <input type="text" name="result_badge" class="form-control form-control-sm" placeholder="e.g. OFA 2 – 4 Team 360" required value="{{ old('result_badge') }}">
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Badge Colour <span class="text-danger">*</span></label>
              <select name="status_color" class="form-select form-select-sm" required>
                <option value="success" {{ old('status_color')=='success'?'selected':'' }}>✅ Win (Green)</option>
                <option value="danger"  {{ old('status_color')=='danger'?'selected':'' }}>❌ Loss (Red)</option>
                <option value="warning" {{ old('status_color')=='warning'?'selected':'' }}>🟡 Draw (Yellow)</option>
                <option value="secondary" {{ old('status_color')=='secondary'?'selected':'' }}>⏸ Postponed (Grey)</option>
                <option value="primary" {{ old('status_color')=='primary'?'selected':'' }}>🔵 Other (Blue)</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Kick-off Time</label>
              <input type="time" name="kick_off_time" class="form-control form-control-sm" value="{{ old('kick_off_time') }}">
            </div>
            <div class="col-md-5">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Venue</label>
              <input type="text" name="venue" class="form-control form-control-sm" placeholder="e.g. Nathaniel Idowu Football Field" value="{{ old('venue') }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Notes <small class="text-muted">(shown on result card)</small></label>
              <input type="text" name="notes" class="form-control form-control-sm" placeholder="e.g. A tough home defeat — the squad will bounce back stronger" value="{{ old('notes') }}">
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-sm fw-bold px-5" style="background:linear-gradient(135deg,#10316B,#1e4db7);color:#fff;border-radius:10px;">
                <i class="bi bi-plus-circle-fill me-1"></i>Add Result
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Results Table --}}
  <div class="lpnl">
    <div class="lpnl-h">
      <div class="lph"><div class="lphi" style="background:#fef3c7;"><i class="bi bi-list-ol" style="color:#d97706;"></i></div>All Match Results</div>
      <span class="pl pl-b">{{ $results->count() }} matches</span>
    </div>
    <div class="table-responsive">
      <table class="table mtbl mb-0">
        <thead><tr>
          <th>Date</th><th>Week</th><th>Opponent</th>
          <th class="d-none d-md-table-cell">Competition</th>
          <th>Result</th>
          <th class="d-none d-lg-table-cell">Venue</th>
          <th class="text-center">Actions</th>
        </tr></thead>
        <tbody>
          @forelse($results as $r)
          <tr>
            <td>{{ $r->match_date->format('d M Y') }}</td>
            <td>@if($r->week_label)<span class="pl pl-b">{{ $r->week_label }}</span>@else<span class="text-muted">—</span>@endif</td>
            <td class="fw-semibold" style="color:#0d1117;">{{ $r->opponent }}</td>
            <td class="d-none d-md-table-cell text-muted" style="font-size:.75rem;">{{ Str::limit($r->competition,40) }}</td>
            <td><span class="badge bg-{{ $r->status_color }} px-2 py-1">{{ $r->result_badge }}</span></td>
            <td class="d-none d-lg-table-cell text-muted" style="font-size:.75rem;">{{ Str::limit($r->venue??'—',35) }}</td>
            <td class="text-center">
              <div class="d-flex gap-1 justify-content-center">
                <button class="abtn" style="background:#dbeafe;color:#1d4ed8;" title="Edit"
                        onclick="openEditResult({{ $r->id }}, {{ json_encode($r) }})">
                  <i class="bi bi-pencil-fill"></i></button>
                <form action="{{ route('admin.league.results.destroy', $r) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this result?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="abtn" style="background:#fee2e2;color:#b91c1c;" title="Delete">
                    <i class="bi bi-trash-fill"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center text-muted py-4">No match results yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>{{-- /tab-results --}}

{{-- ══════════════ TAB 2: STANDINGS ══════════════ --}}
<div class="tab-pane fade" id="tab-standings">

  {{-- Add Standing --}}
  <div class="lpnl mb-4">
    <div class="lpnl-h">
      <div class="lph"><div class="lphi" style="background:#dcfce7;"><i class="bi bi-plus-circle-fill" style="color:#16a34a;"></i></div>Add / Update Standing Entry</div>
      <button class="btn btn-sm" style="background:#f0f4f8;border-radius:8px;" type="button" data-bs-toggle="collapse" data-bs-target="#addStandingForm">
        <i class="bi bi-chevron-down"></i>
      </button>
    </div>
    <div class="collapse show" id="addStandingForm">
      <div class="p-4">
        <form action="{{ route('admin.league.standings.store') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-1">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Rank <span class="text-danger">*</span></label>
              <input type="number" name="rank" class="form-control form-control-sm" min="1" required value="{{ old('rank') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Club Name <span class="text-danger">*</span></label>
              <input type="text" name="club_name" class="form-control form-control-sm" placeholder="e.g. Olufunke FA" required value="{{ old('club_name') }}">
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Played <span class="text-danger">*</span></label>
              <input type="number" name="played" class="form-control form-control-sm" min="0" required value="{{ old('played', 0) }}">
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Points <span class="text-danger">*</span></label>
              <input type="number" name="points" class="form-control form-control-sm" min="0" required value="{{ old('points', 0) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="is_featured_club" value="1" id="isFeatured" {{ old('is_featured_club') ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="isFeatured" style="font-size:.78rem;">
                  Highlight as OFA (featured club)
                </label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-sm fw-bold px-5" style="background:linear-gradient(135deg,#059669,#10b981);color:#fff;border-radius:10px;">
                <i class="bi bi-plus-circle-fill me-1"></i>Add Entry
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Standings Table --}}
  <div class="lpnl">
    <div class="lpnl-h">
      <div class="lph"><div class="lphi" style="background:#ccfbf1;"><i class="bi bi-bar-chart-line-fill" style="color:#0d9488;"></i></div>Current Standings</div>
      <span class="pl" style="background:#f0f4f8;color:#64748b;">{{ $standings->count() }} clubs</span>
    </div>
    <div class="table-responsive">
      <table class="table mtbl mb-0">
        <thead><tr>
          <th style="width:60px;">#</th><th>Club</th>
          <th class="text-center">Played</th><th class="text-center">Points</th>
          <th class="text-center">Featured</th><th class="text-center">Actions</th>
        </tr></thead>
        <tbody>
          @forelse($standings as $s)
          <tr @if($s->is_featured_club) style="background:#f0fdf4;" @endif>
            <td class="fw-bold" style="color:#10316B;">{{ $s->rank }}</td>
            <td class="fw-semibold" style="color:#0d1117;">
              @if($s->is_featured_club)<i class="bi bi-shield-fill-check text-success me-1"></i>@endif
              {{ $s->club_name }}
            </td>
            <td class="text-center">{{ $s->played }}</td>
            <td class="text-center fw-bold">{{ $s->points }}</td>
            <td class="text-center">
              @if($s->is_featured_club)<span class="pl pl-g">OFA</span>@else<span class="text-muted">—</span>@endif
            </td>
            <td class="text-center">
              <div class="d-flex gap-1 justify-content-center">
                <button class="abtn" style="background:#dbeafe;color:#1d4ed8;" title="Edit"
                        onclick="openEditStanding({{ $s->id }}, {{ json_encode($s) }})">
                  <i class="bi bi-pencil-fill"></i></button>
                <form action="{{ route('admin.league.standings.destroy', $s) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete {{ addslashes($s->club_name) }}?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="abtn" style="background:#fee2e2;color:#b91c1c;" title="Delete">
                    <i class="bi bi-trash-fill"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-4">No standings yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>{{-- /tab-standings --}}

{{-- ══════════════ TAB 3: NEXT FIXTURE ══════════════ --}}
<div class="tab-pane fade" id="tab-fixtures">

  {{-- Add Fixture --}}
  <div class="lpnl mb-4">
    <div class="lpnl-h">
      <div class="lph"><div class="lphi" style="background:#fef3c7;"><i class="bi bi-calendar-plus-fill" style="color:#d97706;"></i></div>Add Next Fixture</div>
      <button class="btn btn-sm" style="background:#f0f4f8;border-radius:8px;" type="button" data-bs-toggle="collapse" data-bs-target="#addFixtureForm">
        <i class="bi bi-chevron-down"></i>
      </button>
    </div>
    <div class="collapse show" id="addFixtureForm">
      <div class="p-4">
        <form action="{{ route('admin.league.fixtures.store') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-2">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Week Label <span class="text-danger">*</span></label>
              <input type="text" name="week_label" class="form-control form-control-sm" placeholder="e.g. WK5" required value="{{ old('week_label') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Home Team <span class="text-danger">*</span></label>
              <input type="text" name="home_team" class="form-control form-control-sm" placeholder="e.g. Young Strikers FC" required value="{{ old('home_team') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Away Team <span class="text-danger">*</span></label>
              <input type="text" name="away_team" class="form-control form-control-sm" placeholder="e.g. OFA" required value="{{ old('away_team') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Competition <span class="text-danger">*</span></label>
              <input type="text" name="competition" class="form-control form-control-sm" value="{{ old('competition', 'LSFA State League 2026/27 — Atlantic Conference') }}" required>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Fixture Date <span class="text-danger">*</span></label>
              <input type="date" name="fixture_date" class="form-control form-control-sm" required value="{{ old('fixture_date') }}">
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Kick-off Time <span class="text-danger">*</span></label>
              <input type="time" name="kick_off_time" class="form-control form-control-sm" required value="{{ old('kick_off_time', '08:00') }}">
            </div>
            <div class="col-md-5">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Venue <span class="text-danger">*</span></label>
              <input type="text" name="venue" class="form-control form-control-sm" placeholder="e.g. Maracana Football Pitch, Ajegunle, Lagos" required value="{{ old('venue') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                <label class="form-check-label fw-semibold" for="isActive" style="font-size:.78rem;">Set as Active</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-sm fw-bold px-5" style="background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;border-radius:10px;">
                <i class="bi bi-calendar-plus-fill me-1"></i>Add Fixture
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Fixtures List --}}
  <div class="lpnl">
    <div class="lpnl-h">
      <div class="lph"><div class="lphi" style="background:#ffedd5;"><i class="bi bi-calendar-event-fill" style="color:#ea580c;"></i></div>All Fixtures</div>
      <span class="pl" style="background:#f0f4f8;color:#64748b;">{{ $fixtures->count() }} fixtures</span>
    </div>
    <div class="table-responsive">
      <table class="table mtbl mb-0">
        <thead><tr>
          <th>Week</th><th>Match</th>
          <th class="d-none d-md-table-cell">Date &amp; Time</th>
          <th class="d-none d-lg-table-cell">Venue</th>
          <th class="text-center">Active</th>
          <th class="text-center">Actions</th>
        </tr></thead>
        <tbody>
          @forelse($fixtures as $f)
          <tr @if($f->is_active) style="background:#fffbeb;" @endif>
            <td><span class="pl pl-y">{{ $f->week_label }}</span></td>
            <td class="fw-semibold" style="color:#0d1117;">{{ $f->home_team }} vs {{ $f->away_team }}</td>
            <td class="d-none d-md-table-cell text-muted" style="font-size:.78rem;">
              {{ $f->fixture_date->format('D, d M Y') }} · {{ \Carbon\Carbon::parse($f->kick_off_time)->format('g:i A') }}
            </td>
            <td class="d-none d-lg-table-cell text-muted" style="font-size:.75rem;">{{ Str::limit($f->venue,40) }}</td>
            <td class="text-center">
              @if($f->is_active)<span class="pl pl-g"><i class="bi bi-broadcast"></i> Live</span>
              @else<span class="pl" style="background:#f1f5f9;color:#64748b;">Off</span>@endif
            </td>
            <td class="text-center">
              <div class="d-flex gap-1 justify-content-center">
                <button class="abtn" style="background:#dbeafe;color:#1d4ed8;" title="Edit"
                        onclick="openEditFixture({{ $f->id }}, {{ json_encode($f) }})">
                  <i class="bi bi-pencil-fill"></i></button>
                <form action="{{ route('admin.league.fixtures.destroy', $f) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this fixture?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="abtn" style="background:#fee2e2;color:#b91c1c;" title="Delete">
                    <i class="bi bi-trash-fill"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-4">No fixtures yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>{{-- /tab-fixtures --}}

</div>{{-- /tab-content --}}
</div>{{-- /flex-grow-1 --}}
</div>{{-- /dash-wrap --}}

{{-- ══════════════ EDIT MODALS ══════════════ --}}

{{-- Edit Result Modal --}}
<div class="modal fade" id="editResultModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
      <div class="modal-header border-0 text-white" style="background:linear-gradient(135deg,#10316B,#1e4db7);">
        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-fill me-2"></i>Edit Match Result</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editResultForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-3"><label class="form-label fw-semibold" style="font-size:.78rem;">Match Date</label>
              <input type="date" name="match_date" id="er_date" class="form-control form-control-sm" required></div>
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Week Label</label>
              <input type="text" name="week_label" id="er_week" class="form-control form-control-sm" placeholder="WK4"></div>
            <div class="col-md-3"><label class="form-label fw-semibold" style="font-size:.78rem;">Opponent</label>
              <input type="text" name="opponent" id="er_opp" class="form-control form-control-sm" required></div>
            <div class="col-md-4"><label class="form-label fw-semibold" style="font-size:.78rem;">Competition</label>
              <input type="text" name="competition" id="er_comp" class="form-control form-control-sm" required></div>
            <div class="col-md-4"><label class="form-label fw-semibold" style="font-size:.78rem;">Result Badge</label>
              <input type="text" name="result_badge" id="er_badge" class="form-control form-control-sm" required></div>
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Badge Colour</label>
              <select name="status_color" id="er_color" class="form-select form-select-sm" required>
                <option value="success">✅ Win</option><option value="danger">❌ Loss</option>
                <option value="warning">🟡 Draw</option><option value="secondary">⏸ Postponed</option>
                <option value="primary">🔵 Other</option>
              </select></div>
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Kick-off</label>
              <input type="time" name="kick_off_time" id="er_time" class="form-control form-control-sm"></div>
            <div class="col-md-4"><label class="form-label fw-semibold" style="font-size:.78rem;">Venue</label>
              <input type="text" name="venue" id="er_venue" class="form-control form-control-sm"></div>
            <div class="col-12"><label class="form-label fw-semibold" style="font-size:.78rem;">Notes</label>
              <input type="text" name="notes" id="er_notes" class="form-control form-control-sm"></div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn fw-bold px-4" style="background:linear-gradient(135deg,#10316B,#1e4db7);color:#fff;border-radius:10px;">
            <i class="bi bi-save-fill me-1"></i>Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Edit Standing Modal --}}
<div class="modal fade" id="editStandingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
      <div class="modal-header border-0 text-white" style="background:linear-gradient(135deg,#059669,#10b981);">
        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-fill me-2"></i>Edit Standing</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editStandingForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Rank</label>
              <input type="number" name="rank" id="es_rank" class="form-control form-control-sm" min="1" required></div>
            <div class="col-md-6"><label class="form-label fw-semibold" style="font-size:.78rem;">Club Name</label>
              <input type="text" name="club_name" id="es_club" class="form-control form-control-sm" required></div>
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Played</label>
              <input type="number" name="played" id="es_played" class="form-control form-control-sm" min="0" required></div>
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Points</label>
              <input type="number" name="points" id="es_points" class="form-control form-control-sm" min="0" required></div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_featured_club" value="1" id="es_featured">
                <label class="form-check-label fw-semibold" for="es_featured" style="font-size:.82rem;">Highlight as OFA (featured club)</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn fw-bold px-4" style="background:linear-gradient(135deg,#059669,#10b981);color:#fff;border-radius:10px;">
            <i class="bi bi-save-fill me-1"></i>Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Edit Fixture Modal --}}
<div class="modal fade" id="editFixtureModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
      <div class="modal-header border-0 text-white" style="background:linear-gradient(135deg,#d97706,#f59e0b);">
        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-fill me-2"></i>Edit Fixture</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editFixtureForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Week Label</label>
              <input type="text" name="week_label" id="ef_week" class="form-control form-control-sm" required></div>
            <div class="col-md-4"><label class="form-label fw-semibold" style="font-size:.78rem;">Home Team</label>
              <input type="text" name="home_team" id="ef_home" class="form-control form-control-sm" required></div>
            <div class="col-md-4"><label class="form-label fw-semibold" style="font-size:.78rem;">Away Team</label>
              <input type="text" name="away_team" id="ef_away" class="form-control form-control-sm" required></div>
            <div class="col-md-2"></div>
            <div class="col-12"><label class="form-label fw-semibold" style="font-size:.78rem;">Competition</label>
              <input type="text" name="competition" id="ef_comp" class="form-control form-control-sm" required></div>
            <div class="col-md-4"><label class="form-label fw-semibold" style="font-size:.78rem;">Fixture Date</label>
              <input type="date" name="fixture_date" id="ef_date" class="form-control form-control-sm" required></div>
            <div class="col-md-2"><label class="form-label fw-semibold" style="font-size:.78rem;">Kick-off</label>
              <input type="time" name="kick_off_time" id="ef_time" class="form-control form-control-sm" required></div>
            <div class="col-md-6"><label class="form-label fw-semibold" style="font-size:.78rem;">Venue</label>
              <input type="text" name="venue" id="ef_venue" class="form-control form-control-sm" required></div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="ef_active">
                <label class="form-check-label fw-semibold" for="ef_active" style="font-size:.82rem;">Set as Active (shown on home page)</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn fw-bold px-4" style="background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;border-radius:10px;">
            <i class="bi bi-save-fill me-1"></i>Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script>
function openEditResult(id, r) {
  document.getElementById('editResultForm').action = '/admin/league/results/' + id;
  document.getElementById('er_date').value  = r.match_date ? r.match_date.substring(0,10) : '';
  document.getElementById('er_week').value  = r.week_label  || '';
  document.getElementById('er_opp').value   = r.opponent    || '';
  document.getElementById('er_comp').value  = r.competition || '';
  document.getElementById('er_badge').value = r.result_badge|| '';
  document.getElementById('er_color').value = r.status_color|| 'success';
  document.getElementById('er_time').value  = r.kick_off_time ? r.kick_off_time.substring(0,5) : '';
  document.getElementById('er_venue').value = r.venue || '';
  document.getElementById('er_notes').value = r.notes || '';
  new bootstrap.Modal(document.getElementById('editResultModal')).show();
}

function openEditStanding(id, s) {
  document.getElementById('editStandingForm').action = '/admin/league/standings/' + id;
  document.getElementById('es_rank').value   = s.rank;
  document.getElementById('es_club').value   = s.club_name;
  document.getElementById('es_played').value = s.played;
  document.getElementById('es_points').value = s.points;
  document.getElementById('es_featured').checked = !!s.is_featured_club;
  new bootstrap.Modal(document.getElementById('editStandingModal')).show();
}

function openEditFixture(id, f) {
  document.getElementById('editFixtureForm').action = '/admin/league/fixtures/' + id;
  document.getElementById('ef_week').value  = f.week_label  || '';
  document.getElementById('ef_home').value  = f.home_team   || '';
  document.getElementById('ef_away').value  = f.away_team   || '';
  document.getElementById('ef_comp').value  = f.competition || '';
  document.getElementById('ef_date').value  = f.fixture_date ? f.fixture_date.substring(0,10) : '';
  document.getElementById('ef_time').value  = f.kick_off_time ? f.kick_off_time.substring(0,5) : '';
  document.getElementById('ef_venue').value = f.venue || '';
  document.getElementById('ef_active').checked = !!f.is_active;
  new bootstrap.Modal(document.getElementById('editFixtureModal')).show();
}
</script>
@endpush
