<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ===== DANH SÁCH =====
    public function index()
    {
        $users = User::with('student')->latest()->get();
        return view('users.index', compact('users'));
    }

    // ===== FORM CREATE =====
    public function create()
{
    $students = Student::whereNull('user_id')->get();
    return view('users.create', compact('students'));
}

    // ===== LƯU =====
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'role' => 'required',
            'student_id' => 'nullable|exists:students,id'
        ]);

        try {
            // tạo user
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password, // nếu muốn bảo mật: Hash::make()
                'role' => $request->role,
            ]);

            // nếu chọn student → gán user_id
            if ($request->student_id) {

                $student = Student::find($request->student_id);

                // ❌ nếu đã có tài khoản rồi thì chặn
                if ($student->user_id) {
                    return back()->with('error', 'Sinh viên này đã có tài khoản!');
                }

                $student->user_id = $user->id;
                $student->save();
            }

            return redirect()->route('users.index')
                ->with('success', 'Tạo tài khoản thành công');

        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi tạo tài khoản');
        }
    }

    // ===== FORM EDIT =====
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $students = Student::all();

        return view('users.edit', compact('user', 'students'));
    }

    // ===== UPDATE =====
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        try {
            $user = User::findOrFail($id);

            $data = [
                'email' => $request->email,
                'role' => $request->role,
            ];

            if ($request->password) {
                $data['password'] = $request->password;
            }

            $user->update($data);

            // reset student cũ
            Student::where('user_id', $user->id)->update(['user_id' => null]);

            // gán lại student mới
            if ($request->student_id) {
                $student = Student::find($request->student_id);
                $student->user_id = $user->id;
                $student->save();
            }

            return redirect()->route('users.index')
                ->with('success', 'Cập nhật thành công');

        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi cập nhật');
        }
    }

    // ===== DELETE =====
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // gỡ liên kết student
            Student::where('user_id', $user->id)->update(['user_id' => null]);

            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'Xóa thành công');

        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa');
        }
    }
}