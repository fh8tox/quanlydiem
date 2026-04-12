@extends('layouts.app')

@section('content')

<h2>Tạo tài khoản</h2>

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>

    <select name="role" id="role">
        <option value="">-- Role --</option>
        <option value="admin">Admin</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
    </select>

    <br><br>

    <div id="student-box" style="display:none;">
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

    <button>Tạo</button>
</form>

<script>
document.getElementById('role').addEventListener('change', function () {
    document.getElementById('student-box').style.display =
        this.value === 'student' ? 'block' : 'none';
});
</script>

@endsection