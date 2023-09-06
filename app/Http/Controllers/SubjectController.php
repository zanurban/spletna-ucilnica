<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function list()
    {
        return view('admin.subject.list', [
            'title' => 'Prikaz predmetov',
            'data' => Subject::all(),
        ]);
    }

    /**
     * Function for responding to GET request when admin is trying to create new subject or edit and existing one
     * If editing existing subject already saved data will be passed to autofill the form, otherwise empty object is passed
     *
     * @param Request $request
     * @param Subject $subjectId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function showForm(Request $request, Subject $subjectId)
    {
        return view('admin.subject.edit', [
            'title' => 'Urejanje predmeta',
            'formData' => $subjectId,
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
            'subject_name' => ['required', 'max:60'],
            'subject_description' => ['max:512']
        ]);

        $subject = new Subject([
            'subject_name' => $validatedData['subject_name'],
            'subject_description' => $validatedData['subject_description']
        ]);
        $subject->save();

        return redirect()->route('subject.list')->with('message', 'Predmet je bil uspešno shranjen!');
    }

    /**
     * Function for responding to PUT/PATCH request when adminn is trying to update existing subject
     * Data is firstly validated, in case of errors those are displayed, otherwise data is saved to database
     * Operation finishes by redirecting to list page of all subject with completion message
     *
     * @param Request $request
     * @param Subject $subject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Subject $subjectId)
    {
        $validatedData = $request->validate([
            'subject_name' => ['required', 'max:60'],
            'subject_description' => ['max:512']
        ]);

        $subjectId->update($validatedData);

        return redirect()->route('subject.list')->with('message', 'Predmet je bil uspešno urejen!');
    }

    /**
     * Function for responding to DELETE request when admin is trying to delete existing subject
     * Data is deleted and after finished operation redirection with success message is made
     *
     * @param Request $request
     * @param Subject $subject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Subject $subjectId)
    {
        $subjectId->delete();

        return redirect()->route('subject.list')->with('message', 'Predmet je bil uspešno izbrisan!');
    }
}
