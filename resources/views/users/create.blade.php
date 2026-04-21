@extends('layouts.app')

@section('content')

<h2>➕ Tạo tài khoản</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<div class="card">

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email') <p style="color:red">{{ $message }}</p> @enderror

    <label>Password</label>
    <input type="password" name="password">
    @error('password') <p style="color:red">{{ $message }}</p> @enderror

    <label>Role</label>
    <select name="role" id="role">
        <option value="">-- Chọn role --</option>
        <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
        <option value="teacher" {{ old('role')=='teacher'?'selected':'' }}>Teacher</option>
        <option value="student" {{ old('role')=='student'?'selected':'' }}>Student</option>
    </select>

    <div id="student-box" style="{{ old('role')=='student' ? '' : 'display:none;' }}">
        <label>Chọn sinh viên</label>
        <select name="student_id" class="select2">
            <option value="">-- Chọn sinh viên --</option>
            @foreach($students as $s)
                <option value="{{ $s->id }}" {{ old('student_id')==$s->id?'selected':'' }}>
                    {{ $s->name }} ({{ $s->ma_sv }})
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <button class="btn btn-primary">💾 Tạo</button>
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