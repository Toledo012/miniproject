<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Venta::class);

        /** @var Usuario $usuario */
        $usuario = auth()->user();

        $ventas = Venta::query()
            ->with(['producto', 'cliente', 'vendedor'])
            ->when($usuario->esCliente(), fn ($query) => $query->where('cliente_id', $usuario->id))
            ->latest()
            ->paginate(10);

        return view('ventas.index', [
            'ventas' => $ventas,
        ]);
    }

    public function create(): View
    {
        abort_unless(Gate::allows('registrar-ventas'), 403);
        $this->authorize('create', Venta::class);

        return view('ventas.create', [
            'productos' => Producto::query()->with('vendedor', 'categorias')->where('existencia', '>', 0)->get(),
            'clientes' => Usuario::query()->where('rol', Usuario::ROL_CLIENTE)->orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreVentaRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('registrar-ventas'), 403);
        $this->authorize('create', Venta::class);

        /** @var Usuario $usuario */
        $usuario = auth()->user();
        $producto = Producto::query()->with('vendedor')->findOrFail($request->validated('producto_id'));

        if ($producto->existencia < 1) {
            return back()->withErrors([
                'producto_id' => 'El producto seleccionado no tiene existencia disponible.',
            ])->withInput();
        }

        $clienteId = $usuario->esCliente()
            ? $usuario->id
            : ($request->input('cliente_id') ?: $usuario->id);

        $venta = Venta::create([
            'producto_id' => $producto->id,
            'vendedor_id' => $producto->usuario_id,
            'cliente_id' => $clienteId,
            'fecha' => $request->validated('fecha'),
            'total' => $producto->precio,
        ]);

        $producto->decrement('existencia');

        Log::channel('ventas')->info('Venta creada', [
            'venta_id' => $venta->id,
            'producto_id' => $producto->id,
            'vendedor_id' => $venta->vendedor_id,
            'cliente_id' => $venta->cliente_id,
            'total' => $venta->total,
            'ip' => request()->ip(),
        ]);

        return redirect()->route('ventas.index')
            ->with('status', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta): View
    {
        $this->authorize('view', $venta);

        return view('ventas.show', [
            'venta' => $venta->load(['producto', 'cliente', 'vendedor']),
        ]);
    }

    public function edit(Venta $venta): View
    {
        $this->authorize('update', $venta);

        return view('ventas.edit', [
            'venta' => $venta,
            'productos' => Producto::query()->with('vendedor')->get(),
            'clientes' => Usuario::query()->where('rol', Usuario::ROL_CLIENTE)->orderBy('nombre')->get(),
        ]);
    }

    public function update(UpdateVentaRequest $request, Venta $venta): RedirectResponse
    {
        $producto = Producto::query()->findOrFail($request->validated('producto_id'));

        $venta->update([
            'producto_id' => $producto->id,
            'vendedor_id' => $request->validated('vendedor_id'),
            'cliente_id' => $request->validated('cliente_id'),
            'fecha' => $request->validated('fecha'),
            'total' => $request->validated('total'),
        ]);

        return redirect()->route('ventas.index')
            ->with('status', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta): RedirectResponse
    {
        $this->authorize('delete', $venta);
        $venta->delete();

        return redirect()->route('ventas.index')
            ->with('status', 'Venta eliminada correctamente.');
    }
}
