<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClass;
use App\Models\Session;
use App\Models\Subject;
use App\Models\Student;

class CourseClassController extends Controller
{
    public function index()
    {
        $classes = CourseClass::with('subject')->get();
        return view('courseclasses.index', compact('classes'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $students = Student::all();
        return view('courseclasses.create', compact('subjects', 'students'));
    }

    public function store(Request $request)
    {
        // 1. Tạo lớp học
        $courseClass = CourseClass::create([
            'name' => $request->name,
            'subject_id' => $request->subject_id
        ]);

        // 2. Gán sinh viên
        $courseClass->students()->sync($request->students);

        // 3. 🔥 Lấy số buổi từ môn học
        $subject = Subject::findOrFail($request->subject_id);

        // 4. 🔥 Tạo sessions tự động
        for ($i = 1; $i <= $subject->so_buoi; $i++) {
            Session::create([
                'course_class_id' => $courseClass->id,
                'session_number' => $i,
                'date' => now()->addDays($i) // có thể để null nếu chưa cần
            ]);
        }

        return redirect()->route('course-classes.index')
            ->with('success', 'Tạo lớp + buổi học thành công');
    }

    public function edit($id)
    {
        $courseClass = CourseClass::findOrFail($id);
        $subjects = Subject::all();
        $students = Student::all();

        return view('courseclasses.edit', compact('courseClass','subjects','students'));
    }

    public function update(Request $request, $id)
    {
        $courseClass = CourseClass::findOrFail($id);

        $courseClass->update([
            'name' => $request->name,
            'subject_id' => $request->subject_id
        ]);

        $courseClass->students()->sync($request->students);

        return redirect()->route('course-classes.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        CourseClass::destroy($id);

        return back()->with('success', 'Đã xoá');
    }
}