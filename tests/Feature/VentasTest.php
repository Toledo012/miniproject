<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VentasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba 8: una compra realizada por un comprador autenticado se
     * registra correctamente en la tabla 'ventas' en estado pendiente,
     * con el total calculado a partir del precio del producto y la
     * cantidad solicitada.
     */
    public function test_venta_se_registra_correctamente(): void
    {
        Storage::fake('private');

        $comprador = User::factory()->comprador()->create();
        $vendedor = User::factory()->vendedor()->create();
        $producto = Producto::factory()->create([
            'vendedor_id' => $vendedor->id,
            'precio' => 250.00,
            'stock' => 10,
        ]);

        $this->actingAs($comprador)
            ->post(route('ventas.store'), [
                'producto_id' => $producto->id,
                'cantidad' => 2,
                'ticket' => $this->imagenFake('ticket.png'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('ventas', [
            'comprador_id' => $comprador->id,
            'producto_id' => $producto->id,
            'cantidad' => 2,
            'estado' => 'pendiente',
        ]);

        $venta = Venta::firstOrFail();
        // El total debe ser precio * cantidad
        $this->assertEquals(500.00, (float) $venta->total);
        // El ticket debe haberse persistido en el disco privado
        $this->assertNotNull($venta->ticket_ruta);
        Storage::disk('private')->assertExists($venta->ticket_ruta);
    }
}
