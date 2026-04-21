<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        $user = User::where('email', $request->email)->first();

        // ❌ sai: so sánh trực tiếp
        // ✅ đúng: dùng Hash::check
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
        }

        // ✅ LOGIN
        Auth::login($user);

        // redirect theo role
        if ($user->role === 'admin') {
            return redirect('/admin');
        }

        if ($user->role === 'teacher') {
            return redirect('/teacher');
        }

        if ($user->role === 'student') {
            return redirect('/student');
        }

        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Đã đăng xuất');
    }
}