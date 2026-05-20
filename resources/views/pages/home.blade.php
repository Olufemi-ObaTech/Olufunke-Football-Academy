@extends('layouts.main')

@section('title', 'Official Website')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" id="top">
        <div class="container hero-overlay">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-2 fs-6">
                        ⚽ 2026/2027 LSFA State League — Atlantic Conference
                    </span>
                    <h1 class="display-4 fw-bold mb-3">Chasing Excellence, Inspiring Futures</h1>
                    <p class="lead mb-4">
                        Welcome to <b>Olufunke Football Academy</b>, Nigeria's Next Footballing Powerhouse.
                        Committed to Nurturing Tomorrow's Talent with World-class Coaching Education, and Unwavering Values.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ url('/about-us') }}" class="btn btn-warning btn-lg shadow fw-bold">Explore Our Vision</a>
                        <a href="{{ url('/contact-us') }}" class="btn btn-outline-light btn-lg">Book a Trial</a>
                    </div>
                </div>
                <div class="col-md-4 text-center d-none d-md-block">
                     <img src="{{ asset('images/OFA New Logo.jpg') }}"
                         alt="OFA Emblem"
                         class="img-fluid shadow"
                         style="width:200px; border-radius:50%; border:4px solid #ffc107; object-fit:cover;">
                </div>
            </div>
        </div>
    </section>

    {{-- 2026/2027 Season Banner --}}
    <div style="background:linear-gradient(90deg,#10316B,#1a4a9e,#10316B); color:#fff; padding:10px 0;">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 text-center">
                <div>
                    <span class="fw-bold text-warning">🏆 2024/25 Achievement</span>
                    <span class="ms-2 small">Lagos State U17 Champions · League Finalists</span>
                </div>
                <div class="vr d-none d-md-block" style="border-color:rgba(255,255,255,.3);"></div>
                <div>
                    <span class="fw-bold text-warning">⚽ 2026/27 LSFA State League</span>
                    <span class="ms-2 small">Atlantic Conference · WK4 Complete · P3 W1 L2</span>
                </div>
                <div class="vr d-none d-md-block" style="border-color:rgba(255,255,255,.3);"></div>
                <div>
                    <span class="fw-bold text-warning">📍 Home Ground</span>
                    <span class="ms-2 small">Nathaniel Idowu Football Field, Oregie, Ajegunle</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== NEWS SECTION ===== -->
    <main class="container py-5" id="news-main-content">
        <h2 class="fw-bold text-center mb-4">Latest from OFA</h2>
        <ul class="nav nav-tabs news-tabs mb-4 justify-content-center" id="newsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest-panel" type="button" role="tab" aria-controls="latest-panel" aria-selected="true">
                    <i class="bi bi-lightning-charge-fill text-warning"></i> Latest News
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports-panel" type="button" role="tab" aria-controls="reports-panel" aria-selected="false">
                    <i class="bi bi-clipboard-data-fill text-success"></i> Match Reports
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-panel" type="button" role="tab" aria-controls="media-panel" aria-selected="false">
                    <i class="bi bi-camera-video-fill text-danger"></i> Media Highlights
                </button>
            </li>
        </ul>
 
        <div class="tab-content" id="newsTabContent">

            {{-- Latest News Tab --}}
            <div class="tab-pane fade show active" id="latest-panel" role="tabpanel" aria-labelledby="latest-tab">
                <div class="row g-4">
                    @forelse($latestNews as $news)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden news-card">
                                <img src="{{ asset($news->image_path) }}"
                                     class="card-img-top"
                                     alt="{{ $news->title }}"
                                     style="height:200px; object-fit:cover;"
                                     onerror="this.src='{{ asset('images/OFA New Logo.jpg') }}'">
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-primary mb-2 align-self-start">
                                        <i class="bi bi-newspaper"></i> News
                                    </span>
                                    <h5 class="card-title fw-bold">{{ $news->title }}</h5>
                                    <p class="card-text text-muted" style="font-size:.92rem;">
                                        {{ Str::limit($news->content, 120) }}
                                    </p>
                                    {{-- Read More Dropdown --}}
                                    <div class="mt-auto">
                                        <button class="btn btn-sm btn-outline-primary w-100"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#news-latest-{{ $news->id }}"
                                                aria-expanded="false">
                                            <i class="bi bi-chevron-down me-1"></i>Read More
                                        </button>
                                        <div class="collapse mt-2" id="news-latest-{{ $news->id }}">
                                            <div class="p-3 bg-light rounded-3 small text-muted" style="line-height:1.7;">
                                                {!! nl2br(e($news->content)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <i class="bi bi-newspaper fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">No current news posts found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Match Reports Tab --}}
            <div class="tab-pane fade" id="reports-panel" role="tabpanel" aria-labelledby="reports-tab">
                <div class="row g-4">
                    @forelse($matchReports as $report)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden news-card">
                                <img src="{{ asset($report->image_path) }}"
                                     class="card-img-top"
                                     alt="{{ $report->title }}"
                                     style="height:200px; object-fit:cover;"
                                     onerror="this.src='{{ asset('images/OFA New Logo.jpg') }}'">
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-success mb-2 align-self-start">
                                        <i class="bi bi-trophy-fill"></i> Full-Time
                                    </span>
                                    <h5 class="card-title fw-bold">{{ $report->title }}</h5>
                                    <p class="card-text text-muted" style="font-size:.92rem;">
                                        {{ Str::limit($report->content, 140) }}
                                    </p>
                                    {{-- Read More Dropdown --}}
                                    <div class="mt-auto">
                                        <button class="btn btn-sm btn-outline-success w-100"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#news-report-{{ $report->id }}"
                                                aria-expanded="false">
                                            <i class="bi bi-chevron-down me-1"></i>Read Full Report
                                        </button>
                                        <div class="collapse mt-2" id="news-report-{{ $report->id }}">
                                            <div class="p-3 bg-light rounded-3 small text-muted" style="line-height:1.7;">
                                                {!! nl2br(e($report->content)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <i class="bi bi-clipboard-x fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">No recent match reports found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Media Highlights Tab --}}
            <div class="tab-pane fade" id="media-panel" role="tabpanel" aria-labelledby="media-tab">
                <div class="row g-4">
                    @forelse($mediaHighlights as $media)
                        <div class="col-12 col-md-6">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden news-card">
                                <div class="position-relative">
                                    <img src="{{ asset($media->image_path) }}"
                                         class="card-img-top"
                                         alt="{{ $media->title }}"
                                         style="height:200px; object-fit:cover;"
                                         onerror="this.src='{{ asset('images/OFA New Logo.jpg') }}'">
                                    <span class="position-absolute top-50 start-50 translate-middle">
                                        <i class="bi bi-play-circle-fill text-white" style="font-size:3rem; opacity:.85;"></i>
                                    </span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-danger mb-2 align-self-start">
                                        <i class="bi bi-youtube"></i> Video
                                    </span>
                                    <h5 class="card-title fw-bold">{{ $media->title }}</h5>
                                    <p class="card-text text-muted" style="font-size:.92rem;">
                                        {{ Str::limit($media->content, 120) }}
                                    </p>
                                    {{-- Read More Dropdown --}}
                                    <div class="mt-auto">
                                        <button class="btn btn-sm btn-outline-danger w-100 mb-2"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#news-media-{{ $media->id }}"
                                                aria-expanded="false">
                                            <i class="bi bi-chevron-down me-1"></i>Read More
                                        </button>
                                        <div class="collapse mb-2" id="news-media-{{ $media->id }}">
                                            <div class="p-3 bg-light rounded-3 small text-muted" style="line-height:1.7;">
                                                {!! nl2br(e($media->content)) !!}
                                            </div>
                                        </div>
                                        @if($media->meta_link)
                                            <a href="{{ $media->meta_link }}" target="_blank" rel="noopener"
                                               class="btn btn-sm btn-danger w-100">
                                                <i class="bi bi-youtube me-1"></i>Watch on YouTube
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <i class="bi bi-camera-video-off fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">No highlight videos found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <!-- Game Results Scoreboard -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold"><i class="bi bi-calendar2-check text-primary"></i> 2026/27 LSFA League Results — Atlantic Conference</h3>
                <a href="#next-match" class="btn btn-outline-primary btn-sm">Next Fixture</a>
            </div>
            <div class="scoreboard-table table-responsive">
                <table class="table mb-0 align-middle text-center">
                    <thead style="background:#10316B; color:#fff;">
                        <tr>
                            <th>Week</th>
                            <th>Date</th>
                            <th>Opponent</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matchResults as $match)
                            <tr>
                                <td>
                                    @if($match->week_label)
                                        <span class="badge bg-secondary">{{ $match->week_label }}</span>
                                    @else —
                                    @endif
                                </td>
                                <td>{{ $match->match_date->format('d M Y') }}</td>
                                <td class="fw-semibold">{{ $match->opponent }}</td>
                                <td>
                                    <span class="badge bg-{{ $match->status_color }} fs-6 px-3 py-2">
                                        {{ $match->result_badge }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted py-3">No match results yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- League Standings -->
    <section class="py-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <div class="p-3 bg-white rounded-3 shadow-sm">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-bar-chart-line-fill text-primary"></i>
                            LSFA State League 2026/27 — Atlantic Conference
                        </h6>
                        @if($standings->isEmpty())
                        <p class="text-muted text-center py-3 mb-0">
                            <i class="bi bi-bar-chart-line-fill d-block fs-2 mb-2 opacity-25"></i>
                            Standings not yet available.
                        </p>
                        @else
                        <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered align-middle mb-0" style="font-size:.85rem;">
                            <thead style="background:#10316B; color:#fff;">
                                <tr>
                                    <th class="text-center" style="width:36px;">POS</th>
                                    <th>CLUB</th>
                                    <th class="text-center" style="width:36px;">PL</th>
                                    <th class="text-center d-none d-sm-table-cell" style="width:36px;">W</th>
                                    <th class="text-center d-none d-sm-table-cell" style="width:36px;">D</th>
                                    <th class="text-center d-none d-sm-table-cell" style="width:36px;">L</th>
                                    <th class="text-center d-none d-md-table-cell" style="width:36px;">GF</th>
                                    <th class="text-center d-none d-md-table-cell" style="width:36px;">GA</th>
                                    <th class="text-center d-none d-md-table-cell" style="width:40px;">GD</th>
                                    <th class="text-center" style="width:40px;">PTS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($standings as $team)
                                @php $gd = $team->goals_for - $team->goals_against; @endphp
                                <tr @if($team->is_featured_club) style="background:#e8f5e9;font-weight:600;" @endif>
                                    <td class="text-center fw-bold" style="color:#10316B;">{{ $team->rank }}</td>
                                    <td>
                                        @if($team->is_featured_club)
                                            <strong class="text-success">
                                                <i class="bi bi-shield-fill-check"></i> {{ $team->club_name }}
                                            </strong>
                                        @else
                                            {{ $team->club_name }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $team->played }}</td>
                                    <td class="text-center d-none d-sm-table-cell text-success fw-semibold">{{ $team->won }}</td>
                                    <td class="text-center d-none d-sm-table-cell">{{ $team->drawn }}</td>
                                    <td class="text-center d-none d-sm-table-cell text-danger fw-semibold">{{ $team->lost }}</td>
                                    <td class="text-center d-none d-md-table-cell">{{ $team->goals_for }}</td>
                                    <td class="text-center d-none d-md-table-cell">{{ $team->goals_against }}</td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <span class="{{ $gd > 0 ? 'text-success' : ($gd < 0 ? 'text-danger' : 'text-muted') }}">
                                            {{ $gd > 0 ? '+' : '' }}{{ $gd }}
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold" style="color:#10316B;">{{ $team->points }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <div class="small text-muted mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            @if($matchResults->isNotEmpty())
                                Updated after {{ $matchResults->first()->week_label ?? $matchResults->first()->match_date->format('d M Y') }}.
                            @else
                                Current league standings.
                            @endif
                            @if($nextFixture)
                                Next: {{ $nextFixture->week_label }} — {{ $nextFixture->fixture_date->format('d M Y') }}.
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Last Match / Next Fixture Section -->
    <section class="py-4" id="next-match">
        <div class="container">
            <div class="row g-4">

                {{-- Last Confirmed Result (dynamic) --}}
                <div class="col-md-6">
                    @if($lastResult)
                    @php
                        $isWin  = $lastResult->status_color === 'success';
                        $isLoss = $lastResult->status_color === 'danger';
                        $bgGrad = $isWin
                            ? 'linear-gradient(135deg,#1a5c2a 60%,#145222 100%)'
                            : ($isLoss ? 'linear-gradient(135deg,#c0392b 60%,#922b21 100%)' : 'linear-gradient(135deg,#374151 60%,#1f2937 100%)');
                    @endphp
                    <div class="p-4 rounded-4 shadow h-100" style="background:{{ $bgGrad }}; color:#fff;">
                        <span class="badge bg-white fw-bold mb-2 px-3 py-2"
                              style="color:{{ $isWin ? '#15803d' : ($isLoss ? '#dc2626' : '#374151') }};">
                            {{ $isWin ? '✅' : ($isLoss ? '❌' : '⏸') }}
                            Last Result{{ $lastResult->week_label ? ' — '.$lastResult->week_label : '' }}
                        </span>
                        <h4 class="fw-bold mb-2 text-uppercase">
                            <i class="bi bi-flag-fill text-warning"></i> {{ $lastResult->result_badge }}
                        </h4>
                        @if($lastResult->notes)
                        <p class="mb-1 opacity-90">
                            <i class="bi bi-info-circle"></i> {{ $lastResult->notes }}
                        </p>
                        @endif
                        <p class="mb-1 opacity-90">{{ $lastResult->competition }}</p>
                        <small class="opacity-75 d-block mt-2">
                            <i class="bi bi-calendar3"></i> {{ $lastResult->match_date->format('l, jS F Y') }}
                            @if($lastResult->kick_off_time)
                                &nbsp;|&nbsp; <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($lastResult->kick_off_time)->format('g:i A') }}
                            @endif
                            @if($lastResult->venue)
                                <br><i class="bi bi-geo-alt-fill"></i> {{ $lastResult->venue }}
                            @endif
                        </small>
                    </div>
                    @else
                    <div class="p-4 rounded-4 shadow h-100 d-flex align-items-center justify-content-center"
                         style="background:linear-gradient(135deg,#374151,#1f2937);color:#fff;min-height:180px;">
                        <div class="text-center opacity-60">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            <p class="mb-0">No match results yet.</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Next Fixture (dynamic) --}}
                <div class="col-md-6">
                    @if($nextFixture)
                    <div class="p-4 rounded-4 shadow h-100"
                         style="background:linear-gradient(135deg,#ffc107 0%,#ff9800 100%); color:#222;">
                        <span class="badge bg-dark fw-bold mb-2 px-3 py-2">
                            📅 Next Fixture — {{ $nextFixture->week_label }}
                        </span>
                        <h4 class="fw-bold mb-2 text-uppercase">
                            <i class="bi bi-calendar2-event"></i>
                            {{ $nextFixture->home_team }} vs {{ $nextFixture->away_team }}
                        </h4>
                        <p class="mb-1 fw-semibold">{{ $nextFixture->competition }}</p>
                        <small class="d-block mt-2">
                            <i class="bi bi-calendar3"></i> {{ $nextFixture->fixture_date->format('l, jS F Y') }}
                            &nbsp;|&nbsp; <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($nextFixture->kick_off_time)->format('g:i A') }}<br>
                            <i class="bi bi-geo-alt-fill"></i> {{ $nextFixture->venue }}
                        </small>
                        <a href="{{ url('/contact-us') }}" class="btn btn-dark btn-sm fw-bold mt-3">
                            <i class="bi bi-person-plus-fill me-1"></i>Book a Trial
                        </a>
                    </div>
                    @else
                    <div class="p-4 rounded-4 shadow h-100 d-flex align-items-center justify-content-center"
                         style="background:linear-gradient(135deg,#ffc107,#ff9800);color:#222;min-height:180px;">
                        <div class="text-center opacity-60">
                            <i class="bi bi-calendar-event fs-1 d-block mb-2"></i>
                            <p class="mb-0 fw-semibold">No upcoming fixture scheduled.</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Season summary bar (dynamic from match results) --}}
                @if($matchResults->count())
                <div class="col-12">
                    <div class="p-3 rounded-3 bg-white border d-flex flex-wrap align-items-center gap-2">
                        @foreach($matchResults->sortBy('match_date') as $mr)
                        @php
                            $emoji = $mr->status_color === 'success' ? '✅' : ($mr->status_color === 'danger' ? '❌' : '⏸');
                            $bg    = $mr->status_color === 'success' ? 'bg-success' : ($mr->status_color === 'danger' ? 'bg-danger' : 'bg-secondary');
                        @endphp
                        <span class="badge {{ $bg }} px-3 py-2 fw-bold">
                            {{ $emoji }}
                            @if($mr->week_label) {{ $mr->week_label }} — @endif
                            {{ $mr->result_badge }}
                        </span>
                        @endforeach
                        @if($nextFixture)
                        <span class="badge bg-warning text-dark px-3 py-2 fw-bold">
                            📅 {{ $nextFixture->week_label }} — {{ $nextFixture->fixture_date->format('d M Y') }}
                        </span>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>

    <!-- ===== PLAYER SPOTLIGHT ===== -->
    <section class="py-5" style="background: linear-gradient(180deg, #f0f4ff 0%, #fff 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color:#10316B;">
                    <i class="bi bi-person-badge-fill text-warning"></i> Player Spotlight
                </h2>
                <p class="text-muted">Meet the rising stars of Olufunke Football Academy</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                @forelse($players as $player)
                    <div class="col">
                        <div class="player-card p-4 text-center h-100 d-flex flex-column align-items-center"
                             style="border-top: 4px solid #10316B;">
                            <div class="mb-3">
                                <img src="{{ asset($player->image_path) }}"
                                     alt="{{ $player->name }}"
                                     class="shadow"
                                     style="width:110px; height:110px; border-radius:50%; object-fit:cover; border:3px solid #4CAF50; display:block;"
                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="profile-img-fallback shadow" style="display:none;">
                                    {{ strtoupper(substr($player->name, 0, 1)) }}
                                </div>
                            </div>
                            <h5 class="fw-bold mb-0" style="color:#10316B;">{{ $player->name }}</h5>
                            <span class="badge mt-1 mb-2" style="background:#4CAF50; font-size:.85rem;">
                                {{ $player->position }} &nbsp;|&nbsp; Age {{ $player->age }}
                            </span>
                            <div class="d-flex gap-3 justify-content-center mb-3">
                                <div class="text-center">
                                    <div class="fw-bold fs-5" style="color:#10316B;">{{ $player->goals }}</div>
                                    <small class="text-muted">Goals</small>
                                </div>
                                <div class="vr"></div>
                                <div class="text-center">
                                    <div class="fw-bold fs-5" style="color:#10316B;">{{ $player->assists }}</div>
                                    <small class="text-muted">Assists</small>
                                </div>
                                <div class="vr"></div>
                                <div class="text-center">
                                    <div class="fw-bold fs-5" style="color:#10316B;">{{ $player->matches }}</div>
                                    <small class="text-muted">Matches</small>
                                </div>
                            </div>
                            <blockquote class="blockquote mt-auto mb-0 fst-italic text-muted"
                                        style="font-size:.88rem; border-left:3px solid #ffc107; padding-left:10px; text-align:left;">
                                "{{ $player->quote }}"
                            </blockquote>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <i class="bi bi-people fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">No player profiles available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="my-5">
        <div class="container">
            <div class="cta-banner shadow-lg">
                <h2 class="fw-bold mb-2">Ready to Join the Olufunke FA Family?</h2>
                <p class="lead mb-4">Unlock your footballing dreams — enroll today and become part of a winning tradition. Let's shape the future, together.</p>
                <a href="{{ url('/contact-us') }}" class="btn btn-warning btn-lg px-5 fw-bold">Contact Us Now</a>
            </div>
        </div>
    </section>

    <!-- FIFA Training Centre -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold">🌍 FIFA Talent Development</h2>
            <p class="text-muted">We align with global standards through FIFA's Training Centre and international partnerships.</p>
            <a href="https://www.fifatrainingcentre.com" target="_blank" rel="noopener" class="btn btn-outline-primary px-4">
                Visit FIFA Training Centre
            </a>
        </div>
    </section>

    {{-- Weekly Football IQ Quiz CTA --}}
    <section class="py-5" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-8 text-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span style="font-size:3rem;">🧠⚽</span>
                        <div>
                            <h2 class="fw-bold mb-1">Weekly Football IQ Quiz</h2>
                            <p class="opacity-75 mb-0">Think you know football? Prove it! Open to everyone — no login required.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 flex-wrap">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                            <i class="bi bi-lightning-fill me-1"></i>New Quiz Every Week
                        </span>
                        <span class="badge bg-white text-dark fs-6 px-3 py-2">
                            <i class="bi bi-trophy-fill me-1 text-warning"></i>Live Leaderboard
                        </span>
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="bi bi-people-fill me-1"></i>Free for Everyone
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <a href="{{ route('quiz.index') }}" class="btn btn-warning btn-lg fw-bold px-5 shadow">
                        <i class="bi bi-play-fill me-2"></i>Take the Quiz
                    </a>
                </div>
            </div>
        </div>
    </section>

    <hr class="mb-0">

    <div class="py-3 text-center bg-white">
        <a href="#top" class="btn btn-outline-dark btn-sm">
            <i class="bi bi-arrow-up-circle"></i> Back to Top
        </a>
    </div>
@endsection

@push('scripts')
<script>
// Rotate chevron icon when collapse opens/closes
document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(btn) {
    var target = document.querySelector(btn.getAttribute('data-bs-target'));
    if (!target) return;
    target.addEventListener('show.bs.collapse', function() {
        var icon = btn.querySelector('.bi-chevron-down');
        if (icon) { icon.classList.replace('bi-chevron-down', 'bi-chevron-up'); }
        btn.innerHTML = btn.innerHTML.replace('Read More', 'Show Less')
                                     .replace('Read Full Report', 'Show Less');
    });
    target.addEventListener('hide.bs.collapse', function() {
        var icon = btn.querySelector('.bi-chevron-up');
        if (icon) { icon.classList.replace('bi-chevron-up', 'bi-chevron-down'); }
        btn.innerHTML = btn.innerHTML.replace('Show Less', btn.dataset.originalLabel || 'Read More');
    });
    // Store original label
    btn.dataset.originalLabel = btn.textContent.trim();
});
</script>
@endpush
