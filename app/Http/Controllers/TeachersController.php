<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use Illuminate\Support\Facades\Hash;

class TeachersController extends Controller
{
    public function list()
    {

        return view('admin.teacher.list', [
            'title' => 'Prikaz učiteljev',
            'data' => User::where('role', 'tch')->with('subjects')->get(),
        ]);
    }

    /**
     * Function for responding to GET request when admin is trying to create new subject or edit and existing one
     * If editing existing subject already saved data will be passed to autofill the form, otherwise empty object is passed
     *
     * @param Request $request
     * @param User $teacherId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function showForm(Request $request, User $teacherId)
    {
        $existingDataSubject = Subject::all();
        $currentSubjects = SubjectTeacher::where('teacher_id', $teacherId->id)
            ->pluck('subject_id')
            ->toArray();

        return view('admin.teacher.edit', [
            'title' => 'Urejanje učitelja',
            'formData' => $teacherId,
            'existingDataSubject' => $existingDataSubject,
            'currentSubjects' => $currentSubjects,
        ]);
    }


    /**
     * Function for responding to POST request when admin is trying to save a new subject
     * Data is firstly validated, in case of errors those are displayed, otherwise data is saved to database
     * Operation finishes by redirecting to list page of all subject with completion message
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        $teacher = new User([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make('password'.$validatedData['username']),
            'username' => $validatedData['username'],
            'role' => $validatedData['role'],
        ]);
        $teacher->save();

        foreach ($request->subjects as $subjectId) {
            SubjectTeacher::create([
                'subject_id' => $subjectId,
                'teacher_id' => $teacher->id,
            ]);
        }

        return redirect()->route('teacher.list')->with('message', 'Učitelj je bil uspešno shranjen!');
    }


    public function update(Request $request, User $teacherId)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:60'],
            'last_name' => ['required', 'max:60'],
            'email' => ['required', 'max:128'],
            'subjects' => ['required', 'array'],
            'role' => ['required', 'in:adm,tch,usr'],
        ]);

        $teacherId->update($validatedData);

        $currentSubjectIds = SubjectTeacher::where('teacher_id', $teacherId->id)
            ->pluck('subject_id')
            ->toArray();

        $subjectIdsToAdd = array_diff($request->subjects, $currentSubjectIds);
        $subjectIdsToDelete = array_diff($currentSubjectIds, $request->subjects);

        foreach ($subjectIdsToAdd as $subjectId) {
            SubjectTeacher::create([
                'subject_id' => $subjectId,
                'teacher_id' => $teacherId->id,
            ]);
        }

        SubjectTeacher::where('teacher_id', $teacherId->id)
            ->whereIn('subject_id', $subjectIdsToDelete)
            ->delete();

        return redirect()->route('teacher.list')->with('message', 'Učitelj je bil uspešno urejen!');
    }





    /**
     * Function for responding to DELETE request when admin is trying to delete existing subject
     * Data is deleted and after finished operation redirection with success message is made
     *
     * @param Request $request
     * @param User $teacherId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, User $teacherId)
    {
        $teacherId->delete();

        return redirect()->route('teacher.list')->with('message', 'Učitelj je bil uspešno izbrisan!');
    }
}