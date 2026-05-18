<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'image_path', 'category', 'cta_label'];

    public function progress()
    {
        return $this->hasMany(\App\Models\PlayerProgress::class);
    }

    public function lessons()
    {
        return $this->hasMany(\App\Models\Lesson::class)->orderBy('order');
    }
}
