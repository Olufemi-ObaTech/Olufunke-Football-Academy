@extends('layouts.main')

@section('title', 'Football Education')

@section('content')

    {{-- Hero --}}
    <section class="py-5 text-white text-center" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
        <div class="container">
            <h1 class="fw-bold display-5">🎓 OFA E-Learning Platform</h1>
            <p class="lead opacity-75 mb-3">Standard lectures for players, coaches, and administrators — develop every dimension of your game and career.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="bi bi-collection-play me-1"></i>{{ $courses->count() }} Courses</span>
                <span class="badge bg-white text-dark fs-6 px-3 py-2"><i class="bi bi-book-fill me-1 text-primary"></i>{{ $courses->sum(fn($c) => $c->lessons->count()) }} Lessons</span>
                <span class="badge bg-success fs-6 px-3 py-2"><i class="bi bi-people-fill me-1"></i>Players · Coaches · Admin</span>
            </div>
        </div>
    </section>

    {{-- On-Demand Courses --}}
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
                <div>
                    <h2 class="fw-bold mb-1" style="color:#10316B;">
                        <i class="bi bi-play-circle-fill text-primary me-2"></i>📚 On-Demand Courses
                    </h2>
                    <p class="text-muted mb-0">Standard lectures designed for players, coaches, and administrators.</p>
                </div>
                {{-- Audience filter --}}
                <div class="d-flex gap-2 flex-wrap" id="audience-filter">
                    <button class="btn btn-sm btn-primary active" data-filter="all">All</button>
                    <button class="btn btn-sm btn-outline-success" data-filter="player">⚽ Players</button>
                    <button class="btn btn-sm btn-outline-warning" data-filter="coach">🎯 Coaches</button>
                    <button class="btn btn-sm btn-outline-info" data-filter="both">👥 Both</button>
                </div>
            </div>
            <hr class="mb-4">

            <div class="row g-4" id="courses-grid">
                @foreach($courses as $course)
                @php
                    $pStatus  = $myProgress[$course->id] ?? null;
                    $badgeMap = ['started' => 'secondary', 'in_progress' => 'warning', 'completed' => 'success'];
                    $iconMap  = ['started' => 'bi-play-circle', 'in_progress' => 'bi-hourglass-split', 'completed' => 'bi-check-circle-fill'];
                    $labelMap = ['started' => 'Started', 'in_progress' => 'In Progress', 'completed' => 'Completed'];
                    // Determine primary audience from lessons
                    $audiences = $course->lessons->pluck('target_audience')->unique()->values();
                    $audienceTag = $audiences->count() > 1 ? 'both' : ($audiences->first() ?? 'both');
                @endphp
                <div class="col-md-4 course-item" data-audience="{{ $audienceTag }}">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden course-card"
                         id="course-card-{{ $course->id }}">
                        <div style="height:200px;overflow:hidden;position:relative;">
                            <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}"
                                 class="w-100 h-100" style="object-fit:cover;">
                            @if($pStatus === 'completed')
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success fs-6 shadow">
                                        <i class="bi bi-check-circle-fill me-1"></i>Completed
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge
                                    @if($course->category === 'technical') bg-primary
                                    @elseif($course->category === 'psychology') bg-warning text-dark
                                    @elseif($course->category === 'health') bg-danger
                                    @elseif($course->category === 'environment') bg-success
                                    @elseif($course->category === 'community') bg-info text-dark
                                    @elseif($course->category === 'education') bg-secondary
                                    @else bg-success @endif">
                                    {{ ucfirst($course->category) }}
                                </span>
                                <div class="d-flex gap-1 flex-wrap justify-content-end">
                                    {{-- Audience badge --}}
                                    <span class="badge bg-light text-dark border small">
                                        @if($audienceTag === 'player') ⚽ Players
                                        @elseif($audienceTag === 'coach') 🎯 Coaches
                                        @else 👥 All
                                        @endif
                                    </span>
                                    @if($pStatus)
                                        <span class="badge bg-{{ $badgeMap[$pStatus] }} {{ $pStatus === 'in_progress' ? 'text-dark' : '' }}">
                                            <i class="bi {{ $iconMap[$pStatus] }} me-1"></i>{{ $labelMap[$pStatus] }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <h5 class="fw-bold" style="color:#10316B;">{{ $course->title }}</h5>
                            <p class="text-muted small flex-grow-1">{{ $course->description }}</p>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-collection-play me-1"></i>{{ $course->lessons->count() }} lessons
                                @if(isset($lessonsDone))
                                    &nbsp;·&nbsp;
                                    <i class="bi bi-check-circle me-1 text-success"></i>
                                    {{ collect($course->lessons)->filter(fn($l) => isset($lessonsDone[$l->id]))->count() }} done
                                @endif
                            </div>

                            {{-- Progress bar --}}
                            @if($pStatus)
                                @php
                                    $totalL = $course->lessons->count();
                                    $doneL  = $totalL > 0
                                        ? collect($course->lessons)->filter(fn($l) => isset($lessonsDone[$l->id]))->count()
                                        : 0;
                                    $pct = $totalL > 0 ? round(($doneL / $totalL) * 100) : 0;
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>Progress</span>
                                        <span>{{ $pct }}%</span>
                                    </div>
                                    <div class="progress" style="height:8px;">
                                        <div class="progress-bar bg-{{ $pct >= 100 ? 'success' : ($pct > 0 ? 'warning' : 'secondary') }} progress-bar-striped"
                                             style="width:{{ $pct }}%">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Action buttons --}}
                            <div class="d-flex gap-2 mt-auto flex-wrap">
                                <a href="{{ route('course.view', $course) }}"
                                   class="btn btn-sm btn-primary flex-grow-1">
                                    <i class="bi bi-play-fill me-1"></i>
                                    @if($pStatus === 'completed') Review Course
                                    @elseif($pStatus === 'in_progress') Continue Learning
                                    @else {{ $course->cta_label }}
                                    @endif
                                </a>
                                @if(!$pStatus || $pStatus === 'started')
                                    <button class="btn btn-sm btn-outline-secondary progress-btn"
                                            data-course="{{ $course->id }}"
                                            data-status="in_progress"
                                            data-percent="10"
                                            title="Mark as started">
                                        <i class="bi bi-play-circle"></i>
                                    </button>
                                @endif
                                @if($pStatus === 'in_progress')
                                    <button class="btn btn-sm btn-outline-success progress-btn"
                                            data-course="{{ $course->id }}"
                                            data-status="completed"
                                            data-percent="100"
                                            title="Mark complete">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Skill Challenges --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3" style="color:#10316B;">🎮 ⚽ Skill Challenges &amp; Fantasy League</h2>
                    <p>At Olufunke Football Academy, Skill Challenges and Fantasy League are designed to ignite competitive spirit and sharpen football intelligence through weekly interactive tasks that test players' tactical awareness, technical execution, and strategic thinking.</p>
                    <p>Each challenge mirrors real match scenarios, encouraging participants to analyze formations, predict outcomes, and make decisions like elite football minds. Players earn <strong>digital badges</strong> for completing quizzes, mastering drills, and climbing the leaderboard.</p>
                    <p>The Fantasy League component allows users to build dream teams based on real-world performance data, rewarding those who understand player dynamics, matchups, and game flow.</p>
                    <a href="{{ route('quiz.index') }}" class="btn btn-primary fw-bold">
                        <i class="bi bi-controller me-1"></i>Join the Challenge
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fs-2 mb-2">🏅</div>
                                <h6 class="fw-bold" style="color:#10316B;">Digital Badges</h6>
                                <small class="text-muted">Earn rewards for every milestone</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fs-2 mb-2">📊</div>
                                <h6 class="fw-bold" style="color:#10316B;">Leaderboard</h6>
                                <small class="text-muted">Compete and climb the ranks</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fs-2 mb-2">⚽</div>
                                <h6 class="fw-bold" style="color:#10316B;">Fantasy League</h6>
                                <small class="text-muted">Build your dream team</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fs-2 mb-2">🧠</div>
                                <h6 class="fw-bold" style="color:#10316B;">Weekly Quizzes</h6>
                                <small class="text-muted">Test your football IQ</small>
                                <div class="mt-2">
                                    <a href="{{ route('quiz.index') }}" class="btn btn-sm btn-outline-primary">
                                        Play Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- AI Player Matching --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-5 text-center order-md-2">
                    <div class="p-5 rounded-3 shadow" style="background:linear-gradient(135deg,#10316B,#4CAF50);">
                        <div class="text-white fs-1 mb-3">🤖</div>
                        <h4 class="text-white fw-bold">AI-Powered</h4>
                        <p class="text-white opacity-75">Smart algorithms connecting players with the right opportunities</p>
                    </div>
                </div>
                <div class="col-md-7 order-md-1">
                    <h2 class="fw-bold mb-3" style="color:#10316B;">🤖 AI-Driven Player Matching</h2>
                    <p>OFA's AI-Driven Player Matching system revolutionizes talent discovery by using smart algorithms to connect players with trial opportunities, scouts, and development programs tailored to their unique skill sets.</p>
                    <p>By analyzing performance metrics such as <strong>speed, accuracy, positioning, and decision-making</strong>, the system builds a dynamic profile for each athlete.</p>
                    <a href="{{ route('contact') }}" class="btn btn-success fw-bold">
                        <i class="bi bi-robot me-1"></i>Get Matched
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Sustainability --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3" style="color:#10316B;">🌱 Sustainability &amp; CSR</h2>
                    <p>At Olufunke Football Academy, football is more than a sport — it's a platform for positive change.</p>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="bi bi-tree-fill text-success me-2"></i>Tree-planting campaigns to offset carbon footprints</li>
                        <li class="mb-2"><i class="bi bi-people-fill text-primary me-2"></i>Community outreach — free clinics &amp; mentorship</li>
                        <li class="mb-2"><i class="bi bi-mortarboard-fill text-warning me-2"></i>Scholarships for talented players from underserved backgrounds</li>
                        <li class="mb-2"><i class="bi bi-building-fill text-danger me-2"></i>Partnerships with schools, NGOs, and local leaders</li>
                        <li><i class="bi bi-globe text-info me-2"></i>Inclusive spaces where football drives education &amp; unity</li>
                    </ul>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/OFA 1.jpg') }}" alt="OFA Community"
                         class="img-fluid rounded-3 shadow" style="max-height:340px;object-fit:cover;width:100%;">
                </div>
            </div>
        </div>
    </section>

    {{-- FIFA --}}
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold">🌍 FIFA Training Centre</h2>
            <p class="text-muted">Access global football education resources and training modules inspired by FIFA standards.</p>
            <a href="https://www.fifatrainingcentre.com" target="_blank" rel="noopener" class="btn btn-outline-primary px-4">Visit FIFA Training Centre</a>
        </div>
    </section>

    <div class="py-3 text-center bg-white">
        <a href="#top" class="btn btn-outline-dark btn-sm"><i class="bi bi-arrow-up-circle"></i> Back to Top</a>
    </div>

