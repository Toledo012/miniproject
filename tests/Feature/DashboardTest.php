<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private function ventaValidada(User $cliente, Producto $producto, int $cantidad = 1): Venta
    {
        return Venta::create([
            'cliente_id' => $cliente->id,
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'total' => $cantidad * (float) $producto->precio,
            'estado' => 'validada',
        ]);
    }

    public function test_totales_cuenta_usuarios_por_rol(): void
    {
        User::factory()->admin()->count(1)->create();
        User::factory()->gerente()->count(2)->create();
        User::factory()->cliente()->count(5)->create();
        Producto::factory()->count(3)->create();
        Categoria::factory()->count(4)->create();

        $totales = app(DashboardService::class)->totales();

        $this->assertSame(8, $totales['usuarios']);
        $this->assertSame(1, $totales['admins']);
        $this->assertSame(2, $totales['gerentes']);
        $this->assertSame(5, $totales['clientes']);
        $this->assertSame(3, $totales['productos']);
        $this->assertSame(4, $totales['categorias']);
    }

    public function test_productos_por_categoria_devuelve_conteo_correcto(): void
    {
        $cat1 = Categoria::factory()->create(['nombre' => 'Aaa']);
        $cat2 = Categoria::factory()->create(['nombre' => 'Bbb']);

        $p1 = Producto::factory()->create();
        $p2 = Producto::factory()->create();
        $p3 = Producto::factory()->create();

        $cat1->productos()->attach([$p1->id, $p2->id]);
        $cat2->productos()->attach([$p3->id]);

        $resultado = app(DashboardService::class)->productosPorCategoria();

        $this->assertSame(2, $resultado->firstWhere('id', $cat1->id)->productos_count);
        $this->assertSame(1, $resultado->firstWhere('id', $cat2->id)->productos_count);
    }

    public function test_producto_mas_vendido_solo_cuenta_ventas_validadas(): void
    {
        $cliente = User::factory()->cliente()->create();
        $top = Producto::factory()->create(['nombre' => 'TopSeller', 'stock' => 100]);
        $otro = Producto::factory()->create(['nombre' => 'Otro', 'stock' => 100]);

        $this->ventaValidada($cliente, $top);
        $this->ventaValidada($cliente, $top);
        $this->ventaValidada($cliente, $top);
        $this->ventaValidada($cliente, $otro);

        // Pendiente — no debe contar
        Venta::create([
            'cliente_id' => $cliente->id,
            'producto_id' => $otro->id,
            'cantidad' => 1,
            'total' => 10,
            'estado' => 'pendiente',
        ]);

        $resultado = app(DashboardService::class)->productoMasVendido();

        $this->assertSame($top->id, $resultado->id);
        $this->assertSame(3, (int) $resultado->ventas_validadas_count);
    }

    public function test_cliente_mas_frecuente_por_categoria(): void
    {
        $catA = Categoria::factory()->create(['nombre' => 'Cat A']);
        $catB = Categoria::factory()->create(['nombre' => 'Cat B']);

        $pA = Producto::factory()->create(['stock' => 100]);
        $pB = Producto::factory()->create(['stock' => 100]);

        $catA->productos()->attach($pA->id);
        $catB->productos()->attach($pB->id);

        $ana = User::factory()->cliente()->create(['nombre' => 'Ana']);
        $beto = User::factory()->cliente()->create(['nombre' => 'Beto']);

        // En categoría A: Ana lidera 2-1
        $this->ventaValidada($ana, $pA);
        $this->ventaValidada($ana, $pA);
        $this->ventaValidada($beto, $pA);

        // En categoría B: Beto lidera 3-0
        $this->ventaValidada($beto, $pB);
        $this->ventaValidada($beto, $pB);
        $this->ventaValidada($beto, $pB);

        $resultado = app(DashboardService::class)->clienteMasFrecuentePorCategoria();

        $filaA = $resultado->firstWhere('categoria.id', $catA->id);
        $filaB = $resultado->firstWhere('categoria.id', $catB->id);

        $this->assertSame($ana->id, $filaA['cliente']->id);
        $this->assertSame(2, $filaA['compras']);

        $this->assertSame($beto->id, $filaB['cliente']->id);
        $this->assertSame(3, $filaB['compras']);
    }

    public function test_categoria_sin_ventas_devuelve_cliente_null(): void
    {
        $cat = Categoria::factory()->create();
        Producto::factory()->create()->categorias()->attach($cat->id);

        $resultado = app(DashboardService::class)->clienteMasFrecuentePorCategoria();
        $fila = $resultado->firstWhere('categoria.id', $cat->id);

        $this->assertNull($fila['cliente']);
        $this->assertSame(0, $fila['compras']);
    }

    public function test_dashboard_muestra_totales_en_la_vista(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->cliente()->count(3)->create();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard administrativo')
            ->assertSee('Productos por categoría')
            ->assertSee('Producto más vendido')
            ->assertSee('Cliente más frecuente por categoría');
    }
}
