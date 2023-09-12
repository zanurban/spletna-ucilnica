<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TeachersController extends Controller
{
    public function list()
    {
        return view('admin.teacher.list', [
            'title' => 'Prikaz učiteljev',
            'data' => User::where('role', 'tch')->get(),
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
        return view('admin.teacher.edit', [
            'title' => 'Urejanje učitelja',
            'formData' => $teacherId,
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
            'email' => ['required', 'max:128']
        ]);

        $subject = new User([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
        ]);
        $subject->save();

        return redirect()->route('teacher.list')->with('message', 'Učitelj je bil uspešno shranjen!');
    }

    /**
     * Function for responding to PUT/PATCH request when adminn is trying to update existing subject
     * Data is firstly validated, in case of errors those are displayed, otherwise data is saved to database
     * Operation finishes by redirecting to list page of all subject with completion message
     *
     * @param Request $request
     * @param User $teacherId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $teacherId)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:60'],
            'last_name' => ['required', 'max:60'],
            'email' => ['required', 'max:128']
        ]);

        $teacherId->update($validatedData);

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
