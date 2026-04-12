@extends('layouts.app')

@section('content')

<h2>Thêm điểm</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('scores.store') }}">
    @csrf

    {{-- Sinh viên --}}
    <select name="student_id" class="select2">
        <option value="">-- Chọn sinh viên --</option>
        @foreach($students as $s)
            <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                {{ $s->name }} ({{ $s->ma_sv }})
            </option>
        @endforeach
    </select>
    @error('student_id') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    {{-- Môn --}}
    <select name="subject_id" class="select2">
        <option value="">-- Chọn môn --</option>
        @foreach($subjects as $sub)
            <option value="{{ $sub->id }}" {{ old('subject_id') == $sub->id ? 'selected' : '' }}>
                {{ $sub->ten_mon }} ({{ $sub->ma_mon }})
            </option>
        @endforeach
    </select>
    @error('subject_id') <p style="color:red">{{ $message }}</p> @enderror
    <br><br>

    {{-- Học kỳ --}}
    <select name="semester">
        <option value="HK1">HK1</option>
        <option value="HK2">HK2</option>
        <option value="HK3">HK3</option>
    </select>
    <br><br>

    {{-- Điểm --}}
    <input type="number" step="0.1" name="chuyen_can" placeholder="Chuyên cần" value="{{ old('chuyen_can') }}"><br><br>
    <input type="number" step="0.1" name="giua_ky" placeholder="Giữa kỳ" value="{{ old('giua_ky') }}"><br><br>
    <input type="number" step="0.1" name="thuc_hanh" placeholder="Thực hành" value="{{ old('thuc_hanh') }}"><br><br>
    <input type="number" step="0.1" name="cuoi_ky" placeholder="Cuối kỳ" value="{{ old('cuoi_ky') }}"><br><br>

    <button type="submit">Lưu</button>
    <a href="{{ route('scores.index') }}">⬅ Quay lại</a>
</form>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Tìm kiếm...",
            allowClear: true,
            width: '300px'
        });
    });
</script>

@endsection