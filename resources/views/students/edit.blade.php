@extends('layouts.app')

@section('content')

<h2>Sửa sinh viên</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('students.update', $student->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="ma_sv" value="{{ old('ma_sv', $student->ma_sv) }}">
    @error('ma_sv') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    <input type="text" name="name" value="{{ old('name', $student->name) }}">
    @error('name') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    <input type="email" name="email" value="{{ old('email', $student->email) }}">
    @error('email') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

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

    <button type="submit">Cập nhật</button>
    <a href="{{ route('students.index') }}">⬅ Quay lại</a>
</form>

@endsection