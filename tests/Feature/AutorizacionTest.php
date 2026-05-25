<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AutorizacionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba 5: un administrador puede crear una categoría.
     * Se valida la persistencia con assertDatabaseHas.
     */
    public function test_administrador_puede_crear_categoria(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('categorias.store'), [
                'nombre' => 'Audio Premium',
            ])
            ->assertRedirect(route('categorias.index'));

        $this->assertDatabaseHas('categorias', [
            'nombre' => 'Audio Premium',
        ]);
    }

    /**
     * Prueba 6: un vendedor puede publicar un producto y la relación
     * con la categoría queda registrada en la tabla pivote.
     *
     * NOTA: la policy actual (ProductoPolicy::create) habilita a admin
     * y vendedor — el gerente no crea productos en este dominio.
     */
    public function test_vendedor_puede_crear_producto_con_categoria(): void
    {
        Storage::fake('public');

        $vendedor = User::factory()->vendedor()->create();
        $categoria = Categoria::factory()->create();

        $payload = [
            'nombre' => 'Producto QA Pipeline',
            'descripcion' => 'Producto creado durante una prueba automatizada.',
            'precio' => 1250.50,
            'stock' => 8,
            'categorias' => [$categoria->id],
            'fotos' => [$this->imagenFake('foto.png')],
        ];

        $this->actingAs($vendedor)
            ->post(route('productos.store'), $payload)
            ->assertRedirect(route('productos.index'));

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Producto QA Pipeline',
            'vendedor_id' => $vendedor->id,
            'stock' => 8,
        ]);

        $producto = \App\Models\Producto::where('nombre', 'Producto QA Pipeline')->firstOrFail();

        $this->assertDatabaseHas('categoria_producto', [
            'producto_id' => $producto->id,
            'categoria_id' => $categoria->id,
        ]);
    }

    /**
     * Prueba 7: un comprador no puede acceder a la gestión de usuarios
     * (solo admin) ni al formulario de creación de productos (admin/vendedor).
     */
    public function test_comprador_no_puede_acceder_a_gestion_de_usuarios_ni_a_crear_productos(): void
    {
        $comprador = User::factory()->comprador()->create();

        $this->actingAs($comprador)
            ->get(route('users.index'))
            ->assertForbidden();

        $this->actingAs($comprador)
            ->get(route('productos.create'))
            ->assertForbidden();
    }
}
