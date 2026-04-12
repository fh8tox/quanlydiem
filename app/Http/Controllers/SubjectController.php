<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_mon' => 'required|unique:subjects|max:20',
            'ten_mon' => 'required|max:100',
            'so_tin_chi' => 'required|integer|min:1'
        ]);

        try {
            $data = $request->only(['ma_mon', 'ten_mon', 'so_tin_chi']);

            Subject::create($data);

            return redirect()->route('subjects.index')
                ->with('success', 'Thêm môn học thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ma_mon' => 'required|max:20|unique:subjects,ma_mon,' . $id,
            'ten_mon' => 'required|max:100',
            'so_tin_chi' => 'required|integer|min:1'
        ]);

        try {
            $subject = Subject::findOrFail($id);

            $data = $request->only(['ma_mon', 'ten_mon', 'so_tin_chi']);

            $subject->update($data);

            return redirect()->route('subjects.index')
                ->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            Subject::destroy($id);

            return redirect()->route('subjects.index')
                ->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa (có thể đang được sử dụng)');
        }
    }
}