<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CodigoVerificacion;
use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request, TwoFactorService $twoFactor): RedirectResponse
    {
        $datos = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $usuario = User::where('email', $datos['email'])->first();

        if (! $usuario || ! Hash::check($datos['password'], $usuario->password)) {
            return back()
                ->withErrors(['email' => 'Credenciales inválidas.'])
                ->onlyInput('email');
        }

        Log::channel('autenticacion')->info('login_fase1_correcto', [
            'usuario_id' => $usuario->id,
            'ip' => $request->ip(),
        ]);

        // Bypass de 2FA para cuentas demo (emails @demo.test)
        if (str_ends_with(strtolower($usuario->email), '@demo.test')) {
            Auth::login($usuario);
            $request->session()->regenerate();

            Log::channel('autenticacion')->info('login_demo_bypass_2fa', [
                'usuario_id' => $usuario->id,
                'ip' => $request->ip(),
            ]);

            return redirect()->intended(route('catalogo'));
        }

        $twoFactor->emitirCodigo($usuario, $request->ip());

        $request->session()->put('2fa_usuario_id', $usuario->id);

        return redirect()->route('verificar.form');
    }

    public function logout(Request $request): RedirectResponse
    {
        $usuarioId = Auth::id();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($usuarioId) {
            CodigoVerificacion::where('usuario_id', $usuarioId)->delete();
        }

        return redirect()->route('login');
    }
}
