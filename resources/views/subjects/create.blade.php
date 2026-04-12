@extends('layouts.app')

@section('content')

<h2>Thêm môn học</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('subjects.store') }}">
    @csrf

    <input type="text" name="ma_mon" placeholder="Mã môn" value="{{ old('ma_mon') }}">
    @error('ma_mon')
        <p style="color:red">{{ $message }}</p>
    @enderror
    <br><br>

    <input type="text" name="ten_mon" placeholder="Tên môn" value="{{ old('ten_mon') }}">
    @error('ten_mon')
        <p style="color:red">{{ $message }}</p>
    @enderror
    <br><br>

    <input type="number" name="so_tin_chi" placeholder="Số tín chỉ" value="{{ old('so_tin_chi') }}">
    @error('so_tin_chi')
        <p style="color:red">{{ $message }}</p>
    @enderror
    <br><br>

    <button type="submit">Lưu</button>
    <a href="{{ route('subjects.index') }}">⬅ Quay lại</a>
</form>

@endsection