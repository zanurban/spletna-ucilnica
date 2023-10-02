<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EncryptCookies;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialsController extends Controller
{
    public function listSubjects()
    {
        return view('teacher.material.listSubjects', [
            'title' => 'Predmeti učitelja',
            'subjects' => User::find(Auth::user()->id)->subjects,
        ]);
    }

    public function list(Request $request, Subject $subjectId)
    {
        $subject_teacher_id = DB::table('subject_teachers')
            ->where('teacher_id', Auth::user()->id)
            ->where('subject_id', $subjectId->id)->select('id')->first()->id;

        return view('teacher.material.listClassroomContent', [
            'title' => $subjectId->subject_name,
            'subjectId' => $subjectId->id,
            'materials' => Material::where('subject_teacher_id', $subject_teacher_id)->get(),
            'assignments' => Assignment::where('subject_teacher_id', $subject_teacher_id)->get(),
        ]);
    }

    public function showForm(Request $request, Subject $subjectId, Material $materialId)
    {
        return view('teacher.material.editMaterial', [
            'title' => 'Urejanje gradiva',
            'subjectId' => $subjectId->id,
            'formData' => $materialId,
        ]);
    }

    public function save(Request $request, Subject $subjectId)
    {
        $validatedData = $request->validate([
            'material_title' => ['required', 'max:60'],
            'material_description' => ['max:512'],
            'file' => ['required', 'file', 'max:4096'],
        ]);

        $material = new Material([
            'material_title' => $validatedData['material_title'],
            'material_description' => $validatedData['material_description'],
            'subject_teacher_id' => (string)DB::table('subject_teachers')
                ->where('teacher_id', Auth::user()->id)
                ->where('subject_id', $subjectId->id)->select('id')->first()->id,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/materials');

            $material->material_file_path = $path;
            $material->save();

            return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Gradivo je bilo uspešno shranjeno!');
        }

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Med shranjevanje gradiva se je zgodila napaka!');
    }

    public function update(Request $request, Subject $subjectId, Material $materialId)
    {
        $validatedData = $request->validate([
            'material_title' => ['required', 'max:60'],
            'material_description' => ['max:512'],
            'file' => ['file', 'max:4096'],
        ]);

        if ($request->hasFile('file')) {
            Storage::delete($materialId->material_file_path);
            $file = $request->file('file');
            $path = $file->store('public/materials');

            $materialId->update([
                'material_title' => $validatedData['material_title'],
                'material_description' => $validatedData['material_description'],
                'material_file_path' => $path,
            ]);

            return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Gradivo je bilo uspešno shranjeno!');
        }
        else {
            $materialId->update([
                'material_title' => $validatedData['material_title'],
                'material_description' => $validatedData['material_description'],
            ]);
        }

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Gradivo je bil uspešno urejeno!');
    }

    public function delete(Request $request, Subject $subjectId, Material $materialId)
    {
        $materialId->delete();

        return redirect()->route('classroom.list', ['subjectId' => $subjectId->id])->with('message', 'Gradivo je bilo uspešno izbrisano!');
    }
}
