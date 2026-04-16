@extends('layouts.app')

@section('content')

<h2>Thêm khoa</h2>

<form method="POST" action="{{ route('departments.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Tên khoa">

    <button type="submit">Lưu</button>
</form>

<a href="{{ route('departments.index') }}">Quay lại</a>

@endsection