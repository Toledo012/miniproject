<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VerificacionController extends Controller
{
    public function showForm(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('2fa_usuario_id')) {
            return redirect()->route('login');
        }

        return view('auth.verificar');
    }

    public function verify(Request $request, TwoFactorService $twoFactor): RedirectResponse
    {
        $datos = $request->validate([
            'codigo' => ['required', 'string', 'digits:6'],
        ]);

        $usuarioId = $request->session()->get('2fa_usuario_id');

        if (! $usuarioId) {
            return redirect()
                ->route('login')
                ->withErrors(['codigo' => 'Sesión no válida, inicia sesión nuevamente.']);
        }

        $usuario = User::find($usuarioId);

        if (! $usuario) {
            $request->session()->forget('2fa_usuario_id');

            return redirect()
                ->route('login')
                ->withErrors(['codigo' => 'Sesión no válida, inicia sesión nuevamente.']);
        }

        $resultado = $twoFactor->verificarCodigo($usuario, $datos['codigo'], $request->ip());

        return match ($resultado) {
            'ok' => $this->loginExitoso($request, $usuario),
            'expirado' => $this->codigoExpirado($request),
            default => back()->withErrors(['codigo' => 'Código inválido.']),
        };
    }

    private function loginExitoso(Request $request, User $usuario): RedirectResponse
    {
        Auth::login($usuario);
        $request->session()->regenerate();
        $request->session()->forget('2fa_usuario_id');

        return redirect()->intended($this->rutaInicialPorRol($usuario));
    }

    private function rutaInicialPorRol(User $usuario): string
    {
        return match (true) {
            $usuario->esAdmin() => route('dashboard'),
            $usuario->esGerente() => route('ventas.index'),
            $usuario->esVendedor() => route('productos.index'),
            default => route('catalogo'),
        };
    }

    private function codigoExpirado(Request $request): RedirectResponse
    {
        $request->session()->forget('2fa_usuario_id');

        return redirect()
            ->route('login')
            ->withErrors(['email' => 'El código ha expirado, inicia sesión nuevamente.']);
    }
}
