@extends('layouts.app')

@section('content')

<h2>Sửa tài khoản</h2>

<form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <input type="email" name="email" value="{{ $user->email }}"><br><br>

    <input type="password" name="password" placeholder="Đổi mật khẩu (nếu muốn)"><br><br>

    <select name="role" id="role">
        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
        <option value="teacher" {{ $user->role=='teacher'?'selected':'' }}>Teacher</option>
        <option value="student" {{ $user->role=='student'?'selected':'' }}>Student</option>
    </select>

    <br><br>

    <div id="student-box" style="{{ $user->role=='student'?'':'display:none;' }}">
        <select name="student_id">
            <option value="">-- Chọn sinh viên --</option>
            @foreach($students as $s)
                <option value="{{ $s->id }}">
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br><br>

    <button>Cập nhật</button>
</form>

<script>
document.getElementById('role').addEventListener('change', function () {
    document.getElementById('student-box').style.display =
        this.value === 'student' ? 'block' : 'none';
});
</script>

@endsection