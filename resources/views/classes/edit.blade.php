@extends('layouts.app')

@section('content')

<h2>Sửa lớp</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('classes.update', $class->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" 
        value="{{ old('name', $class->name) }}">
    @error('name')
        <p style="color:red">{{ $message }}</p>
    @enderror
    <br><br>

    <select name="department_id">
        <option value="">-- Chọn khoa --</option>
        @foreach($departments as $d)
            <option value="{{ $d->id }}"
                {{ old('department_id', $class->department_id) == $d->id ? 'selected' : '' }}>
                {{ $d->name }}
            </option>
        @endforeach
    </select>
    @error('department_id')
        <p style="color:red">{{ $message }}</p>
    @enderror
    <br><br>

    <button type="submit">Cập nhật</button>
    <a href="{{ route('classes.index') }}" style="margin-left:10px;">⬅ Quay lại</a>
</form>

@endsection