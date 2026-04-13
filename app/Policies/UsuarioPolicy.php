<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return $usuario->esAdministrador() || $usuario->esGerente();
    }

    public function create(Usuario $usuario): bool
    {
        return $usuario->esAdministrador();
    }

    public function update(Usuario $usuario, Usuario $objetivo): bool
    {
        if ($usuario->esAdministrador()) {
            return true;
        }

        return $usuario->esGerente() && $objetivo->esCliente();
    }

    public function delete(Usuario $usuario, Usuario $objetivo): bool
    {
        return $usuario->esAdministrador() && $usuario->id !== $objetivo->id;
    }
}
