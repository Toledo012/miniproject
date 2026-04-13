<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AutenticacionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credenciales = $request->validated();

        if (! Auth::attempt([
            'correo' => $credenciales['correo'],
            'password' => $credenciales['clave'],
        ], $request->boolean('remember'))) {
            Log::channel('autenticacion')->warning('Login incorrecto', [
                'correo' => $credenciales['correo'],
                'ip' => $request->ip(),
            ]);

            return back()
                ->withErrors(['correo' => 'Las credenciales proporcionadas no son correctas.'])
                ->onlyInput('correo');
        }

        $request->session()->regenerate();

        /** @var Usuario $usuario */
        $usuario = $request->user();

        Log::channel('autenticacion')->info('Login correcto', [
            'usuario_id' => $usuario->id,
            'correo' => $usuario->correo,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy(): RedirectResponse
    {
        /** @var Usuario|null $usuario */
        $usuario = Auth::user();

        if ($usuario) {
            Log::channel('autenticacion')->info('Logout', [
                'usuario_id' => $usuario->id,
                'correo' => $usuario->correo,
                'ip' => request()->ip(),
            ]);
        }

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
