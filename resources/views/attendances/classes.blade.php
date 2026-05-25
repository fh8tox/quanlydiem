@extends('layouts.app')

@section('content')

<h2>📘 {{ $subject->ten_mon }}</h2>

@foreach($subject->courseClasses as $class)

<div class="card shadow-sm mb-3">

    <div class="card-body d-flex justify-content-between align-items-center">

        <div>
            <h5 class="mb-0">
                🏫 {{ $class->name }}
            </h5>
        </div>

        <a href="{{ url('attendances/sessions/'.$class->id) }}"
           class="btn btn-primary px-4">

            📅 Xem buổi học

        </a>

    </div>

</div>

@endforeach

@endsection