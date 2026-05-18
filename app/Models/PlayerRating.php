<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerRating extends Model
{
    protected $fillable = [
        'player_id', 'rated_by', 'technical', 'tactical',
        'physical', 'mental', 'teamwork', 'attitude', 'comments', 'rated_for_date',
    ];

    protected $casts = ['rated_for_date' => 'date'];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function rater()
    {
        return $this->belongsTo(User::class, 'rated_by');
    }

    public function getOverallAttribute(): float
    {
        return round(($this->technical + $this->tactical + $this->physical +
                      $this->mental + $this->teamwork + $this->attitude) / 6, 1);
    }
}
