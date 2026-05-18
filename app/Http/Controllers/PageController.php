<?php

namespace App\Http\Controllers;

use App\Models\BookingPackage;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\ManagementTeam;
use App\Models\PlayerProgress;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $team = ManagementTeam::orderBy('sort_order')->get();
        return view('pages.about', compact('team'));
    }

    public function store()
    {
        $products = Product::where('category', 'merchandise')->where('available', true)->get();
        $packages = BookingPackage::where('available', true)->get();
        return view('pages.store', compact('products', 'packages'));
    }

    public function program()
    {
        return view('pages.program');
    }

    public function footballEducation()
    {
        $courses = Course::with('lessons')->get();

        // Auto-record "started" progress for each course when player visits
        if (auth()->check() && auth()->user()->role === 'player') {
            foreach ($courses as $course) {
                PlayerProgress::firstOrCreate(
                    ['user_id' => auth()->id(), 'course_id' => $course->id],
                    ['status' => 'started', 'progress_percent' => 0, 'started_at' => now()]
                );
            }
        }

        $myProgress  = [];
        $lessonsDone = [];
        if (auth()->check()) {
            $myProgress  = PlayerProgress::where('user_id', auth()->id())->pluck('status', 'course_id')->toArray();
            $lessonsDone = LessonProgress::where('user_id', auth()->id())->where('completed', true)->pluck('completed', 'lesson_id')->toArray();
        }

        return view('pages.football-education', compact('courses', 'myProgress', 'lessonsDone'));
    }

    public function viewCourse(Course $course)
    {
        $lessons     = $course->lessons;
        $lessonsDone = [];
        if (auth()->check()) {
            $lessonsDone = LessonProgress::where('user_id', auth()->id())
                ->where('completed', true)
                ->pluck('completed', 'lesson_id')
                ->toArray();
        }
        $progress = PlayerProgress::where('user_id', auth()->id())->where('course_id', $course->id)->first();
        return view('pages.course-view', compact('course', 'lessons', 'lessonsDone', 'progress'));
    }

    public function viewLesson(Lesson $lesson)
    {
        $course     = $lesson->course;
        $allLessons = $course->lessons;
        $currentIdx = $allLessons->search(fn($l) => $l->id === $lesson->id);
        $prevLesson = $currentIdx > 0 ? $allLessons[$currentIdx - 1] : null;
        $nextLesson = $currentIdx < $allLessons->count() - 1 ? $allLessons[$currentIdx + 1] : null;
        $isDone     = LessonProgress::where('user_id', auth()->id())
            ->where('lesson_id', $lesson->id)
            ->where('completed', true)
            ->exists();

        // All completed lesson IDs for this course (for sidebar indicators)
        $completedLessonIds = LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->where('completed', true)
            ->pluck('completed', 'lesson_id')
            ->toArray();

        return view('pages.lesson-view', compact(
            'lesson', 'course', 'prevLesson', 'nextLesson',
            'isDone', 'allLessons', 'completedLessonIds'
        ));
    }

    public function completeLesson(Request $request, Lesson $lesson)
    {
        LessonProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'lesson_id' => $lesson->id],
            ['completed' => true, 'completed_at' => now()]
        );

        $course       = $lesson->course;
        $totalLessons = $course->lessons->count();
        $doneLessons  = LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->where('completed', true)
            ->count();

        $pct    = $totalLessons > 0 ? round(($doneLessons / $totalLessons) * 100) : 0;
        $status = $pct >= 100 ? 'completed' : ($pct > 0 ? 'in_progress' : 'started');

        PlayerProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'course_id' => $course->id],
            [
                'status'           => $status,
                'progress_percent' => $pct,
                'started_at'       => now(),
                'completed_at'     => $status === 'completed' ? now() : null,
            ]
        );

        return response()->json(['success' => true, 'percent' => $pct, 'status' => $status]);
    }

    public function updateProgress(Request $request, Course $course)
    {
        $request->validate([
            'status'           => 'required|in:started,in_progress,completed',
            'progress_percent' => 'required|integer|min:0|max:100',
        ]);

        PlayerProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'course_id' => $course->id],
            [
                'status'           => $request->status,
                'progress_percent' => $request->progress_percent,
                'started_at'       => now(),
                'completed_at'     => $request->status === 'completed' ? now() : null,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')->with('success', 'Thank you! Your message has been received. We\'ll get back to you shortly.');
    }
}
