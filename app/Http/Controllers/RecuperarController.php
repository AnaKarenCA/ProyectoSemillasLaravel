<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecuperarController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email',
        ]);

        // Aquí la lógica de recuperación (enviar correo, etc.)
        return back()->with('success', 'Correo de recuperación enviado.');
    }
}
