@extends('layouts.app')

@section('content')
<div class="container">

<h2>➕ Thêm lớp</h2>

@if(session('error'))
    <p class="error">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('classes.store') }}">
    @csrf

    <label>Tên lớp</label><br>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name') <p class="error">{{ $message }}</p> @enderror
    <br><br>

    <label>Khoa</label><br>
    <select name="department_id">
        <option value="">-- Chọn khoa --</option>
        @foreach($departments as $d)
            <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>
                {{ $d->name }}
            </option>
        @endforeach
    </select>
    @error('department_id') <p class="error">{{ $message }}</p> @enderror
    <br><br>

    <button type="submit">💾 Lưu</button>
    <a href="{{ route('classes.index') }}" class="btn">⬅ Quay lại</a>
</form>

</div>
@endsection