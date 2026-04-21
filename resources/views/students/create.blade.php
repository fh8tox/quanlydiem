@extends('layouts.app')

@section('content')

<h2>➕ Thêm sinh viên</h2>

@if(session('error'))
    <div style="color:red; margin-bottom:10px">{{ session('error') }}</div>
@endif

<div class="card">

<form method="POST" action="{{ route('students.store') }}">
    @csrf

    <label>Mã sinh viên</label><br>
    <input type="text" name="ma_sv" value="{{ old('ma_sv') }}">
    @error('ma_sv') <p style="color:red">{{ $message }}</p> @enderror

    <label>Tên sinh viên</label><br>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name') <p style="color:red">{{ $message }}</p> @enderror

    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email') <p style="color:red">{{ $message }}</p> @enderror

    <label>Lớp</label><br>
    <select name="class_id">
        <option value="">-- Chọn lớp --</option>
        @foreach($classes as $c)
            <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <button class="btn btn-success">💾 Lưu</button>
    <a href="{{ route('students.index') }}" class="btn">⬅ Quay lại</a>

</form>

</div>

@endsection