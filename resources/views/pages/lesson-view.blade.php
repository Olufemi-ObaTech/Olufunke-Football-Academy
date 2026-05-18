@extends('layouts.main')
@section('title', $lesson->title)
@section('content')

{{-- Lesson Header --}}
<section class="py-4 text-white" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('football-education') }}" class="text-warning">Football Education</a></li>
                <li class="breadcrumb-item"><a href="{{ route('course.view', $course) }}" class="text-warning">{{ $course->title }}</a></li>
                <li class="breadcrumb-item active text-white">{{ $lesson->title }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                 style="width:56px;height:56px;min-width:56px;">
                <i class="bi {{ $lesson->icon }} fs-3 text-dark"></i>
            </div>
            <div>
                <h1 class="fw-bold mb-1 fs-3">{{ $lesson->title }}</h1>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-white text-dark"><i class="bi bi-clock me-1"></i>{{ $lesson->duration }}</span>
                    <span class="badge bg-white text-dark"><i class="bi bi-bar-chart me-1"></i>{{ ucfirst($lesson->difficulty) }}</span>
                    <span class="badge bg-white text-dark">
                        <i class="bi bi-person me-1"></i>
                        {{ $lesson->target_audience === 'both' ? 'Players & Coaches' : ucfirst($lesson->target_audience) }}
                    </span>
                    @if($isDone)
                        <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Completed</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Lesson Content --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <div class="lesson-content" style="line-height:1.9; font-size:1.05rem; color:#333;">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>

                        {{-- Complete Button --}}
                        <div class="mt-5 pt-3 border-top">
                            @if(!$isDone)
                                <button id="completeBtn" class="btn btn-success btn-lg fw-bold px-5"
                                        data-lesson="{{ $lesson->id }}">
                                    <i class="bi bi-check-circle-fill me-2"></i>Mark as Complete
                                </button>
                            @else
                                <div class="alert alert-success d-flex align-items-center gap-2 mb-0">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                    <div><strong>Lesson Completed!</strong> Great work. Move on to the next lesson.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="d-flex justify-content-between mt-4 gap-3">
                    @if($prevLesson)
                        <a href="{{ route('lesson.view', $prevLesson) }}" class="btn btn-outline-secondary flex-grow-1">
                            <i class="bi bi-arrow-left me-1"></i>{{ Str::limit($prevLesson->title, 30) }}
                        </a>
                    @else
                        <div class="flex-grow-1"></div>
                    @endif
                    @if($nextLesson)
                        <a href="{{ route('lesson.view', $nextLesson) }}" class="btn btn-primary flex-grow-1 text-end" id="nextBtn">
                            {{ Str::limit($nextLesson->title, 30) }}<i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('course.view', $course) }}" class="btn btn-success flex-grow-1">
                            <i class="bi bi-trophy-fill me-1"></i>Course Complete — View Summary
                        </a>
                    @endif
                </div>
            </div>

            {{-- Sidebar: All Lessons --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top:80px;">
                    <div class="card-header fw-bold py-3" style="background:#10316B;color:#fff;">
                        <i class="bi bi-list-ul me-2"></i>{{ $course->title }}
                    </div>
                    <div class="card-body p-0">
                        @foreach($allLessons as $i => $l)
                        @php
                            $lDone = isset($completedLessonIds[$l->id]);
                        @endphp
                        <a href="{{ route('lesson.view', $l) }}"
                           class="d-flex align-items-center gap-3 p-3 text-decoration-none border-bottom
                                  {{ $l->id === $lesson->id ? 'bg-primary bg-opacity-10' : 'bg-white' }}"
                           style="transition:background .2s;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:32px;height:32px;
                                        background:{{ $l->id === $lesson->id ? '#10316B' : ($lDone ? '#4CAF50' : '#e9ecef') }};">
                                @if($l->id === $lesson->id)
                                    <i class="bi bi-play-fill text-white small"></i>
                                @elseif($lDone)
                                    <i class="bi bi-check-lg text-white small"></i>
                                @else
                                    <span class="small fw-bold text-muted">{{ $i+1 }}</span>
                                @endif
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="small fw-semibold text-truncate
                                     {{ $l->id === $lesson->id ? 'text-primary' : 'text-dark' }}">
                                    {{ $l->title }}
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $l->duration }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const btn = document.getElementById('completeBtn');
if (btn) {
    btn.addEventListener('click', function() {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        fetch('{{ route("lesson.complete", $lesson) }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({})
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.className = 'btn btn-success btn-lg fw-bold px-5';
                btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Completed! (' + data.percent + '% of course done)';
                @if($nextLesson)
                setTimeout(() => { window.location.href = '{{ route("lesson.view", $nextLesson) }}'; }, 1200);
                @endif
            }
        })
        .catch(() => { btn.disabled = false; btn.innerHTML = 'Try Again'; });
    });
}
</script>
@endpush
