<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AssignmentsController extends Controller
{
    public function showForm(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        return view('teacher.assignment.edit', [
            'title' => 'Urejanje naloge',
            'subjectId' => $subjectId->id,
            'formData' => $assignmentId,
        ]);
    }

    public function save(Request $request, Subject $subjectId)
    {
        $validatedData = $request->validate([
            'assignment_title' => ['required', 'max:60'],
            'assignment_description' => ['max:512'],
            'completion_date' => ['required', 'date', 'after:today'],
            'file' => ['file', 'max:4096'],
        ]);

        $assignment = new Assignment([
            'assignment_title' => $validatedData['assignment_title'],
            'assignment_description' => $validatedData['assignment_description'],
            'completion_date' => $validatedData['completion_date'],
            'subject_teacher_id' => (string)DB::table('subject_teachers')
                ->where('teacher_id', Auth::user()->id)
                ->where('subject_id', $subjectId->id)->select('id')->first()->id,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/assignments');

            $assignment->material_file_path = $path;
            $assignment->save();

            return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bilo uspešno shranjena z datoteko!');
        }

        $assignment->material_file_path = '';
        $assignment->save();

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bila uspešno shranjena brez datoteke!');
    }

    public function update(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        $validatedData = $request->validate([
            'assignment_title' => ['required', 'max:60'],
            'assignment_description' => ['max:512'],
            'completion_date' => ['required', 'date', 'after:today'],
            'file' => ['file', 'max:4096'],
        ]);

        Storage::delete($assignmentId->material_file_path);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/assignments');
        }

        $assignmentId->update([
            'assignment_title' => $validatedData['assignment_title'],
            'assignment_description' => $validatedData['assignment_description'],
            'completion_date' => $validatedData['completion_date'],
            'material_file_path' => $path ?? '',
        ]);

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bil uspešno urejena!');
    }

    public function delete(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        $assignmentId->delete();

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bila uspešno izbrisana!');
    }

    public function downloadAllAssignmentSubmissions(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        $usersThatSubmitted = DB::table('assignment_students')
            ->where('assignment_id', '=', $assignmentId->id)
            ->select('student_id')
            ->get();

        $zip = new ZipArchive();
        $zipFileName = $assignmentId->assignment_title . '.zip';
        $zip->open($zipFileName, ZipArchive::CREATE);

        foreach ($usersThatSubmitted as $userId) {
            $studentAssignmentDirectory = 'public/studentAssignments/' . $assignmentId->id . '/' . $userId->student_id;
            $files = Storage::files($studentAssignmentDirectory);

            if (count($files) !== 0) {
                $filePath = storage_path('app/' . $files[0]);

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
        }
        $zip->close();
        $zipStream = fopen($zipFileName, 'r');

        $response = response()->stream(
            function () use ($zipStream) {
                fpassthru($zipStream);
                fclose($zipStream);
            },
            200,
            [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            ]
        );
        unlink($zipFileName);

        return $response;

    }
}
