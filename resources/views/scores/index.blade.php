@extends('layouts.app')

@section('content')

<h2>📊 Quản lý điểm</h2>

@if(request('class_id') && request('subject_id'))
    <a href="{{ route('scores.create', [
        'class_id' => request('class_id'),
        'subject_id' => request('subject_id')
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
    <select name="class_id" required>
        <option value="">-- Chọn lớp --</option>
        @foreach($classes as $c)
            <option value="{{ $c->id }}"
                {{ request('class_id') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <select name="subject_id" required>
        <option value="">-- Chọn môn --</option>
        @foreach($subjects as $sub)
            <option value="{{ $sub->id }}"
                {{ request('subject_id') == $sub->id ? 'selected' : '' }}>
                {{ $sub->ten_mon }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-primary">Xem</button>
    <a href="{{ route('scores.index') }}" class="btn btn-reset">🔄Reset</a>
</form>

<hr>

@if(!request('class_id') || !request('subject_id'))
    <p style="color:gray">👉 Hãy chọn lớp và môn</p>
@endif

@if(request('class_id') && request('subject_id'))

<h4>
    📚 {{ $classes->firstWhere('id', request('class_id'))->name }}
    |
    📘 {{ $subjects->firstWhere('id', request('subject_id'))->ten_mon }}
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