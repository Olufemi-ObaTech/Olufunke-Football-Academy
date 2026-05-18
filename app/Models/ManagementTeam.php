<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementTeam extends Model
{
    protected $table    = 'management_team';
    protected $fillable = ['name', 'role', 'email', 'image_path', 'sort_order'];
}
