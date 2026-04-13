<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(): View
    {
        abort_unless(Gate::allows('gestionar-usuarios'), 403);

        return view('usuarios.index', [
            'administradores' => Usuario::query()->where('rol', Usuario::ROL_ADMINISTRADOR)->latest()->paginate(8, ['*'], 'administradores'),
            'gerentes' => Usuario::query()->where('rol', Usuario::ROL_GERENTE)->latest()->paginate(8, ['*'], 'gerentes'),
            'clientes' => Usuario::query()->where('rol', Usuario::ROL_CLIENTE)->latest()->paginate(8, ['*'], 'clientes'),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Usuario::class);

        return view('usuarios.create', [
            'roles' => $this->rolesDisponibles(),
        ]);
    }

    public function store(StoreUsuarioRequest $request): RedirectResponse
    {
        Usuario::create([
            'nombre' => $request->validated('nombre'),
            'apellidos' => $request->validated('apellidos'),
            'correo' => $request->validated('correo'),
            'clave' => Hash::make($request->validated('clave')),
            'rol' => $request->validated('rol'),
        ]);

        return redirect()->route('usuarios.index')
            ->with('status', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario): View
    {
        $this->authorize('update', $usuario);

        return view('usuarios.edit', [
            'usuario' => $usuario,
            'roles' => $this->rolesDisponibles(),
        ]);
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario): RedirectResponse
    {
        if (
            $usuario->esAdministrador()
            && $request->validated('rol') !== Usuario::ROL_ADMINISTRADOR
            && Usuario::query()->where('rol', Usuario::ROL_ADMINISTRADOR)->count() === 1
        ) {
            return back()->withErrors([
                'rol' => 'Debe existir al menos un administrador en el sistema.',
            ])->withInput();
        }

        $datos = [
            'nombre' => $request->validated('nombre'),
            'apellidos' => $request->validated('apellidos'),
            'correo' => $request->validated('correo'),
            'rol' => $request->validated('rol'),
        ];

        if ($request->filled('clave')) {
            $datos['clave'] = Hash::make($request->validated('clave'));
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')
            ->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        $this->authorize('delete', $usuario);

        if ($usuario->ventasComoCliente()->exists() || $usuario->ventasComoVendedor()->exists()) {
            return back()->with('status', 'No se puede eliminar un usuario con historial de ventas.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('status', 'Usuario eliminado correctamente.');
    }

    private function rolesDisponibles(): array
    {
        return [
            Usuario::ROL_ADMINISTRADOR => 'Administrador',
            Usuario::ROL_GERENTE => 'Gerente',
            Usuario::ROL_CLIENTE => 'Cliente',
        ];
    }
}
