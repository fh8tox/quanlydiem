@extends('layouts.app')

@section('content')

<h2>✏️ Sửa điểm</h2>

<div class="card">

<form method="POST" action="{{ route('scores.update', $score->id) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Sinh viên</label><br>
        <select name="student_id" class="select2">
            @foreach($students as $s)
                <option value="{{ $s->id }}"
                    {{ $score->student_id == $s->id ? 'selected' : '' }}>
                    {{ $s->name }} ({{ $s->ma_sv }})
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Môn</label><br>
        <select name="subject_id">
            @foreach($subjects as $sub)
                <option value="{{ $sub->id }}"
                    {{ $score->subject_id == $sub->id ? 'selected' : '' }}>
                    {{ $sub->ten_mon }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Học kỳ</label><br>
        <select name="semester">
            <option value="HK1" {{ $score->semester=='HK1'?'selected':'' }}>HK1</option>
            <option value="HK2" {{ $score->semester=='HK2'?'selected':'' }}>HK2</option>
            <option value="HK3" {{ $score->semester=='HK3'?'selected':'' }}>HK3</option>
        </select>
    </div>

    <br>

    <div>
        <label>Chuyên cần</label><br>
        <input type="number" step="0.1" name="chuyen_can" value="{{ $score->chuyen_can }}">
    </div>

    <div>
        <label>Giữa kỳ</label><br>
        <input type="number" step="0.1" name="giua_ky" value="{{ $score->giua_ky }}">
    </div>

    <div>
        <label>Cuối kỳ</label><br>
        <input type="number" step="0.1" name="cuoi_ky" value="{{ $score->cuoi_ky }}">
    </div>

    <br>

    <button class="btn btn-primary">💾 Cập nhật</button>
    <a href="{{ route('scores.index') }}" class="btn">⬅ Quay lại</a>

</form>

</div>

@endsection