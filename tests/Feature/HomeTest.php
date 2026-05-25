<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba 1: la página principal carga (HTTP 200) y muestra el catálogo
     * con al menos un producto publicado por un vendedor.
     */
    public function test_pagina_principal_carga_y_muestra_catalogo(): void
    {
        $vendedor = User::factory()->vendedor()->create();

        $producto = Producto::factory()->create([
            'vendedor_id' => $vendedor->id,
            'nombre' => 'Producto Vitrina QA',
            'precio' => 199.99,
            'stock' => 5,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        // Aparece el título del catálogo y el nombre del producto creado.
        $response->assertSee('Explora la colección', escape: false);
        $response->assertSee($producto->nombre);
    }
}
