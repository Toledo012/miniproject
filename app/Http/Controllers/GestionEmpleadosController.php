<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class GestionEmpleadosController extends Controller
{
    public function index(Request $request): View
    {
        $employees = User::query()
            ->where('role', User::ROLE_EMPLEADO)
            ->latest()
            ->paginate(10, ['*'], 'employees_page')
            ->withQueryString();

        $clients = User::query()
            ->where('role', User::ROLE_CLIENTE)
            ->latest()
            ->paginate(10, ['*'], 'clients_page')
            ->withQueryString();

        $managers = User::query()
            ->where('role', User::ROLE_GERENTE)
            ->latest()
            ->paginate(10, ['*'], 'managers_page')
            ->withQueryString();

        return view('manager.users.index', [
            'employees' => $employees,
            'clients' => $clients,
            'managers' => $managers,
        ]);
    }

    public function create(): View
    {
        return view('manager.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => User::ROLE_EMPLEADO,
        ]);

        return redirect()->route('manager.users.index')
            ->with('status', 'Empleado creado correctamente.');
    }
}

