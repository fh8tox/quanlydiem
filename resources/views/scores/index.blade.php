@extends('layouts.app')

@section('content')

<h2>📊 Quản lý điểm</h2>

@if(request('course_class_id'))
    <a href="{{ route('scores.create', [
        'course_class_id' => request('course_class_id')
    ]) }}" class="btn btn-success">
        + Thêm điểm
    </a>
@endif

<br><br>

@if(session('success'))
    <div style="color:green;">✔ {{ session('success') }}</div>
@endif

@if(session('error'))
    <div style="color:red;">❌ {{ session('error') }}</div>
@endif

<div class="card">

<form method="GET">
    <select name="course_class_id" required>
        <option value="">-- Chọn lớp học phần --</option>
        @foreach($courseClasses as $cc)
            <option value="{{ $cc->id }}"
                {{ request('course_class_id') == $cc->id ? 'selected' : '' }}>
                {{ $cc->name }} - {{ $cc->subject->ten_mon ?? '' }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-primary">Xem</button>
    <a href="{{ route('scores.index') }}" class="btn btn-reset">🔄 Reset</a>
</form>

<hr>

@if(!request('course_class_id'))
    <p style="color:gray">👉 Hãy chọn lớp học phần</p>
@endif

@if(request('course_class_id'))

<h4>
    📚 {{ $courseClasses->firstWhere('id', request('course_class_id'))->name }}
</h4>

<table>
    <tr>
        <th>ID</th>
        <th>Mã SV</th>
        <th>Tên</th>
        <th>HK</th>
        <th>CC</th>
        <th>GK</th>
        <th>CK</th>
        <th>Tổng</th>
        <th>Loại</th>
        <th>Action</th>
    </tr>

    @forelse($scores as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->student->ma_sv }}</td>
        <td>{{ $s->student->name }}</td>
        <td>{{ $s->semester }}</td>
        <td>{{ $s->chuyen_can }}</td>
        <td>{{ $s->giua_ky }}</td>
        <td>{{ $s->cuoi_ky }}</td>
        <td><b>{{ $s->tong_ket }}</b></td>

        <td>
            @if(in_array($s->xep_loai, ['A+', 'A']))
                <span style="color:green">{{ $s->xep_loai }}</span>
            @elseif(in_array($s->xep_loai, ['D', 'F']))
                <span style="color:red">{{ $s->xep_loai }}</span>
            @else
                {{ $s->xep_loai }}
            @endif
        </td>

        <td>
            <a href="{{ route('scores.edit', $s->id) }}" class="btn btn-primary">✏️ Sửa</a>

            @if(Auth::user()->role == 'admin')
            <form method="POST" action="{{ route('scores.destroy', $s->id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Xóa?')">🗑 Xóa</button>
            </form>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="10" style="text-align:center">Không có dữ liệu</td>
    </tr>
    @endforelse

</table>

@endif

</div>

@endsection