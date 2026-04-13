<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use App\Policies\CategoriaPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\UsuarioPolicy;
use App\Policies\VentaPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Usuario::class, UsuarioPolicy::class);
        Gate::policy(Producto::class, ProductoPolicy::class);
        Gate::policy(Categoria::class, CategoriaPolicy::class);
        Gate::policy(Venta::class, VentaPolicy::class);

        Gate::define('gestionar-usuarios', fn (Usuario $usuario) => $usuario->esAdministrador() || $usuario->esGerente());
        Gate::define('gestionar-catalogo', fn (Usuario $usuario) => $usuario->esAdministrador() || $usuario->esGerente());
        Gate::define('registrar-ventas', fn (Usuario $usuario) => $usuario->esCliente() || $usuario->esAdministrador() || $usuario->esGerente());
    }
}
