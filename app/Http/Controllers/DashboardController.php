<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}

    public function index(): View
    {
        $totales = $this->dashboard->totales();
        $productosPorCategoria = $this->dashboard->productosPorCategoria();
        $productoTop = $this->dashboard->productoMasVendido();
        $compradoresPorCategoria = $this->dashboard->compradorMasFrecuentePorCategoria();

        return view('dashboard.index', compact(
            'totales',
            'productosPorCategoria',
            'productoTop',
            'compradoresPorCategoria',
        ));
    }
}
