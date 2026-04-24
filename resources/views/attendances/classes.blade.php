@extends('layouts.app')

@section('content')

<h2>📘 {{ $subject->ten_mon }}</h2>

@foreach($subject->courseClasses as $class)
    <div style="margin:10px 0;">
        <a href="{{ url('attendances/sessions/'.$class->id) }}">
            🏫 {{ $class->name }}
        </a>
    </div>
@endforeach

@endsection