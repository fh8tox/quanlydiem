<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Department;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('department')->latest()->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('classes.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:classes,name',
            'department_id' => 'nullable|exists:departments,id'
        ]);

        try {
            $data = $request->only(['name', 'department_id']);

            Classes::create($data);

            return redirect()->route('classes.index')
                ->with('success', 'Thêm lớp thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);
        $departments = Department::all();

        return view('classes.edit', compact('class', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // ❗ fix trùng khi update
            'name' => 'required|max:50|unique:classes,name,' . $id,
            'department_id' => 'nullable|exists:departments,id'
        ]);

        try {
            $class = Classes::findOrFail($id);

            $data = $request->only(['name', 'department_id']);

            $class->update($data);

            return redirect()->route('classes.index')
                ->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            Classes::destroy($id);

            return redirect()->route('classes.index')
                ->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa (có thể đang được sử dụng)');
        }
    }
}