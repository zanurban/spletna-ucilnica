<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function downloadMaterial(string $filename)
    {
        $filePath = 'public/materials/' . $filename;

        if (Storage::exists($filePath)) {
            $mimeType = Storage::mimeType($filePath);

            // Generate a response to force the file download
            return response()->stream(function () use ($filePath) {
                Storage::disk('local')->download($filePath);
            }, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } else {
            abort(404);
        }
    }
}
