<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Collection;

class DashboardService
{
    public function totales(): array
    {
        return [
            'usuarios' => User::count(),
            'admins' => User::where('rol', 'admin')->count(),
            'gerentes' => User::where('rol', 'gerente')->count(),
            'vendedores' => User::where('rol', 'vendedor')->count(),
            'compradores' => User::where('rol', 'comprador')->count(),
            'productos' => Producto::count(),
            'categorias' => Categoria::count(),
        ];
    }

    public function productosPorCategoria(): Collection
    {
        return Categoria::withCount('productos')
            ->orderBy('nombre')
            ->get();
    }

    public function productoMasVendido(): ?Producto
    {
        return Producto::withCount(['ventas as ventas_validadas_count' => fn ($q) => $q->where('estado', 'validada')])
            ->orderByDesc('ventas_validadas_count')
            ->first();
    }

    public function compradorMasFrecuentePorCategoria(): Collection
    {
        $categorias = Categoria::with([
            'ventas' => fn ($q) => $q->where('estado', 'validada')->with('comprador'),
        ])->orderBy('nombre')->get();

        return $categorias->map(function (Categoria $categoria) {
            $ventas = $categoria->ventas;

            if ($ventas->isEmpty()) {
                return [
                    'categoria' => $categoria,
                    'comprador' => null,
                    'compras' => 0,
                ];
            }

            $top = $ventas
                ->groupBy('comprador_id')
                ->map(fn ($items) => [
                    'comprador' => $items->first()->comprador,
                    'compras' => $items->count(),
                ])
                ->sortByDesc('compras')
                ->first();

            return [
                'categoria' => $categoria,
                'comprador' => $top['comprador'],
                'compras' => $top['compras'],
            ];
        });
    }
}
