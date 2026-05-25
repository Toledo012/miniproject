<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Producto $producto): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->esAdmin() || $user->esVendedor();
    }

    public function update(User $user, Producto $producto): bool
    {
        if ($user->esAdmin()) {
            return true;
        }

        return $user->esVendedor() && $producto->vendedor_id === $user->id;
    }

    public function delete(User $user, Producto $producto): bool
    {
        if ($user->esAdmin()) {
            return true;
        }

        return $user->esVendedor() && $producto->vendedor_id === $user->id;
    }
}
