@extends('layouts.app')

@section('content')

<h2>Danh sách môn học</h2>

<a href="{{ route('subjects.create') }}">+ Thêm môn học</a>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<br><br>

<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>Mã môn</th>
        <th>Tên môn</th>
        <th>Số tín chỉ</th>
        <th>Hành động</th>
    </tr>

    @foreach($subjects as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->ma_mon }}</td>
        <td>{{ $s->ten_mon }}</td>
        <td>{{ $s->so_tin_chi }}</td>
        <td>
            <a href="{{ route('subjects.edit', $s->id) }}">Sửa</a>

            <form action="{{ route('subjects.destroy', $s->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Xóa?')">Xóa</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection