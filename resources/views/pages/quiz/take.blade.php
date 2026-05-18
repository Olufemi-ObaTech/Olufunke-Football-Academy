@extends('layouts.main')
@section('title', 'Take Quiz — ' . $quizWeek->title)

@section('content')

{{-- Quiz Header --}}
<section class="py-4 text-white" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="fw-bold mb-1 fs-3">🧠 {{ $quizWeek->title }}</h1>
                @if($quizWeek->theme)
                    <span class="badge bg-warning text-dark me-2">{{ $quizWeek->theme }}</span>
                @endif
                <span class="badge bg-white text-dark">{{ $questions->count() }} Questions</span>
                <span class="badge bg-success ms-1"><i class="bi bi-shuffle me-1"></i>Randomised</span>
            </div>
            {{-- Countdown Timer --}}
            <div class="text-center">
                <div class="fw-bold fs-4" id="timer-display">
                    <i class="bi bi-clock me-1"></i><span id="timer-text">{{ gmdate('i:s', $quizWeek->time_limit) }}</span>
                </div>
                <small class="opacity-75">Time Remaining</small>
            </div>
        </div>
        {{-- Progress bar --}}
        <div class="progress mt-3" style="height:6px;">
            <div class="progress-bar bg-warning" id="quiz-progress-bar" style="width:0%;transition:width .3s;"></div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Guest name prompt (if not logged in) --}}
                @guest
                <div class="card border-0 shadow-sm rounded-3 mb-4" style="border-left:4px solid #4CAF50 !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-2"><i class="bi bi-person-circle me-2 text-success"></i>Enter Your Name for the Leaderboard</h6>
                        <input type="text" id="guest-name-input" class="form-control" placeholder="Your name (optional)" maxlength="60">
                        <small class="text-muted">Leave blank to appear as "Anonymous"</small>
                    </div>
                </div>
                @endguest

                {{-- Quiz Form --}}
                <form id="quiz-form" action="{{ route('quiz.submit', $quizWeek) }}" method="POST">
                    @csrf
                    <input type="hidden" name="time_taken" id="time-taken-input" value="0">
                    @guest
                    <input type="hidden" name="guest_name" id="guest-name-hidden">
                    @endguest

                    {{-- Questions --}}
                    @foreach($questions as $qIdx => $question)
                    <div class="quiz-question-block mb-4" id="question-block-{{ $qIdx }}"
                         style="{{ $qIdx > 0 ? 'display:none;' : '' }}">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4 p-md-5">
                                {{-- Question meta --}}
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                    <span class="text-muted small fw-semibold">
                                        Question {{ $qIdx + 1 }} of {{ $questions->count() }}
                                    </span>
                                    <div class="d-flex gap-2">
                                        <span class="badge
                                            @if($question->difficulty === 'easy') bg-success
                                            @elseif($question->difficulty === 'hard') bg-danger
                                            @else bg-warning text-dark @endif">
                                            {{ ucfirst($question->difficulty) }}
                                        </span>
                                        <span class="badge bg-light text-dark border">{{ ucfirst($question->category) }}</span>
                                    </div>
                                </div>

                                {{-- Question text --}}
                                <h4 class="fw-bold mb-4" style="color:#10316B;line-height:1.5;">
                                    {{ $question->question }}
                                </h4>

                                {{-- Options --}}
                                <div class="row g-3">
                                    @foreach($question->options as $oIdx => $option)
                                    <div class="col-md-6">
                                        <label class="option-label d-block p-3 rounded-3 border cursor-pointer"
                                               style="cursor:pointer;transition:all .2s;"
                                               for="opt-{{ $question->id }}-{{ $option->id }}">
                                            <input type="radio"
                                                   class="d-none question-radio"
                                                   name="answers[{{ $question->id }}]"
                                                   id="opt-{{ $question->id }}-{{ $option->id }}"
                                                   value="{{ $option->id }}"
                                                   data-question="{{ $qIdx }}">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="option-letter rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold"
                                                     style="width:36px;height:36px;background:#e9ecef;font-size:.9rem;">
                                                    {{ chr(65 + $oIdx) }}
                                                </div>
                                                <span class="fw-semibold">{{ $option->option_text }}</span>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Navigation --}}
                        <div class="d-flex justify-content-between mt-3 gap-3">
                            @if($qIdx > 0)
                            <button type="button" class="btn btn-outline-secondary prev-btn" data-idx="{{ $qIdx }}">
                                <i class="bi bi-arrow-left me-1"></i>Previous
                            </button>
                            @else
                            <div></div>
                            @endif

                            @if($qIdx < $questions->count() - 1)
                            <button type="button" class="btn btn-primary next-btn" data-idx="{{ $qIdx }}">
                                Next<i class="bi bi-arrow-right ms-1"></i>
                            </button>
                            @else
                            <button type="button" id="submit-btn"
                                    class="btn btn-success btn-lg fw-bold px-5"
                                    data-bs-toggle="modal" data-bs-target="#confirmModal">
                                <i class="bi bi-send-fill me-2"></i>Submit Quiz
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    {{-- Question dots navigation --}}
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-4" id="question-dots">
                        @foreach($questions as $qIdx => $question)
                        <button type="button" class="dot-btn btn btn-sm btn-outline-secondary rounded-circle"
                                style="width:36px;height:36px;padding:0;"
                                data-idx="{{ $qIdx }}">
                            {{ $qIdx + 1 }}
                        </button>
                        @endforeach
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

