@extends('layouts.app')

@section('content')

<h2>Danh sách lớp</h2>

<a href="{{ route('classes.create') }}" class="btn">+ Thêm lớp</a>

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
        <th>Tên lớp</th>
        <th>Khoa</th>
        <th>Hành động</th>
    </tr>

    @foreach($classes as $c)
    <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ $c->department->name ?? '---' }}</td>
        <td>
            <a href="{{ route('classes.edit', $c->id) }}">Sửa</a>

            <form action="{{ route('classes.destroy', $c->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Xóa?')">Xóa</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection