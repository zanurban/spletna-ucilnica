<?php

namespace App\Http\Controllers;

use App\Models\SubjectStudent;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\SubjectTeacher;
use Illuminate\Support\Facades\Hash;

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


        $assignments = Assignment::leftJoin('assignment_students', 'assignments.id', '=', 'assignment_students.assignment_id')
            ->where('subject_teacher_id', '=', $subject_teacher_id)
            ->select([
                'assignments.id',
                'assignments.subject_teacher_id',
                'assignments.assignment_title',
                'assignments.completion_date',
                'assignments.material_file_path',
                'assignment_students.id AS assignment_student_id',
                'assignment_students.assignment_id',
                'assignment_students.student_id',
                'assignment_students.date_of_submission',
                'assignment_students.assignment_student_comment',
            ])
            ->get();

        return view('student.subject.material.listContent', [
            'title' => $subjectId->subject_name,
            'subjectId' => $subjectId->id,
            'materials' => Material::where('subject_teacher_id', $subject_teacher_id)->get(),
            'assignments' => $assignments,
        ]);

    }
    public function listClasses()
    {
        $subjects = Subject::leftJoin('subject_teachers', 'subjects.id', '=', 'subject_teachers.subject_id')
            ->leftJoin('users', 'subject_teachers.teacher_id', '=', 'users.id')
            ->select('subjects.subject_name', 'subjects.id as subject_id', 'users.first_name as teacher_first_name', 'users.last_name as teacher_last_name','subject_teachers.id as id')
            ->get();
        $subjects_joined = User::where('users.id', Auth::user()->id)
            ->leftJoin('subject_students', 'users.id', '=', 'subject_students.student_id')
            ->leftJoin('subject_teachers', 'subject_students.subject_teacher_id', '=', 'subject_teachers.id')
            ->select('subject_id as subject_id')
            ->get();
        return view('student.subjects.listSubjects', [
            'title' => 'Prikaz predmetov',
            'data' => $subjects,
            'data_joined' => $subjects_joined->pluck('subject_id')->toArray(),
        ]);
    }
    public function joinSubject(Request $request, SubjectTeacher $teacherSubjectId)
    {
        $Subjectstudent = new SubjectStudent([
            'student_id' => Auth::user()->id,
            'subject_teacher_id' => SubjectTeacher::where('id', $teacherSubjectId->id)->get()->first()->id,
        ]);
        $Subjectstudent->save();
        return redirect()->route('subject_classrooms.list');
    }
    public function deleteSubject(Request $request, SubjectTeacher $teacherSubjectId){
        SubjectStudent::where('student_id', Auth::user()->id)->where('subject_teacher_id', $teacherSubjectId->id)->delete();
        return redirect()->route('subject_classrooms.list');
    }

}