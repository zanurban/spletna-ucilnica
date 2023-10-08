<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('login.loginForm', [
            'title' => 'Prijava',
            'formData' => (object) [],
        ]);
    }

    public function showFormRegister()
    {
        return view('register.registerForm', [
            'title' => 'Registracija',
            'formData' => (object) [],
        ]);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('user', Auth::user());
            if (Auth::user()->role == 'adm') {
                return redirect()->route('teacher.list');
            } else if (Auth::user()->role == 'usr') {
                return redirect()->route('subjectList.list');
            } else if (Auth::user()->role == 'tch') {
                return redirect()->route('subject_material.list');
            }
        }

        return back()->withErrors([
            'username' => 'Napačno uporabniško ime ali geslo.',
        ])->onlyInput('username');
    }

    public function register(Request $request)
    {

        $credentials = $request->validate([
            'username' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'max:255'],
            'password2' => ['required', 'max:255'],
            'email' => ['required', 'max:255'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
        ]);

        function isValidPassword($password)
        {
            $hasUppercase = preg_match('/[A-Z]/', $password);
            $hasLowercase = preg_match('/[a-z]/', $password);
            $hasNumber = preg_match('/\d/', $password);
            $hasSpecialCharacter = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
            $hasMinimumLength = strlen($password) >= 8;

            return $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialCharacter && $hasMinimumLength;
        }

        if (!isValidPassword($credentials['password'])) {

            return back()->withErrors([
                'password' => 'Geslo mora vsebovati vsaj 8 znakov, eno veliko črko, eno malo črko, eno številko in en poseben znak.',
            ])->onlyInput('username', 'email', 'first_name', 'last_name');
        }

        if ($credentials['password'] != $credentials['password2']) {
            return back()->withErrors([
                'password' => 'Gesli se ne ujemata.',
            ])->onlyInput('username', 'email', 'first_name', 'last_name');
        }

        $user = new User();
        $user->username = $credentials['username'];
        $user->password = Hash::make($credentials['password']);
        $user->email = $credentials['email'];
        $user->first_name = $credentials['first_name'];
        $user->last_name = $credentials['last_name'];

        $user->save();

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route('login');
    }
}