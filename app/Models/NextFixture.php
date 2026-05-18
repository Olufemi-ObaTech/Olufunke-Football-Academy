<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextFixture extends Model
{
    protected $fillable = [
        'week_label',
        'home_team',
        'away_team',
        'competition',
        'fixture_date',
        'kick_off_time',
        'venue',
        'is_active',
    ];

    protected $casts = [
        'fixture_date' => 'date',
        'is_active'    => 'boolean',
    ];
}
