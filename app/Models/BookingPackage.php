<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPackage extends Model
{
    protected $fillable = ['name', 'description', 'price', 'duration', 'group_size', 'available'];
}
