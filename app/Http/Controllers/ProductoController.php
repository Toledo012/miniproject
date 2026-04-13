<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Producto::class);

        return view('productos.index', [
            'productos' => Producto::query()
                ->with(['vendedor', 'categorias'])
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Producto::class);

        return view('productos.create', [
            'categorias' => Categoria::query()->orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreProductoRequest $request): RedirectResponse
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        $producto = Producto::create([
            'nombre' => $request->validated('nombre'),
            'descripcion' => $request->validated('descripcion'),
            'precio' => $request->validated('precio'),
            'existencia' => $request->validated('existencia'),
            'usuario_id' => $usuario->id,
            'imagen' => $request->hasFile('imagen')
                ? $request->file('imagen')->store('productos', 'public')
                : null,
        ]);

        $producto->categorias()->sync($request->validated('categoria_ids'));

        Log::channel('productos')->info('Producto creado', [
            'producto_id' => $producto->id,
            'usuario_id' => $usuario->id,
            'nombre' => $producto->nombre,
            'ip' => request()->ip(),
        ]);

        return redirect()->route('productos.index')
            ->with('status', 'Producto creado correctamente.');
    }

    public function show(Producto $producto): View
    {
        $this->authorize('view', $producto);

        return view('productos.show', [
            'producto' => $producto->load(['vendedor', 'categorias', 'ventas.cliente']),
        ]);
    }

    public function edit(Producto $producto): View
    {
        $this->authorize('update', $producto);

        return view('productos.edit', [
            'producto' => $producto,
            'categorias' => Categoria::query()->orderBy('nombre')->get(),
        ]);
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $datos = [
            'nombre' => $request->validated('nombre'),
            'descripcion' => $request->validated('descripcion'),
            'precio' => $request->validated('precio'),
            'existencia' => $request->validated('existencia'),
        ];

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($datos);
        $producto->categorias()->sync($request->validated('categoria_ids'));

        Log::channel('productos')->info('Producto editado', [
            'producto_id' => $producto->id,
            'usuario_id' => Auth::id(),
            'nombre' => $producto->nombre,
            'ip' => request()->ip(),
        ]);

        return redirect()->route('productos.index')
            ->with('status', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $this->authorize('delete', $producto);

        if ($producto->ventas()->exists()) {
            return back()->with('status', 'No se puede eliminar un producto con ventas registradas.');
        }

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $productoId = $producto->id;
        $nombre = $producto->nombre;
        $producto->categorias()->detach();
        $producto->delete();

        Log::channel('productos')->info('Producto eliminado', [
            'producto_id' => $productoId,
            'usuario_id' => Auth::id(),
            'nombre' => $nombre,
            'ip' => request()->ip(),
        ]);

        return redirect()->route('productos.index')
            ->with('status', 'Producto eliminado correctamente.');
    }
}
