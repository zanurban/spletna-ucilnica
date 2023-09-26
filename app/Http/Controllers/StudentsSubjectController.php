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
        $userId = Auth::user()->id;
        // Assuming $subjectTeacherId is an Eloquent model

        /*$assignmentsCombined = DB::table('assignments')
            ->leftJoin('assignment_students', 'assignments.id', '=', 'assignment_students.assignment_id')
            ->where('assignments.subject_teacher_id', $subjectTeacherId->id)
            ->where(function ($query) use ($userId) {
                $query->whereNull('assignment_students.id')
                    ->orWhere('assignment_students.student_id', $userId);
            })
            ->select('assignments.id',
                'assignments.subject_teacher_id',
                'assignments.assignment_title',
                'assignments.assignment_description',
                'assignments.completion_date',
                'assignments.material_file_path',
                'assignment_students.date_of_submission',
                'assignment_students.assignment_student_comment',)
            ->distinct()
            ->get();*/

        $assignmentsWithoutSubmissions = DB::table('assignments')
            ->leftJoin('assignment_students', 'assignments.id', '=', 'assignment_students.assignment_id')
            ->whereNull('assignment_students.id')
            ->where('assignments.subject_teacher_id', $subjectTeacherId->id)
            ->select('assignments.id',
                'assignments.subject_teacher_id',
                'assignments.assignment_title',
                'assignments.assignment_description',
                'assignments.completion_date',
                'assignments.material_file_path',
                'assignment_students.date_of_submission',
                'assignment_students.assignment_student_comment',
                'assignment_students.id AS assignment_student_id',)
            ->get();

        $assignmentsWithSubmissions = DB::table('assignments')
            ->join('assignment_students', function ($join) use ($subjectTeacherId, $userId) {
                $join->on('assignments.id', '=', 'assignment_students.assignment_id')
                    ->where('assignments.subject_teacher_id', $subjectTeacherId->id)
                    ->where('assignment_students.student_id', $userId);
            })
            ->select('assignments.id',
                'assignments.subject_teacher_id',
                'assignments.assignment_title',
                'assignments.assignment_description',
                'assignments.completion_date',
                'assignments.material_file_path',
                'assignment_students.date_of_submission',
                'assignment_students.assignment_student_comment',
                'assignment_students.id AS assignment_student_id',)
            ->get();


        return view('student.subject.material.listContent', [
            'title' => Subject::where('id', $subjectTeacherId->subject_id)->get()->first()->subject_name,
            'subjectTeacherId' => $subjectTeacherId->id,
            'materials' => Material::where('subject_teacher_id', $subjectTeacherId->id)->get(),
            'assignmentsWithoutSubmission' => $assignmentsWithoutSubmissions,
            'assignmentsWithSubmission' => $assignmentsWithSubmissions,
        ]);
    }
}
