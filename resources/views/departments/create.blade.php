@extends('layouts.app')

@section('content')

<h2>➕ Thêm khoa</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('departments.store') }}">
    @csrf

    <div>
        <label>Tên khoa</label><br>
        <input type="text" name="name" placeholder="Nhập tên khoa"
               value="{{ old('name') }}">
        @error('name')
            <p style="color:red">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <button type="submit" class="btn btn-success">💾 Lưu</button>
    <a href="{{ route('departments.index') }}" class="btn">⬅ Quay lại</a>
</form>

@endsection