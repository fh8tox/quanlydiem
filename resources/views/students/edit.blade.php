@extends('layouts.app')

@section('content')

<h2>✏️ Sửa sinh viên</h2>

@if(session('error'))
    <div style="color:red; margin-bottom:10px">{{ session('error') }}</div>
@endif

<div class="card">

<form method="POST" action="{{ route('students.update', $student->id) }}">
    @csrf
    @method('PUT')

    <label>Mã sinh viên</label><br>
    <input type="text" name="ma_sv" value="{{ old('ma_sv', $student->ma_sv) }}">
    @error('ma_sv') <p style="color:red">{{ $message }}</p> @enderror<br>

    <label>Tên sinh viên</label><br>
    <input type="text" name="name" value="{{ old('name', $student->name) }}">
    @error('name') <p style="color:red">{{ $message }}</p> @enderror<br>

    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email', $student->email) }}">
    @error('email') <p style="color:red">{{ $message }}</p> @enderror<br>

    <label>Lớp</label><br>
    <select name="class_id">
        <option value="">-- Chọn lớp --</option>
        @foreach($classes as $c)
            <option value="{{ $c->id }}"
                {{ old('class_id', $student->class_id) == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <button class="btn btn-primary">💾 Cập nhật</button>
    <a href="{{ route('students.index') }}" class="btn btn-primary px-4">⬅ Quay lại</a>

</form>

</div>

@endsection