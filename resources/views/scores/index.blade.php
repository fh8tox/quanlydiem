@extends('layouts.app')

@section('content')

<h2>Danh sách điểm</h2>

<a href="{{ route('scores.create') }}">+ Thêm điểm</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<br><br>

<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>Sinh viên</th>
        <th>Môn học</th>
        <th>Học kỳ</th>
        <th>CC</th>
        <th>GK</th>
        <th>TH</th>
        <th>CK</th>
        <th>Tổng</th>
        <th>Xếp loại</th>
        <th>Hành động</th>
    </tr>

    @foreach($scores as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->student->name ?? '---' }}</td>
        <td>{{ $s->subject->ten_mon ?? '---' }}</td>
        <td>{{ $s->semester }}</td>
        <td>{{ $s->chuyen_can }}</td>
        <td>{{ $s->giua_ky }}</td>
        <td>{{ $s->thuc_hanh }}</td>
        <td>{{ $s->cuoi_ky }}</td>
        <td><b>{{ $s->tong_ket }}</b></td>
        <td>{{ $s->xep_loai }}</td>
        <td>

            <a href="{{ route('scores.edit', $s->id) }}">Sửa</a>

            {{-- CHỈ ADMIN ĐƯỢC XÓA --}}
            @if(Auth::user()->role == 'admin')
                <form action="{{ route('scores.destroy', $s->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Xóa?')">Xóa</button>
                </form>
            @endif

        </td>
    </tr>
    @endforeach

</table>

@endsection