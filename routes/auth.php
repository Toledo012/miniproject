<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\RegistroController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AutenticacionController::class, 'create'])->name('login');
    Route::post('login', [AutenticacionController::class, 'store']);

    Route::get('register', [RegistroController::class, 'create'])->name('register');
    Route::post('register', [RegistroController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AutenticacionController::class, 'destroy'])->name('logout');
});
