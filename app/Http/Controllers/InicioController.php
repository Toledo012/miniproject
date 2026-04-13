<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function index(): View
    {
        $productos = Producto::query()
            ->with(['vendedor', 'categorias'])
            ->latest()
            ->take(8)
            ->get();

        return view('home', [
            'productos' => $productos,
            'siteContent' => [
                'about_us' => 'RAPH es una tienda digital enfocada en ofrecer productos de calidad con una experiencia de compra clara y eficiente.',
                'mission' => 'Facilitar la administracion de productos y ventas mientras brindamos una experiencia sencilla para el cliente.',
                'vision' => 'Consolidar una tienda confiable, organizada y escalable para futuras etapas del proyecto.',
                'location' => 'Tuxtla Gutierrez, Chiapas, Mexico.',
                'contact' => 'Correo: contacto@raph.com | Telefono: +52 961 000 0000',
            ],
        ]);
    }
}
