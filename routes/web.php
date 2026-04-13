<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PanelAdministradorController;
use App\Http\Controllers\PanelClienteController;
use App\Http\Controllers\PanelGerenteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RedireccionPanelController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', RedireccionPanelController::class)->name('dashboard');

    Route::get('/panel/administrador', [PanelAdministradorController::class, 'index'])
        ->name('panel.administrador');
    Route::get('/panel/gerente', [PanelGerenteController::class, 'index'])
        ->name('panel.gerente');
    Route::get('/panel/cliente', [PanelClienteController::class, 'index'])
        ->name('panel.cliente');

    Route::resource('usuarios', UsuarioController::class)
        ->except(['show']);

    Route::resource('productos', ProductoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('ventas', VentaController::class);
});

require __DIR__.'/auth.php';
