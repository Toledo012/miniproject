<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class RedireccionPanelController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        return match ($user->role) {
            User::ROLE_GERENTE => redirect()->route('manager.dashboard'),
            User::ROLE_EMPLEADO => redirect()->route('employee.dashboard'),
            default => redirect()->route('client.products.index'),
        };
    }
}

