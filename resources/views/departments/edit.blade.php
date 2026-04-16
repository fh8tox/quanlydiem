@extends('layouts.app')

@section('content')

<h2>Sửa khoa</h2>

<form method="POST" action="{{ route('departments.update', $department->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $department->name }}">

    <button type="submit">Cập nhật</button>
</form>

<a href="{{ route('departments.index') }}">Quay lại</a>

@endsection