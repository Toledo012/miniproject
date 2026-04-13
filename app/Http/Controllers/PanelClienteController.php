<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\View\View;

class PanelClienteController extends Controller
{
    public function index(): View
    {
        /** @var Usuario $usuario */
        $usuario = auth()->user();

        $ventas = $usuario->ventasComoCliente()->with(['producto', 'vendedor']);

        return view('paneles.cliente', [
            'comprasRealizadas' => (clone $ventas)->count(),
            'gastoTotal' => (float) (clone $ventas)->sum('total'),
            'productosDisponibles' => Producto::query()->where('existencia', '>', 0)->count(),
            'ultimasCompras' => (clone $ventas)->latest()->take(5)->get(),
            'productosDestacados' => Producto::query()
                ->with('vendedor')
                ->where('existencia', '>', 0)
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }
}
