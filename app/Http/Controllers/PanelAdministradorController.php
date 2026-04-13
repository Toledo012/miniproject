<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\View\View;

class PanelAdministradorController extends Controller
{
    public function index(): View
    {
        return view('paneles.administrador', [
            'totalUsuarios' => Usuario::count(),
            'totalProductos' => Producto::count(),
            'totalCategorias' => Categoria::count(),
            'totalVentas' => Venta::count(),
            'ultimosUsuarios' => Usuario::latest()->take(5)->get(),
            'ultimasVentas' => Venta::query()->with(['producto', 'cliente', 'vendedor'])->latest()->take(5)->get(),
        ]);
    }
}
