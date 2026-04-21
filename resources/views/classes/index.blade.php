@extends('layouts.app')

@section('content')

<h2>Danh sách lớp</h2>

<a href="{{ route('classes.create') }}" class="btn btn-primary">+ Thêm lớp</a>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<br><br>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên lớp</th>
            <th>Khoa</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        @forelse($classes as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->name }}</td>

            {{-- ✅ FIX LỖI --}}
            <td>{{ optional($c->department)->name ?? '---' }}</td>

            <td>
                <a href="{{ route('classes.edit', $c->id) }}" class="btn btn-success">✏️ Sửa</a>

                <form action="{{ route('classes.destroy', $c->id) }}" 
                      method="POST" 
                      style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger"
                        onclick="return confirm('Xóa lớp này?')">
                        🗑 Xóa
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align:center">
                Không có dữ liệu
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection