<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContenidoSitioController extends Controller
{
    public function edit(): View
    {
        $content = SiteContent::query()->first();

        if (! $content) {
            $content = new SiteContent([
                'about_us' => 'Somos una tienda digital enfocada en ventas en linea y atencion al cliente.',
                'mission' => 'Ofrecer productos de calidad con un proceso de compra simple, seguro y rapido.',
                'vision' => 'Ser una tienda en linea confiable y referente en servicio para nuestros clientes.',
                'location' => 'Av. Comercio 123, Ciudad de Mexico, Mexico.',
                'contact' => 'Email: contacto@tienda.local | Telefono: +52 55 0000 0000',
            ]);
        }

        return view('manager.content.edit', [
            'content' => $content,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'about_us' => ['required', 'string'],
            'mission' => ['required', 'string'],
            'vision' => ['required', 'string'],
            'location' => ['required', 'string'],
            'contact' => ['required', 'string'],
        ]);

        SiteContent::query()->updateOrCreate(
            ['id' => 1],
            $validated
        );

        return redirect()->route('manager.content.edit')
            ->with('status', 'Contenido del inicio actualizado.');
    }
}


