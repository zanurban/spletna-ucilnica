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

        $assignments = Assignment::where('subject_teacher_id', $subject_teacher_id)->get();

        /*$assignments = Assignment::leftJoin('assignment_students', 'assignments.id', '=', 'assignment_students.assignment_id')
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
            ->get();*/

        $userId = Auth::user()->id;

        /*$assignments = DB::table('assignment_students')
            ->rightJoin(DB::raw('(
        SELECT
            assignments.id,
            assignments.subject_teacher_id,
            assignments.assignment_title,
            assignments.assignment_description,
            assignments.completion_date,
            assignments.material_file_path
        FROM subject_students
        INNER JOIN subject_teachers ON subject_students.subject_teacher_id = subject_teachers.id
        INNER JOIN assignments ON subject_teachers.id = assignments.subject_teacher_id
        WHERE subject_students.student_id = ?
        AND subject_teachers.id = ?
    ) subQuery'), 'assignment_students.assignment_id', '=', 'subQuery.id')
            ->where(function ($query) use ($userId) {
                $query->where('assignment_students.student_id', '=', $userId)
                    ->orWhereNull('assignment_students.student_id');
            })
            ->select('assignment_students.*')
            ->distinct()
            ->get();


        return view('student.subject.material.listContent', [
            'title' => $subjectId->subject_name,
            'subjectId' => $subjectId->id,
            'materials' => Material::where('subject_teacher_id', $subject_teacher_id)->get(),
            'assignments' => $assignments,
        ]);*/

        /*$sql = "SELECT DISTINCT *
FROM assignment_students as as2
RIGHT JOIN (
    SELECT
        assignments.id,
        assignments.subject_teacher_id,
        assignments.assignment_title,
        assignments.assignment_description,
        assignments.completion_date,
        assignments.material_file_path
    FROM subject_students
    INNER JOIN subject_teachers ON subject_students.subject_teacher_id = subject_teachers.id
    INNER JOIN assignments ON subject_teachers.id = assignments.subject_teacher_id
    WHERE subject_students.student_id = :userId
    AND subject_teachers.id = :subjectTeacherId
) as subQuery
ON as2.assignment_id = subQuery.id
WHERE as2.student_id = :userId
OR as2.student_id IS NULL";

        $results = DB::select($sql, [
            'userId' => $userId,
            'subjectTeacherId' => $subject_teacher_id,
        ],
        true);
        */

        $results = DB::table('assignment_students')
            ->rightJoin(DB::raw('(
            SELECT
                assignments.id,
                assignments.subject_teacher_id,
                assignments.assignment_title,
                assignments.assignment_description,
                assignments.completion_date,
                assignments.material_file_path FROM subject_students'), function ($join){
                    $join->on('subject_students.subject_teacher_id', '=', 'subject_teacher_id')
                        ->where('subject_students.student_id', '=', Auth::user()->id);
                }), 'assignment_students.assignment_id', '=', 'subQuery.id')
            })
                });

        dd($results);




    }
}
