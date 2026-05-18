<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchResult extends Model
{
    protected $fillable = [
        'match_date', 'opponent', 'competition', 'result_badge',
        'status_color', 'week_label', 'venue', 'kick_off_time', 'notes',
    ];

    protected $casts = ['match_date' => 'date'];
}
