<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Categoria::class);

        $categorias = Categoria::withCount('productos')
            ->orderBy('nombre')
            ->paginate(15);

        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        $this->authorize('create', Categoria::class);

        return view('categorias.create');
    }
    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        $this->authorize('create', Categoria::class);
        $datos = $request->validated();
        $datos['slug'] = $this->generarSlugUnico($datos['nombre']);

        Categoria::create($datos);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }
    public function show(Categoria $categoria): View
    {
        $this->authorize('view', $categoria);

        $categoria->load('productos');

        return view('categorias.show', compact('categoria'));
    }
    public function edit(Categoria $categoria): View
    {
        $this->authorize('update', $categoria);

        return view('categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $this->authorize('update', $categoria);

        $datos = $request->validated();

        if ($datos['nombre'] !== $categoria->nombre) {
            $datos['slug'] = $this->generarSlugUnico($datos['nombre'], $categoria->id);
        }

        $categoria->update($datos);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $this->authorize('delete', $categoria);

        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    private function generarSlugUnico(string $nombre, ?int $ignorarId = null): string
    {
        $slug = Str::slug($nombre);
        $base = $slug;
        $i = 1;

        while ($this->slugExiste($slug, $ignorarId)) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function slugExiste(string $slug, ?int $ignorarId): bool
    {
        $query = Categoria::where('slug', $slug);
        if ($ignorarId) {
            $query->where('id', '!=', $ignorarId);
        }

        return $query->exists();
    }
}
