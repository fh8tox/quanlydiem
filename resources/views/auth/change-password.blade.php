@extends('layouts.app')

@section('content')

<h2>🔐 Đổi mật khẩu</h2>

<div class="card" style="max-width:500px; margin-top:20px">

    {{-- Thông báo --}}
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <label>Mật khẩu hiện tại</label><br>
        <input type="password" name="current_password" style="width:100%" placeholder="Nhập mật khẩu hiện tại">
        <br><br>

        <label>Mật khẩu mới</label><br>
        <input type="password" name="new_password" style="width:100%" placeholder="Nhập mật khẩu mới">
        <br><br>

        <label>Nhập lại mật khẩu mới</label><br>
        <input type="password" name="new_password_confirmation" style="width:100%" placeholder="Nhập lại mật khẩu">
        <br><br>

        <button type="submit" class="btn btn-success">
            ✔ Cập nhật mật khẩu
        </button>
    </form>

</div>

@endsection