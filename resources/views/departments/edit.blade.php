@extends('layouts.app')

@section('content')

<h2>✏️ Sửa khoa</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('departments.update', $department->id) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Tên khoa</label><br>
        <input type="text" name="name"
               value="{{ old('name', $department->name) }}">
        @error('name')
            <p style="color:red">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
    <a href="{{ route('departments.index') }}" class="btn">⬅ Quay lại</a>
</form>

@endsection