@extends('layouts.app')

@section('content')

<h2>📚 Lớp học tín chỉ</h2>

<a href="{{ route('course-classes.create') }}">➕ Thêm</a>

<table border="1" cellpadding="10">
<tr>
    <th>Tên lớp</th>
    <th>Môn</th>
    <th>Action</th>
</tr>

@foreach($classes as $c)
<tr>
    <td>{{ $c->name }}</td>
    <td>{{ $c->subject->ten_mon }}</td>
    <td>
        <a href="{{ route('course-classes.edit',$c->id) }}">Sửa</a>

        <form method="POST" action="{{ route('course-classes.destroy',$c->id) }}" style="display:inline;">
            @csrf @method('DELETE')
            <button onclick="return confirm('Xoá?')">Xoá</button>
        </form>
    </td>
</tr>
@endforeach
</table>

@endsection