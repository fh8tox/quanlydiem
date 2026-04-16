@extends('layouts.app')

@section('content')

<h2>Sửa điểm</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('scores.update', $score->id) }}">
    @csrf
    @method('PUT')

    {{-- Sinh viên --}}
    <select name="student_id" class="select2">
        @foreach($students as $s)
            <option value="{{ $s->id }}"
                {{ old('student_id', $score->student_id) == $s->id ? 'selected' : '' }}>
                {{ $s->name }} ({{ $s->ma_sv }})
            </option>
        @endforeach
    </select>
    @error('student_id') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    {{-- Môn --}}
    <select name="subject_id" class="select2">
        @foreach($subjects as $sub)
            <option value="{{ $sub->id }}"
                {{ old('subject_id', $score->subject_id) == $sub->id ? 'selected' : '' }}>
                {{ $sub->ten_mon }} ({{ $sub->ma_mon }})
            </option>
        @endforeach
    </select>
    @error('subject_id') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    {{-- Học kỳ --}}
    <select name="semester">
        <option value="HK1" {{ old('semester', $score->semester)=='HK1'?'selected':'' }}>HK1</option>
        <option value="HK2" {{ old('semester', $score->semester)=='HK2'?'selected':'' }}>HK2</option>
        <option value="HK3" {{ old('semester', $score->semester)=='HK3'?'selected':'' }}>HK3</option>
    </select>
    <br><br>

    {{-- Điểm --}}
    <input type="number" step="0.1" name="chuyen_can"
        value="{{ old('chuyen_can', $score->chuyen_can) }}"><br><br>

    <input type="number" step="0.1" name="giua_ky"
        value="{{ old('giua_ky', $score->giua_ky) }}"><br><br>

    <input type="number" step="0.1" name="thuc_hanh"
        value="{{ old('thuc_hanh', $score->thuc_hanh) }}"><br><br>

    <input type="number" step="0.1" name="cuoi_ky"
        value="{{ old('cuoi_ky', $score->cuoi_ky) }}"><br><br>

    <button type="submit">Cập nhật</button>
    <a href="{{ route('scores.index') }}">⬅ Quay lại</a>

</form>

@endsection