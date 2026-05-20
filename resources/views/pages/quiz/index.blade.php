@extends('layouts.main')
@section('title', 'Weekly Football IQ Quiz')

@section('content')

{{-- Hero --}}
<section class="py-5 text-white text-center" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <div class="mb-3" style="font-size:3.5rem;">🧠⚽</div>
        <h1 class="fw-bold display-5">Weekly Football IQ Quiz</h1>
        <p class="lead opacity-75 mb-3">Test your football knowledge — open to everyone, no login required!</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="bi bi-lightning-fill me-1"></i>New Quiz Every Week</span>
            <span class="badge bg-white text-dark fs-6 px-3 py-2"><i class="bi bi-trophy-fill me-1 text-warning"></i>Live Leaderboard</span>
            <span class="badge bg-success fs-6 px-3 py-2"><i class="bi bi-people-fill me-1"></i>Open to All</span>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">

        {{-- Flash messages --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Active Quiz --}}
        @if($activeQuiz)
        <div class="mb-5">
            <h2 class="fw-bold mb-4" style="color:#10316B;">
                <i class="bi bi-fire text-danger me-2"></i>This Week's Quiz
            </h2>
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-8">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="bi bi-broadcast me-1"></i>LIVE NOW
                                </span>
                                @if($activeQuiz->theme)
                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        <i class="bi bi-tag-fill me-1"></i>{{ $activeQuiz->theme }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="fw-bold mb-2" style="color:#10316B;">{{ $activeQuiz->title }}</h3>
                            @if($activeQuiz->description)
                                <p class="text-muted mb-3">{{ $activeQuiz->description }}</p>
                            @endif
                            <div class="d-flex gap-3 flex-wrap mb-4 text-muted small">
                                <span><i class="bi bi-calendar3 me-1"></i>
                                    {{ $activeQuiz->week_start->format('M d') }} – {{ $activeQuiz->week_end->format('M d, Y') }}
                                </span>
                                <span><i class="bi bi-question-circle me-1"></i>
                                    {{ $activeQuiz->questions()->count() }} questions in pool
                                </span>
                                <span><i class="bi bi-shuffle me-1"></i>
                                    10 random per session — different every time
                                </span>
                                <span><i class="bi bi-clock me-1"></i>
                                    {{ round($activeQuiz->time_limit / 60) }} min time limit
                                </span>
                                <span><i class="bi bi-people me-1"></i>
                                    {{ $activeQuiz->attempts()->count() }} attempts so far
                                </span>
                            </div>

                            @if($myBestAttempt)
                                <div class="alert alert-success d-flex align-items-center gap-3 mb-3">
                                    <i class="bi bi-check-circle-fill fs-3"></i>
                                    <div>
                                        <strong>Your best score: {{ $myBestAttempt->score }}/{{ $myBestAttempt->total_questions }}</strong>
                                        <span class="badge bg-{{ $myBestAttempt->iq_badge_color }} ms-2">{{ $myBestAttempt->iq_rating }}</span>
                                        <div class="small mt-1">
                                            <a href="{{ route('quiz.result', $myBestAttempt) }}" class="text-success fw-semibold">
                                                View your best result →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 flex-wrap">
                                    <a href="{{ route('quiz.take', $activeQuiz) }}"
                                       class="btn btn-warning btn-lg fw-bold px-5 shadow-sm">
                                        <i class="bi bi-arrow-repeat me-2"></i>Play Again
                                    </a>
                                    <a href="{{ route('quiz.show', $activeQuiz) }}"
                                       class="btn btn-outline-primary btn-lg">
                                        <i class="bi bi-bar-chart-fill me-1"></i>Leaderboard
                                    </a>
                                </div>
                            @else
                                <div class="d-flex gap-3 flex-wrap">
                                    <a href="{{ route('quiz.take', $activeQuiz) }}"
                                       class="btn btn-success btn-lg fw-bold px-5 shadow-sm">
                                        <i class="bi bi-play-fill me-2"></i>Take the Quiz Now
                                    </a>
                                    <a href="{{ route('quiz.show', $activeQuiz) }}"
                                       class="btn btn-outline-primary btn-lg">
                                        <i class="bi bi-bar-chart-fill me-1"></i>Leaderboard
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center"
                         style="background:linear-gradient(135deg,#10316B,#4CAF50);min-height:260px;">
                        <div class="text-center text-white p-4">
                            <div style="font-size:4rem;">🏆</div>
                            <h5 class="fw-bold mt-2">Prove Your Football IQ</h5>
                            <p class="opacity-75 small">Climb the leaderboard and earn your badge</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5 mb-5">
            <div style="font-size:4rem;">⏳</div>
            <h3 class="fw-bold mt-3" style="color:#10316B;">No Active Quiz Right Now</h3>
            <p class="text-muted">A new quiz drops every week. Check back soon!</p>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.quiz.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i>Create This Week's Quiz
                    </a>
                @endif
            @endauth
        </div>
        @endif

        {{-- IQ Rating Guide --}}
        <div class="mb-5">
            <h4 class="fw-bold mb-3" style="color:#10316B;"><i class="bi bi-award-fill me-2 text-warning"></i>Football IQ Ratings</h4>
            <div class="row g-3">
                @foreach([
                    ['emoji'=>'🧠','label'=>'Football Genius','range'=>'90–100%','color'=>'success'],
                    ['emoji'=>'⭐','label'=>'Expert Analyst','range'=>'75–89%','color'=>'primary'],
                    ['emoji'=>'🎯','label'=>'Tactical Thinker','range'=>'60–74%','color'=>'info'],
                    ['emoji'=>'⚽','label'=>'Solid Fan','range'=>'40–59%','color'=>'warning'],
                    ['emoji'=>'📚','label'=>'Keep Learning','range'=>'0–39%','color'=>'secondary'],
                ] as $rating)
                <div class="col-6 col-md-4 col-lg-2-4">
                    <div class="card border-0 shadow-sm text-center p-3 h-100">
                        <div style="font-size:2rem;">{{ $rating['emoji'] }}</div>
                        <span class="badge bg-{{ $rating['color'] }} mt-2 mb-1">{{ $rating['label'] }}</span>
                        <small class="text-muted">{{ $rating['range'] }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Past Quizzes --}}
        @if($pastQuizzes->isNotEmpty())
        <div>
            <h2 class="fw-bold mb-4" style="color:#10316B;">
                <i class="bi bi-clock-history me-2"></i>Past Quizzes
            </h2>
            <div class="row g-3">
                @foreach($pastQuizzes as $quiz)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-secondary">Ended</span>
                                @if($quiz->theme)
                                    <span class="badge bg-light text-dark border">{{ $quiz->theme }}</span>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-1" style="color:#10316B;">{{ $quiz->title }}</h6>
                            <div class="text-muted small mb-3">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $quiz->week_start->format('M d') }} – {{ $quiz->week_end->format('M d, Y') }}
                                &nbsp;·&nbsp;
                                <i class="bi bi-people me-1"></i>{{ $quiz->attempts()->count() }} played
                            </div>
                            <a href="{{ route('quiz.show', $quiz) }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-bar-chart-fill me-1"></i>View Leaderboard
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@endsection
