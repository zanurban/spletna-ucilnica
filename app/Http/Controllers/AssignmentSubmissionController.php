<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\AssignmentStudent;
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AssignmentSubmissionController extends Controller
{
    public function showAssigment(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        return view('student.subject.material.editAssigment', [
            'title' => 'Urejanje naloge',
            'subjectId' => $subjectId->id,
            'formData' => $assignmentId,
        ]);
    }

    public function submit(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        date_default_timezone_set('Europe/Ljubljana');

        $validatedData = $request->validate([
            'assignment_student_comment' => ['max:512'],
            'file' => [ 'file', 'max:4096', 'required'],
        ]);

        $assignment = new AssignmentStudent([
            'assignment_id' => $assignmentId->id,
            'student_id' => Auth::user()?->id,
            'date_of_submission' => date('Y-m-d H:i:s', time()),
            'assignment_student_comment' => $validatedData['assignment_student_comment'] ?? '',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filepath = 'public/studentAssignments/'. $assignmentId->id . '/'. Auth::user()?->id . '/';
            $filename = Auth::user()?->last_name. ' ' . Auth::user()?->first_name . ' - ' . $assignmentId->assignment_title . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $file->storeAs($filepath, $filename);

            $assignment->save();

            return redirect()->route('subject.listMaterial', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bilo uspešno shranjena z datoteko!');
        }

        return redirect()->route('subject.listMaterial', ['subjectId' => $subjectId?->id])->with('message', 'Naloga je bila uspešno shranjena brez datoteke!');
    }

    public function resubmit(Request $request, Subject $subjectId, AssignmentStudent $assignmentId)
    {
        $validatedData = $request->validate([

            'assignment_description' => ['max:512'],
            'completion_date' => ['required', 'date', 'after:today'],
            'file' => [ 'file', 'max:4096'],
        ]);

        Storage::delete($assignmentId->material_file_path);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/studentAssignments/'.$assignmentId.'/'.$userId);
        }

        $assignmentId->update([
            'assignment_title' => $validatedData['assignment_title'],
            'assignment_description' => $validatedData['assignment_description'],
            'completion_date' => $validatedData['completion_date'],
            'material_file_path' => $path ?? '',
        ]);

        return redirect()->route('subject.listMaterial', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bil uspešno urejena!');
    }

    public function delete(Request $request, Subject $subjectId, AssignmentStudent $assignmentId)
    {
        $assignmentId->delete();

        return redirect()->route('subject.listMaterial', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bila uspešno izbrisana!');
    }
}
