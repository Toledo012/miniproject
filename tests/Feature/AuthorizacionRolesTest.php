<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthorizacionRolesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_puede_crear_categoria_pero_gerente_no(): void
    {
        $admin = User::factory()->admin()->create();
        $gerente = User::factory()->gerente()->create();

        $this->actingAs($admin)
            ->post(route('categorias.store'), ['nombre' => 'Bebidas'])
            ->assertRedirect(route('categorias.index'));

        $this->assertDatabaseHas('categorias', ['nombre' => 'Bebidas']);

        $this->actingAs($gerente)
            ->post(route('categorias.store'), ['nombre' => 'Snacks'])
            ->assertForbidden();

        $this->assertDatabaseMissing('categorias', ['nombre' => 'Snacks']);
    }

    public function test_cliente_no_puede_crear_categoria(): void
    {
        $cliente = User::factory()->cliente()->create();

        $this->actingAs($cliente)
            ->post(route('categorias.store'), ['nombre' => 'X'])
            ->assertForbidden();
    }

    public function test_gerente_y_admin_crean_producto_cliente_no(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $gerente = User::factory()->gerente()->create();
        $cliente = User::factory()->cliente()->create();
        $categoria = Categoria::factory()->create();

        $payload = fn (string $nombre) => [
            'nombre' => $nombre,
            'descripcion' => 'descripción detallada',
            'precio' => 99.99,
            'stock' => 5,
            'categorias' => [$categoria->id],
            'fotos' => [UploadedFile::fake()->image('foto.jpg', 400, 400)],
        ];

        $this->actingAs($admin)
            ->post(route('productos.store'), $payload('Producto Admin'))
            ->assertRedirect();

        $this->actingAs($gerente)
            ->post(route('productos.store'), $payload('Producto Gerente'))
            ->assertRedirect();

        $this->actingAs($cliente)
            ->post(route('productos.store'), $payload('Producto Cliente'))
            ->assertForbidden();

        $this->assertSame(2, Producto::count());
    }

    public function test_cliente_no_puede_eliminar_producto_pero_gerente_si(): void
    {
        Storage::fake('public');

        $producto = Producto::factory()->create();
        $cliente = User::factory()->cliente()->create();
        $gerente = User::factory()->gerente()->create();

        $this->actingAs($cliente)
            ->delete(route('productos.destroy', $producto))
            ->assertForbidden();

        $this->assertDatabaseHas('productos', ['id' => $producto->id]);

        $this->actingAs($gerente)
            ->delete(route('productos.destroy', $producto))
            ->assertRedirect();

        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    public function test_invitado_es_redirigido_a_login(): void
    {
        $this->get(route('productos.index'))->assertRedirect(route('login'));
        $this->get(route('categorias.index'))->assertRedirect(route('login'));
    }

    public function test_solo_admin_accede_al_dashboard(): void
    {
        $admin = User::factory()->admin()->create();
        $gerente = User::factory()->gerente()->create();
        $cliente = User::factory()->cliente()->create();

        $this->actingAs($admin)->get(route('dashboard'))->assertOk();
        $this->actingAs($gerente)->get(route('dashboard'))->assertForbidden();
        $this->actingAs($cliente)->get(route('dashboard'))->assertForbidden();
    }
}
