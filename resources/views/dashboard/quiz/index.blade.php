@extends('layouts.main')
@section('title', 'Manage Quizzes — Admin')

@section('content')

<section class="py-4" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="text-white">
                <h1 class="fw-bold mb-1 fs-3"><i class="bi bi-brain me-2"></i>Football IQ Quiz Manager</h1>
                <p class="opacity-75 mb-0">Create and manage weekly football quizzes</p>
            </div>
            <a href="{{ route('admin.quiz.create') }}" class="btn btn-warning fw-bold px-4">
                <i class="bi bi-plus-circle-fill me-2"></i>Create New Quiz
            </a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Stats row --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center p-3">
                    <div class="fs-2 fw-bold" style="color:#10316B;">{{ $quizWeeks->count() }}</div>
                    <small class="text-muted">Total Quizzes</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center p-3">
                    <div class="fs-2 fw-bold text-success">{{ $quizWeeks->where('is_active', true)->count() }}</div>
                    <small class="text-muted">Active</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center p-3">
                    <div class="fs-2 fw-bold text-primary">{{ $quizWeeks->sum('questions_count') }}</div>
                    <small class="text-muted">Total Questions</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center p-3">
                    <div class="fs-2 fw-bold text-warning">{{ $quizWeeks->sum('attempts_count') }}</div>
                    <small class="text-muted">Total Attempts</small>
                </div>
            </div>
        </div>

        @if($quizWeeks->isEmpty())
            <div class="text-center py-5">
                <div style="font-size:4rem;">📋</div>
                <h4 class="fw-bold mt-3" style="color:#10316B;">No Quizzes Yet</h4>
                <p class="text-muted">Create your first weekly football IQ quiz!</p>
                <a href="{{ route('admin.quiz.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-1"></i>Create First Quiz
                </a>
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header py-3 fw-bold" style="background:#10316B;color:#fff;">
                    <i class="bi bi-list-ul me-2"></i>All Quiz Weeks
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Quiz Title</th>
                                <th class="text-center">Status</th>
                                <th class="text-center d-none d-md-table-cell">Questions</th>
                                <th class="text-center d-none d-md-table-cell">Attempts</th>
                                <th class="text-center d-none d-lg-table-cell">Week</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quizWeeks as $quiz)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold" style="color:#10316B;">{{ $quiz->title }}</div>
                                    @if($quiz->theme)
                                        <small class="text-muted"><i class="bi bi-tag me-1"></i>{{ $quiz->theme }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($quiz->is_active)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-broadcast me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center d-none d-md-table-cell">
                                    <span class="badge bg-primary">{{ $quiz->questions_count }}</span>
                                </td>
                                <td class="text-center d-none d-md-table-cell">
                                    <span class="badge bg-warning text-dark">{{ $quiz->attempts_count }}</span>
                                </td>
                                <td class="text-center d-none d-lg-table-cell text-muted small">
                                    {{ $quiz->week_start->format('M d') }} – {{ $quiz->week_end->format('M d, Y') }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <a href="{{ route('quiz.show', $quiz) }}"
                                           class="btn btn-sm btn-outline-primary" title="View Leaderboard">
                                            <i class="bi bi-bar-chart-fill"></i>
                                        </a>
                                        <form action="{{ route('admin.quiz.toggle', $quiz) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm {{ $quiz->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                    title="{{ $quiz->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="bi {{ $quiz->is_active ? 'bi-pause-fill' : 'bi-play-fill' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.quiz.destroy', $quiz) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this quiz and all its data? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
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
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Admin Dashboard
            </a>
        </div>

    </div>
</section>

@endsection
