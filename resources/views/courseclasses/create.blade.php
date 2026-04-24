@extends('layouts.app')

@section('content')

<h2>➕ Thêm lớp học</h2>

<form method="POST" action="{{ route('course-classes.store') }}">
@csrf

<label>Tên lớp</label><br>
<input type="text" name="name" required><br><br>

<label>Môn học</label><br>
<select name="subject_id">
@foreach($subjects as $s)
<option value="{{ $s->id }}">{{ $s->ten_mon }}</option>
@endforeach
</select><br><br>

<label>Sinh viên</label><br>
@foreach($students as $sv)
    <div>
        <input type="checkbox" name="students[]" value="{{ $sv->id }}">
        {{ $sv->name }}
    </div>
@endforeach

<br>
<button type="submit">💾 Lưu</button>

</form>

@endsection