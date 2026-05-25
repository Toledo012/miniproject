<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $usuarios = User::query()
            ->when($request->filled('rol'), fn ($q) => $q->where('rol', $request->string('rol')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->string('q');
                $q->where(fn ($w) => $w->where('nombre', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%"));
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('users.index', compact('usuarios'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        User::create($request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->loadCount(['compras', 'productos']);

        return view('users.show', ['usuario' => $user]);
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', ['usuario' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $datos = $request->validated();

        if (empty($datos['password'])) {
            unset($datos['password']);
        }

        $user->update($datos);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        if ($user->ventas()->exists()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'No se puede eliminar: el usuario tiene ventas asociadas.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
