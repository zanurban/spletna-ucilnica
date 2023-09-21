<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Material;
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
    public function listMaterial(Request $request, Subject $subjectId){

        $subject_teacher_id = SubjectTeacher::where('subject_id', $subjectId->id)->first()->id;

        return view('student.subject.material.listClassroomContent', [
            'title' => $subjectId->subject_name,
            'subjectId' => $subjectId->id,
            'materials' => Material::where('subject_teacher_id', $subject_teacher_id)->get(),
        ]);

    }
}