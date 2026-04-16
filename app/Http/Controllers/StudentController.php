<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('class')->latest()->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes = Classes::all();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_sv' => 'required|unique:students|max:20',
            'name' => 'required|max:100',
            'email' => 'required|email|unique:students,email',
            'class_id' => 'nullable|exists:classes,id'
        ]);

        try {
            $data = $request->only(['ma_sv', 'name', 'email', 'class_id']);

            Student::create($data);

            return redirect()->route('students.index')
                ->with('success', 'Thêm sinh viên thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = Classes::all();

        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ma_sv' => 'required|max:20|unique:students,ma_sv,' . $id,
            'name' => 'required|max:100',
            'email' => 'required|email|unique:students,email,' . $id,
            'class_id' => 'nullable|exists:classes,id'
        ]);

        try {
            $student = Student::findOrFail($id);

            $data = $request->only(['ma_sv', 'name', 'email', 'class_id']);

            $student->update($data);

            return redirect()->route('students.index')
                ->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            Student::destroy($id);

            return redirect()->route('students.index')
                ->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa');
        }
    }
}