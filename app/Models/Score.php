<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'student_id',
        'course_class_id',
        'subject_id',
        'semester',
        'chuyen_can',
        'giua_ky',
        'cuoi_ky',
        'tong_ket',
        'xep_loai'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class);
    }


}