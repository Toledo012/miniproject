<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    public function index(Request $request): View
    {
        $categoriaId = $request->integer('categoria') ?: null;

        $productos = Producto::with(['fotos', 'categorias', 'vendedor'])
            ->when($categoriaId, fn ($q) => $q->whereHas('categorias', fn ($c) => $c->where('categorias.id', $categoriaId)))
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('catalogo.index', compact('productos', 'categorias', 'categoriaId'));
    }
}
