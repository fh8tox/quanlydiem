@extends('layouts.app')

@section('content')

<style>
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    a, button { padding: 5px 10px; text-decoration: none; }
    .btn { background: #3498db; color: white; border: none; border-radius: 5px; }
    .delete { background: red; color: white; border: none; border-radius: 5px; }
</style>

<h2>Danh sách khoa</h2>

<a href="{{ route('departments.create') }}" class="btn">+ Thêm khoa</a>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<br><br>

<table>
    <tr>
        <th>ID</th>
        <th>Tên khoa</th>
        <th>Hành động</th>
    </tr>

    @foreach($departments as $dep)
    <tr>
        <td>{{ $dep->id }}</td>
        <td>{{ $dep->name }}</td>
        <td>
            <a href="{{ route('departments.edit', $dep->id) }}" class="btn">Sửa</a>

            <form action="{{ route('departments.destroy', $dep->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="delete" onclick="return confirm('Xóa?')">Xóa</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection