@extends('layouts.main')
@section('title', 'Quiz Result — ' . $quizWeek->title)

@section('content')

{{-- Result Hero --}}
<section class="py-5 text-white text-center" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <div style="font-size:4rem;" class="mb-2">
            @if($attempt->percentage >= 90) 🧠
            @elseif($attempt->percentage >= 75) ⭐
            @elseif($attempt->percentage >= 60) 🎯
            @elseif($attempt->percentage >= 40) ⚽
            @else 📚
            @endif
        </div>
        <h1 class="fw-bold display-5 mb-2">{{ $attempt->iq_rating }}</h1>
        <div class="display-3 fw-bold mb-1">
            {{ $attempt->score }}<span class="fs-3 opacity-75">/{{ $attempt->total_questions }}</span>
        </div>
        <div class="fs-4 mb-3 opacity-90">{{ $attempt->percentage }}% Correct</div>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <span class="badge bg-white text-dark fs-6 px-3 py-2">
                <i class="bi bi-trophy-fill me-1 text-warning"></i>Rank #{{ $rank }} of {{ $totalAttempts }}
            </span>
            @if($attempt->time_taken)
            <span class="badge bg-white text-dark fs-6 px-3 py-2">
                <i class="bi bi-clock me-1 text-primary"></i>
                {{ floor($attempt->time_taken / 60) }}m {{ $attempt->time_taken % 60 }}s
            </span>
            @endif
            <span class="badge bg-{{ $attempt->iq_badge_color }} fs-6 px-3 py-2">
                {{ $attempt->iq_rating }}
            </span>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Answer Review --}}
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4" style="color:#10316B;">
                    <i class="bi bi-clipboard-check me-2"></i>Answer Review
                </h4>

                @foreach($questions as $qIdx => $question)
                @php
                    $answerData    = $attempt->answers[$question->id] ?? null;
                    $selectedId    = $answerData['selected'] ?? null;
                    $correctId     = $answerData['correct'] ?? null;
                    $isCorrect     = $answerData['is_correct'] ?? false;
                @endphp
                <div class="card border-0 shadow-sm rounded-3 mb-3"
                     style="border-left:4px solid {{ $isCorrect ? '#4CAF50' : '#dc3545' }} !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                            <span class="text-muted small fw-semibold">Question {{ $qIdx + 1 }}</span>
                            <div class="d-flex gap-2">
                                @if($isCorrect)
                                    <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Correct</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Incorrect</span>
                                @endif
                                <span class="badge bg-light text-dark border">{{ ucfirst($question->difficulty) }}</span>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3" style="color:#10316B;">{{ $question->question }}</h6>

                        <div class="row g-2">
                            @foreach($question->options as $option)
                            @php
                                $isSelected = $selectedId && (int)$selectedId === $option->id;
                                $isCorrectOpt = $option->is_correct;
                            @endphp
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 border d-flex align-items-center gap-2
                                    @if($isCorrectOpt) border-success bg-success bg-opacity-10
                                    @elseif($isSelected && !$isCorrectOpt) border-danger bg-danger bg-opacity-10
                                    @endif">
                                    @if($isCorrectOpt)
                                        <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i>
                                    @elseif($isSelected && !$isCorrectOpt)
                                        <i class="bi bi-x-circle-fill text-danger flex-shrink-0"></i>
                                    @else
                                        <i class="bi bi-circle text-muted flex-shrink-0"></i>
                                    @endif
                                    <span class="{{ $isCorrectOpt ? 'fw-semibold text-success' : ($isSelected ? 'text-danger' : 'text-muted') }}">
                                        {{ $option->option_text }}
                                    </span>
                                    @if($isSelected && !$isCorrectOpt)
                                        <span class="badge bg-danger ms-auto">Your answer</span>
                                    @elseif($isCorrectOpt && $isSelected)
                                        <span class="badge bg-success ms-auto">Your answer ✓</span>
                                    @elseif($isCorrectOpt)
                                        <span class="badge bg-success ms-auto">Correct answer</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if(!$selectedId)
                            <div class="mt-2 small text-warning">
                                <i class="bi bi-dash-circle me-1"></i>You skipped this question.
                            </div>
                        @endif

                        @if($question->explanation)
                        <div class="mt-3 p-3 rounded-3 bg-light border-start border-4 border-primary">
                            <small class="fw-bold text-primary"><i class="bi bi-lightbulb-fill me-1"></i>Explanation:</small>
                            <p class="mb-0 small mt-1">{{ $question->explanation }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="mt-4 d-flex gap-3 flex-wrap">
                    <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>All Quizzes
                    </a>
                    <a href="{{ route('quiz.show', $quizWeek) }}" class="btn btn-primary">
                        <i class="bi bi-bar-chart-fill me-1"></i>Full Leaderboard
                    </a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Score Card --}}
                <div class="card border-0 shadow rounded-3 mb-4 text-center"
                     style="border-top:4px solid #4CAF50 !important;">
                    <div class="card-body p-4">
                        <div style="font-size:3rem;">
                            @if($attempt->percentage >= 90) 🧠
                            @elseif($attempt->percentage >= 75) ⭐
                            @elseif($attempt->percentage >= 60) 🎯
                            @elseif($attempt->percentage >= 40) ⚽
                            @else 📚
                            @endif
                        </div>
                        <h5 class="fw-bold mt-2" style="color:#10316B;">{{ $attempt->display_name }}</h5>
                        <div class="display-4 fw-bold" style="color:#4CAF50;">
                            {{ $attempt->score }}<span class="fs-5 text-muted">/{{ $attempt->total_questions }}</span>
                        </div>
                        <div class="progress my-3" style="height:12px;">
                            <div class="progress-bar bg-{{ $attempt->iq_badge_color }}"
                                 style="width:{{ $attempt->percentage }}%;border-radius:6px;"></div>
                        </div>
                        <span class="badge bg-{{ $attempt->iq_badge_color }} fs-6 px-3 py-2">
                            {{ $attempt->iq_rating }}
                        </span>
                        <div class="mt-3 text-muted small">
                            <div><i class="bi bi-trophy me-1 text-warning"></i>Rank <strong>#{{ $rank }}</strong> of {{ $totalAttempts }}</div>
                            @if($attempt->time_taken)
                            <div class="mt-1"><i class="bi bi-clock me-1 text-primary"></i>
                                Completed in <strong>{{ floor($attempt->time_taken / 60) }}m {{ $attempt->time_taken % 60 }}s</strong>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Mini Leaderboard --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header fw-bold py-3" style="background:#10316B;color:#fff;">
                        <i class="bi bi-trophy-fill me-2 text-warning"></i>Top 10
                    </div>
                    <div class="card-body p-0">
                        @foreach($leaderboard as $i => $lb)
                        <div class="d-flex align-items-center gap-2 px-3 py-2 border-bottom
                             {{ $lb->id === $attempt->id ? 'bg-warning bg-opacity-25' : '' }}">
                            <span class="fw-bold" style="width:28px;">
                                @if($i===0) 🥇 @elseif($i===1) 🥈 @elseif($i===2) 🥉
                                @else <span class="text-muted small">#{{ $i+1 }}</span>
                                @endif
                            </span>
                            <span class="flex-grow-1 small fw-semibold text-truncate">{{ $lb->display_name }}</span>
                            <span class="badge bg-{{ $lb->iq_badge_color }} small">
                                {{ $lb->score }}/{{ $lb->total_questions }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Share / CTA --}}
                <div class="card border-0 shadow-sm rounded-3 text-center p-4">
                    <div style="font-size:2rem;">📣</div>
                    <h6 class="fw-bold mt-2 mb-1" style="color:#10316B;">Challenge Your Friends!</h6>
                    <p class="text-muted small mb-3">Share this quiz and see who has the best football IQ.</p>
                    @if($quizWeek->is_active)
                    <a href="{{ route('quiz.take', $quizWeek) }}"
                       class="btn btn-outline-success btn-sm w-100 mb-2"
                       onclick="return confirm('You have already submitted. This will create a new attempt.')">
                        <i class="bi bi-arrow-repeat me-1"></i>Play Again
                    </a>
                    @endif
                    <a href="{{ route('quiz.index') }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-grid me-1"></i>More Quizzes
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
