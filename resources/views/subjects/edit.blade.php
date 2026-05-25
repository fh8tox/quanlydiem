@extends('layouts.app')

@section('content')

<h2>✏️ Sửa môn học</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<div class="card">

<form method="POST" action="{{ route('subjects.update', $subject->id) }}">
    @csrf
    @method('PUT')

    <label>Mã môn</label>
    <input type="text" name="ma_mon" value="{{ old('ma_mon', $subject->ma_mon) }}">
    @error('ma_mon')
        <p style="color:red">{{ $message }}</p>
    @enderror<br>

    <label>Tên môn</label>
    <input type="text" name="ten_mon" value="{{ old('ten_mon', $subject->ten_mon) }}">
    @error('ten_mon')
        <p style="color:red">{{ $message }}</p>
    @enderror<br>

    <label>Số tín chỉ</label>
    <input type="number" name="so_tin_chi" value="{{ old('so_tin_chi', $subject->so_tin_chi) }}">
    @error('so_tin_chi')
        <p style="color:red">{{ $message }}</p>
    @enderror<br>

    <br>

    <button class="btn btn-success">💾 Cập nhật</button>
    <a href="{{ route('subjects.index') }}" class="btn btn-primary px-4">⬅ Quay lại</a>
</form>

</div>

@endsection