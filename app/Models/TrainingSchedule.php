<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    protected $fillable = [
        'title', 'description', 'session_date', 'session_time',
        'location', 'type', 'age_group', 'duration_minutes', 'notes', 'created_by',
    ];

    protected $casts = ['session_date' => 'date'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'training_schedule_player')
            ->withPivot('attendance')
            ->withTimestamps();
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'technical'  => 'primary',
            'tactical'   => 'info',
            'fitness'    => 'success',
            'match'      => 'warning',
            'recovery'   => 'secondary',
            default      => 'dark',
        };
    }
}
