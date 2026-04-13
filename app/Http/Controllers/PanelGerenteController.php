<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\View\View;

class PanelGerenteController extends Controller
{
    public function index(): View
    {
        /** @var Usuario $usuario */
        $usuario = auth()->user();

        $ventas = Venta::query()
            ->where('vendedor_id', $usuario->id);

        $ventasHoy = (float) (clone $ventas)
            ->whereDate('fecha', now()->toDateString())
            ->sum('total');

        return view('paneles.gerente', [
            'totalProductos' => Producto::query()->where('usuario_id', $usuario->id)->count(),
            'totalCategorias' => $usuario->categoriasPivot()
                ->distinct('categoria_id')
                ->count('categoria_id'),
            'totalVentas' => (clone $ventas)->count(),
            'ventasHoy' => $ventasHoy,
            'productos' => Producto::query()->with('categorias')->where('usuario_id', $usuario->id)->latest()->take(5)->get(),
            'ultimasVentas' => (clone $ventas)->with(['producto', 'cliente'])->latest()->take(5)->get(),
        ]);
    }
}
