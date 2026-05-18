@extends('layouts.main')
@section('title', $course->title)
@section('content')

<section class="py-4 text-white" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('football-education') }}" class="text-warning">Football Education</a></li>
                <li class="breadcrumb-item active text-white">{{ $course->title }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div>
                <span class="badge mb-2
                    @if($course->category==='technical') bg-primary
                    @elseif($course->category==='psychology') bg-warning text-dark
                    @elseif($course->category==='health') bg-danger
                    @elseif($course->category==='environment') bg-success
                    @elseif($course->category==='community') bg-info text-dark
                    @else bg-success @endif fs-6">
                    {{ ucfirst($course->category) }}
                </span>
                <h1 class="fw-bold mb-1">{{ $course->title }}</h1>
                <p class="opacity-75 mb-0">{{ $course->description }}</p>
            </div>
            @if($progress)
            <div class="ms-auto text-center">
                <div class="fw-bold fs-3">{{ $progress->progress_percent }}%</div>
                <small class="opacity-75">Complete</small>
            </div>
            @endif
        </div>
        @if($progress)
        <div class="progress mt-3" style="height:8px;">
            <div class="progress-bar bg-warning" style="width:{{ $progress->progress_percent }}%"></div>
        </div>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12">
                <h4 class="fw-bold mb-4" style="color:#10316B;">
                    <i class="bi bi-list-ul me-2"></i>Course Lessons — {{ $lessons->count() }} Modules
                </h4>
                <div class="row g-3">
                    @foreach($lessons as $i => $lesson)
                    @php $done = isset($lessonsDone[$lesson->id]); @endphp
                    <div class="col-md-6">
                        <a href="{{ route('lesson.view', $lesson) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-3 h-100 {{ $done ? 'border-success' : '' }}"
                                 style="{{ $done ? 'border-left:4px solid #4CAF50 !important;' : 'border-left:4px solid #10316B !important;' }}">
                                <div class="card-body d-flex align-items-start gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width:48px;height:48px;background:{{ $done ? '#4CAF50' : '#10316B' }};">
                                        @if($done)
                                            <i class="bi bi-check-lg text-white fs-5"></i>
                                        @else
                                            <span class="text-white fw-bold">{{ $i+1 }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="fw-bold mb-1" style="color:#10316B;">{{ $lesson->title }}</h6>
                                            @if($done)
                                                <span class="badge bg-success ms-2">Done</span>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <span class="badge bg-light text-dark border">
                                                <i class="bi bi-clock me-1"></i>{{ $lesson->duration }}
                                            </span>
                                            <span class="badge bg-light text-dark border">
                                                <i class="bi bi-bar-chart me-1"></i>{{ ucfirst($lesson->difficulty) }}
                                            </span>
                                            <span class="badge bg-light text-dark border">
                                                <i class="bi bi-person me-1"></i>
                                                {{ $lesson->target_audience === 'both' ? 'Players & Coaches' : ucfirst($lesson->target_audience) }}
                                            </span>
                                        </div>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('football-education') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to All Courses
            </a>
        </div>
    </div>
</section>
@endsection
