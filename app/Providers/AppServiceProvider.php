<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use App\Policies\CategoriaPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\UserPolicy;
use App\Policies\VentaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Producto::class, ProductoPolicy::class);
        Gate::policy(Categoria::class, CategoriaPolicy::class);
        Gate::policy(Venta::class, VentaPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Gate::define('acceder-dashboard', fn ($user) => $user->esAdmin());
        Gate::define('rol-admin', fn ($user) => $user->esAdmin());
        Gate::define('rol-gerente', fn ($user) => $user->esGerente());
        Gate::define('rol-vendedor', fn ($user) => $user->esVendedor());
        Gate::define('rol-comprador', fn ($user) => $user->esComprador());
        Gate::define('admin-o-gerente', fn ($user) => $user->esAdmin() || $user->esGerente());
    }
}
