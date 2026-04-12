<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function index()
    {
        $scores = Score::with(['student', 'subject'])->latest()->get();
        return view('scores.index', compact('scores'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('scores.create', compact('students', 'subjects'));
    }

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
            'thuc_hanh' => 'nullable|numeric|min:0|max:10',
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
                'thuc_hanh' => $request->thuc_hanh,
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

    public function edit($id)
    {
        $score = Score::findOrFail($id);
        $students = Student::all();
        $subjects = Subject::all();

        return view('scores.edit', compact('score', 'students', 'subjects'));
    }

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
            'thuc_hanh' => 'nullable|numeric|min:0|max:10',
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
                'thuc_hanh' => $request->thuc_hanh,
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

    // ================== STUDENT VIEW ==================
    public function myScores()
        {
            $user = Auth::user(); // ✅ dùng Auth

            if (!$user) {
                return redirect('/login');
            }

            $student = Student::where('user_id', $user->id)->first();

            if (!$student) {
                return back()->with('error', 'Không tìm thấy sinh viên');
            }

            $scores = Score::with('subject')
                ->where('student_id', $student->id)
                ->get();

            return view('scores.my-scores', compact('scores'));
        }

    // ================== LOGIC ==================

    private function tinhTongKet($r)
    {
        return round(
            ($r->chuyen_can ?? 0) * 0.1 +
            ($r->giua_ky ?? 0) * 0.2 +
            ($r->thuc_hanh ?? 0) * 0.2 +
            ($r->cuoi_ky ?? 0) * 0.5
        , 2);
    }

    private function xepLoai($tk)
    {
        if ($tk >= 8.5) return 'A';
        if ($tk >= 7) return 'B';
        if ($tk >= 5.5) return 'C';
        if ($tk >= 4) return 'D';
        return 'F';
    }
}