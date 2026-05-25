@extends('layouts.app')

@section('content')

<h2>✏️ Cập nhật lớp học tín chỉ</h2>

<div class="mb-3">

    <a href="{{ route('course-classes.index') }}"
       class="btn btn-primary px-4">
        ← Quay lại
    </a>

</div><br>

<form method="POST" action="{{ route('course-classes.update',$courseClass->id) }}">
@csrf
@method('PUT')

<label>Tên lớp</label><br>
<input type="text"
       name="name"
       value="{{ $courseClass->name }}"
       required>

<br><br>

<label>Môn học</label><br>

<select name="subject_id">

@foreach($subjects as $s)

<option value="{{ $s->id }}"
    {{ $courseClass->subject_id == $s->id ? 'selected' : '' }}>

    {{ $s->ten_mon }}

</option>

@endforeach

</select>

<br><br>

<label>Sinh viên</label><br>

@foreach($students as $sv)

<div>

    <input type="checkbox"
           name="students[]"
           value="{{ $sv->id }}"
           {{ $courseClass->students->contains($sv->id) ? 'checked' : '' }}>

    {{ $sv->name }}

</div>

@endforeach

<br>

<button type="submit" class="btn btn-primary">
    💾 Cập nhật
</button>

</form>

@endsection