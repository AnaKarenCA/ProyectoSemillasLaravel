<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('usuario', $request->username)->first();

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
        return redirect('/');
    }
    public function sendTemporaryPassword(Request $request)
{
    $request->validate([
        'correo_electronico' => 'required|email',
    ]);

    $user = DB::table('usuarios')
        ->where('correo_electronico', $request->correo_electronico)
        ->where('estado', 'Activo')
        ->first();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'No se encontró una cuenta activa con ese correo.'
        ]);
    }

    $newPassword = $this->generateTempPassword();
    $hashedPassword = Hash::make($newPassword);

    DB::table('usuarios')
        ->where('correo_electronico', $request->correo_electronico)
        ->update(['contrasena' => $hashedPassword]);

    try {
        Mail::send('emails.password_reset', [
            'user' => $user,
            'newPassword' => $newPassword
        ], function ($message) use ($user) {
            $message->to($user->correo_electronico)
                    ->subject('Recuperación de Contraseña');
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Se ha enviado un correo con tu nueva contraseña temporal.'
        ]);

    } catch (\Exception $e) {
        \Log::error('Error enviando correo: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Hubo un problema al enviar el correo. Intenta más tarde.'
        ]);
    }
}




    private function generateTempPassword($length = 10)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        return substr(str_shuffle($chars), 0, $length);
    }
}
