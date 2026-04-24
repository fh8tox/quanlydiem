<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\CourseClass;
use App\Models\Session;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Score;

class AttendanceController extends Controller
{
    // 1. Trang chọn môn → lớp học
    public function index()
    {
        $subjects = Subject::with('courseClasses')->get();
        return view('attendances.index', compact('subjects'));
    }

    // 2. Danh sách lớp theo môn
    public function classes($subjectId)
    {
        $subject = Subject::with('courseClasses')->findOrFail($subjectId);
        return view('attendances.classes', compact('subject'));
    }

    // 3. Danh sách buổi học
    public function sessions($courseClassId)
    {
        $courseClass = CourseClass::with('sessions')->findOrFail($courseClassId);
        return view('attendances.sessions', compact('courseClass'));
    }

    // 4. Điểm danh
    public function take($sessionId)
    {
        $session = Session::with([
            'courseClass.students',
            'attendances'
        ])->findOrFail($sessionId);

        $students = $session->courseClass->students;

        $attendanceData = $session->attendances
            ->pluck('status', 'student_id')
            ->toArray();

        return view('attendances.take', compact('session', 'students', 'attendanceData'));
    }

    // 5. Lưu điểm danh + UPDATE ĐIỂM
    public function store(Request $request)
    {
        $session = Session::with('courseClass.students')
            ->findOrFail($request->session_id);

        $students = $session->courseClass->students;

        foreach ($students as $sv) {

            $status = $request->attendance[$sv->id] ?? 0;

            // ===== LƯU ĐIỂM DANH =====
            Attendance::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'student_id' => $sv->id
                ],
                [
                    'status' => $status
                ]
            );

            // ===== UPDATE ĐIỂM =====
            $this->updateScore($sv->id, $session->course_class_id);
        }

        return back()->with('success', 'Đã lưu điểm danh & cập nhật điểm');
    }

    // =====================================================
    // 🔥 LOGIC TÍNH ĐIỂM (VIẾT NGAY TRONG CONTROLLER)
    // =====================================================

    private function updateScore($studentId, $courseClassId)
    {
        $score = Score::where('student_id', $studentId)
            ->where('course_class_id', $courseClassId)
            ->first();

        if (!$score) return;

        $chuyen_can = $this->tinhChuyenCan($studentId, $courseClassId);

        $tong_ket = $this->tinhTongKet(
            $chuyen_can,
            $score->giua_ky,
            $score->cuoi_ky
        );

        $score->update([
            'chuyen_can' => $chuyen_can,
            'tong_ket' => $tong_ket,
            'xep_loai' => $this->xepLoai($tong_ket)
        ]);
    }

    private function tinhChuyenCan($studentId, $courseClassId)
    {
        $sessions = Session::where('course_class_id', $courseClassId)->get();

        $totalSessions = $sessions->count();
        if ($totalSessions == 0) return 0;

        $attendances = Attendance::where('student_id', $studentId)
            ->whereIn('session_id', $sessions->pluck('id'))
            ->get();

        $totalPoint = 0;

        foreach ($attendances as $a) {
            if ($a->status == 1) $totalPoint += 1;
            elseif ($a->status == 2) $totalPoint += 0.5;
        }

        return round(($totalPoint / $totalSessions) * 10, 2);
    }

    private function tinhTongKet($chuyen_can, $giua_ky, $cuoi_ky)
    {
        return round(
            $chuyen_can * 0.1 +
            ($giua_ky ?? 0) * 0.2 +
            ($cuoi_ky ?? 0) * 0.7,
        2);
    }

    private function xepLoai($tk)
    {
        if ($tk >= 9.0) return 'A+';
        if ($tk >= 8.5) return 'A';
        if ($tk >= 8.0) return 'B+';
        if ($tk >= 7.0) return 'B';
        if ($tk >= 6.5) return 'C+';
        if ($tk >= 5.5) return 'C';
        if ($tk >= 5.0) return 'D+';
        if ($tk >= 4.0) return 'D';
        return 'F';
    }
}