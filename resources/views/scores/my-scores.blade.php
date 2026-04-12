@extends('layouts.app')

@section('content')

<h2>Điểm của tôi</h2>

<table border="1" width="100%">
    <tr>
        <th>Môn</th>
        <th>Học kỳ</th>
        <th>CC</th>
        <th>GK</th>
        <th>TH</th>
        <th>CK</th>
        <th>Tổng</th>
        <th>Xếp loại</th>
    </tr>

    @foreach($scores as $s)
    <tr>
        <td>{{ $s->subject->ten_mon }}</td>
        <td>{{ $s->semester }}</td>
        <td>{{ $s->chuyen_can }}</td>
        <td>{{ $s->giua_ky }}</td>
        <td>{{ $s->thuc_hanh }}</td>
        <td>{{ $s->cuoi_ky }}</td>
        <td><b>{{ $s->tong_ket }}</b></td>
        <td>{{ $s->xep_loai }}</td>
    </tr>
    @endforeach

</table>

@endsection