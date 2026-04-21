@extends('layouts.app')

@section('content')

<h2>🎓 Danh sách sinh viên</h2>

<a href="{{ route('students.create') }}" class="btn btn-success">
    + Thêm sinh viên
</a>

@if(session('success'))
    <div style="color:green; margin-top:10px">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div style="color:red; margin-top:10px">{{ session('error') }}</div>
@endif

<div class="card" style="margin-top:15px">

<table>
    <tr>
        <th>ID</th>
        <th>Mã SV</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Lớp</th>
        <th>Hành động</th>
    </tr>

    @forelse($students as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->ma_sv }}</td>
        <td>{{ $s->name }}</td>
        <td>{{ $s->email }}</td>
        <td>{{ $s->class->name ?? '---' }}</td>
        <td>
            <a href="{{ route('students.edit', $s->id) }}" class="btn btn-primary">✏️ Sửa</a>

            <form action="{{ route('students.destroy', $s->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Xóa sinh viên này?')">
                   🗑 Xóa
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" style="text-align:center">
            Không có sinh viên
        </td>
    </tr>
    @endforelse

</table>

</div>

@endsection