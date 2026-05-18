<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\PlayerProgress;
use App\Models\User;

class DashboardController extends Controller
{
    /** Player dashboard */
    public function index()
    {
        $user      = auth()->user();
        $courses   = Course::withCount('lessons')->get();
        $progress  = \App\Models\PlayerProgress::where('user_id', $user->id)
            ->with('course')
            ->get()
            ->keyBy('course_id');

        // New: messages, schedules, ratings
        $messages  = \App\Models\PlayerMessage::where('to_user_id', $user->id)
            ->with('sender')
            ->latest()
            ->get();
        $unreadCount = $messages->where('is_read', false)->count();
        $schedules = $user->trainingSchedules()
            ->orderBy('session_date')
            ->where('session_date', '>=', now()->toDateString())
            ->get();

        $latestRating = $user->latestRating()->with('rater')->first();

        return view('dashboard.player', compact(
            'user', 'courses', 'progress',
            'messages', 'unreadCount', 'schedules', 'latestRating'
        ));
    }

    /** Admin dashboard */
    public function admin()
    {
        $courses = Course::withCount('lessons')->get();

        $players = User::where('role', 'player')
            ->with(['progress.course', 'latestRating', 'trainingSchedules'])
            ->latest()
            ->get();

        $messages = ContactMessage::latest()->take(20)->get();

        $counts = [
            'total'    => User::where('role', 'player')->count(),
            'approved' => User::where('role', 'player')->where('status', 'approved')->count(),
            'pending'  => User::where('role', 'player')->where('status', 'pending')->count(),
            'rejected' => User::where('role', 'player')->where('status', 'rejected')->count(),
            'messages' => ContactMessage::where('read', false)->count(),
        ];

        return view('dashboard.admin', compact('players', 'messages', 'counts', 'courses'));
    }

    /** Admin: approve a player */
    public function approvePlayer(User $user)
    {
        $user->update(['status' => 'approved']);
        return back()->with('success', $user->name . ' has been approved and can now access all member content.');
    }

    /** Admin: reject a player */
    public function rejectPlayer(User $user)
    {
        $user->update(['status' => 'rejected']);
        return back()->with('success', $user->name . ' has been rejected.');
    }
}
