<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'ma_mon',
        'ten_mon',
        'so_tin_chi',
        'so_buoi'
    ];

    public function courseClasses()
    {
        return $this->hasMany(CourseClass::class, 'subject_id');
    }
}