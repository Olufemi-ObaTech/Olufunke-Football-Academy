<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_week_id', 'user_id', 'guest_name',
        'score', 'total_questions', 'time_taken',
        'answers', 'ip_address',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function quizWeek()
    {
        return $this->belongsTo(QuizWeek::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Display name: logged-in user name or guest name */
    public function getDisplayNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->guest_name ?: 'Anonymous';
    }

    /** Percentage score */
    public function getPercentageAttribute(): int
    {
        if ($this->total_questions === 0) return 0;
        return (int) round(($this->score / $this->total_questions) * 100);
    }

    /** IQ rating label based on score */
    public function getIqRatingAttribute(): string
    {
        $pct = $this->percentage;
        if ($pct >= 90) return '🧠 Football Genius';
        if ($pct >= 75) return '⭐ Expert Analyst';
        if ($pct >= 60) return '🎯 Tactical Thinker';
        if ($pct >= 40) return '⚽ Solid Fan';
        return '📚 Keep Learning';
    }

    /** Badge color for IQ rating */
    public function getIqBadgeColorAttribute(): string
    {
        $pct = $this->percentage;
        if ($pct >= 90) return 'success';
        if ($pct >= 75) return 'primary';
        if ($pct >= 60) return 'info';
        if ($pct >= 40) return 'warning';
        return 'secondary';
    }
}
