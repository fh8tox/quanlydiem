@extends('layouts.app')

@section('content')

<h2>Danh sách sinh viên</h2>

<a href="{{ route('students.create') }}">+ Thêm sinh viên</a>

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
        <th>Mã SV</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Lớp</th>
        <th>Hành động</th>
    </tr>

    @foreach($students as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->ma_sv }}</td>
        <td>{{ $s->name }}</td>
        <td>{{ $s->email }}</td>
        <td>{{ $s->class->name ?? '---' }}</td>
        <td>
            <a href="{{ route('students.edit', $s->id) }}">Sửa</a>

            <form action="{{ route('students.destroy', $s->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Xóa?')">Xóa</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection