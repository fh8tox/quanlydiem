@extends('layouts.app')

@section('content')

<h2>📋 Điểm danh - Buổi {{ $session->session_number }}</h2>

@if(session('success'))
    <div style="color:green">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ url('attendances/store') }}">
    @csrf

    <input type="hidden" name="session_id" value="{{ $session->id }}">

    <div style="margin-bottom:15px">

        <a href="{{ url('attendances/sessions/'.$session->courseClass->id) }}"
        class="btn btn-primary px-4">

            <span style="font-size:18px;">←</span>
            Quay lại

        </a>

        <button type="button"
                class="btn btn-success"
                onclick="selectAll(1)">
            ✅ Có mặt tất cả
        </button>

        <button type="button"
                class="btn btn-warning"
                onclick="selectAll(2)">
            ⏰ Đi muộn tất cả
        </button>

        <button type="button"
                class="btn btn-danger"
                onclick="selectAll(0)">
            ❌ Vắng tất cả
        </button>

        <button type="submit" class="btn btn-primary">
            💾 Lưu điểm danh
        </button>

    </div>

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

    

</form>

<script>

function selectAll(status){

    let radios=document.querySelectorAll(
        'input[type="radio"][value="'+status+'"]'
    );

    radios.forEach(radio=>{
        radio.checked=true;
    });

}

</script>

@endsection