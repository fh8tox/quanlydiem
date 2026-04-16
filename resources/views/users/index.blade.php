@extends('layouts.app')

@section('content')

<h2>Danh sách tài khoản</h2>

<a href="{{ route('users.create') }}">+ Tạo tài khoản</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<br><br>

<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Role</th>
        <th>Hành động</th>
    </tr>

    @foreach($users as $u)
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->role }}</td>
        <td>
            <a href="{{ route('users.edit', $u->id) }}">Sửa</a>

            <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Xóa?')">Xóa</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection