<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RedireccionPanelController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        /** @var Usuario $user */
        $user = Auth::user();

        return match ($user->rol) {
            Usuario::ROL_ADMINISTRADOR => redirect()->route('panel.administrador'),
            Usuario::ROL_GERENTE => redirect()->route('panel.gerente'),
            default => redirect()->route('panel.cliente'),
        };
    }
}
