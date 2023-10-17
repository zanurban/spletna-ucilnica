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
    private string $assignmentDirectory = 'public/assignments';
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
            'subject_teacher_id' => (string) DB::table('subject_teachers')
                ->where('teacher_id', Auth::user()->id)
                ->where('subject_id', $subjectId->id)->select('id')->first()->id,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store($this->assignmentDirectory);

            $assignment->material_file_path = pathinfo($path)['filename'] . '.' . pathinfo($path)['extension'];
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



        if ($request->hasFile('file')) {
            Storage::delete($assignmentId->material_file_path);
            $file = $request->file('file');
            $path = $file->store($this->assignmentDirectory);

            $assignmentId->update([
                'assignment_title' => $validatedData['assignment_title'],
                'assignment_description' => $validatedData['assignment_description'],
                'completion_date' => $validatedData['completion_date'],
                'material_file_path' => pathinfo($path)['filename'] . '.' . pathinfo($path)['extension'] ?? '',
            ]);
            return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bila uspešno urejena z datoteko!');
        }

        $assignmentId->update([
            'assignment_title' => $validatedData['assignment_title'],
            'assignment_description' => $validatedData['assignment_description'],
            'completion_date' => $validatedData['completion_date'],
        ]);

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bil uspešno urejena!');
    }

    public function delete(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        $assignmentId->delete();

        if (file_exists(Storage::path($this->assignmentDirectory . '/' . $assignmentId->material_file_path))) {
            Storage::delete(Storage::path($this->assignmentDirectory . '/' . $assignmentId->material_file_path));
        }

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Naloga je bila uspešno izbrisana!');
    }

    public function downloadAllAssignmentSubmissions(Request $request, Subject $subjectId, Assignment $assignmentId)
    {
        // Define the directory and filename for the new zip file
        $zipDirectory = storage_path('app/public/zip_files/');
        $zipFileName = $assignmentId->assignment_title . '.zip';
        $zipFilePath = $zipDirectory . $zipFileName;

        // Check if the old zip file exists and delete it if it does
        if (file_exists($zipFilePath)) {
            unlink($zipFilePath);
        }

        $usersThatSubmitted = DB::table('assignment_students')
            ->where('assignment_id', '=', $assignmentId->id)
            ->select('student_id')
            ->get();

        $zip = new ZipArchive();

        $filesExist = false;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== true) {
            return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('error', 'Napaka pri ustvarjanju arhiva!');
        }

        foreach ($usersThatSubmitted as $userId) {
            $studentAssignmentDirectory = 'public/studentAssignments/' . $assignmentId->id . '/' . $userId->student_id;
            $files = Storage::files($studentAssignmentDirectory);

            if (count($files) !== 0) {
                $filesExist = true;
                foreach ($files as $file) {
                    $filePath = storage_path('app/' . $file);

                    if (file_exists($filePath)) {
                        // Add each file to the open zip archive
                        $zip->addFile($filePath, basename($filePath));
                    }
                }
            }
        }

        // Close the zip archive
        $zip->close();

        if (!$filesExist) {
            return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('error', 'Ni datotek za prenos!');
        }

        // Open the zip file for reading
        $zipStream = fopen($zipFilePath, 'r');

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

        return $response;
    }


}