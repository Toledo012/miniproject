<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteContent;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->where('is_active', true)
            ->latest()
            ->take(15)
            ->get();

        $siteContent = SiteContent::query()->first();

        return view('home', [
            'products' => $products,
            'siteContent' => [
                'about_us' => $siteContent?->about_us ?: 'Somos una tienda digital enfocada en ventas en linea y atencion al cliente.',
                'mission' => $siteContent?->mission ?: 'Ofrecer productos de calidad con un proceso de compra simple, seguro y rapido.',
                'vision' => $siteContent?->vision ?: 'Ser una tienda en linea confiable y referente en servicio para nuestros clientes.',
                'location' => $siteContent?->location ?: 'Av. Comercio 123, Ciudad de Mexico, Mexico.',
                'contact' => $siteContent?->contact ?: 'Email: contacto@tienda.local | Telefono: +52 55 0000 0000',
            ],
        ]);
    }
}

