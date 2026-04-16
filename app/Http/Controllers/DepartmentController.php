<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments|max:100'
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Thêm khoa thành công');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        Department::destroy($id);

        return redirect()->route('departments.index')
            ->with('success', 'Xóa thành công');
    }
}