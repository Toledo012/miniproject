<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificacionController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

// Catálogo público (visible para invitados y autenticados)
Route::get('/', [CatalogoController::class, 'index'])->name('catalogo');

// ────────── Públicas (guest) ──────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

    Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');

    Route::get('/verificar-codigo', [VerificacionController::class, 'showForm'])->name('verificar.form');
    Route::post('/verificar-codigo', [VerificacionController::class, 'verify'])
        ->middleware('throttle:5,1')
        ->name('verificar.attempt');
});

// ────────── Autenticadas ──────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Solo admin: dashboard y gestión de usuarios
    Route::middleware('can:acceder-dashboard')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
    });

    // Productos & Categorías (autorización fina via Policy)
    Route::resource('productos', ProductoController::class);
    Route::resource('categorias', CategoriaController::class);

    // Ventas
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::patch('/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update');

    // Ticket privado (con Policy verTicket)
    Route::get('/ventas/{venta}/ticket', [TicketController::class, 'show'])->name('ventas.ticket');
});
