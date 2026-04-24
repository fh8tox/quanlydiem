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
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseClassController;

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
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminDashboardController::class, 'adminDashboard'])
            ->name('admin.dashboard');
    });

    Route::middleware(['role:teacher'])->group(function () {
        Route::get('/teacher', function () {
            return view('teacher.dashboard');
        })->name('teacher.dashboard');
    });

    Route::middleware(['role:student'])->group(function () {
        Route::get('/student', function () {
            return view('student.dashboard');
        })->name('student.dashboard');
    });


    // ===== 🔥 ADMIN ONLY =====
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('departments', DepartmentController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('users', UserController::class);

        // ✅ CHỈ ADMIN được quản lý sinh viên
        Route::resource('students', StudentController::class);
        Route::resource('course-classes', CourseClassController::class);
    });


    // ===== 🔥 ADMIN + TEACHER =====
    Route::middleware(['role:admin,teacher'])->group(function () {

        // ✔ Nhập điểm
        Route::resource('scores', ScoreController::class);

        // ✔ Điểm danh
        Route::prefix('attendances')->group(function () {

            Route::get('/', [AttendanceController::class, 'index'])
                ->name('attendances.index');

            Route::get('/classes/{subject}', [AttendanceController::class, 'classes'])
                ->name('attendances.classes');

            Route::get('/sessions/{courseClass}', [AttendanceController::class, 'sessions'])
                ->name('attendances.sessions');

            Route::get('/take/{session}', [AttendanceController::class, 'take'])
                ->name('attendances.take');

            Route::post('/store', [AttendanceController::class, 'store'])
                ->name('attendances.store');
        });

    });


    // ===== 🔥 STUDENT =====
    Route::prefix('student')->middleware(['role:student'])->group(function () {

        Route::get('/my-scores', [ScoreController::class, 'myScores'])
            ->name('student.scores');

    });


    // ===== PASSWORD =====
    Route::get('/change-password', [AuthController::class, 'showChangePassword']);
    Route::post('/change-password', [AuthController::class, 'updatePassword'])
        ->name('password.update');

});