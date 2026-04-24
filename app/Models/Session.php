<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'course_class_id',
        'session_number',
        'date'
    ];

    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class, 'course_class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}