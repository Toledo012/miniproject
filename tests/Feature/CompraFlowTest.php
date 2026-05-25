<?php

namespace Tests\Feature;

use App\Mail\VentaRechazadaCliente;
use App\Mail\VentaValidadaCliente;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompraFlowTest extends TestCase
{
    use RefreshDatabase;

    private function ticketFalso(): UploadedFile
    {
        return UploadedFile::fake()->image('ticket.jpg', 600, 400);
    }

    public function test_cliente_crea_venta_pendiente_y_guarda_ticket_privado(): void
    {
        Storage::fake('private');
        Mail::fake();

        $cliente = User::factory()->cliente()->create();
        $producto = Producto::factory()->create(['stock' => 10, 'precio' => 100]);

        $response = $this
            ->actingAs($cliente)
            ->post(route('ventas.store'), [
                'producto_id' => $producto->id,
                'cantidad' => 2,
                'ticket' => $this->ticketFalso(),
            ]);

        $venta = Venta::firstOrFail();

        $response->assertRedirect(route('ventas.show', $venta));
        $this->assertSame('pendiente', $venta->estado);
        $this->assertSame($cliente->id, $venta->cliente_id);
        $this->assertSame(2, $venta->cantidad);
        $this->assertEquals(200.00, (float) $venta->total);

        $this->assertNotNull($venta->ticket_ruta);
        Storage::disk('private')->assertExists($venta->ticket_ruta);
        $this->assertStringStartsWith("tickets/{$venta->id}/", $venta->ticket_ruta);

        // Stock no debe decrementarse hasta validación
        $this->assertSame(10, $producto->fresh()->stock);

        Mail::assertNothingSent();
    }

    public function test_venta_falla_si_cantidad_supera_stock(): void
    {
        Storage::fake('private');
        $cliente = User::factory()->cliente()->create();
        $producto = Producto::factory()->create(['stock' => 1]);

        $this
            ->actingAs($cliente)
            ->post(route('ventas.store'), [
                'producto_id' => $producto->id,
                'cantidad' => 5,
                'ticket' => $this->ticketFalso(),
            ])
            ->assertSessionHasErrors('cantidad');

        $this->assertSame(0, Venta::count());
    }

    public function test_gerente_valida_venta_decrementa_stock_y_envia_email_al_cliente(): void
    {
        Storage::fake('private');
        Mail::fake();

        $cliente = User::factory()->cliente()->create();
        $gerente = User::factory()->gerente()->create();
        $producto = Producto::factory()->create(['stock' => 10, 'precio' => 50]);

        $this->actingAs($cliente)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'cantidad' => 3,
            'ticket' => $this->ticketFalso(),
        ]);

        $venta = Venta::firstOrFail();

        $this
            ->actingAs($gerente)
            ->patch(route('ventas.update', $venta), ['estado' => 'validada'])
            ->assertRedirect(route('ventas.show', $venta));

        $venta->refresh();
        $this->assertSame('validada', $venta->estado);
        $this->assertSame($gerente->id, $venta->validado_por);
        $this->assertSame(7, $producto->fresh()->stock);

        Mail::assertSent(VentaValidadaCliente::class, function ($mail) use ($cliente, $venta) {
            return $mail->hasTo($cliente->email)
                && $mail->venta->is($venta);
        });
        Mail::assertNotSent(VentaRechazadaCliente::class);
    }

    public function test_gerente_rechaza_venta_envia_email_y_no_decrementa_stock(): void
    {
        Storage::fake('private');
        Mail::fake();

        $cliente = User::factory()->cliente()->create();
        $gerente = User::factory()->gerente()->create();
        $producto = Producto::factory()->create(['stock' => 8]);

        $this->actingAs($cliente)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'cantidad' => 2,
            'ticket' => $this->ticketFalso(),
        ]);

        $venta = Venta::firstOrFail();

        $this
            ->actingAs($gerente)
            ->patch(route('ventas.update', $venta), ['estado' => 'rechazada'])
            ->assertRedirect(route('ventas.show', $venta));

        $venta->refresh();
        $this->assertSame('rechazada', $venta->estado);
        $this->assertSame($gerente->id, $venta->validado_por);
        $this->assertSame(8, $producto->fresh()->stock);

        Mail::assertSent(VentaRechazadaCliente::class, fn ($m) => $m->hasTo($cliente->email));
        Mail::assertNotSent(VentaValidadaCliente::class);
    }

    public function test_cliente_no_puede_validar_ni_rechazar_ventas(): void
    {
        Storage::fake('private');
        Mail::fake();

        $cliente = User::factory()->cliente()->create();
        $otroCliente = User::factory()->cliente()->create();
        $producto = Producto::factory()->create(['stock' => 5]);

        $this->actingAs($cliente)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'cantidad' => 1,
            'ticket' => $this->ticketFalso(),
        ]);

        $venta = Venta::firstOrFail();

        $this
            ->actingAs($otroCliente)
            ->patch(route('ventas.update', $venta), ['estado' => 'validada'])
            ->assertForbidden();

        $this->assertSame('pendiente', $venta->fresh()->estado);
        Mail::assertNothingSent();
    }

    public function test_cliente_dueno_descarga_su_ticket_pero_otro_cliente_no(): void
    {
        Storage::fake('private');
        Mail::fake();

        $cliente = User::factory()->cliente()->create();
        $intruso = User::factory()->cliente()->create();
        $producto = Producto::factory()->create(['stock' => 3]);

        $this->actingAs($cliente)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'cantidad' => 1,
            'ticket' => $this->ticketFalso(),
        ]);

        $venta = Venta::firstOrFail();

        $this
            ->actingAs($cliente)
            ->get(route('ventas.ticket', $venta))
            ->assertOk()
            ->assertHeader('content-disposition');

        $this
            ->actingAs($intruso)
            ->get(route('ventas.ticket', $venta))
            ->assertForbidden();
    }

    public function test_gerente_y_admin_pueden_descargar_cualquier_ticket(): void
    {
        Storage::fake('private');
        Mail::fake();

        $cliente = User::factory()->cliente()->create();
        $gerente = User::factory()->gerente()->create();
        $admin = User::factory()->admin()->create();
        $producto = Producto::factory()->create(['stock' => 3]);

        $this->actingAs($cliente)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'cantidad' => 1,
            'ticket' => $this->ticketFalso(),
        ]);

        $venta = Venta::firstOrFail();

        $this->actingAs($gerente)->get(route('ventas.ticket', $venta))->assertOk();
        $this->actingAs($admin)->get(route('ventas.ticket', $venta))->assertOk();
    }
}