{{-- Confirm Submit Modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background:#10316B;color:#fff;">
                <h5 class="modal-title fw-bold" id="confirmModalLabel">
                    <i class="bi bi-send-fill me-2"></i>Submit Quiz?
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="unanswered-warning" class="alert alert-warning d-none">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    You have <strong id="unanswered-count">0</strong> unanswered question(s). You can still submit.
                </div>
                <p>Are you sure you want to submit your answers? You cannot change them after submission.</p>
                <div class="d-flex justify-content-between text-muted small">
                    <span><i class="bi bi-check-circle me-1 text-success"></i>Answered: <strong id="answered-count">0</strong></span>
                    <span><i class="bi bi-dash-circle me-1 text-warning"></i>Skipped: <strong id="skipped-count">0</strong></span>
                    <span><i class="bi bi-list-ol me-1 text-primary"></i>Total: <strong>{{ $questions->count() }}</strong></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left me-1"></i>Go Back
                </button>
                <button type="button" id="confirm-submit-btn" class="btn btn-success fw-bold px-4">
                    <i class="bi bi-send-fill me-2"></i>Yes, Submit
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
    // ── Timer ──────────────────────────────────────────────────────────────────
    let timeLimit = {{ $quizWeek->time_limit }};
    let elapsed   = 0;
    let timerEl   = document.getElementById('timer-text');
    let timerDisp = document.getElementById('timer-display');

    const timerInterval = setInterval(function() {
        elapsed++;
        let remaining = timeLimit - elapsed;
        if (remaining <= 0) {
            clearInterval(timerInterval);
            document.getElementById('time-taken-input').value = timeLimit;
            submitForm();
            return;
        }
        let m = Math.floor(remaining / 60);
        let s = remaining % 60;
        timerEl.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
        if (remaining <= 60) {
            timerDisp.classList.add('text-warning');
        }
        if (remaining <= 30) {
            timerDisp.classList.remove('text-warning');
            timerDisp.classList.add('text-danger');
        }
    }, 1000);

    // ── Question navigation ────────────────────────────────────────────────────
    let currentQ = 0;
    const totalQ = {{ $questions->count() }};

    function showQuestion(idx) {
        document.querySelectorAll('.quiz-question-block').forEach(function(el, i) {
            el.style.display = i === idx ? '' : 'none';
        });
        currentQ = idx;
        updateDots();
        updateProgressBar();
    }

    function updateDots() {
        document.querySelectorAll('.dot-btn').forEach(function(btn, i) {
            btn.classList.remove('btn-primary','btn-success','btn-outline-secondary');
            const answered = document.querySelector('input[name="answers[' + getQuestionId(i) + '"]]:checked');
            if (i === currentQ) {
                btn.classList.add('btn-primary');
            } else if (answered) {
                btn.classList.add('btn-success');
            } else {
                btn.classList.add('btn-outline-secondary');
            }
        });
    }

    function getQuestionId(idx) {
        const radios = document.querySelectorAll('.quiz-question-block')[idx]
            .querySelectorAll('input[type=radio]');
        if (radios.length > 0) {
            return radios[0].name.match(/\[(\d+)\]/)[1];
        }
        return null;
    }

    function updateProgressBar() {
        const answered = document.querySelectorAll('input[type=radio]:checked').length;
        const pct = Math.round((answered / totalQ) * 100);
        document.getElementById('quiz-progress-bar').style.width = pct + '%';
    }

    // Next buttons
    document.querySelectorAll('.next-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const idx = parseInt(this.dataset.idx);
            if (idx + 1 < totalQ) showQuestion(idx + 1);
        });
    });

    // Prev buttons
    document.querySelectorAll('.prev-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const idx = parseInt(this.dataset.idx);
            if (idx - 1 >= 0) showQuestion(idx - 1);
        });
    });

    // Dot navigation
    document.querySelectorAll('.dot-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            showQuestion(parseInt(this.dataset.idx));
        });
    });

    // ── Option selection styling ───────────────────────────────────────────────
    document.querySelectorAll('.option-label').forEach(function(label) {
        label.addEventListener('click', function() {
            const radio = this.querySelector('input[type=radio]');
            const qIdx  = radio.dataset.question;
            // Reset all options in this question
            document.querySelectorAll('#question-block-' + qIdx + ' .option-label').forEach(function(l) {
                l.style.background = '';
                l.style.borderColor = '';
                l.querySelector('.option-letter').style.background = '#e9ecef';
                l.querySelector('.option-letter').style.color = '#333';
            });
            // Highlight selected
            this.style.background = '#e8f5e9';
            this.style.borderColor = '#4CAF50';
            this.querySelector('.option-letter').style.background = '#4CAF50';
            this.querySelector('.option-letter').style.color = '#fff';
            setTimeout(updateDots, 50);
            setTimeout(updateProgressBar, 50);
        });
    });

    // ── Submit modal ───────────────────────────────────────────────────────────
    document.getElementById('confirmModal').addEventListener('show.bs.modal', function() {
        const answered = document.querySelectorAll('input[type=radio]:checked').length;
        const skipped  = totalQ - answered;
        document.getElementById('answered-count').textContent = answered;
        document.getElementById('skipped-count').textContent  = skipped;
        document.getElementById('unanswered-count').textContent = skipped;
        const warn = document.getElementById('unanswered-warning');
        if (skipped > 0) { warn.classList.remove('d-none'); }
        else             { warn.classList.add('d-none'); }
    });

    document.getElementById('confirm-submit-btn').addEventListener('click', function() {
        document.getElementById('time-taken-input').value = elapsed;
        @guest
        const guestName = document.getElementById('guest-name-input').value.trim();
        document.getElementById('guest-name-hidden').value = guestName;
        @endguest
        submitForm();
    });

    function submitForm() {
        clearInterval(timerInterval);
        const btn = document.getElementById('confirm-submit-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        }
        document.getElementById('quiz-form').submit();
    }

    // Init
    updateDots();
})();
</script>
@endpush
