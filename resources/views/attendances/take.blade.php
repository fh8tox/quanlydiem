@extends('layouts.app')

@section('content')

<h2>📋 Điểm danh - Buổi {{ $session->session_number }}</h2>

@if(session('success'))
    <div style="color:green">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ url('attendances/store') }}">
    @csrf

    <input type="hidden" name="session_id" value="{{ $session->id }}">

    <table border="1" cellpadding="10">
        <tr>
            <th>Tên sinh viên</th>
            <th>Có mặt</th>
            <th>Đi muộn</th>
            <th>Vắng</th>
        </tr>

        @foreach($students as $sv)
        <tr>
            <td>{{ $sv->name }}</td>

            <td>
                <input type="radio" 
                       name="attendance[{{ $sv->id }}]" 
                       value="1"
                       {{ isset($attendanceData[$sv->id]) && $attendanceData[$sv->id] == 1 ? 'checked' : '' }}>
            </td>

            <td>
                <input type="radio" 
                       name="attendance[{{ $sv->id }}]" 
                       value="2"
                       {{ isset($attendanceData[$sv->id]) && $attendanceData[$sv->id] == 2 ? 'checked' : '' }}>
            </td>

            <td>
                <input type="radio" 
                       name="attendance[{{ $sv->id }}]" 
                       value="0"
                       {{ isset($attendanceData[$sv->id]) && $attendanceData[$sv->id] == 0 ? 'checked' : '' }}>
            </td>
        </tr>
        @endforeach

    </table>

    <br>
    <button type="submit">💾 Lưu điểm danh</button>

</form>

@endsection