<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\SubjectStudent;
use App\Models\SubjectTeacher;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    public function list()
    {
        $students = User::where('users.role', 'usr')
            ->leftJoin('subject_students', 'users.id', '=', 'subject_students.student_id')
            ->leftJoin('subject_teachers', 'subject_students.subject_teacher_id', '=', 'subject_teachers.id')
            ->leftJoin('subjects', 'subject_teachers.subject_id', '=', 'subjects.id')
            ->select('users.*', 'subjects.subject_name as subject_name')
            ->get();

        $grouped = $students->groupBy('id')->map(function ($group) {
            return [
                'id' => $group[0]->id,
                'first_name' => $group[0]->first_name,
                'last_name' => $group[0]->last_name,
                'email' => $group[0]->email,
                'username' => $group[0]->username,
                'role' => $group[0]->role,
                // ... any other user fields you need
                'subjects' => $group->pluck('subject_name')->filter()->all(),
            ];
        });

        $result = $grouped->values()->all();
        
        return view('admin.student.list', [
            'title' => 'Prikaz učencev',
            'data' => $result,
        ]);
    }


    public function showForm(Request $request, User $studentId)
    {
        $subjectTeacherIds = SubjectStudent::where('student_id', $studentId->id)
            ->pluck('subject_teacher_id')
            ->toArray();

        $existingDataSubjectTeacher = SubjectTeacher::with(['subject', 'teacher'])->get();
        $currentSubjectTeacherIds = $subjectTeacherIds;

        return view('admin.student.edit', [
            'title' => 'Urejanje učenca',
            'formData' => $studentId,
            'existingDataSubjectTeacher' => $existingDataSubjectTeacher,
            'currentSubjectTeacherIds' => $currentSubjectTeacherIds,
        ]);
    }


    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:60'],
            'last_name' => ['required', 'max:60'],
            'email' => ['required', 'max:128', 'email'],
            'username' => ['required', 'max:128', 'unique:users'],
            'subjects' => ['required', 'array'],
            'role' => ['required', 'in:adm,tch,usr'],
        ]);

        $student = new User([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make('password' . $validatedData['username']),
            'username' => $validatedData['username'],
            'role' => $validatedData['role'],
        ]);
        $student->save();

        foreach ($request->subjects as $subjectTeacherId) {
            SubjectStudent::create([
                'subject_teacher_id' => $subjectTeacherId,
                'student_id' => $student->id,
            ]);
        }

        return redirect()->route('student.list')->with('message', 'Učenec je bil uspešno shranjen!');
    }

    public function update(Request $request, User $studentId)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:60'],
            'last_name' => ['required', 'max:60'],
            'email' => ['required', 'max:128'],
            'subjects' => ['required', 'array'],
            'role' => ['required', 'in:adm,tch,usr'],
        ]);

        $studentId->update($validatedData);

        $currentSubjectTeacherIds = SubjectStudent::where('student_id', $studentId->id)
            ->pluck('subject_teacher_id')
            ->toArray();

        $subjectTeacherIdsToAdd = array_diff($request->subjects, $currentSubjectTeacherIds);
        $subjectTeacherIdsToDelete = array_diff($currentSubjectTeacherIds, $request->subjects);

        foreach ($subjectTeacherIdsToAdd as $subjectTeacherId) {
            SubjectStudent::create([
                'subject_teacher_id' => $subjectTeacherId,
                'student_id' => $studentId->id,
            ]);
        }

        SubjectStudent::where('student_id', $studentId->id)
            ->whereIn('subject_teacher_id', $subjectTeacherIdsToDelete)
            ->delete();

        return redirect()->route('student.list')->with('message', 'Učenec je bil uspešno urejen!');
    }

    public function delete(Request $request, User $studentId)
    {
        $studentId->delete();

        return redirect()->route('student.list')->with('message', 'Učenec je bil uspešno izbrisan!');
    }
}