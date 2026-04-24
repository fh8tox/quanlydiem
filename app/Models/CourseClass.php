<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    protected $fillable = [
        'name',
        'subject_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'course_class_students'
        );
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'course_class_id');
    }

    public $timestamps = false;
}