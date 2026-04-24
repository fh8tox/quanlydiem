<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Score;
use App\Models\Session;
use App\Models\Attendance;
use App\Models\CourseClass;
use App\Models\Student;

class ScoreController extends Controller
{
    // ===== LIST (ADMIN / TEACHER) =====
    public function index(Request $request)
    {
        $courseClasses = CourseClass::with('subject')->get();

        $scores = Score::with(['student', 'subject', 'courseClass'])
            ->when($request->course_class_id, function ($q) use ($request) {
                $q->where('course_class_id', $request->course_class_id);
            })
            ->when($request->subject_id, function ($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            })
            ->get();

        return view('scores.index', compact('scores', 'courseClasses'));
    }

    // ===== CREATE =====
    public function create(Request $request)
    {
        $courseClass = CourseClass::with('students', 'subject')
            ->findOrFail($request->course_class_id);

        $students = $courseClass->students;

        return view('scores.create', compact('courseClass', 'students'));
    }

    // ===== STORE =====
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                'unique:scores,student_id,NULL,id,course_class_id,' 
                . $request->course_class_id . ',semester,' . $request->semester
            ],
            'course_class_id' => 'required|exists:course_classes,id',
            'semester' => 'required',
            'giua_ky' => 'nullable|numeric|min:0|max:10',
            'cuoi_ky' => 'nullable|numeric|min:0|max:10',
        ]);

        try {
            $courseClass = CourseClass::findOrFail($request->course_class_id);

            $chuyen_can = $this->tinhChuyenCan(
                $request->student_id,
                $request->course_class_id
            );

            $tong_ket = $this->tinhTongKet($chuyen_can, $request);
            $xep_loai = $this->xepLoai($tong_ket);

            Score::create([
                'student_id' => $request->student_id,
                'course_class_id' => $request->course_class_id,
                'subject_id' => $courseClass->subject_id,
                'semester' => $request->semester,
                'chuyen_can' => $chuyen_can,
                'giua_ky' => $request->giua_ky,
                'cuoi_ky' => $request->cuoi_ky,
                'tong_ket' => $tong_ket,
                'xep_loai' => $xep_loai
            ]);

            return redirect()->route('scores.index', [
                'course_class_id' => $request->course_class_id
            ])->with('success', 'Thêm điểm thành công');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ===== EDIT =====
    public function edit($id)
    {
        $score = Score::findOrFail($id);

        $courseClass = CourseClass::with('students', 'subject')
            ->findOrFail($score->course_class_id);

        $students = $courseClass->students;

        return view('scores.edit', compact('score', 'students', 'courseClass'));
    }

    // ===== UPDATE =====
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                'unique:scores,student_id,' . $id . ',id,course_class_id,' 
                . $request->course_class_id . ',semester,' . $request->semester
            ],
            'course_class_id' => 'required|exists:course_classes,id',
            'semester' => 'required',
            'giua_ky' => 'nullable|numeric|min:0|max:10',
            'cuoi_ky' => 'nullable|numeric|min:0|max:10',
        ]);

        try {
            $score = Score::findOrFail($id);
            $courseClass = CourseClass::findOrFail($request->course_class_id);

            $chuyen_can = $this->tinhChuyenCan(
                $request->student_id,
                $request->course_class_id
            );

            $tong_ket = $this->tinhTongKet($chuyen_can, $request);
            $xep_loai = $this->xepLoai($tong_ket);

            $score->update([
                'student_id' => $request->student_id,
                'course_class_id' => $request->course_class_id,
                'subject_id' => $courseClass->subject_id,
                'semester' => $request->semester,
                'chuyen_can' => $chuyen_can,
                'giua_ky' => $request->giua_ky,
                'cuoi_ky' => $request->cuoi_ky,
                'tong_ket' => $tong_ket,
                'xep_loai' => $xep_loai
            ]);

            return redirect()->route('scores.index', [
                'course_class_id' => $request->course_class_id
            ])->with('success', 'Cập nhật thành công');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ===== DELETE =====
    public function destroy($id)
    {
        Score::destroy($id);
        return back()->with('success', 'Đã xoá');
    }

    // =====================================================
    // ===== STUDENT VIEW =====
    // =====================================================

    public function myScores()
    {
        $student = auth()->user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'Không tìm thấy sinh viên');
        }

        $scores = Score::with('subject')
            ->where('student_id', $student->id)
            ->get();

        // ===== TÍNH GPA =====
        $totalCredits = 0;
        $totalPoint4 = 0;
        $totalPoint10 = 0;
        $relearn = 0;

        foreach ($scores as $s) {
            if (!$s->subject) continue;

            $credits = $s->subject->so_tin_chi ?? 0;

            // quy đổi hệ 4
            $point4 = $this->convertTo4($s->tong_ket);

            if ($s->tong_ket < 4) $relearn++;

            $totalCredits += $credits;
            $totalPoint4 += $point4 * $credits;
            $totalPoint10 += ($s->tong_ket ?? 0) * $credits;
        }

        $gpa4 = $totalCredits ? round($totalPoint4 / $totalCredits, 2) : 0;
        $gpa10 = $totalCredits ? round($totalPoint10 / $totalCredits, 2) : 0;

        // xếp loại học lực
        $rank = $this->rankGPA($gpa4);

        return view('scores.my-scores', compact(
            'scores',
            'gpa4',
            'gpa10',
            'rank',
            'totalCredits',
            'relearn'
        ));
    }

    // =====================================================
    // ===== LOGIC =====
    // =====================================================

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

    private function tinhTongKet($chuyen_can, $r)
    {
        return round(
            $chuyen_can * 0.1 +
            ($r->giua_ky ?? 0) * 0.2 +
            ($r->cuoi_ky ?? 0) * 0.7
        , 2);
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

    private function convertTo4($tk)
    {
        if ($tk >= 9) return 4.0;
        if ($tk >= 8.5) return 3.7;
        if ($tk >= 8) return 3.5;
        if ($tk >= 7) return 3.0;
        if ($tk >= 6.5) return 2.5;
        if ($tk >= 5.5) return 2.0;
        if ($tk >= 5) return 1.5;
        if ($tk >= 4) return 1.0;
        return 0;
    }

    // ===== XẾP LOẠI GPA =====
    private function rankGPA($gpa)
    {
        if ($gpa >= 3.6) return 'Xuất sắc';
        if ($gpa >= 3.2) return 'Giỏi';
        if ($gpa >= 2.5) return 'Khá';
        if ($gpa >= 2.0) return 'Trung bình';
        return 'Yếu';
    }

}