<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'ma_sv',
        'name',
        'email',
        'class_id'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function courseClasses()
    {
        return $this->belongsToMany(
            CourseClass::class,
            'course_class_students'
        );
    }
}