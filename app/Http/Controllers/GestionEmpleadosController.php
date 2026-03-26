<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
        return view('manager.users.create', [
            'roles' => $this->availableRoles(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'role' => $validated['role'],
        ]);

        return redirect()->route('manager.users.index')
            ->with('status', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        return view('manager.users.edit', [
            'user' => $user,
            'roles' => $this->availableRoles(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $this->validateUser($request, $user);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'role' => $validated['role'],
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        if (
            $user->isGerente()
            && $validated['role'] !== User::ROLE_GERENTE
            && User::query()->where('role', User::ROLE_GERENTE)->count() === 1
        ) {
            return back()->withErrors([
                'role' => 'Debe existir al menos un gerente activo en el sistema.',
            ])->withInput();
        }

        $user->update($payload);

        return redirect()->route('manager.users.index')
            ->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->with('status', 'No puedes eliminar tu propia cuenta desde este panel.');
        }

        if ($user->isGerente() && User::query()->where('role', User::ROLE_GERENTE)->count() === 1) {
            return back()->with('status', 'No puedes eliminar al ultimo gerente del sistema.');
        }

        if ($user->orders()->exists()) {
            return back()->with('status', 'No se puede eliminar un usuario con historial de pedidos.');
        }

        $user->cartItems()->delete();
        $user->delete();

        return redirect()->route('manager.users.index')
            ->with('status', 'Usuario eliminado correctamente.');
    }

    private function validateUser(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'confirmed', Password::defaults()]
            : ['required', 'confirmed', Password::defaults()];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', Rule::in(array_keys($this->availableRoles()))],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'password' => $passwordRules,
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function availableRoles(): array
    {
        return [
            User::ROLE_CLIENTE => 'Cliente',
            User::ROLE_EMPLEADO => 'Empleado',
            User::ROLE_GERENTE => 'Gerente',
        ];
    }
}
