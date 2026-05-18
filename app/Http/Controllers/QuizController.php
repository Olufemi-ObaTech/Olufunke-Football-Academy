<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\QuizWeek;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /** Public quiz hub — list all quiz weeks */
    public function index()
    {
        $activeQuiz = QuizWeek::where('is_active', true)
            ->orderByDesc('week_start')
            ->first();

        $pastQuizzes = QuizWeek::where('is_active', false)
            ->orderByDesc('week_start')
            ->get();

        // Check if current user already attempted the active quiz
        $myAttempt = null;
        if ($activeQuiz && auth()->check()) {
            $myAttempt = QuizAttempt::where('quiz_week_id', $activeQuiz->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('pages.quiz.index', compact('activeQuiz', 'pastQuizzes', 'myAttempt'));
    }

    /** Show a specific quiz week's leaderboard / info */
    public function show(QuizWeek $quizWeek)
    {
        $leaderboard = QuizAttempt::where('quiz_week_id', $quizWeek->id)
            ->with('user')
            ->orderByDesc('score')
            ->orderBy('time_taken')
            ->limit(20)
            ->get();

        $myAttempt = null;
        if (auth()->check()) {
            $myAttempt = QuizAttempt::where('quiz_week_id', $quizWeek->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('pages.quiz.show', compact('quizWeek', 'leaderboard', 'myAttempt'));
    }

    /** Show the quiz taking page — 10 random questions per session */
    public function take(QuizWeek $quizWeek)
    {
        // If already attempted (logged-in user), redirect to results
        if (auth()->check()) {
            $existing = QuizAttempt::where('quiz_week_id', $quizWeek->id)
                ->where('user_id', auth()->id())
                ->first();
            if ($existing) {
                return redirect()->route('quiz.result', $existing->id)
                    ->with('info', 'You have already completed this quiz. Here are your results.');
            }
        }

        $allQuestions = $quizWeek->questions()->with('options')->get();

        if ($allQuestions->isEmpty()) {
            return redirect()->route('quiz.index')
                ->with('error', 'This quiz has no questions yet. Check back soon!');
        }

        // Pick 10 random questions (or all if fewer than 10)
        $questions = $allQuestions->shuffle()->take(10);

        // Store the selected question IDs in session so submit can score only those
        session(['quiz_question_ids_' . $quizWeek->id => $questions->pluck('id')->toArray()]);

        return view('pages.quiz.take', compact('quizWeek', 'questions'));
    }

    /** Submit quiz answers */
    public function submit(Request $request, QuizWeek $quizWeek)
    {
        $request->validate([
            'answers'    => 'required|array',
            'time_taken' => 'nullable|integer|min:0',
            'guest_name' => 'nullable|string|max:60',
        ]);

        // Use the session-stored question IDs to score only the questions shown
        $sessionKey  = 'quiz_question_ids_' . $quizWeek->id;
        $questionIds = session($sessionKey);

        if ($questionIds) {
            $questions = $quizWeek->questions()->with('options')
                ->whereIn('id', $questionIds)
                ->get();
            session()->forget($sessionKey);
        } else {
            // Fallback: score all questions
            $questions = $quizWeek->questions()->with('options')->get();
        }

        $submitted  = $request->input('answers', []);
        $score      = 0;
        $answersLog = [];

        foreach ($questions as $question) {
            $selectedOptionId = $submitted[$question->id] ?? null;
            $correctOption    = $question->options->firstWhere('is_correct', true);

            $isCorrect = $selectedOptionId && $correctOption
                && (int) $selectedOptionId === $correctOption->id;

            if ($isCorrect) $score++;

            $answersLog[$question->id] = [
                'selected'   => $selectedOptionId ? (int) $selectedOptionId : null,
                'correct'    => $correctOption?->id,
                'is_correct' => $isCorrect,
            ];
        }

        $attempt = QuizAttempt::create([
            'quiz_week_id'    => $quizWeek->id,
            'user_id'         => auth()->id(),
            'guest_name'      => auth()->check() ? null : ($request->guest_name ?: 'Anonymous'),
            'score'           => $score,
            'total_questions' => $questions->count(),
            'time_taken'      => $request->time_taken,
            'answers'         => $answersLog,
            'ip_address'      => $request->ip(),
        ]);

        return redirect()->route('quiz.result', $attempt->id);
    }

    /** Show quiz result page */
    public function result(QuizAttempt $attempt)
    {
        $quizWeek = $attempt->quizWeek;

        // Only show the questions that were part of this attempt
        $answeredIds = array_keys($attempt->answers ?? []);
        $questions   = $quizWeek->questions()->with('options')
            ->whereIn('id', $answeredIds)
            ->get()
            ->sortBy(fn($q) => array_search($q->id, $answeredIds));

        // Leaderboard position
        $rank = QuizAttempt::where('quiz_week_id', $quizWeek->id)
            ->where(function ($q) use ($attempt) {
                $q->where('score', '>', $attempt->score)
                  ->orWhere(function ($q2) use ($attempt) {
                      $q2->where('score', $attempt->score)
                         ->where('time_taken', '<', $attempt->time_taken ?? PHP_INT_MAX);
                  });
            })
            ->count() + 1;

        $totalAttempts = QuizAttempt::where('quiz_week_id', $quizWeek->id)->count();

        $leaderboard = QuizAttempt::where('quiz_week_id', $quizWeek->id)
            ->with('user')
            ->orderByDesc('score')
            ->orderBy('time_taken')
            ->limit(10)
            ->get();

        return view('pages.quiz.result', compact(
            'attempt', 'quizWeek', 'questions', 'rank', 'totalAttempts', 'leaderboard'
        ));
    }

    // ── Admin Methods ──────────────────────────────────────────────────────────

    /** Admin: list all quiz weeks */
    public function adminIndex()
    {
        $quizWeeks = QuizWeek::withCount(['questions', 'attempts'])
            ->orderByDesc('week_start')
            ->get();

        return view('dashboard.quiz.index', compact('quizWeeks'));
    }

    /** Admin: create quiz week form */
    public function adminCreate()
    {
        return view('dashboard.quiz.create');
    }

    /** Admin: store new quiz week */
    public function adminStore(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'theme'       => 'nullable|string|max:100',
            'week_start'  => 'required|date',
            'week_end'    => 'required|date|after_or_equal:week_start',
            'time_limit'  => 'required|integer|min:60|max:1800',
            'is_active'   => 'boolean',

            'questions'                       => 'required|array|min:1',
            'questions.*.question'            => 'required|string',
            'questions.*.difficulty'          => 'required|in:easy,medium,hard',
            'questions.*.category'            => 'required|string',
            'questions.*.explanation'         => 'nullable|string',
            'questions.*.options'             => 'required|array|min:2',
            'questions.*.options.*.text'      => 'required|string',
            'questions.*.options.*.is_correct'=> 'boolean',
        ]);

        // Deactivate other quizzes if this one is active
        if ($request->boolean('is_active')) {
            QuizWeek::where('is_active', true)->update(['is_active' => false]);
        }

        $quizWeek = QuizWeek::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'theme'       => $data['theme'] ?? null,
            'week_start'  => $data['week_start'],
            'week_end'    => $data['week_end'],
            'time_limit'  => $data['time_limit'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        foreach ($data['questions'] as $qIdx => $qData) {
            $question = QuizQuestion::create([
                'quiz_week_id' => $quizWeek->id,
                'order'        => $qIdx + 1,
                'question'     => $qData['question'],
                'difficulty'   => $qData['difficulty'],
                'category'     => $qData['category'],
                'explanation'  => $qData['explanation'] ?? null,
            ]);

            foreach ($qData['options'] as $oIdx => $oData) {
                QuizOption::create([
                    'quiz_question_id' => $question->id,
                    'option_text'      => $oData['text'],
                    'is_correct'       => isset($oData['is_correct']) && $oData['is_correct'],
                    'order'            => $oIdx + 1,
                ]);
            }
        }

        return redirect()->route('admin.quiz.index')
            ->with('success', "Quiz week \"{$quizWeek->title}\" created with " . count($data['questions']) . ' questions.');
    }

    /** Admin: toggle active status */
    public function adminToggle(QuizWeek $quizWeek)
    {
        if (!$quizWeek->is_active) {
            // Deactivate all others first
            QuizWeek::where('is_active', true)->update(['is_active' => false]);
        }
        $quizWeek->update(['is_active' => !$quizWeek->is_active]);

        return back()->with('success', 'Quiz status updated.');
    }

    /** Admin: delete a quiz week */
    public function adminDestroy(QuizWeek $quizWeek)
    {
        $quizWeek->delete();
        return redirect()->route('admin.quiz.index')
            ->with('success', 'Quiz week deleted.');
    }
}
