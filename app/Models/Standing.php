<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $fillable = [
        'rank', 'club_name', 'played', 'won', 'drawn', 'lost',
        'goals_for', 'goals_against', 'points', 'is_featured_club',
    ];

    public function getGoalDifferenceAttribute(): int
    {
        return $this->goals_for - $this->goals_against;
    }
}
