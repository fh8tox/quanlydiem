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
}