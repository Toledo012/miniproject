<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\RedireccionPanelController;
use App\Http\Controllers\PanelEmpleadoController;
use App\Http\Controllers\GestionEmpleadosController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PanelGerenteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SolicitudCompraController;
use App\Http\Controllers\ContenidoSitioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', RedireccionPanelController::class)->name('dashboard');

    Route::get('/profile', [PerfilController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PerfilController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PerfilController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:cliente')->prefix('cliente')->name('client.')->group(function () {
        Route::get('/carrito', [CarritoController::class, 'index'])->name('cart');
        Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('cart.checkout');
        Route::post('/carrito/{product}', [CarritoController::class, 'store'])->name('cart.store');
        Route::patch('/carrito/{item}', [CarritoController::class, 'update'])->name('cart.update');
        Route::delete('/carrito/{item}', [CarritoController::class, 'destroy'])->name('cart.destroy');
        Route::get('/pedidos', [PedidoController::class, 'index'])->name('orders.index');
        Route::get('/productos', [ProductoController::class, 'indiceCliente'])->name('products.index');
        Route::get('/productos/{product}', [ProductoController::class, 'mostrarCliente'])->name('products.show');
    });

    Route::middleware('role:empleado,gerente')->prefix('empleado')->name('employee.')->group(function () {
        Route::get('/dashboard', [PanelEmpleadoController::class, 'index'])->name('dashboard');
        Route::get('/solicitudes-compra', [SolicitudCompraController::class, 'index'])->name('purchase-requests.index');
        Route::patch('/solicitudes-compra/{order}/estado', [SolicitudCompraController::class, 'actualizarEstado'])->name('purchase-requests.status');
    });

    Route::middleware('role:gerente')->prefix('gerente')->name('manager.')->group(function () {
        Route::get('/dashboard', [PanelGerenteController::class, 'index'])->name('dashboard');
        Route::get('/usuarios', [GestionEmpleadosController::class, 'index'])->name('users.index');
        Route::get('/empleados/crear', [GestionEmpleadosController::class, 'create'])->name('users.create');
        Route::post('/empleados', [GestionEmpleadosController::class, 'store'])->name('users.store');
        Route::get('/contenido', [ContenidoSitioController::class, 'edit'])->name('content.edit');
        Route::patch('/contenido', [ContenidoSitioController::class, 'update'])->name('content.update');
    });

    Route::middleware('role:empleado,gerente')->prefix('inventario')->name('inventory.')->group(function () {
        Route::resource('products', ProductoController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Rutas alias de compatibilidad (URLs antiguas)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::middleware('role:cliente')->prefix('client')->group(function () {
        Route::get('/cart', [CarritoController::class, 'index']);
        Route::post('/cart/checkout', [CarritoController::class, 'checkout']);
        Route::post('/cart/{product}', [CarritoController::class, 'store']);
        Route::patch('/cart/{item}', [CarritoController::class, 'update']);
        Route::delete('/cart/{item}', [CarritoController::class, 'destroy']);
        Route::get('/orders', [PedidoController::class, 'index']);
        Route::get('/products', [ProductoController::class, 'indiceCliente']);
        Route::get('/products/{product}', [ProductoController::class, 'mostrarCliente']);
    });

    Route::middleware('role:empleado,gerente')->prefix('employee')->group(function () {
        Route::get('/dashboard', [PanelEmpleadoController::class, 'index']);
        Route::get('/purchase-requests', [SolicitudCompraController::class, 'index']);
        Route::patch('/purchase-requests/{order}/status', [SolicitudCompraController::class, 'actualizarEstado']);
    });

    Route::middleware('role:gerente')->prefix('manager')->group(function () {
        Route::get('/dashboard', [PanelGerenteController::class, 'index']);
        Route::get('/users', [GestionEmpleadosController::class, 'index']);
        Route::get('/employees/create', [GestionEmpleadosController::class, 'create']);
        Route::post('/employees', [GestionEmpleadosController::class, 'store']);
        Route::get('/content', [ContenidoSitioController::class, 'edit']);
        Route::patch('/content', [ContenidoSitioController::class, 'update']);
    });

    Route::middleware('role:empleado,gerente')->prefix('inventory')->group(function () {
        Route::resource('products', ProductoController::class);
    });
});

require __DIR__.'/auth.php';

