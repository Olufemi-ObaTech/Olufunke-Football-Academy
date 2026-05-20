<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ── Public Routes ──────────────────────────────────────────────────────────────
Route::get('/',          [HomeController::class, 'index'])->name('home');
Route::get('/about-us',  [PageController::class, 'about'])->name('about');
Route::get('/our-store', [PageController::class, 'store'])->name('store');
Route::get('/contact-us',[PageController::class, 'contact'])->name('contact');
Route::post('/contact-us',[PageController::class, 'contactSubmit'])->name('contact.submit');

// ── Serve uploaded files (without symlink) ──────────────────────────────────────
Route::get('/storage/{path}', function($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.file');

// ── Weekly Football IQ Quiz (Public — no login required) ───────────────────────
Route::prefix('quiz')->name('quiz.')->group(function () {
    Route::get('/',                          [QuizController::class, 'index'])->name('index');
    Route::get('/{quizWeek}',                [QuizController::class, 'show'])->name('show');
    Route::get('/{quizWeek}/take',           [QuizController::class, 'take'])->name('take');
    Route::post('/{quizWeek}/submit',        [QuizController::class, 'submit'])->name('submit');
    Route::get('/result/{attempt}',          [QuizController::class, 'result'])->name('result');
});

// ── Auth Routes ────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login',     [LoginController::class, 'showForm'])->name('login');
    Route::post('/login',    [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Protected: Registered & Approved Players + Admin ──────────────────────────
Route::middleware(['auth', 'approved.player'])->group(function () {
    Route::get('/our-program',        [PageController::class, 'program'])->name('program');
    Route::get('/football-education', [PageController::class, 'footballEducation'])->name('football-education');
    Route::post('/football-education/progress/{course}', [PageController::class, 'updateProgress'])->name('progress.update');
    Route::get('/football-education/course/{course}',    [PageController::class, 'viewCourse'])->name('course.view');
    Route::get('/football-education/lesson/{lesson}',    [PageController::class, 'viewLesson'])->name('lesson.view');
    Route::post('/football-education/lesson/{lesson}/complete', [PageController::class, 'completeLesson'])->name('lesson.complete');
});

// ── Player Dashboard — auth only (no approved.player guard — handles pending state itself) ──
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ── Player: mark message as read + reply to admin ─────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/messages/{message}/read', function(\App\Models\PlayerMessage $message) {
        if ($message->to_user_id === auth()->id()) {
            $message->markRead();
        }
        return response()->json(['ok' => true]);
    })->name('messages.read');

    Route::post('/messages/reply', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'subject' => 'nullable|string|max:150',
            'body'    => 'required|string|max:2000',
        ]);
        // Players always reply to admin
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            \App\Models\PlayerMessage::create([
                'from_user_id' => auth()->id(),
                'to_user_id'   => $admin->id,
                'subject'      => $request->subject ?? 'Reply from ' . auth()->user()->name,
                'body'         => $request->body,
            ]);
        }
        return back()->with('success', 'Your message has been sent to the coach.');
    })->name('messages.reply');
});

