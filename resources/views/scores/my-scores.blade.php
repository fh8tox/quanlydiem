@extends('layouts.app')

@section('content')

<h2>📊 Điểm của tôi</h2>

{{-- ===== GPA BOX ===== --}}
<div class="card" style="margin-bottom:20px">

    <div style="display:flex; flex-wrap:wrap; gap:25px">

        <div>
            <b>TBC tích luỹ (thang 4):</b><br>
            <span style="font-size:20px; color:#3498db">
                {{ $gpa4 ?? 0 }}
            </span>
        </div>

        <div>
            <b>Xếp hạng học lực:</b><br>
            <span style="color:green; font-weight:bold">
                {{ $rank ?? '---' }}
            </span>
        </div>

        <div>
            <b>Số tín chỉ tích luỹ:</b><br>
            {{ $totalCredits ?? 0 }}
        </div>

        <div>
            <b>TBC học tập (thang 10):</b><br>
            {{ $gpa10 ?? 0 }}
        </div>

        <div>
            <b>Số môn học lại:</b><br>
            <span style="color:red">{{ $relearn ?? 0 }}</span>
        </div>

    </div>
</div>


{{-- ===== TABLE ===== --}}
<div class="card">

<table>
    <tr>
        <th>Môn học</th>
        <th>Lớp TC</th>
        <th>HK</th>
        <th>CC</th>
        <th>GK</th>
        <th>CK</th>
        <th>Tổng</th>
        <th>Xếp loại</th>
    </tr>

    @forelse($scores as $s)
    <tr>
        {{-- MÔN --}}
        <td>
            {{ $s->subject->ten_mon ?? '---' }}
        </td>

        {{-- LỚP TÍN CHỈ --}}
        <td>
            {{ $s->courseClass->name ?? '---' }}
        </td>

        <td>{{ $s->semester }}</td>

        <td>{{ $s->chuyen_can ?? '-' }}</td>
        <td>{{ $s->giua_ky ?? '-' }}</td>
        <td>{{ $s->cuoi_ky ?? '-' }}</td>

        <td>
            <b>{{ $s->tong_ket ?? '-' }}</b>
        </td>

        <td>
            @if(in_array($s->xep_loai, ['A+', 'A']))
                <span style="color:green; font-weight:bold">
                    {{ $s->xep_loai }}
                </span>

            @elseif(in_array($s->xep_loai, ['D', 'F']))
                <span style="color:red; font-weight:bold">
                    {{ $s->xep_loai }}
                </span>

            @elseif($s->xep_loai)
                {{ $s->xep_loai }}

            @else
                <span style="color:gray">Chưa có</span>
            @endif
        </td>
    </tr>

    @empty
    <tr>
        <td colspan="8" style="text-align:center">
            Chưa có điểm
        </td>
    </tr>
    @endforelse

</table>

</div>

@endsection