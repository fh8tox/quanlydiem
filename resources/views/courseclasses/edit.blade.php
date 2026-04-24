@extends('layouts.app')

@section('content')

<h2>✏️ Sửa lớp học</h2>

<form method="POST" action="{{ route('course-classes.update',$courseClass->id) }}">
@csrf @method('PUT')

<label>Tên lớp</label><br>
<input type="text" name="name" value="{{ $courseClass->name }}" required><br><br>

<label>Môn học</label><br>
<select name="subject_id">
@foreach($subjects as $s)
<option value="{{ $s->id }}"
    {{ $courseClass->subject_id == $s->id ? 'selected' : '' }}>
    {{ $s->ten_mon }}
</option>
@endforeach
</select><br><br>

<label>Sinh viên</label><br>
@foreach($students as $sv)
    <div>
        <input type="checkbox" name="students[]" value="{{ $sv->id }}"
        {{ $courseClass->students->contains($sv->id) ? 'checked' : '' }}>
        {{ $sv->name }}
    </div>
@endforeach

<br>
<button type="submit">💾 Cập nhật</button>

</form>

@endsection