<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizWeek extends Model
{
    protected $fillable = [
        'title', 'description', 'theme',
        'week_start', 'week_end', 'is_active', 'time_limit',
    ];

    protected $casts = [
        'week_start' => 'date',
        'week_end'   => 'date',
        'is_active'  => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /** Leaderboard: top 10 scores for this week */
    public function leaderboard()
    {
        return $this->hasMany(QuizAttempt::class)
            ->orderByDesc('score')
            ->orderBy('time_taken')
            ->limit(10);
    }

    /** Check if the current user (or guest) has already attempted this quiz */
    public function userAttempt()
    {
        if (auth()->check()) {
            return $this->attempts()->where('user_id', auth()->id())->first();
        }
        return null;
    }
}
