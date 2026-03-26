<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function indiceCliente(Request $request): View
    {
        $busqueda = $request->string('q')->toString();

        $productos = Product::query()
            ->where('is_active', true)
            ->when($busqueda !== '', function ($consulta) use ($busqueda) {
                $consulta->where(function ($consultaInterna) use ($busqueda) {
                    $consultaInterna
                        ->where('name', 'like', "%{$busqueda}%")
                        ->orWhere('description', 'like', "%{$busqueda}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('client.products.index', [
            'products' => $productos,
            'search' => $busqueda,
        ]);
    }

    public function mostrarCliente(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('client.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::query()->latest()->paginate(5)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $datosValidados = $this->validarProducto($request);
        $datosValidados['slug'] = $this->generarSlugUnico($datosValidados['name']);
        $datosValidados['image_path'] = $request->hasFile('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        Product::create($datosValidados);

        return redirect()->route('inventory.products.index')
            ->with('status', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $datosValidados = $this->validarProducto($request);
        $datosValidados['slug'] = $this->generarSlugUnico($datosValidados['name'], $product->id);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $datosValidados['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($datosValidados);

        return redirect()->route('inventory.products.index')
            ->with('status', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $tieneHistorialPedidos = OrderItem::query()
            ->where('product_id', $product->id)
            ->exists();

        if ($tieneHistorialPedidos) {
            $product->update([
                'is_active' => false,
            ]);

            return redirect()->route('inventory.products.index')
                ->with('status', 'El producto tiene historial de pedidos y se desactivo en lugar de eliminarse.');
        }

        try {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();
        } catch (QueryException) {
            $product->update([
                'is_active' => false,
            ]);

            return redirect()->route('inventory.products.index')
                ->with('status', 'No se pudo eliminar por referencias existentes. El producto fue desactivado.');
        }

        return redirect()->route('inventory.products.index')
            ->with('status', 'Producto eliminado correctamente.');
    }

    private function validarProducto(Request $request): array
    {
        $datosValidados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
        $datosValidados['is_active'] = $request->boolean('is_active');

        return $datosValidados;
    }

    private function generarSlugUnico(string $name, ?int $ignorarId = null): string
    {
        $slugBase = Str::slug($name);
        $semilla = $slugBase !== '' ? $slugBase : 'producto';
        $slug = $semilla;
        $contador = 1;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when($ignorarId, fn ($consulta) => $consulta->where('id', '!=', $ignorarId))
                ->exists()
        ) {
            $slug = "{$semilla}-{$contador}";
            $contador++;
        }

        return $slug;
    }
}

