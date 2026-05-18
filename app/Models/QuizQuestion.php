<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_week_id', 'order', 'question',
        'difficulty', 'category', 'explanation',
    ];

    public function quizWeek()
    {
        return $this->belongsTo(QuizWeek::class);
    }

    public function options()
    {
        return $this->hasMany(QuizOption::class, 'quiz_question_id')->orderBy('order');
    }

    public function correctOption()
    {
        return $this->hasOne(QuizOption::class, 'quiz_question_id')->where('is_correct', true);
    }
}
