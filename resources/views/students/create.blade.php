@extends('layouts.app')

@section('content')

<h2>Thêm sinh viên</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('students.store') }}">
    @csrf

    <input type="text" name="ma_sv" placeholder="Mã SV" value="{{ old('ma_sv') }}">
    @error('ma_sv') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    <input type="text" name="name" placeholder="Tên" value="{{ old('name') }}">
    @error('name') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
    @error('email') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    <select name="class_id">
        <option value="">-- Chọn lớp --</option>
        @foreach($classes as $c)
            <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <button type="submit">Lưu</button>
    <a href="{{ route('students.index') }}">⬅ Quay lại</a>
</form>

@endsection