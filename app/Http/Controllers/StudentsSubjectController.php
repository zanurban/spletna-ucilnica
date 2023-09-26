<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\SubjectTeacher;
use Illuminate\Support\Facades\DB;

class StudentsSubjectController extends Controller
{
    public function list()
    {
        $subjects = User::where('users.id', Auth::user()->id)
            ->leftJoin('subject_students', 'users.id', '=', 'subject_students.student_id')
            ->leftJoin('subject_teachers', 'subject_students.subject_teacher_id', '=', 'subject_teachers.id')
            ->leftJoin('subjects', 'subject_teachers.subject_id', '=', 'subjects.id')
            ->leftJoin('users as teachers', 'subject_teachers.teacher_id', '=', 'teachers.id')
            ->select('subjects.subject_name', 'subjects.id as subject_id', 'teachers.first_name as teacher_first_name', 'teachers.last_name as teacher_last_name')
            ->get()
            ->filter(function ($item) {
                return $item->subject_name !== null && $item->subject_id !== null;
            });

        return view('student.subject.listSubjects', [
            'title' => 'Prikaz predmetov',
            'data' => $subjects,
        ]);

    }

    public function listMaterial(Request $request, Subject $subjectId)
    {
        $subject_teacher_id = SubjectTeacher::where('subject_id', $subjectId->id)->first()->id;

        $userId = Auth::user()->id;

        $firstTable = DB::table('subject_students')
            ->join('subject_teachers', 'subject_students.subject_teacher_id', '=', 'subject_teachers.id')
            ->join('assignments', 'subject_teachers.id', '=', 'assignments.subject_teacher_id')
            ->select(
                'assignments.id',
                'assignments.subject_teacher_id',
                'assignments.assignment_title',
                'assignments.assignment_description',
                'assignments.completion_date',
                'assignments.material_file_path'
            )
            ->where('subject_students.student_id', $userId)
            ->where('subject_teachers.id', $subject_teacher_id);

        $assignments = DB::table('assignment_students')
            ->rightJoinSub($firstTable, 'subQuery', function ($join) {
                $join->on('assignment_students.assignment_id', '=', 'subQuery.id');
            })
            ->select('*')
            ->where('assignment_students.student_id', $userId)
            ->orWhereNull('assignment_students.student_id')
            ->distinct()
            ->get();

        return view('student.subject.material.listContent', [
            'title' => $subjectId->subject_name,
            'subjectId' => $subjectId->id,
            'materials' => Material::where('subject_teacher_id', $subject_teacher_id)->get(),
            'assignments' => $assignments,
        ]);
    }
}