// ── Admin Only Routes ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                    [DashboardController::class, 'admin'])->name('dashboard');
    Route::post('/players/{user}/approve',      [DashboardController::class, 'approvePlayer'])->name('players.approve');
    Route::post('/players/{user}/reject',       [DashboardController::class, 'rejectPlayer'])->name('players.reject');
    Route::get('/players/{player}/profile',     [AdminController::class, 'playerProfile'])->name('players.profile');

    // Training schedules
    Route::get('/schedules',                    [AdminController::class, 'scheduleIndex'])->name('schedules.index');
    Route::post('/schedules',                   [AdminController::class, 'scheduleStore'])->name('schedules.store');
    Route::delete('/schedules/{schedule}',      [AdminController::class, 'scheduleDestroy'])->name('schedules.destroy');

    // Messages
    Route::post('/messages',                    [AdminController::class, 'messageStore'])->name('messages.store');
    Route::post('/messages/broadcast',          [AdminController::class, 'messageBroadcast'])->name('messages.broadcast');
    Route::get('/messages',                     [AdminController::class, 'messageIndex'])->name('messages.index');

    // Contact message mark-as-read
    Route::post('/contact-messages/{id}/read', function($id) {
        \App\Models\ContactMessage::where('id', $id)->update(['read' => true]);
        return response()->json(['ok' => true]);
    })->name('contact.messages.read');

    // Player ratings
    Route::post('/ratings',                     [AdminController::class, 'ratingStore'])->name('ratings.store');

    // Quiz management
    Route::get('/quiz',                         [QuizController::class, 'adminIndex'])->name('quiz.index');
    Route::get('/quiz/create',                  [QuizController::class, 'adminCreate'])->name('quiz.create');
    Route::post('/quiz',                        [QuizController::class, 'adminStore'])->name('quiz.store');
    Route::post('/quiz/{quizWeek}/toggle',      [QuizController::class, 'adminToggle'])->name('quiz.toggle');
    Route::delete('/quiz/{quizWeek}',           [QuizController::class, 'adminDestroy'])->name('quiz.destroy');

    // Player Spotlight management
    Route::get('/spotlight',                    [AdminController::class, 'spotlightIndex'])->name('spotlight.index');
    Route::post('/spotlight',                   [AdminController::class, 'spotlightStore'])->name('spotlight.store');
    Route::get('/spotlight/{player}/edit',      [AdminController::class, 'spotlightEdit'])->name('spotlight.edit');
    Route::put('/spotlight/{player}',           [AdminController::class, 'spotlightUpdate'])->name('spotlight.update');
    Route::delete('/spotlight/{player}',        [AdminController::class, 'spotlightDestroy'])->name('spotlight.destroy');

    // News / Posts management
    Route::get('/news',                         [AdminController::class, 'newsIndex'])->name('news.index');
    Route::post('/news',                        [AdminController::class, 'newsStore'])->name('news.store');
    Route::get('/news/{post}/edit',             [AdminController::class, 'newsEdit'])->name('news.edit');
    Route::put('/news/{post}',                  [AdminController::class, 'newsUpdate'])->name('news.update');
    Route::delete('/news/{post}',               [AdminController::class, 'newsDestroy'])->name('news.destroy');

    // About page — Management Team
    Route::get('/about',                        [AdminController::class, 'aboutIndex'])->name('about.index');
    Route::post('/about',                       [AdminController::class, 'aboutStore'])->name('about.store');
    Route::get('/about/{member}/edit',          [AdminController::class, 'aboutEdit'])->name('about.edit');
    Route::put('/about/{member}',               [AdminController::class, 'aboutUpdate'])->name('about.update');
    Route::delete('/about/{member}',            [AdminController::class, 'aboutDestroy'])->name('about.destroy');

    // League — Match Results, Standings, Next Fixtures
    Route::get('/league',                       [AdminController::class, 'matchIndex'])->name('league.index');
    Route::get('/league/results/{result}/edit',    [AdminController::class, 'resultEdit'])->name('league.results.edit');
    Route::get('/league/standings/{standing}/edit',[AdminController::class, 'standingEdit'])->name('league.standings.edit');
    Route::get('/league/fixtures/{fixture}/edit',  [AdminController::class, 'fixtureEdit'])->name('league.fixtures.edit');
    Route::post('/league/results',              [AdminController::class, 'matchStore'])->name('league.results.store');
    Route::put('/league/results/{result}',      [AdminController::class, 'matchUpdate'])->name('league.results.update');
    Route::delete('/league/results/{result}',   [AdminController::class, 'matchDestroy'])->name('league.results.destroy');
    Route::post('/league/standings',            [AdminController::class, 'standingStore'])->name('league.standings.store');
    Route::put('/league/standings/{standing}',  [AdminController::class, 'standingUpdate'])->name('league.standings.update');
    Route::delete('/league/standings/{standing}',[AdminController::class, 'standingDestroy'])->name('league.standings.destroy');
    Route::post('/league/fixtures',             [AdminController::class, 'fixtureStore'])->name('league.fixtures.store');
    Route::put('/league/fixtures/{fixture}',    [AdminController::class, 'fixtureUpdate'])->name('league.fixtures.update');
    Route::delete('/league/fixtures/{fixture}', [AdminController::class, 'fixtureDestroy'])->name('league.fixtures.destroy');
});