@endsection

@push('scripts')
<script>
// ── Audience filter ────────────────────────────────────────────────────────────
document.querySelectorAll('#audience-filter button').forEach(function(btn) {
    btn.addEventListener('click', function() {
        // Update active button styles
        document.querySelectorAll('#audience-filter button').forEach(function(b) {
            b.classList.remove('btn-primary','btn-success','btn-warning','btn-info','active');
            b.classList.add('btn-outline-' + (b.dataset.filter === 'player' ? 'success' : b.dataset.filter === 'coach' ? 'warning' : b.dataset.filter === 'both' ? 'info' : 'primary'));
        });
        this.classList.remove('btn-outline-primary','btn-outline-success','btn-outline-warning','btn-outline-info');
        this.classList.add('btn-' + (this.dataset.filter === 'player' ? 'success' : this.dataset.filter === 'coach' ? 'warning' : this.dataset.filter === 'both' ? 'info' : 'primary'), 'active');

        var filter = this.dataset.filter;
        document.querySelectorAll('.course-item').forEach(function(item) {
            if (filter === 'all') {
                item.style.display = '';
            } else if (filter === 'both') {
                // Show courses that have mixed audiences
                item.style.display = (item.dataset.audience === 'both') ? '' : 'none';
            } else {
                // Show courses for this audience OR courses for 'both'
                item.style.display = (item.dataset.audience === filter || item.dataset.audience === 'both') ? '' : 'none';
            }
        });
    });
});

// ── Progress button ────────────────────────────────────────────────────────────
document.querySelectorAll('.progress-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const courseId = this.dataset.course;
        const status   = this.dataset.status;
        const percent  = this.dataset.percent;

        fetch('{{ route("progress.update", ":id") }}'.replace(':id', courseId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status, progress_percent: percent })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                setTimeout(() => location.reload(), 600);
            }
        })
        .catch(console.error);
    });
});
</script>
@endpush
