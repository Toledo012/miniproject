<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegistroController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $usuario = Usuario::create([
            'nombre' => $request->validated('nombre'),
            'apellidos' => $request->validated('apellidos'),
            'correo' => $request->validated('correo'),
            'clave' => Hash::make($request->validated('clave')),
            'rol' => Usuario::ROL_CLIENTE,
        ]);

        Auth::login($usuario);

        return redirect()->route('dashboard');
    }
}
