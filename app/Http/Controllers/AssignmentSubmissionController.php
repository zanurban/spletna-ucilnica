<?php

namespace App\Http\Controllers;

use Auth;
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

    public function save(Request $request, Subject $subjectId, AssignmentStudent $assignmentId)
    {
        $validatedData = $request->validate([
            'assignment_description' => ['max:512'],
            'completion_date' => ['required', 'date', 'after:today'],
            'file' => [ 'file', 'max:4096', 'required'],
        ]);
        $userId = User::where('id', Auth::user()->id)->select('id');
        $assignment = new AssignmentStudent([
            'assigment_id' => $assignmentId->id,
            'assignment_description' => $validatedData['assignment_description'],
            'completion_date' => $validatedData['completion_date'],
            'student_id' => (string)$userId,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/studentAssignments/'.$assignmentId.'/'.$userId);

            $assignment->material_file_path = $path;
            $assignment->save();

            return redirect()->route('subject.listMaterial', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bilo uspešno shranjena z datoteko!');
        }

        $assignment->material_file_path = '';
        $assignment->save();

        return redirect()->route('subject.listMaterial', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bila uspešno shranjena brez datoteke!');
    }

    public function update(Request $request, Subject $subjectId, AssignmentStudent $assignmentId)
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
