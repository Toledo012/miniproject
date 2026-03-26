<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BusinessFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_employee_account(): void
    {
        $manager = User::factory()->gerente()->create();

        $response = $this->actingAs($manager)->post('/gerente/empleados', [
            'name' => 'Nuevo Empleado',
            'email' => 'nuevo-empleado@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('manager.users.index', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'nuevo-empleado@example.com',
            'role' => User::ROLE_EMPLEADO,
        ]);
    }

    public function test_employee_and_manager_can_manage_products(): void
    {
        $employee = User::factory()->empleado()->create();
        $manager = User::factory()->gerente()->create();
        Storage::fake('public');

        $employeeResponse = $this->actingAs($employee)->post('/inventario/products', [
            'name' => 'Producto Empleado',
            'description' => 'Creado por empleado',
            'price' => 99.99,
            'stock' => 10,
            'is_active' => 1,
        ]);
        $employeeResponse->assertRedirect(route('inventory.products.index', absolute: false));

        $managerResponse = $this->actingAs($manager)->post('/inventario/products', [
            'name' => 'Producto Gerente',
            'description' => 'Creado por gerente',
            'price' => 149.99,
            'stock' => 5,
            'is_active' => 1,
            'image' => UploadedFile::fake()->create('producto.jpg', 120, 'image/jpeg'),
        ]);
        $managerResponse->assertRedirect(route('inventory.products.index', absolute: false));

        $this->assertDatabaseHas('products', ['name' => 'Producto Empleado']);
        $this->assertDatabaseHas('products', ['name' => 'Producto Gerente']);
        $this->assertDatabaseMissing('products', ['name' => 'Producto Gerente', 'image_path' => null]);

        $product = Product::where('name', 'Producto Empleado')->firstOrFail();
        $updateResponse = $this->actingAs($employee)->put('/inventario/products/'.$product->id, [
            'name' => 'Producto Empleado Editado',
            'description' => 'Editado',
            'price' => 120.00,
            'stock' => 20,
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect(route('inventory.products.index', absolute: false));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Producto Empleado Editado']);
    }

    public function test_home_lists_only_active_products(): void
    {
        Product::factory()->create([
            'name' => 'Producto Visible',
            'is_active' => true,
        ]);
        Product::factory()->create([
            'name' => 'Producto Oculto',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertSee('Producto Visible');
        $response->assertDontSee('Producto Oculto');
    }

    public function test_client_can_add_products_to_cart(): void
    {
        $client = User::factory()->cliente()->create();
        $product = Product::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($client)->post('/cliente/carrito/'.$product->id, [
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('client.cart', absolute: false));
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $client->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_client_can_checkout_and_employee_can_update_order_status(): void
    {
        $client = User::factory()->cliente()->create([
            'address' => 'Calle 123',
            'city' => 'CDMX',
            'state' => 'CDMX',
            'postal_code' => '01000',
        ]);
        $employee = User::factory()->empleado()->create();
        $product = Product::factory()->create(['is_active' => true, 'price' => 50.00]);

        $this->actingAs($client)->post('/cliente/carrito/'.$product->id, ['quantity' => 3]);
        $checkout = $this->actingAs($client)->post('/cliente/carrito/checkout');
        $checkout->assertRedirect(route('client.orders.index', absolute: false));

        $order = Order::firstOrFail();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $client->id,
            'status' => Order::STATUS_PENDING,
            'shipping_address' => 'Calle 123',
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $statusResponse = $this->actingAs($employee)->patch('/empleado/solicitudes-compra/'.$order->id.'/estado', [
            'status' => Order::STATUS_DELIVERED,
        ]);
        $statusResponse->assertRedirect(route('employee.purchase-requests.index', absolute: false));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => Order::STATUS_DELIVERED,
        ]);
    }
}
