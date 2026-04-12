<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        // ❌ bỏ Session
        // ✅ dùng Auth chuẩn Laravel
        if (!Auth::check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}