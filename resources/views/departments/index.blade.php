@extends('layouts.app')

@section('content')

<h2>🏫 Danh sách khoa</h2>

<a href="{{ route('departments.create') }}" class="btn btn-success">
    + Thêm khoa
</a>

<br><br>

@if(session('success'))
    <div style="color:green; margin-bottom:10px;">
        ✔ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="color:red; margin-bottom:10px;">
        ❌ {{ session('error') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th width="80">ID</th>
            <th>Tên khoa</th>
            <th width="180">Hành động</th>
        </tr>
    </thead>

    <tbody>
        @forelse($departments as $dep)
        <tr>
            <td>{{ $dep->id }}</td>
            <td>{{ $dep->name }}</td>
            <td>
                <a href="{{ route('departments.edit', $dep->id) }}"
                   class="btn btn-primary">✏️ Sửa</a>

                <form action="{{ route('departments.destroy', $dep->id) }}"
                      method="POST"
                      style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger"
                        onclick="return confirm('Xóa khoa này?')">
                        🗑 Xóa
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" style="text-align:center">
                Không có dữ liệu
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection