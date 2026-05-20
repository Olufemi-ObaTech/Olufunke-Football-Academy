@extends('layouts.main')
@section('title', $quizWeek->title . ' — Leaderboard')

@section('content')

{{-- Header --}}
<section class="py-4 text-white" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('quiz.index') }}" class="text-warning">Football IQ Quiz</a></li>
                <li class="breadcrumb-item active text-white">{{ $quizWeek->title }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div style="font-size:2.5rem;">🏆</div>
            <div>
                <h1 class="fw-bold mb-1 fs-3">{{ $quizWeek->title }}</h1>
                <div class="d-flex gap-2 flex-wrap">
                    @if($quizWeek->theme)
                        <span class="badge bg-warning text-dark"><i class="bi bi-tag-fill me-1"></i>{{ $quizWeek->theme }}</span>
                    @endif
                    <span class="badge bg-white text-dark">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $quizWeek->week_start->format('M d') }} – {{ $quizWeek->week_end->format('M d, Y') }}
                    </span>
                    <span class="badge {{ $quizWeek->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $quizWeek->is_active ? '🔴 Live' : 'Ended' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Leaderboard --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header py-3 fw-bold" style="background:#10316B;color:#fff;">
                        <i class="bi bi-trophy-fill me-2 text-warning"></i>Top 20 Leaderboard
                        <span class="badge bg-warning text-dark ms-2">{{ $leaderboard->count() }} entries</span>
                    </div>
                    <div class="card-body p-0">
                        @if($leaderboard->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <div style="font-size:3rem;">📋</div>
                                <p class="mt-2">No attempts yet. Be the first!</p>
                                @if($quizWeek->is_active)
                                    <a href="{{ route('quiz.take', $quizWeek) }}" class="btn btn-success">
                                        <i class="bi bi-play-fill me-1"></i>Take the Quiz
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4" style="width:60px;">Rank</th>
                                            <th>Player</th>
                                            <th class="text-center">Score</th>
                                            <th class="text-center d-none d-md-table-cell">Time</th>
                                            <th class="text-center">Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaderboard as $i => $attempt)
                                        <tr class="{{ $myBestAttempt && $myBestAttempt->id === $attempt->id ? 'table-warning' : '' }}">
                                            <td class="ps-4 fw-bold">
                                                @if($i === 0) 🥇
                                                @elseif($i === 1) 🥈
                                                @elseif($i === 2) 🥉
                                                @else <span class="text-muted">#{{ $i + 1 }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                         style="width:36px;height:36px;background:{{ $i < 3 ? '#10316B' : '#e9ecef' }};color:{{ $i < 3 ? '#fff' : '#666' }};font-weight:bold;font-size:.85rem;">
                                                        {{ strtoupper(substr($attempt->display_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $attempt->display_name }}</div>
                                                        @if($myBestAttempt && $myBestAttempt->id === $attempt->id)
                                                            <small class="text-warning fw-bold">← You</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold fs-5" style="color:#10316B;">{{ $attempt->score }}</span>
                                                <span class="text-muted small">/{{ $attempt->total_questions }}</span>
                                                <div class="small text-muted">{{ $attempt->percentage }}%</div>
                                            </td>
                                            <td class="text-center d-none d-md-table-cell text-muted small">
                                                @if($attempt->time_taken)
                                                    {{ floor($attempt->time_taken / 60) }}m {{ $attempt->time_taken % 60 }}s
                                                @else —
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $attempt->iq_badge_color }} small">
                                                    {{ $attempt->iq_rating }}
                                                </span>
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

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- My Result --}}
                @if($myBestAttempt)
                <div class="card border-0 shadow-sm rounded-3 mb-4" style="border-top:4px solid #4CAF50 !important;">
                    <div class="card-body text-center p-4">
                        <div style="font-size:2.5rem;">🎯</div>
                        <h5 class="fw-bold mt-2 mb-1" style="color:#10316B;">Your Best Score</h5>
                        <div class="display-4 fw-bold" style="color:#4CAF50;">
                            {{ $myBestAttempt->score }}<span class="fs-4 text-muted">/{{ $myBestAttempt->total_questions }}</span>
                        </div>
                        <span class="badge bg-{{ $myBestAttempt->iq_badge_color }} fs-6 px-3 py-2 mt-2">
                            {{ $myBestAttempt->iq_rating }}
                        </span>
                        <div class="mt-3 d-flex flex-column gap-2">
                            <a href="{{ route('quiz.result', $myBestAttempt) }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-eye me-1"></i>View Full Results
                            </a>
                            @if($quizWeek->is_active)
                            <a href="{{ route('quiz.take', $quizWeek) }}" class="btn btn-warning w-100 fw-bold">
                                <i class="bi bi-arrow-repeat me-1"></i>Play Again
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @elseif($quizWeek->is_active)
                <div class="card border-0 shadow-sm rounded-3 mb-4" style="border-top:4px solid #10316B !important;">
                    <div class="card-body text-center p-4">
                        <div style="font-size:2.5rem;">⚽</div>
                        <h5 class="fw-bold mt-2 mb-1" style="color:#10316B;">Ready to Play?</h5>
                        <p class="text-muted small">Take the quiz and see where you rank!</p>
                        <a href="{{ route('quiz.take', $quizWeek) }}" class="btn btn-success w-100 fw-bold">
                            <i class="bi bi-play-fill me-1"></i>Take the Quiz
                        </a>
                    </div>
                </div>
                @endif

                {{-- Stats --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header fw-bold py-3" style="background:#f8f9fa;">
                        <i class="bi bi-bar-chart-fill me-2 text-primary"></i>Quiz Stats
                    </div>
                    <div class="card-body">
                        @php
                            $totalAttempts = $leaderboard->count();
                            $avgScore = $totalAttempts > 0 ? round($leaderboard->avg('score'), 1) : 0;
                            $topScore = $totalAttempts > 0 ? $leaderboard->max('score') : 0;
                        @endphp
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Total Attempts</span>
                            <strong>{{ $totalAttempts }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Average Score</span>
                            <strong>{{ $avgScore }}/{{ $quizWeek->questions()->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Top Score</span>
                            <strong class="text-success">{{ $topScore }}/{{ $quizWeek->questions()->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Questions</span>
                            <strong>{{ $quizWeek->questions()->count() }}</strong>
                        </div>
                    </div>
                </div>

                <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-1"></i>All Quizzes
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
