@extends('layouts.app')

@section('content')

<h2>👤 Danh sách tài khoản</h2>

<a href="{{ route('users.create') }}" class="btn btn-primary">+ Tạo tài khoản</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<div class="card">

<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Tên</th>
        <th>Role</th>
        <th>Hành động</th>
    </tr>

    @forelse($users as $u)
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->name ?? ($u->student->name ?? '---') }}</td>
        <td>
            <span class="badge 
                {{ $u->role=='admin' ? 'badge-danger' : '' }}
                {{ $u->role=='teacher' ? 'badge-primary' : '' }}
                {{ $u->role=='student' ? 'badge-success' : '' }}">
                {{ ucfirst($u->role) }}
            </span>
        </td>
        <td>
            <a href="{{ route('users.edit', $u->id) }}" class="btn btn-success">✏️ Sửa</a>

            <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Xóa tài khoản này?')">🗑️ Xóa</button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" style="text-align:center">Không có dữ liệu</td>
    </tr>
    @endforelse

</table>

</div>

@endsection