<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Score;

class AdminDashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalStudents = Student::count();
        $totalUsers = User::count();

        $failedStudents = Score::where('xep_loai', 'F')
            ->orWhere('tong_ket', '<', 4)
            ->distinct('student_id')
            ->count('student_id');

        $topStudent = Student::orderByDesc('gpa')->first();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalUsers',
            'failedStudents',
            'topStudent'
        ));
    }
}