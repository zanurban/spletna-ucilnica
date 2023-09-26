<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class ProfileController extends Controller
{
    public function showForm()
    {
        return view('student.profile.editProfile', [
            'title' => 'Urejanje profila',
            'formData' => User::where('id', auth()->user()->id)->first(),
        ]);
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:60'],
            'last_name' => ['required', 'max:60'],
            'email' => ['required', 'max:128'],
        ]);

        User::where('id', auth()->user()->id)->update($validatedData);

        return redirect()->route('profile.update')->with('message', 'Profil je bil uspešno urejen!');
    }
}
