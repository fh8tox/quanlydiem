@extends('layouts.app')

@section('content')
<h2>📚 Chọn môn học</h2>

@foreach($subjects as $subject)
    <div style="padding:10px; margin-bottom:10px; border:1px solid #ddd;">
        <h4>{{ $subject->ten_mon }}</h4>

        <a href="{{ url('attendances/classes/'.$subject->id) }}">
            👉 Xem lớp học
        </a>
    </div>
@endforeach

@endsection