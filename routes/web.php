<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;

// ===== HOME =====
Route::get('/', function () {
    return redirect('/login');
});

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);


// ================== SAU LOGIN ==================
Route::middleware(['check.login'])->group(function () {

    // ===== DASHBOARD =====
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/teacher', function () {
        return view('teacher.dashboard');
    })->middleware('role:teacher')->name('teacher.dashboard');

    Route::get('/student', function () {
        return view('student.dashboard');
    })->middleware('role:student')->name('student.dashboard');


    // ===== 🔥 ADMIN ONLY =====
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminDashboardController::class, 'adminDashboard']);
        Route::resource('departments', DepartmentController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('users', UserController::class);
    });


    // ===== 🔥 ADMIN + TEACHER =====
    Route::middleware(['role:admin,teacher'])->group(function () {

        Route::resource('students', StudentController::class);
        Route::resource('scores', ScoreController::class);

    });


    // ===== 🔥 STUDENT =====
    Route::prefix('student')->middleware(['role:student'])->group(function () {

        Route::get('/my-scores', [ScoreController::class, 'myScores'])
            ->name('student.scores');
    });

});