<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== SHOW LOGIN =====
    public function showLogin()
    {
        return view('login');
    }

    // ===== LOGIN =====
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        $user = User::where('email', $request->email)->first();

        // ❌ không tồn tại user
        if (!$user) {
            return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
        }

        // ❌ sai mật khẩu (đã hash)
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
        }

        // ✅ login chuẩn Laravel
        Auth::login($user);

        $request->session()->regenerate();

        // ===== redirect theo role =====
        return match ($user->role) {
            'admin' => redirect('/admin'),
            'teacher' => redirect('/teacher'),
            'student' => redirect('/student'),
            default => redirect('/login')
        };
    }

    // ===== LOGOUT =====
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đã đăng xuất');
    }

    public function showChangePassword()
{
    return view('auth.change-password');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công');
    }

}