@extends('layouts.app')

@section('content')

<h2>📅 {{ $courseClass->name }}</h2>

@foreach($courseClass->sessions as $session)
    <div style="margin:10px 0;">
        <a href="{{ url('attendances/take/'.$session->id) }}">
            Buổi {{ $session->session_number }} ({{ $session->date }})
        </a>
    </div>
@endforeach

@endsection