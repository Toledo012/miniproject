<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Producto;
use App\Models\Venta;
use App\Services\VentaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function __construct(private VentaService $ventas) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Venta::class);

        $usuario = $request->user();
        $estado = $request->query('estado');

        $query = Venta::with(['producto.vendedor', 'comprador', 'gerente'])
            ->when(
                in_array($estado, ['pendiente', 'validada', 'rechazada'], true),
                fn ($q) => $q->where('estado', $estado),
            )
            ->latest();

        if ($usuario->esComprador()) {
            $query->where('comprador_id', $usuario->id);
        } elseif ($usuario->esVendedor()) {
            $query->whereHas('producto', fn ($q) => $q->where('vendedor_id', $usuario->id));
        }

        $ventas = $query->paginate(15)->withQueryString();

        return view('ventas.index', compact('ventas', 'estado'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Venta::class);

        $producto = null;
        if ($request->filled('producto_id')) {
            $producto = Producto::find($request->integer('producto_id'));
        }

        $productos = Producto::where('stock', '>', 0)
            ->where('vendedor_id', '!=', $request->user()->id)
            ->orderBy('nombre')
            ->get();

        return view('ventas.create', compact('productos', 'producto'));
    }

    public function store(StoreVentaRequest $request): RedirectResponse
    {
        $this->authorize('create', Venta::class);

        $datos = $request->validated();
        $producto = Producto::findOrFail($datos['producto_id']);

        $venta = $this->ventas->crear(
            $request->user(),
            $producto,
            (int) $datos['cantidad'],
            $request->file('ticket'),
        );

        return redirect()
            ->route('ventas.show', $venta)
            ->with('success', 'Compra registrada. Pendiente de validación.');
    }

    public function show(Venta $venta): View
    {
        $this->authorize('view', $venta);

        $venta->load(['producto.vendedor', 'comprador', 'gerente']);

        return view('ventas.show', compact('venta'));
    }

    public function update(UpdateVentaRequest $request, Venta $venta): RedirectResponse
    {
        $this->authorize('update', $venta);

        $datos = $request->validated();

        match ($datos['estado']) {
            'validada' => $this->ventas->validar($venta, $request->user()),
            'rechazada' => $this->ventas->rechazar($venta, $request->user()),
            default => null,
        };

        $mensaje = $datos['estado'] === 'validada'
            ? 'Venta validada y notificada al comprador y vendedor.'
            : 'Venta rechazada y notificada al comprador.';

        return redirect()
            ->route('ventas.show', $venta)
            ->with('success', $mensaje);
    }
}
