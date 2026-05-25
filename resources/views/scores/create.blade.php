@extends('layouts.app')

@section('content')

<h2>➕ Thêm điểm</h2>

@if(session('error'))
    <div style="color:red; margin-bottom:10px;">{{ session('error') }}</div>
@endif

<div class="card">

    <p><b>📚 Lớp học phần:</b> {{ $courseClass->name ?? '---' }}</p>
    <p><b>📘 Môn:</b> {{ $courseClass->subject->ten_mon ?? '---' }}</p>

    <form method="POST" action="{{ route('scores.store') }}">
        @csrf

        <input type="hidden" name="course_class_id" value="{{ $courseClass->id }}">

        <div>
            <label>Sinh viên</label><br>
            <select name="student_id" class="select2">
                <option value="">-- Chọn sinh viên --</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}">
                        {{ $s->name }} ({{ $s->ma_sv }})
                    </option>
                @endforeach
            </select>
            @error('student_id') <p style="color:red">{{ $message }}</p> @enderror
        </div>

        <br>

        <div>
            <label>Học kỳ</label><br>
            <select name="semester">
                <option value="HK1">HK1</option>
                <option value="HK2">HK2</option>
                <option value="HK3">HK3</option>
            </select>
        </div>

        <br>

        <div>
            <label>Chuyên cần (auto)</label><br>
            <input type="number" step="0.1" disabled placeholder="Tự động tính">
        </div>

        <div>
            <label>Giữa kỳ</label><br>
            <input type="number" step="0.1" name="giua_ky">
        </div>

        <div>
            <label>Cuối kỳ</label><br>
            <input type="number" step="0.1" name="cuoi_ky">
        </div>

        <br>

        <button class="btn btn-success">💾 Lưu</button>
        <a href="{{ route('scores.index') }}" class="btn btn-primary px-4">⬅ Quay lại</a>
    </form>

</div>

@endsection