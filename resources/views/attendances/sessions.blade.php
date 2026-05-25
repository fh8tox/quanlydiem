@extends('layouts.app')

@section('content')

<h2>📅 {{ $courseClass->name }}</h2>

@foreach($courseClass->sessions as $session)

<div class="card shadow-sm mb-3">

    <div class="card-body d-flex justify-content-between align-items-center">

        <div>

            <h5 class="mb-1">
                📋 Buổi {{ $session->session_number }}
            </h5>
            <small class="text-muted">
                📆 {{ $session->date }}
            </small>

        </div><br>

        <a href="{{ url('attendances/take/'.$session->id) }}"
           class="btn btn-primary px-4">
            ✅ Điểm danh
        </a>

    </div>

</div>

@endforeach

@endsection