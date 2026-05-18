<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerProgress extends Model
{
    protected $table    = 'player_progress';
    protected $fillable = ['user_id', 'course_id', 'status', 'progress_percent', 'started_at', 'completed_at'];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
