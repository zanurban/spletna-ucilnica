<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function downloadMaterial(string $filename)
    {
        $filePath = 'public/materials/' . $filename;

        if (Storage::exists($filePath)) {
            $mimeType = Storage::mimeType($filePath);
            $fileContents = Storage::disk('local')->get($filePath);

            return response($fileContents, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } else {
            abort(404);
        }
    }

    public function downloadSpecificAssignment(string $assignmentId, string $studentId)
    {
        $filePath = 'public/studentAssignments/' . $assignmentId . '/' . $studentId;
        $files = scandir(Storage::path($filePath));
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath .= '/' . $file;
            }
        }

        if (Storage::exists($filePath)) {
            $mimeType = Storage::mimeType($filePath);
            $fileContents = Storage::disk('local')->get($filePath);

            return response($fileContents, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
            ]);
        } else {
            abort(404);
        }
    }

    public function downloadAssignmentMaterial(Assignment $assignment)
    {
        $filePath = 'public/assignments/' . $assignment->material_file_path;

        if (Storage::exists($filePath)) {
            $mimeType = Storage::mimeType($filePath);
            $fileContents = Storage::disk('local')->get($filePath);

            return response($fileContents, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
            ]);
        } else {
            abort(404);
        }
    }

}
