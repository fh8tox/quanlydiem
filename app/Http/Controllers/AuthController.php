<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        if (!$user || $user->password != $request->password) {
            return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
        }

        // ✅ LOGIN
        Auth::login($user);

        // 🔥 FIX CHÍNH Ở ĐÂY
        if ($user->role === 'admin') {
            return redirect('/admin');
        }

        if ($user->role === 'teacher') {
            return redirect('/teacher');
        }

        if ($user->role === 'student') {
            return redirect('/student');
        }

        // fallback
        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Đã đăng xuất');
    }
}