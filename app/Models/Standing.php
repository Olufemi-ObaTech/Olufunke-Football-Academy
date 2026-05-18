<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $fillable = ['rank', 'club_name', 'played', 'points', 'is_featured_club'];
}
