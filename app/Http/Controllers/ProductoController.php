<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use App\Services\ProductoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function __construct(private ProductoService $productos) {}

    public function index(): View
    {
        $this->authorize('viewAny', Producto::class);

        $usuario = auth()->user();

        $productos = Producto::with(['fotos', 'categorias', 'vendedor'])
            ->when($usuario->esVendedor(), fn ($q) => $q->where('vendedor_id', $usuario->id))
            ->orderBy('nombre')
            ->paginate(12);

        return view('productos.index', compact('productos'));
    }

    public function create(): View
    {
        $this->authorize('create', Producto::class);

        $categorias = Categoria::orderBy('nombre')->get();
        $vendedores = $this->vendedoresParaSelect();

        return view('productos.create', compact('categorias', 'vendedores'));
    }

    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $this->authorize('create', Producto::class);

        $datos = $request->validated();
        $datos['vendedor_id'] = $request->user()->esAdmin()
            ? $datos['vendedor_id']
            : $request->user()->id;

        $this->productos->crear(
            $datos,
            $datos['categorias'],
            $request->file('fotos') ?? [],
        );

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Producto $producto): View
    {
        $this->authorize('view', $producto);

        $producto->load(['fotos', 'categorias', 'vendedor']);

        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto): View
    {
        $this->authorize('update', $producto);

        $categorias = Categoria::orderBy('nombre')->get();
        $producto->load(['fotos', 'categorias']);
        $vendedores = $this->vendedoresParaSelect();

        return view('productos.edit', compact('producto', 'categorias', 'vendedores'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $this->authorize('update', $producto);

        $datos = $request->validated();

        if (! $request->user()->esAdmin()) {
            unset($datos['vendedor_id']);
        }

        $this->productos->actualizar(
            $producto,
            $datos,
            $datos['categorias'],
            $request->file('fotos') ?? [],
            $datos['fotos_eliminar'] ?? [],
        );

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $this->authorize('delete', $producto);

        $this->productos->eliminar($producto);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    private function vendedoresParaSelect()
    {
        if (! auth()->user()?->esAdmin()) {
            return collect();
        }

        return User::where('rol', 'vendedor')->orderBy('nombre')->get(['id', 'nombre']);
    }
}
