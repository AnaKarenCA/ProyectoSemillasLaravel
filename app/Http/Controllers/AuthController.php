<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); // la vista
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Usuario::where('usuario', $request->username)->first();

        if ($user && Hash::check($request->password, $user->contrasena)) {
            Auth::login($user);
            return redirect()->route('home');
        }

        return back()->withErrors([
            'username' => 'Usuario o contraseña incorrectos.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
