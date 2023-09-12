<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('login.loginForm', [
            'title' => 'Prijava',
            'formData' => (object)[],
        ]);
    }

    public function login()
    {
        
    }
}
