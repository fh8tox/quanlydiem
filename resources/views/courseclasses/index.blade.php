@extends('layouts.app')

@section('content')

<h2>📚 Danh sách lớp học tín chỉ</h2>

<a href="{{ route('course-classes.create') }}" class="btn btn-success">
    + Thêm lớp học
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
            <th>Tên lớp</th>
            <th>Môn học</th>
            <th width="180">Hành động</th>
        </tr>
    </thead>

    <tbody>

    @forelse($classes as $c)
    <tr>

        <td>{{ $c->id }}</td>

        <td>{{ $c->name }}</td>

        <td>{{ $c->subject->ten_mon }}</td>

        <td>

            <a href="{{ route('course-classes.edit', $c->id) }}"
               class="btn btn-primary">
               ✏️ Sửa
            </a>

            <form action="{{ route('course-classes.destroy', $c->id) }}"
                  method="POST"
                  style="display:inline">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger"
                    onclick="return confirm('Xóa lớp học này?')">

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