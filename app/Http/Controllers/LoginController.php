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
            'formData' => (object)[],
        ]);
    }

    public function showFormRegister()
    {
        return view('register.registerForm', [
            'title' => 'Registracija',
            'formData' => (object)[],
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
            return redirect()->route('home');
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
        if($credentials['password'] != $credentials['password2']){
            return back()->withErrors([
                'password' => 'Gesli se ne ujemata.',
            ])->onlyInput('password');
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

        return redirect()->route('home');
    }
}
