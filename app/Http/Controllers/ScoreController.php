<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    // ===== LIST + FILTER (GET) =====
    public function index(Request $request)
    {
        $classes = \App\Models\Classes::all();
        $subjects = Subject::all();

        $scores = collect(); // mặc định rỗng

        if ($request->class_id && $request->subject_id) {

            $scores = Score::with(['student', 'subject'])
                ->where('subject_id', $request->subject_id)
                ->whereHas('student', function ($q) use ($request) {
                    $q->where('class_id', $request->class_id);
                })
                ->latest()
                ->get();
        }

        return view('scores.index', compact('scores', 'classes', 'subjects'));
    }

    // ===== CREATE =====
    public function create(Request $request)
    {
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;

        // chỉ lấy sinh viên trong lớp đã chọn
        $students = Student::where('class_id', $class_id)->get();

        $subject = Subject::find($subject_id);

        return view('scores.create', compact('students', 'subject', 'class_id', 'subject_id'));
    }

    // ===== STORE =====
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                'unique:scores,student_id,NULL,id,subject_id,' . $request->subject_id . ',semester,' . $request->semester
            ],
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required',

            'chuyen_can' => 'nullable|numeric|min:0|max:10',
            'giua_ky' => 'nullable|numeric|min:0|max:10',
            'cuoi_ky' => 'nullable|numeric|min:0|max:10',
        ]);

        try {
            $tong_ket = $this->tinhTongKet($request);
            $xep_loai = $this->xepLoai($tong_ket);

            Score::create([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'semester' => $request->semester,
                'chuyen_can' => $request->chuyen_can,
                'giua_ky' => $request->giua_ky,
                'cuoi_ky' => $request->cuoi_ky,
                'tong_ket' => $tong_ket,
                'xep_loai' => $xep_loai
            ]);

            return redirect()->route('scores.index')
                ->with('success', 'Thêm điểm thành công');

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    // ===== EDIT (CHỈ SỬA 1 RECORD) =====
    public function edit($id)
    {
        $score = Score::findOrFail($id);
        $students = Student::all();
        $subjects = Subject::all();

        return view('scores.edit', compact('score', 'students', 'subjects'));
    }

    // ===== UPDATE =====
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                'unique:scores,student_id,' . $id . ',id,subject_id,' . $request->subject_id . ',semester,' . $request->semester
            ],
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required',

            'chuyen_can' => 'nullable|numeric|min:0|max:10',
            'giua_ky' => 'nullable|numeric|min:0|max:10',
            'cuoi_ky' => 'nullable|numeric|min:0|max:10',
        ]);

        try {
            $score = Score::findOrFail($id);

            $tong_ket = $this->tinhTongKet($request);
            $xep_loai = $this->xepLoai($tong_ket);

            $score->update([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'semester' => $request->semester,
                'chuyen_can' => $request->chuyen_can,
                'giua_ky' => $request->giua_ky,
                'cuoi_ky' => $request->cuoi_ky,
                'tong_ket' => $tong_ket,
                'xep_loai' => $xep_loai
            ]);

            return redirect()->route('scores.index')
                ->with('success', 'Cập nhật thành công');

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    // ===== DELETE =====
    public function destroy($id)
    {
        try {
            Score::destroy($id);

            return redirect()->route('scores.index')
                ->with('success', 'Xóa thành công');

        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa');
        }
    }

    // ===== STUDENT VIEW =====
    public function myScores()
    {
        $student = auth()->user()->student;

        $scores = \App\Models\Score::with('subject')
            ->where('student_id', $student->id)
            ->get();

        // ===== TÍNH GPA =====
        $totalCredits = 0;
        $totalPoint4 = 0;
        $totalPoint10 = 0;

        $retake = 0;
        $relearn = 0;
        $pending = 0;

        foreach ($scores as $s) {

            // nếu chưa có điểm thì bỏ qua
            if ($s->tong_ket === null) {
                $pending++;
                continue;
            }

            $credit = $s->subject->so_tin_chi ?? 0;

            // đổi sang thang 4
            $point4 = match ($s->xep_loai) {
                'A+' => 4,
                'A'  => 3.7,
                'B+' => 3.5,
                'B'  => 3,
                'C+' => 2.5,
                'C'  => 2,
                'D'  => 1,
                'F'  => 0,
                default => 0
            };

            // cộng dồn
            $totalCredits += $credit;
            $totalPoint4 += $point4 * $credit;
            $totalPoint10 += $s->tong_ket * $credit;

            // thống kê
            if ($s->xep_loai == 'F') $relearn++;
            if ($s->xep_loai == 'D') $retake++;
        }

        // tránh chia 0
        $gpa4 = $totalCredits ? round($totalPoint4 / $totalCredits, 2) : 0;
        $gpa10 = $totalCredits ? round($totalPoint10 / $totalCredits, 2) : 0;

        // xếp loại
        $rank = match (true) {
            $gpa4 >= 3.6 => 'Xuất sắc',
            $gpa4 >= 3.2 => 'Giỏi',
            $gpa4 >= 2.5 => 'Khá',
            $gpa4 >= 2.0 => 'Trung bình',
            default => 'Yếu'
        };

        return view('scores.my-scores', compact(
            'scores',
            'gpa4',
            'gpa10',
            'rank',
            'totalCredits',
            'retake',
            'relearn',
            'pending'
        ));
    }

    // ===== LOGIC =====
    private function tinhTongKet($r)
    {
        return round(
            ($r->chuyen_can ?? 0) * 0.1 +
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
}