<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;

class VentaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->esAdmin()
            || $user->esGerente()
            || $user->esVendedor()
            || $user->esComprador();
    }

    public function view(User $user, Venta $venta): bool
    {
        if ($user->esAdmin() || $user->esGerente()) {
            return true;
        }

        if ($user->esComprador() && $venta->comprador_id === $user->id) {
            return true;
        }

        if ($user->esVendedor() && $venta->producto?->vendedor_id === $user->id) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->esComprador();
    }

    public function update(User $user, Venta $venta): bool
    {
        return $user->esAdmin() || $user->esGerente();
    }

    public function delete(User $user, Venta $venta): bool
    {
        return false;
    }

    public function verTicket(User $user, Venta $venta): bool
    {
        return $this->view($user, $venta);
    }
}
