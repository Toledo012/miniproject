<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\Usuario|null $usuario */
        $usuario = Auth::user();

        abort_unless(Gate::allows('gestionar-catalogo') || $usuario?->esCliente(), 403);

        return view('categorias.index', [
            'categorias' => Categoria::query()->withCount('productos')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Categoria::class);

        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        Categoria::create($request->validated());

        return redirect()->route('categorias.index')
            ->with('status', 'Categoria creada correctamente.');
    }

    public function show(Categoria $categoria): View
    {
        $this->authorize('view', $categoria);

        return view('categorias.show', [
            'categoria' => $categoria->load('productos.vendedor'),
        ]);
    }

    public function edit(Categoria $categoria): View
    {
        $this->authorize('update', $categoria);

        return view('categorias.edit', [
            'categoria' => $categoria,
        ]);
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return redirect()->route('categorias.index')
            ->with('status', 'Categoria actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $this->authorize('delete', $categoria);
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('status', 'Categoria eliminada correctamente.');
    }
}
