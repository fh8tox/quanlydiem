@extends('layouts.app')

@section('content')

<h2>📊 Dashboard Admin</h2>

<div style="display:flex; flex-wrap:wrap; gap:20px; margin-top:20px">

    {{-- Sinh viên --}}
    <div class="card" style="flex:1; min-width:200px">
        <h3>🎓 Sinh viên</h3>
        <p style="font-size:22px; font-weight:bold">
            {{ $totalStudents }}
        </p>
    </div>

    {{-- Tài khoản --}}
    <div class="card" style="flex:1; min-width:200px">
        <h3>👤 Tài khoản</h3>
        <p style="font-size:22px; font-weight:bold">
            {{ $totalUsers }}
        </p>
    </div>

    {{-- Rớt môn --}}
    <div class="card" style="flex:1; min-width:200px">
        <h3>❌ Sinh viên rớt môn</h3>
        <p style="font-size:22px; font-weight:bold; color:red">
            {{ $failedStudents }}
        </p>
    </div>

    {{-- GPA cao nhất --}}
    <div class="card" style="flex:1; min-width:200px">
        <h3>🏆 GPA cao nhất</h3>

        @if($topStudent)
            <p style="font-size:18px">
                <b>{{ $topStudent->name }}</b>
            </p>
            <p style="font-size:22px; color:green; font-weight:bold">
                {{ $topStudent->gpa }}
            </p>
        @else
            <p>Chưa có dữ liệu</p>
        @endif
    </div>

</div>

@endsection