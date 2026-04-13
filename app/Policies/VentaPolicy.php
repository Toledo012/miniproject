<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Venta;

class VentaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return true;
    }

    public function view(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esAdministrador()
            || $usuario->esGerente()
            || $venta->cliente_id === $usuario->id
            || $venta->vendedor_id === $usuario->id;
    }

    public function create(Usuario $usuario): bool
    {
        return true;
    }

    public function update(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esAdministrador() || $usuario->esGerente();
    }

    public function delete(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esAdministrador();
    }
}
