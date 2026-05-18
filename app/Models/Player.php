<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'position',
        'age',
        'goals',
        'assists',
        'matches',
        'quote',
        'image_path',
    ];
}
