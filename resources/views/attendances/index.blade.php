@extends('layouts.app')

@section('content')

<h2>📚 Chọn môn học</h2>

@foreach($subjects as $subject)

<div class="card shadow-sm mb-3">

    <div class="card-body d-flex justify-content-between align-items-center">

        <div>
            <h4 class="mb-0">{{ $subject->ten_mon }}</h4>
        </div>

        <a href="{{ url('attendances/classes/'.$subject->id) }}"
           class="btn btn-primary px-4">

            🏫 Xem lớp học

        </a>

    </div>

</div>

@endforeach

@endsection