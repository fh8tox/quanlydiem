@extends('layouts.app')

@section('content')

<h2>✏️ Sửa tài khoản</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<div class="card">

<form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}">
    @error('email') <p style="color:red">{{ $message }}</p> @enderror

    <label>Mật khẩu (để trống nếu không đổi)</label>
    <input type="password" name="password">

    <label>Role</label>
    <select name="role" id="role">
        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
        <option value="teacher" {{ $user->role=='teacher'?'selected':'' }}>Teacher</option>
        <option value="student" {{ $user->role=='student'?'selected':'' }}>Student</option>
    </select>

    <div id="student-box" style="{{ $user->role=='student' ? '' : 'display:none;' }}">
        <label>Chọn sinh viên</label>
        <select name="student_id" class="select2">
            <option value="">-- Chọn sinh viên --</option>
            @foreach($students as $s)
                <option value="{{ $s->id }}"
                    {{ ($user->student && $user->student->id == $s->id) ? 'selected' : '' }}>
                    {{ $s->name }} ({{ $s->ma_sv }})
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <button class="btn btn-success">💾 Cập nhật</button>
    <a href="{{ route('users.index') }}" class="btn">⬅ Quay lại</a>

</form>

</div>

<script>
document.getElementById('role').addEventListener('change', function () {
    document.getElementById('student-box').style.display =
        this.value === 'student' ? 'block' : 'none';
});
</script>

@endsection