<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
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
            ->select('subject_teachers.id AS subject_teacher_id', 'subjects.subject_name', 'subjects.id as subject_id', 'teachers.first_name as teacher_first_name', 'teachers.last_name as teacher_last_name')
            ->get()
            ->filter(function ($item) {
                return $item->subject_name !== null && $item->subject_id !== null;
            });

        return view('student.subject.listSubjects', [
            'title' => 'Prikaz predmetov',
            'data' => $subjects,
        ]);

    }

    public function listMaterial(Request $request, SubjectTeacher $subjectTeacherId)
    {
        $studentId = Auth::user()->id;

        $assignments = Assignment::query()
            ->select(['assignments.*', 'asub.student_id AS submitted_student_id', 'asub.date_of_submission', 'asub.assignment_student_comment'])
            ->leftJoin('assignment_students AS asub', function (Builder $join) {
                $join->on('assignments.id', '=', 'asub.assignment_id');
                $join->where('asub.student_id', '=', Auth::user()->id);
            })
            ->where('assignments.subject_teacher_id', '=', $subjectTeacherId->id)
            ->get();

        return view('student.subject.material.listContent', [
            'title' => Subject::where('id', $subjectTeacherId->subject_id)->get()->first()->subject_name,
            'subjectTeacherId' => $subjectTeacherId->id,
            'materials' => Material::where('subject_teacher_id', $subjectTeacherId->id)->get(),
            'assignments' => $assignments,
        ]);
    }
}
