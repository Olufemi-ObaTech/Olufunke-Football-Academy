@extends('layouts.main')
@section('title', 'Create Weekly Quiz — Admin')

@section('content')

<section class="py-4 text-white" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-warning">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.quiz.index') }}" class="text-warning">Quizzes</a></li>
                <li class="breadcrumb-item active text-white">Create New Quiz</li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-1 fs-3"><i class="bi bi-plus-circle-fill me-2"></i>Create Weekly Football IQ Quiz</h1>
        <p class="opacity-75 mb-0">Build a new quiz with questions and answer options</p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.quiz.store') }}" method="POST" id="quiz-create-form">
            @csrf

            {{-- Quiz Details --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header py-3 fw-bold" style="background:#10316B;color:#fff;">
                    <i class="bi bi-info-circle-fill me-2"></i>Quiz Details
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Quiz Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="e.g. Week 1 — World Cup History" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Theme / Topic</label>
                            <input type="text" name="theme" class="form-control"
                                   value="{{ old('theme') }}" placeholder="e.g. Premier League">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="2"
                                      placeholder="Brief description of this week's quiz...">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Week Start <span class="text-danger">*</span></label>
                            <input type="date" name="week_start" class="form-control @error('week_start') is-invalid @enderror"
                                   value="{{ old('week_start', now()->startOfWeek()->format('Y-m-d')) }}" required>
                            @error('week_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Week End <span class="text-danger">*</span></label>
                            <input type="date" name="week_end" class="form-control @error('week_end') is-invalid @enderror"
                                   value="{{ old('week_end', now()->endOfWeek()->format('Y-m-d')) }}" required>
                            @error('week_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Time Limit (seconds) <span class="text-danger">*</span></label>
                            <select name="time_limit" class="form-select">
                                <option value="120" {{ old('time_limit') == 120 ? 'selected' : '' }}>2 minutes</option>
                                <option value="180" {{ old('time_limit') == 180 ? 'selected' : '' }}>3 minutes</option>
                                <option value="300" {{ old('time_limit', 300) == 300 ? 'selected' : '' }}>5 minutes</option>
                                <option value="600" {{ old('time_limit') == 600 ? 'selected' : '' }}>10 minutes</option>
                                <option value="900" {{ old('time_limit') == 900 ? 'selected' : '' }}>15 minutes</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Set as Active Quiz (deactivates any currently active quiz)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Questions Container --}}
            <div id="questions-container">
                {{-- Question template will be cloned here --}}
            </div>

            {{-- Add Question Button --}}
            <div class="text-center mb-4">
                <button type="button" id="add-question-btn" class="btn btn-outline-primary btn-lg px-5">
                    <i class="bi bi-plus-circle-fill me-2"></i>Add Question
                </button>
            </div>

            {{-- Submit --}}
            <div class="card border-0 shadow-sm rounded-3 p-4 d-flex flex-row gap-3 align-items-center flex-wrap">
                <button type="submit" class="btn btn-success btn-lg fw-bold px-5">
                    <i class="bi bi-save-fill me-2"></i>Save Quiz
                </button>
                <a href="{{ route('admin.quiz.index') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
                <span class="text-muted small ms-auto" id="question-count-label">0 questions added</span>
            </div>
        </form>

    </div>
</section>

{{-- Question Template (hidden) --}}
<template id="question-template">
    <div class="card border-0 shadow-sm rounded-3 mb-4 question-card" data-qidx="__IDX__">
        <div class="card-header py-3 d-flex align-items-center justify-content-between"
             style="background:#f8f9fa;">
            <span class="fw-bold" style="color:#10316B;">
                <i class="bi bi-question-circle-fill me-2 text-primary"></i>Question <span class="q-number">__NUM__</span>
            </span>
            <button type="button" class="btn btn-sm btn-outline-danger remove-question-btn">
                <i class="bi bi-trash-fill me-1"></i>Remove
            </button>
        </div>
        <div class="card-body p-4">
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Question Text <span class="text-danger">*</span></label>
                    <textarea name="questions[__IDX__][question]" class="form-control" rows="2"
                              placeholder="Enter your question here..." required></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Difficulty</label>
                    <select name="questions[__IDX__][difficulty]" class="form-select">
                        <option value="easy">Easy</option>
                        <option value="medium" selected>Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="questions[__IDX__][category]" class="form-select">
                        <option value="general">General</option>
                        <option value="history">History</option>
                        <option value="tactics">Tactics</option>
                        <option value="rules">Rules</option>
                        <option value="players">Players</option>
                        <option value="clubs">Clubs</option>
                        <option value="nigeria">Nigeria Football</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Explanation <small class="text-muted">(shown after)</small></label>
                    <input type="text" name="questions[__IDX__][explanation]" class="form-control"
                           placeholder="Brief explanation of the answer">
                </div>
            </div>

            {{-- Answer Options --}}
            <div class="mb-2">
                <label class="form-label fw-semibold">Answer Options <span class="text-danger">*</span></label>
                <small class="text-muted d-block mb-2">Add at least 2 options and mark the correct one.</small>
            </div>
            <div class="options-container row g-2">
                {{-- Options added by JS --}}
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary mt-2 add-option-btn">
                <i class="bi bi-plus me-1"></i>Add Option
            </button>
        </div>
    </div>
</template>

{{-- Option Template (hidden) --}}
<template id="option-template">
    <div class="col-md-6 option-row">
        <div class="input-group">
            <div class="input-group-text">
                <input type="radio" name="questions[__QIDX__][correct_option]"
                       class="form-check-input correct-radio" value="__OIDX__"
                       title="Mark as correct answer">
            </div>
            <input type="text" name="questions[__QIDX__][options][__OIDX__][text]"
                   class="form-control" placeholder="Option __LETTER__" required>
            <input type="hidden" name="questions[__QIDX__][options][__OIDX__][is_correct]"
                   class="is-correct-hidden" value="0">
            <button type="button" class="btn btn-outline-danger remove-option-btn" title="Remove option">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
(function() {
    let questionCount = 0;

    function updateQuestionNumbers() {
        document.querySelectorAll('.question-card').forEach(function(card, i) {
            card.querySelector('.q-number').textContent = i + 1;
        });
        document.getElementById('question-count-label').textContent =
            questionCount + ' question' + (questionCount !== 1 ? 's' : '') + ' added';
    }

    function addQuestion() {
        const idx      = questionCount;
        const template = document.getElementById('question-template');
        const clone    = template.content.cloneNode(true);
        const card     = clone.querySelector('.question-card');

        // Replace __IDX__ and __NUM__
        card.innerHTML = card.innerHTML
            .replace(/__IDX__/g, idx)
            .replace(/__NUM__/g, idx + 1);

        card.dataset.qidx = idx;

        // Remove question button
        card.querySelector('.remove-question-btn').addEventListener('click', function() {
            card.remove();
            questionCount--;
            updateQuestionNumbers();
        });

        // Add option button
        card.querySelector('.add-option-btn').addEventListener('click', function() {
            addOption(card, idx);
        });

        document.getElementById('questions-container').appendChild(card);
        questionCount++;

        // Add 4 default options
        const freshCard = document.querySelector('.question-card[data-qidx="' + idx + '"]');
        for (let i = 0; i < 4; i++) addOption(freshCard, idx);

        updateQuestionNumbers();
    }

    function addOption(card, qIdx) {
        const container = card.querySelector('.options-container');
        const optCount  = container.querySelectorAll('.option-row').length;
        const letters   = ['A','B','C','D','E','F'];
        const template  = document.getElementById('option-template');
        const clone     = template.content.cloneNode(true);
        const row       = clone.querySelector('.option-row');

        row.innerHTML = row.innerHTML
            .replace(/__QIDX__/g, qIdx)
            .replace(/__OIDX__/g, optCount)
            .replace(/__LETTER__/g, letters[optCount] || (optCount + 1));

        // Correct radio toggle
        const radio = row.querySelector('.correct-radio');
        radio.addEventListener('change', function() {
            // Reset all hidden fields in this question
            card.querySelectorAll('.is-correct-hidden').forEach(function(h) { h.value = '0'; });
            // Set this one
            row.querySelector('.is-correct-hidden').value = '1';
        });

        // Remove option
        row.querySelector('.remove-option-btn').addEventListener('click', function() {
            row.remove();
        });

        container.appendChild(row);
    }

    document.getElementById('add-question-btn').addEventListener('click', addQuestion);

    // Add first question automatically
    addQuestion();

    // Form validation
    document.getElementById('quiz-create-form').addEventListener('submit', function(e) {
        if (questionCount === 0) {
            e.preventDefault();
            alert('Please add at least one question.');
            return;
        }
        // Check each question has a correct option selected
        let valid = true;
        document.querySelectorAll('.question-card').forEach(function(card, i) {
            const hasCorrect = card.querySelector('.correct-radio:checked');
            if (!hasCorrect) {
                valid = false;
                card.style.borderColor = '#dc3545';
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        if (!valid) {
            e.preventDefault();
            alert('Please mark the correct answer for each question.');
        }
    });
})();
</script>
@endpush
