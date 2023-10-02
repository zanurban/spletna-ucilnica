<?php

namespace App\Http\Controllers;

use App\Models\SubjectTeacher;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\AssignmentStudent;
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AssignmentSubmissionController extends Controller
{
    public function showAssigment(Request $request, SubjectTeacher $subjectTeacherId, Assignment $assignmentId)
    {
        $formData = Assignment::select('assignments.id AS id', 'assignment_description', 'assignments.subject_teacher_id', 'assignments.assignment_title', 'assignments.completion_date', 'assignments.material_file_path', 'assignment_students.id AS assignment_student_id', 'assignment_students.assignment_id', 'assignment_students.student_id', 'assignment_students.date_of_submission', 'assignment_students.assignment_student_comment')
            ->leftJoin('assignment_students', function (Builder $join) {
                $join->on('assignments.id', '=', 'assignment_students.assignment_id');
                $join->where('assignment_students.student_id', '=', Auth::user()->id);
            })
            ->where('assignments.id', '=', $assignmentId->id)
            ->get()
            ->first();

        if ($formData === null) {
            $formData = $assignmentId;
        }

        return view('student.subject.material.editAssigment', [
            'title' => 'Urejanje naloge',
            'subjectTeacherId' => $subjectTeacherId->id,
            'formData' => $formData,
        ]);
    }

    public function submit(Request $request, SubjectTeacher $subjectTeacherId, Assignment $assignmentId)
    {
        date_default_timezone_set('Europe/Ljubljana');

        $validatedData = $request->validate([
            'assignment_student_comment' => ['max:512'],
            'file' => [ 'file', 'max:4096',],
        ]);

        $filepath = 'public/studentAssignments/'. $assignmentId->id . '/'. Auth::user()?->id . '/';
        if ($request->hasFile('file') && Storage::files($filepath) !== []) {
            $assignment_student = AssignmentStudent::where('assignment_id', '=', $assignmentId->id)
            ->where('student_id', '=', Auth::user()?->id)
            ->get()
            ->first();
            Storage::delete(Storage::files($filepath));
            $file = $request->file('file');
            $filename = Auth::user()?->last_name. ' ' . Auth::user()?->first_name . ' - ' . $assignmentId->assignment_title . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $file->storeAs($filepath, $filename);
            $assignment_student->update([
                'assignment_student_comment' => $validatedData['assignment_student_comment'],
                'date_of_submission' => date('Y-m-d H:i:s', time()),
            ]);
        }
        else if(Storage::files($filepath) !== []){
            $assignment_student = AssignmentStudent::where('assignment_id', '=', $assignmentId->id)
            ->where('student_id', '=', Auth::user()?->id)
            ->get()
            ->first();
            $assignment_student->update([
                'assignment_student_comment' => $validatedData['assignment_student_comment'],
                'date_of_submission' => date('Y-m-d H:i:s', time()),
            ]);
        }
        else if($request->hasFile('file')){
            $assignment = new AssignmentStudent([
                'assignment_id' => $assignmentId->id,
                'student_id' => Auth::user()?->id,
                'date_of_submission' => date('Y-m-d H:i:s', time()),
                'assignment_student_comment' => $validatedData['assignment_student_comment'] ?? '',
            ]);
            $file = $request->file('file');
            $filepath = 'public/studentAssignments/'. $assignmentId->id . '/'. Auth::user()?->id . '/';
            $filename = Auth::user()?->last_name. ' ' . Auth::user()?->first_name . ' - ' . $assignmentId->assignment_title . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $file->storeAs($filepath, $filename);

            $assignment->save();

            return redirect()->route('subjectList.listMaterial', ['subjectTeacherId' => $subjectTeacherId->id])->with('message', 'Naloga je bilo uspešno shranjena z datoteko!');
        }
        else{
            return redirect()->route('assignment_student.show', ['subjectTeacherId' => $subjectTeacherId->id,'assignmentId' => $assignmentId->id])->with('error', 'Naloga mora imeti tudi oddano datoteko!');
        }

        return redirect()->route('subjectList.listMaterial', ['subjectTeacherId' => $subjectTeacherId?->id])->with('message', 'Naloga je bila uspešno posodobljena!');
    }

    public function delete(Request $request, SubjectTeacher $subjectTeacherId, Assignment $assignmentId)
    {
        $assignment_student = AssignmentStudent::where('assignment_id', '=', $assignmentId->id)
            ->where('student_id', '=', Auth::user()?->id)
            ->get()
            ->first();

        $filepath = 'public/studentAssignments/'. $assignmentId->id . '/'. Auth::user()?->id . '/';
        Storage::delete(Storage::files($filepath));

        $assignment_student->delete();

        return redirect()->route('subjectList.listMaterial', ['subjectTeacherId' => $subjectTeacherId->id])->with('message', 'Oddaja je bila uspešno izbrisana!');
    }
}
